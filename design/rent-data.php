<?php
/* ============================================================================
   BOSK FURNITURE — RENTAL MODULE  · data layer
   design/rent-data.php
   ----------------------------------------------------------------------------
   Loads rental product & category data from the DB (rental_plans table).
   Falls back to the built-in demo array if the rental tables do not exist yet
   (e.g., schema has not been run) so the UI remains functional in all envs.
   ============================================================================ */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Connect if not already connected */
if (!isset($con) || !$con) {
    $depth = 0;
    $dir   = __DIR__;
    while ($depth < 5) {
        $try = $dir . '/connect.php';
        if (file_exists($try)) { include_once $try; break; }
        $dir = dirname($dir);
        $depth++;
    }
}

/* ---- helpers ------------------------------------------------------------- */

if (!function_exists('rent_img')) {
    /** Resolve a rental product image to its URL. */
    function rent_img($file)
    {
        return 'Admin/product_image/' . $file;
    }
}

if (!function_exists('rent_money')) {
    /** Format an integer rupee amount: 1499 → ₹1,499 */
    function rent_money($n)
    {
        return '₹' . number_format((int)$n);
    }
}

if (!function_exists('rent_from_price')) {
    /** Lowest monthly price across a product's plans (the "from ₹X/mo"). */
    function rent_from_price($product)
    {
        $min = null;
        foreach ($product['plans'] as $p) {
            if ($min === null || $p['monthly'] < $min) $min = $p['monthly'];
        }
        return $min;
    }
}

if (!function_exists('rent_find')) {
    /** Look up a product by id (returns null if not found). */
    function rent_find($id)
    {
        global $RENTAL_PRODUCTS;
        foreach ($RENTAL_PRODUCTS as $p) {
            if ((int)$p['id'] === (int)$id) return $p;
        }
        return null;
    }
}

