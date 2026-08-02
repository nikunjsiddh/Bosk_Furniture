<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Your Rental Cart | Bosk Furniture on Rent';
$page_description = 'Review your rental cart — monthly rent and free delivery — then continue to checkout at Bosk Furniture.';
$page_canonical   = '/rent-cart';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'Rental Cart', 'url' => '/rent-cart']
];

include_once "connect.php";
include_once "design/rent-data.php";

/* ============================================================
   Load cart from DB if tables exist; otherwise use demo data.
   ============================================================ */
$_db_cart = false;
$cart      = [];
$cart_id   = null;

if (isset($con) && $con) {
    $chk = mysqli_query($con, "SHOW TABLES LIKE 'carts'");
    if ($chk && mysqli_num_rows($chk) > 0) {
        $_db_cart = true;

        $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
        $token   = $_SESSION['rent_session'] ?? null;

        if ($user_id) {
            $cr = mysqli_query($con, "SELECT id FROM carts WHERE user_id=$user_id LIMIT 1");
        } elseif ($token) {
            $tok = mysqli_real_escape_string($con, $token);
            $cr  = mysqli_query($con, "SELECT id FROM carts WHERE session_token='$tok' LIMIT 1");
        } else {
            $cr = false;
        }

        if ($cr && mysqli_num_rows($cr) > 0) {
            $cart_id = (int)mysqli_fetch_row($cr)[0];
            $ir = mysqli_query($con, "
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
                JOIN products p      ON p.id  = ci.product_id
                JOIN rental_plans rp ON rp.id = ci.plan_id
                WHERE ci.cart_id = $cart_id
                ORDER BY ci.added_at ASC
            ");
            while ($row = mysqli_fetch_assoc($ir)) {
                // Normalize to same shape as demo
                $cart[] = [
                    'item_id' => (int)$row['item_id'],
                    'qty'     => (int)$row['qty'],
                    'protection_addon' => (int)$row['protection_addon'],
                    'product' => [
                        'id'    => (int)$row['product_id'],
                        'name'  => $row['product_name'],
                        'image' => $row['product_image'],
                    ],
                    'plan' => [
                        'id'      => (int)$row['plan_id'],
                        'tenure'  => (int)$row['tenure_months'],
                        'monthly' => (int)$row['monthly_rent'],
                        'deposit' => (int)$row['deposit'],
                        'save'    => $row['save_label'],
                    ],
                ];
            }
        }
    }
}

/* --- Demo fallback (no DB tables) --- */
if (!$_db_cart && empty($cart)) {
    $CART_PLAN_INDEX = 1; // 6-month plan
    foreach ([1, 4] as $cid) {
        $prod = rent_find($cid);
        if (!$prod) continue;
        $plan = isset($prod['plans'][$CART_PLAN_INDEX]) ? $prod['plans'][$CART_PLAN_INDEX] : $prod['plans'][0];
        $cart[] = [
            'item_id'          => $cid,
            'qty'              => 1,
            'protection_addon' => 0,
            'product'          => ['id' => $prod['id'], 'name' => $prod['name'], 'image' => $prod['image']],
            'plan'             => $plan,
        ];
    }
}

/* ---- totals ---- */
$rent_total    = 0;
$deposit_total = 0;
foreach ($cart as $item) {
    $rent_total    += $item['plan']['monthly'] * $item['qty'];
    $deposit_total += $item['plan']['deposit'] * $item['qty'];
}
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/header.php"; ?>
    <link rel="stylesheet" href="css/rental.css">
</head>

<body class="inner-page">
    <div id="wrapper">
        <?php include_once "design/nav.php"; ?>
        <div class="clearfix"></div>

        <div class="rent-scope">

            <section class="rent-section">
                <div class="rent-wrap">

                    <!-- flow progress: step 3 -->
                    <?php rent_steps(3); ?>

                    <div class="rent-section-head" style="margin-bottom:28px;">
                        <span class="eyebrow">Step 3</span>
                        <h2>Your rental cart</h2>
                        <p>Review your pieces and monthly rent. You can change anything before
                            you proceed — nothing is charged yet.</p>
                    </div>

                    <?php if (empty($cart)): ?>
                        <!-- Empty cart state -->
                        <div class="rent-empty" style="display:block;margin:40px auto;">
                            <div class="ic"><i class="fa fa-shopping-bag"></i></div>
                            <h3>Your rental cart is empty</h3>
                            <p>Browse our catalogue and add furniture pieces on rent.</p>
                            <a href="rent.php" class="rent-btn" style="margin-top:18px;">
                                <i class="fa fa-search"></i> Browse Rental Catalogue
                            </a>
                        </div>

                    <?php else: ?>

                    <div class="rent-cols">

                        <!-- ===================== MAIN: cart items ===================== -->
                        <div class="rent-panel" id="rcCartPanel">
                            <h3><i class="fa fa-shopping-bag"></i> Rental items (<span id="rcItemCount"><?php echo count($cart); ?></span>)</h3>

                            <?php foreach ($cart as $item):
                                $prod  = $item['product'];
                                $plan  = $item['plan'];
                                $iid   = (int)$item['item_id'];
                            ?>
                                <div class="rent-line" id="rcLine<?php echo $iid; ?>">
                                    <img class="rent-line-img" src="<?php echo rent_img($prod['image']); ?>"
                                        alt="<?php echo htmlspecialchars($prod['name']); ?> on rent" loading="lazy">
                                    <div class="rent-line-main">
                                        <h4><?php echo htmlspecialchars($prod['name']); ?></h4>
                                        <div class="tags">
                                            <span class="rent-chip"><i class="fa fa-calendar"></i> <?php echo (int)$plan['tenure']; ?>-month plan</span>
                                            <span class="rent-chip"><i class="fa fa-truck"></i> Free delivery</span>
                                            <?php if ($item['protection_addon']): ?>
                                                <span class="rent-chip" style="background:#fff8e1;color:#8a5e00;"><i class="fa fa-shield"></i> Protection</span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Qty control -->
                                        <div style="display:flex;align-items:center;gap:8px;margin-top:10px;">
                                            <label style="font-size:12.5px;color:var(--rt-dim);">Qty:</label>
                                            <div style="display:flex;align-items:center;border:1px solid var(--rt-line);border-radius:8px;overflow:hidden;">
                                                <button type="button" class="rc-qty-btn" onclick="rcChangeQty(<?php echo $iid; ?>, -1)" style="border:0;background:#f5f0ec;padding:4px 10px;cursor:pointer;font-weight:700;">−</button>
                                                <span id="rcQty<?php echo $iid; ?>" style="padding:4px 12px;font-weight:700;min-width:32px;text-align:center;"><?php echo (int)$item['qty']; ?></span>
                                                <button type="button" class="rc-qty-btn" onclick="rcChangeQty(<?php echo $iid; ?>, 1)" style="border:0;background:#f5f0ec;padding:4px 10px;cursor:pointer;font-weight:700;">+</button>
                                            </div>
                                            <span style="font-size:12px;color:var(--rt-dim);" id="rcItemPrice<?php echo $iid; ?>"><?php echo rent_money($plan['monthly'] * $item['qty']); ?>/mo</span>
                                        </div>
                                        <button class="rent-line-remove" onclick="rcRemove(<?php echo $iid; ?>)" style="background:none;border:0;cursor:pointer;color:var(--rt-dim);font-size:12.5px;margin-top:8px;padding:0;">
                                            <i class="fa fa-trash-o"></i> Remove
                                        </button>
                                    </div>
                                    <div class="rent-line-price">
                                        <div class="mo"><?php echo rent_money($plan['monthly'] * $item['qty']); ?><small>/mo</small></div>
                                        <div style="font-size:11.5px;color:var(--rt-dim);margin-top:4px;">Deposit <?php echo rent_money($plan['deposit'] * $item['qty']); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- ===================== ASIDE: order summary ===================== -->
                        <aside class="rent-aside">
                            <h3>Order summary</h3>

                            <div class="rent-srow">
                                <span class="k">Monthly rent</span>
                                <span class="v" id="rcRentTotal"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Refundable deposit</span>
                                <span class="v" id="rcDepTotal"><?php echo rent_money($deposit_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Due at checkout</span>
                                <span class="v" id="rcDueTotal"><?php echo rent_money($rent_total + $deposit_total); ?></span>
                            </div>

                            <a class="rent-btn rent-btn-block" href="rent-checkout.php" style="margin-top:16px;">
                                Proceed to Checkout <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent.php" style="margin-top:10px;">
                                <i class="fa fa-angle-left"></i> Continue browsing
                            </a>

                            <p style="font-size:11.8px;color:var(--rt-dim);line-height:1.55;text-align:center;margin:14px 0 0;">
                                Nothing is charged now — confirm your details on the next step.
                            </p>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <!-- next-step note -->
                    <div class="rent-note" style="margin-top:26px;">
                        <i class="fa fa-truck"></i>
                        <div>On the next step, just share your <b>delivery details</b> and confirm your rental request.
                            Our team will call you to arrange free delivery &amp; setup. It takes about a minute.</div>
                    </div>

                    <?php endif; /* empty cart */ ?>

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
    /* Cart interaction — qty change and remove */
    var _cartData = <?php
        $js_cart = [];
        foreach ($cart as $item) {
            $js_cart[(int)$item['item_id']] = [
                'monthly' => (int)$item['plan']['monthly'],
                'deposit' => (int)$item['plan']['deposit'],
                'qty'     => (int)$item['qty'],
            ];
        }
        echo json_encode($js_cart);
    ?>;
    var _dbMode = <?php echo $_db_cart ? 'true' : 'false'; ?>;

    function rcMoney(n) {
        return '₹' + Math.round(n).toLocaleString('en-IN');
    }

    function rcRecalcTotals() {
        var rentTotal = 0, depTotal = 0;
        Object.values(_cartData).forEach(function(d) {
            rentTotal += d.monthly * d.qty;
            depTotal  += d.deposit * d.qty;
        });
        var rt  = document.getElementById('rcRentTotal');
        var dt  = document.getElementById('rcDepTotal');
        var due = document.getElementById('rcDueTotal');
        if (rt)  rt.textContent  = rcMoney(rentTotal);
        if (dt)  dt.textContent  = rcMoney(depTotal);
        if (due) due.textContent = rcMoney(rentTotal + depTotal);
    }

    function rcChangeQty(itemId, delta) {
        if (!_cartData[itemId]) return;
        var newQty = _cartData[itemId].qty + delta;
        if (newQty < 1) { rcRemove(itemId); return; }
        _cartData[itemId].qty = newQty;

        var qEl = document.getElementById('rcQty' + itemId);
        var pEl = document.getElementById('rcItemPrice' + itemId);
        if (qEl) qEl.textContent = newQty;
        var mon = _cartData[itemId].monthly;
        if (pEl) pEl.textContent = rcMoney(mon * newQty) + '/mo';
        rcRecalcTotals();

        if (_dbMode) {
            var fd = new FormData();
            fd.append('action', 'update_qty');
            fd.append('item_id', itemId);
            fd.append('qty', newQty);
            fetch('back/rent-handler.php', { method: 'POST', body: fd }).catch(function(){});
        }
    }

    function rcRemove(itemId) {
        var line = document.getElementById('rcLine' + itemId);
        if (line) {
            line.style.opacity = '0';
            line.style.transition = 'opacity 0.3s';
            setTimeout(function() {
                line.remove();
                delete _cartData[itemId];
                rcRecalcTotals();
                var remaining = Object.keys(_cartData).length;
                var cnt = document.getElementById('rcItemCount');
                if (cnt) cnt.textContent = remaining;
                if (remaining === 0) {
                    window.location.reload();
                }
            }, 300);
        }
        if (_dbMode) {
            var fd = new FormData();
            fd.append('action', 'remove_item');
            fd.append('item_id', itemId);
            fetch('back/rent-handler.php', { method: 'POST', body: fd }).catch(function(){});
        }
    }
    </script>
</body>

</html>
