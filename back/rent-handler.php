<?php
/* =============================================================================
   BOSK FURNITURE — RENT MODULE HANDLER
   back/rent-handler.php
   ---------------------------------------------------------------------------
   JSON API for the rental frontend pages.
   Every request must POST a "action" field.

   Actions:
     add_to_cart      — Add item+plan to the user's rental cart
     update_qty       — Change qty of a cart item
     remove_item      — Remove a cart item
     get_cart         — Return full cart for current session/user
     place_order      — Convert cart → rental_order (checkout)
     get_my_rentals   — Return rental orders for logged-in user
     lifecycle_request — Raise return/extension/repair/buyout request
   ============================================================================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../connect.php';

/* ---- helpers ---- */
function rh_json($ok, $data = [], $msg = '')
{
    echo json_encode(['ok' => (bool)$ok, 'msg' => $msg, 'data' => $data]);
    exit;
}

function rh_user_id()
{
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

function rh_session_token()
{
    if (empty($_SESSION['rent_session'])) {
        $_SESSION['rent_session'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['rent_session'];
}

function rh_sanitize($v)
{
    global $con;
    return mysqli_real_escape_string($con, trim((string)$v));
}

/* ---- dispatch ---- */
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

switch ($action) {

    // -----------------------------------------------------------------------
    // ADD TO CART
    // -----------------------------------------------------------------------
    case 'add_to_cart':
        $product_id = (int)($_POST['product_id'] ?? 0);
        $plan_id    = (int)($_POST['plan_id']    ?? 0);
        $qty        = max(1, (int)($_POST['qty'] ?? 1));
        $protection = isset($_POST['protection']) && $_POST['protection'] == '1' ? 1 : 0;

        if (!$product_id || !$plan_id) {
            rh_json(false, [], 'Invalid product or plan.');
        }

        // Verify plan belongs to product
        $r = mysqli_query($con, "SELECT id FROM rental_plans WHERE id=$plan_id AND product_id=$product_id AND is_active=1 LIMIT 1");
        if (!$r || mysqli_num_rows($r) === 0) {
            rh_json(false, [], 'Rental plan not found or inactive.');
        }

        $user_id = rh_user_id();
        $token   = rh_session_token();

        // Find or create cart
        if ($user_id) {
            $cq = "SELECT id FROM carts WHERE user_id=$user_id LIMIT 1";
        } else {
            $tok = rh_sanitize($token);
            $cq  = "SELECT id FROM carts WHERE session_token='$tok' LIMIT 1";
        }
        $cr = mysqli_query($con, $cq);
        if ($cr && mysqli_num_rows($cr) > 0) {
            $cart_id = (int)mysqli_fetch_row($cr)[0];
        } else {
            $tok = rh_sanitize($token);
            $uid_sql = $user_id ? $user_id : 'NULL';
            mysqli_query($con, "INSERT INTO carts (user_id, session_token) VALUES ($uid_sql, '$tok')");
            $cart_id = (int)mysqli_insert_id($con);
        }

        // Check if same product+plan already in cart
        $existing = mysqli_query($con, "SELECT id, qty FROM cart_items WHERE cart_id=$cart_id AND product_id=$product_id AND plan_id=$plan_id LIMIT 1");
        if ($existing && mysqli_num_rows($existing) > 0) {
            $row = mysqli_fetch_assoc($existing);
            $new_qty = (int)$row['qty'] + $qty;
            $item_id = (int)$row['id'];
            mysqli_query($con, "UPDATE cart_items SET qty=$new_qty, protection_addon=$protection WHERE id=$item_id");
        } else {
            mysqli_query($con, "INSERT INTO cart_items (cart_id, product_id, plan_id, qty, protection_addon) VALUES ($cart_id, $product_id, $plan_id, $qty, $protection)");
        }

        // Return new cart count
        $cnt = mysqli_fetch_row(mysqli_query($con, "SELECT SUM(qty) FROM cart_items WHERE cart_id=$cart_id"))[0] ?? 0;
        rh_json(true, ['cart_count' => (int)$cnt], 'Added to rental cart.');

    // -----------------------------------------------------------------------
    // UPDATE QTY
    // -----------------------------------------------------------------------
    case 'update_qty':
        $item_id = (int)($_POST['item_id'] ?? 0);
        $qty     = max(1, (int)($_POST['qty'] ?? 1));
        if (!$item_id) {
            rh_json(false, [], 'Invalid item.');
        }
        $cart_id = rh_get_cart_id();
        if (!$cart_id) rh_json(false, [], 'Cart not found.');
        mysqli_query($con, "UPDATE cart_items SET qty=$qty WHERE id=$item_id AND cart_id=$cart_id");
        rh_json(true, [], 'Quantity updated.');

    // -----------------------------------------------------------------------
    // REMOVE ITEM
    // -----------------------------------------------------------------------
    case 'remove_item':
        $item_id = (int)($_POST['item_id'] ?? 0);
        if (!$item_id) {
            rh_json(false, [], 'Invalid item.');
        }
        $cart_id = rh_get_cart_id();
        if (!$cart_id) rh_json(false, [], 'Cart not found.');
        mysqli_query($con, "DELETE FROM cart_items WHERE id=$item_id AND cart_id=$cart_id");
        rh_json(true, [], 'Item removed.');

    // -----------------------------------------------------------------------
    // GET CART  (returns structured cart JSON)
    // -----------------------------------------------------------------------
    case 'get_cart':
        $cart = rh_load_cart();
        rh_json(true, $cart);

    // -----------------------------------------------------------------------
    // PLACE ORDER  (convert cart → rental_order)
    // -----------------------------------------------------------------------
    case 'place_order':
        $user_id = rh_user_id();
        if (!$user_id) {
            rh_json(false, [], 'Please log in to place a rental order.');
        }

        $full_name = rh_sanitize($_POST['full_name'] ?? '');
        $mobile    = rh_sanitize($_POST['mobile']    ?? '');
        $address   = rh_sanitize($_POST['address']   ?? '');
        $city      = rh_sanitize($_POST['city']      ?? '');
        $pincode   = rh_sanitize($_POST['pincode']   ?? '');
        $slot      = rh_sanitize($_POST['delivery_slot'] ?? '');

        if (!$full_name || !$mobile || !$address || !$city || !$pincode) {
            rh_json(false, [], 'Please fill all delivery fields.');
        }

        // Validate mobile (10 digits)
        if (!preg_match('/^\d{10}$/', $mobile)) {
            rh_json(false, [], 'Enter a valid 10-digit mobile number.');
        }

        // Load cart items
        $cart_id = rh_get_cart_id();
        if (!$cart_id) {
            rh_json(false, [], 'Your rental cart is empty.');
        }
        $items_r = mysqli_query($con, "
            SELECT ci.id item_id, ci.product_id, ci.plan_id, ci.qty, ci.protection_addon,
                   rp.tenure_months, rp.monthly_rent, rp.deposit
            FROM cart_items ci
            JOIN rental_plans rp ON rp.id = ci.plan_id
            WHERE ci.cart_id = $cart_id
        ");
        $items = [];
        while ($row = mysqli_fetch_assoc($items_r)) {
            $items[] = $row;
        }
        if (empty($items)) {
            rh_json(false, [], 'Your rental cart is empty.');
        }

        // Save delivery address
        mysqli_query($con, "INSERT INTO delivery_addresses (user_id, full_name, mobile, address_line, city, pincode) VALUES ($user_id, '$full_name', '$mobile', '$address', '$city', '$pincode')");
        $addr_id = (int)mysqli_insert_id($con);

        // Calculate totals
        $total_monthly = 0;
        $total_deposit = 0;
        foreach ($items as $it) {
            $total_monthly += (int)$it['monthly_rent'] * (int)$it['qty'];
            $total_deposit += (int)$it['deposit']      * (int)$it['qty'];
        }

        // Handle KYC File Uploads if provided
        $kyc_id = null;
        $doc_type = rh_sanitize($_POST['doc_type'] ?? 'aadhaar');
        $upload_dir = __DIR__ . '/../uploads/kyc/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }

        $front_path  = null;
        $back_path   = null;
        $selfie_path = null;

        if (isset($_FILES['doc_front']) && $_FILES['doc_front']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['doc_front']['name'], PATHINFO_EXTENSION));
            $fn  = 'kyc_front_' . $user_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['doc_front']['tmp_name'], $upload_dir . $fn)) {
                $front_path = 'uploads/kyc/' . $fn;
            }
        }
        if (isset($_FILES['doc_back']) && $_FILES['doc_back']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['doc_back']['name'], PATHINFO_EXTENSION));
            $fn  = 'kyc_back_' . $user_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['doc_back']['tmp_name'], $upload_dir . $fn)) {
                $back_path = 'uploads/kyc/' . $fn;
            }
        }
        if (isset($_FILES['selfie']) && $_FILES['selfie']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['selfie']['name'], PATHINFO_EXTENSION));
            $fn  = 'kyc_selfie_' . $user_id . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['selfie']['tmp_name'], $upload_dir . $fn)) {
                $selfie_path = 'uploads/kyc/' . $fn;
            }
        }

        if ($front_path || $back_path || $selfie_path) {
            $fp_sql = $front_path  ? "'$front_path'"  : 'NULL';
            $bp_sql = $back_path   ? "'$back_path'"   : 'NULL';
            $sp_sql = $selfie_path ? "'$selfie_path'" : 'NULL';
            mysqli_query($con, "
                INSERT INTO kyc_verifications
                    (user_id, doc_type, doc_front_file, doc_back_file, selfie_file, status)
                VALUES
                    ($user_id, '$doc_type', $fp_sql, $bp_sql, $sp_sql, 'pending')
            ");
            $kyc_id = (int)mysqli_insert_id($con);
        }

        // Generate order ref
        $order_ref = 'BR' . date('ymd') . str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $slot_sql  = $slot ? "'$slot'" : 'NULL';
        $kyc_sql   = $kyc_id ? $kyc_id : 'NULL';
        $razorpay_payment_id = rh_sanitize($_POST['razorpay_payment_id'] ?? '');
        $order_status = $kyc_id ? 'kyc_pending' : 'pending';

        // Insert rental_order
        mysqli_query($con, "
            INSERT INTO rental_orders
                (order_ref, user_id, kyc_id, address_id, delivery_slot, status, total_monthly_rent, total_deposit)
            VALUES
                ('$order_ref', $user_id, $kyc_sql, $addr_id, $slot_sql, '$order_status', $total_monthly, $total_deposit)
        ");
        $order_id = (int)mysqli_insert_id($con);

        if (!$order_id) {
            rh_json(false, [], 'Failed to place order. Please try again.');
        }

        // Record Razorpay payment if present
        if ($razorpay_payment_id) {
            $total_paid = $total_monthly + $total_deposit;
            mysqli_query($con, "
                INSERT INTO payments (order_id, user_id, type, amount, status, gateway, gateway_txn, paid_at)
                VALUES ($order_id, $user_id, 'deposit', $total_paid, 'paid', 'razorpay', '$razorpay_payment_id', NOW())
            ");
        }

        // Insert order items
        foreach ($items as $it) {
            $prod_id   = (int)$it['product_id'];
            $plan_id   = (int)$it['plan_id'];
            $tenure    = (int)$it['tenure_months'];
            $monthly   = (int)$it['monthly_rent'];
            $deposit   = (int)$it['deposit'];
            $qty       = (int)$it['qty'];
            $prot      = (int)$it['protection_addon'];
            $start     = date('Y-m-d');
            $end       = date('Y-m-d', strtotime("+{$tenure} months"));
            mysqli_query($con, "
                INSERT INTO rental_order_items
                    (order_id, product_id, plan_id, tenure_months, monthly_rent, deposit, qty, protection_addon, start_date, end_date)
                VALUES
                    ($order_id, $prod_id, $plan_id, $tenure, $monthly, $deposit, $qty, $prot, '$start', '$end')
            ");
        }

        // Clear the cart
        mysqli_query($con, "DELETE FROM cart_items WHERE cart_id=$cart_id");
        mysqli_query($con, "DELETE FROM carts WHERE id=$cart_id");

        // Store in session for confirmation page
        $_SESSION['last_rent_order_ref'] = $order_ref;
        $_SESSION['last_rent_order_id']  = $order_id;

        rh_json(true, ['order_ref' => $order_ref, 'order_id' => $order_id], 'Rental order placed successfully.');

    // -----------------------------------------------------------------------
    // GET MY RENTALS
    // -----------------------------------------------------------------------
    case 'get_my_rentals':
        $user_id = rh_user_id();
        if (!$user_id) rh_json(false, [], 'Not logged in.');
        $orders = [];
        $r = mysqli_query($con, "SELECT * FROM rental_orders WHERE user_id=$user_id ORDER BY created_at DESC");
        while ($row = mysqli_fetch_assoc($r)) {
            // Attach items
            $items_q = mysqli_query($con, "
                SELECT roi.*, p.pname product_name, p.img1 product_image
                FROM rental_order_items roi
                JOIN products p ON p.id = roi.product_id
                WHERE roi.order_id = {$row['id']}
            ");
            $row['items'] = [];
            while ($item = mysqli_fetch_assoc($items_q)) {
                $row['items'][] = $item;
            }
            $orders[] = $row;
        }
        rh_json(true, ['orders' => $orders]);

    // -----------------------------------------------------------------------
    // LIFECYCLE REQUEST  (return / extension / repair / buyout)
    // -----------------------------------------------------------------------
    case 'lifecycle_request':
        $user_id  = rh_user_id();
        if (!$user_id) rh_json(false, [], 'Not logged in.');
        $order_id = (int)($_POST['order_id'] ?? 0);
        $type     = rh_sanitize($_POST['type']  ?? '');
        $notes    = rh_sanitize($_POST['notes'] ?? '');
        $allowed  = ['return','relocation','repair','buyout','extension'];
        if (!$order_id || !in_array($type, $allowed)) {
            rh_json(false, [], 'Invalid request.');
        }
        // Verify order belongs to user
        $ov = mysqli_query($con, "SELECT id FROM rental_orders WHERE id=$order_id AND user_id=$user_id LIMIT 1");
        if (!$ov || mysqli_num_rows($ov) === 0) {
            rh_json(false, [], 'Order not found.');
        }
        mysqli_query($con, "INSERT INTO order_lifecycle_requests (order_id, user_id, type, notes) VALUES ($order_id, $user_id, '$type', '$notes')");
        rh_json(true, [], ucfirst($type) . ' request submitted. Our team will contact you shortly.');

    default:
        rh_json(false, [], 'Unknown action.');
}

/* ============================================================================
   UTILITY FUNCTIONS
   ============================================================================ */

/**
 * Get (or find) the active cart ID for the current session/user.
 */
function rh_get_cart_id()
{
    global $con;
    $user_id = rh_user_id();
    $token   = rh_session_token();
    if ($user_id) {
        $r = mysqli_query($con, "SELECT id FROM carts WHERE user_id=$user_id LIMIT 1");
    } else {
        $tok = mysqli_real_escape_string($con, $token);
        $r   = mysqli_query($con, "SELECT id FROM carts WHERE session_token='$tok' LIMIT 1");
    }
    if ($r && mysqli_num_rows($r) > 0) {
        return (int)mysqli_fetch_row($r)[0];
    }
    return null;
}

/**
 * Load cart items with full product + plan details.
 */
function rh_load_cart()
{
    global $con;
    $cart_id = rh_get_cart_id();
    if (!$cart_id) return ['items' => [], 'totals' => ['monthly' => 0, 'deposit' => 0]];

    $r = mysqli_query($con, "
        SELECT
            ci.id         item_id,
            ci.qty,
            ci.protection_addon,
            p.id          product_id,
            p.pname       product_name,
            p.img1        product_image,
            rp.id         plan_id,
            rp.tenure_months,
            rp.monthly_rent,
            rp.deposit,
            rp.save_label
        FROM cart_items ci
        JOIN products p     ON p.id  = ci.product_id
        JOIN rental_plans rp ON rp.id = ci.plan_id
        WHERE ci.cart_id = $cart_id
        ORDER BY ci.added_at ASC
    ");

    $items          = [];
    $total_monthly  = 0;
    $total_deposit  = 0;
    while ($row = mysqli_fetch_assoc($r)) {
        $monthly = (int)$row['monthly_rent'] * (int)$row['qty'];
        $deposit = (int)$row['deposit']      * (int)$row['qty'];
        $total_monthly += $monthly;
        $total_deposit += $deposit;
        $row['subtotal_monthly'] = $monthly;
        $row['subtotal_deposit'] = $deposit;
        $items[] = $row;
    }

    return [
        'items'  => $items,
        'totals' => ['monthly' => $total_monthly, 'deposit' => $total_deposit],
    ];
}