if (!function_exists('rent_steps')) {
    /**
     * Render the rental flow progress stepper.
     * @param int $current 1=Browse 2=Plan 3=Cart 4=Checkout
     */
    function rent_steps($current)
    {
        $steps = [
            1 => ['Browse',    'fa-search'],
            2 => ['Plan',      'fa-calendar'],
            3 => ['Rent Cart', 'fa-shopping-bag'],
            4 => ['Checkout',  'fa-check-circle'],
        ];
        echo '<div class="rent-progress">';
        foreach ($steps as $n => $s) {
            $cls   = $n < $current ? 'done' : ($n == $current ? 'active' : '');
            $inner = $n < $current ? '<i class="fa fa-check"></i>' : $n;
            echo '<div class="step ' . $cls . '">';
            echo '<div class="dot">' . $inner . '</div>';
            echo '<div class="lbl">' . htmlspecialchars($s[0]) . '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}

if (!function_exists('rent_cart_count')) {
    /**
     * Number of items in the active rental cart (from DB or session fallback).
     */
    function rent_cart_count()
    {
        global $con;
        if (!$con) return 0;
        // Check tables exist
        $t = mysqli_query($con, "SHOW TABLES LIKE 'carts'");
        if (!$t || mysqli_num_rows($t) === 0) return 0;

        $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
        $token   = $_SESSION['rent_session'] ?? null;

        if ($user_id) {
            $r = mysqli_query($con, "SELECT SUM(ci.qty) FROM carts c JOIN cart_items ci ON ci.cart_id=c.id WHERE c.user_id=$user_id");
        } elseif ($token) {
            $tok = mysqli_real_escape_string($con, $token);
            $r   = mysqli_query($con, "SELECT SUM(ci.qty) FROM carts c JOIN cart_items ci ON ci.cart_id=c.id WHERE c.session_token='$tok'");
        } else {
            return 0;
        }
        if (!$r) return 0;
        $row = mysqli_fetch_row($r);
        return (int)($row[0] ?? 0);
    }
}

/* ============================================================================
   LIVE DB LOAD — tries to pull from rental_plans + products tables.
   Falls back to the static demo array if tables don't exist.
   ============================================================================ */

$_rent_db_ok = false;
$RENTAL_CATEGORIES = [];
$RENTAL_PRODUCTS   = [];

if (isset($con) && $con) {
    // Check if rental_plans table exists
    $chk = mysqli_query($con, "SHOW TABLES LIKE 'rental_plans'");
    if ($chk && mysqli_num_rows($chk) > 0) {
        $_rent_db_ok = true;

        // --- Categories ---
        $RENTAL_CATEGORIES = ['All'];
        $cq = mysqli_query($con, "SELECT DISTINCT TRIM(pcategory) cat FROM products WHERE available_for_rent=1 AND pcategory != '' ORDER BY cat");
        if ($cq) {
            while ($crow = mysqli_fetch_row($cq)) {
                if ($crow[0]) $RENTAL_CATEGORIES[] = $crow[0];
            }
        }
        if (count($RENTAL_CATEGORIES) <= 1) {
            // Fallback to category table
            $RENTAL_CATEGORIES = ['All'];
            $cq2 = mysqli_query($con, "SELECT name FROM category WHERE is_active=1 ORDER BY display_order, name");
            if ($cq2) {
                while ($crow = mysqli_fetch_row($cq2)) {
                    $RENTAL_CATEGORIES[] = $crow[0];
                }
            }
        }

        // --- Products with plans ---
        $pq = mysqli_query($con, "
            SELECT p.id, p.pname name, TRIM(p.pcategory) category,
                   p.new_price base_value, p.img1 image,
                   p.description `desc`, p.badge_label
            FROM products p
            WHERE p.available_for_rent = 1
            ORDER BY p.id
        ");

        if ($pq) {
            while ($prod = mysqli_fetch_assoc($pq)) {
                $pid = (int)$prod['id'];

                // Load plans
                $rq = mysqli_query($con, "
                    SELECT id, tenure_months tenure, monthly_rent monthly, deposit, save_label `save`
                    FROM rental_plans
                    WHERE product_id = $pid AND is_active = 1
                    ORDER BY tenure_months ASC
                ");
                $plans = [];
                while ($plan = mysqli_fetch_assoc($rq)) {
                    $plans[] = $plan;
                }

                if (empty($plans)) {
                    // Generate default 3, 6, 12 month rental plans based on base_value if custom plans not added yet
                    $bv = max(500, (int)$prod['base_value']);
                    $m3  = round($bv * 0.12); // ~12% per month
                    $m6  = round($bv * 0.10); // ~10% per month
                    $m12 = round($bv * 0.08); // ~8% per month
                    $dep = round($bv * 0.35); // ~35% deposit

                    $plans = [
                        ['id' => 0, 'tenure' => 3,  'monthly' => max(299, $m3),  'deposit' => max(1000, $dep), 'save' => ''],
                        ['id' => 0, 'tenure' => 6,  'monthly' => max(249, $m6),  'deposit' => max(1000, $dep), 'save' => 'Save 15%'],
                        ['id' => 0, 'tenure' => 12, 'monthly' => max(199, $m12), 'deposit' => max(800,  $dep), 'save' => 'Best value'],
                    ];
                }

                // Load gallery images
                $gq = mysqli_query($con, "SELECT filename FROM product_images WHERE product_id=$pid ORDER BY sort_order, id LIMIT 3");
                $gallery = [];
                while ($gi = mysqli_fetch_row($gq)) {
                    $gallery[] = $gi[0];
                }
                if (empty($gallery)) {
                    $gallery = [$prod['image']];
                }

                $RENTAL_PRODUCTS[] = [
                    'id'         => $pid,
                    'name'       => $prod['name'],
                    'category'   => $prod['category'],
                    'base_value' => (int)$prod['base_value'],
                    'image'      => $prod['image'],
                    'gallery'    => $gallery,
                    'desc'       => $prod['desc'] ?? '',
                    'badge'      => $prod['badge_label'] ?? null,
                    'plans'      => $plans,
                ];
            }
        }
    }
}

/* ============================================================================
   FALLBACK — static demo data used when DB tables are not yet created
   ============================================================================ */

if (!$_rent_db_ok || empty($RENTAL_PRODUCTS)) {

    $RENTAL_CATEGORIES = ['All', 'Sofas', 'Beds', 'Dining', 'Wardrobes', 'Living', 'Study'];

    $RENTAL_PRODUCTS = [
        [
            'id' => 1, 'name' => 'Aspen 3-Seater Fabric Sofa', 'category' => 'Sofas',
            'base_value' => 28000, 'image' => '869486.jpg', 'badge' => null,
            'gallery' => ['869486.jpg', '888379.jpg', '130220.jpg'],
            'desc' => 'A plush 3-seater with a solid wood frame and stain-resistant fabric — the centrepiece your living room deserves, without the upfront cost.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 1499, 'deposit' => 4000, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 1199, 'deposit' => 4000, 'save' => 'Save 20%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 999,  'deposit' => 3500, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 2, 'name' => 'Nordic Queen Bed with Storage', 'category' => 'Beds',
            'base_value' => 32000, 'image' => '245867.png', 'badge' => null,
            'gallery' => ['245867.png', '486254.jpg', '902810.jpg'],
            'desc' => 'Queen-size bed with a hydraulic storage base and a cushioned headboard. Sturdy engineered wood, finished in warm oak.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 1699, 'deposit' => 4500, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 1349, 'deposit' => 4500, 'save' => 'Save 21%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 1099, 'deposit' => 4000, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 3, 'name' => 'Oakwood 6-Seater Dining Set', 'category' => 'Dining',
            'base_value' => 38000, 'image' => '130220.jpg', 'badge' => null,
            'gallery' => ['130220.jpg', '888379.jpg', '869486.jpg'],
            'desc' => 'A six-seater dining table with cushioned chairs in solid oak. Family dinners, sorted — pay monthly, return any time at tenure end.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 1899, 'deposit' => 5000, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 1499, 'deposit' => 5000, 'save' => 'Save 21%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 1249, 'deposit' => 4500, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 4, 'name' => 'Sterling 4-Door Wardrobe', 'category' => 'Wardrobes',
            'base_value' => 26000, 'image' => '902810.jpg', 'badge' => null,
            'gallery' => ['902810.jpg', '217110.jpg', '130220.jpg'],
            'desc' => 'Spacious 4-door wardrobe with mirror, drawers and a hanging rail. Keeps a growing home organised from day one.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 1399, 'deposit' => 3800, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 1099, 'deposit' => 3800, 'save' => 'Save 21%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 899,  'deposit' => 3200, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 5, 'name' => 'Cloud Recliner Armchair', 'category' => 'Living',
            'base_value' => 18000, 'image' => '888379.jpg', 'badge' => null,
            'gallery' => ['888379.jpg', '869486.jpg', '130220.jpg'],
            'desc' => 'A single-seat recliner with a smooth push-back mechanism and deep cushioning — your personal corner to unwind.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 999, 'deposit' => 2800, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 799, 'deposit' => 2800, 'save' => 'Save 20%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 649, 'deposit' => 2400, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 6, 'name' => 'Metro TV Entertainment Unit', 'category' => 'Living',
            'base_value' => 16000, 'image' => '869486.jpg', 'badge' => null,
            'gallery' => ['869486.jpg', '888379.jpg', '217110.jpg'],
            'desc' => 'A wall TV unit with open shelves and closed storage for consoles and decor. Clean lines that suit any living room.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 899, 'deposit' => 2500, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 699, 'deposit' => 2500, 'save' => 'Save 22%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 579, 'deposit' => 2100, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 7, 'name' => 'Studious Work Desk', 'category' => 'Study',
            'base_value' => 12000, 'image' => '902810.jpg', 'badge' => null,
            'gallery' => ['902810.jpg', '130220.jpg', '217110.jpg'],
            'desc' => 'A compact work-from-home desk with a cable channel and a side drawer. Built for focus in any corner of the house.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 749, 'deposit' => 2000, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 599, 'deposit' => 2000, 'save' => 'Save 20%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 499, 'deposit' => 1700, 'save' => 'Best value'],
            ],
        ],
        [
            'id' => 8, 'name' => 'Bloom Coffee Table', 'category' => 'Living',
            'base_value' => 9000, 'image' => '888379.jpg', 'badge' => null,
            'gallery' => ['888379.jpg', '130220.jpg', '869486.jpg'],
            'desc' => 'A round coffee table with a lower shelf — the finishing touch that pulls the living room together.',
            'plans' => [
                ['id' => 0, 'tenure' => 3,  'monthly' => 599, 'deposit' => 1500, 'save' => null],
                ['id' => 0, 'tenure' => 6,  'monthly' => 479, 'deposit' => 1500, 'save' => 'Save 20%'],
                ['id' => 0, 'tenure' => 12, 'monthly' => 399, 'deposit' => 1300, 'save' => 'Best value'],
            ],
        ],
    ];
}
?>
