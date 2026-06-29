<?php
/* ============================================================================
   BOSK FURNITURE — RENTAL MODULE  ·  demo data + shared helpers
   ----------------------------------------------------------------------------
   This is TEMPLATE/DEMO data so the rental UI renders without the live
   rental_products / rental_plans tables. When the DB tables from the spec are
   built, replace $RENTAL_PRODUCTS with a mysqli query (same shape) and the
   pages keep working unchanged.

   Shape per product:
     id, name, category, base_value, image, gallery[], desc,
     plans[] => each: tenure (months), monthly, deposit, save (label|null)
   ========================================================================== */

$RENTAL_CATEGORIES = ['All', 'Sofas', 'Beds', 'Dining', 'Wardrobes', 'Living', 'Study'];

$RENTAL_PRODUCTS = [
    [
        'id' => 1, 'name' => 'Aspen 3-Seater Fabric Sofa', 'category' => 'Sofas',
        'base_value' => 28000, 'image' => '869486.jpg',
        'gallery' => ['869486.jpg', '888379.jpg', '130220.jpg'],
        'desc' => 'A plush 3-seater with a solid wood frame and stain-resistant fabric — the centrepiece your living room deserves, without the upfront cost.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 1499, 'deposit' => 4000, 'save' => null],
            ['tenure' => 6, 'monthly' => 1199, 'deposit' => 4000, 'save' => 'Save 20%'],
            ['tenure' => 12, 'monthly' => 999, 'deposit' => 3500, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 2, 'name' => 'Nordic Queen Bed with Storage', 'category' => 'Beds',
        'base_value' => 32000, 'image' => '245867.png',
        'gallery' => ['245867.png', '486254.jpg', '902810.jpg'],
        'desc' => 'Queen-size bed with a hydraulic storage base and a cushioned headboard. Sturdy engineered wood, finished in warm oak.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 1699, 'deposit' => 4500, 'save' => null],
            ['tenure' => 6, 'monthly' => 1349, 'deposit' => 4500, 'save' => 'Save 21%'],
            ['tenure' => 12, 'monthly' => 1099, 'deposit' => 4000, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 3, 'name' => 'Oakwood 6-Seater Dining Set', 'category' => 'Dining',
        'base_value' => 38000, 'image' => '130220.jpg',
        'gallery' => ['130220.jpg', '888379.jpg', '869486.jpg'],
        'desc' => 'A six-seater dining table with cushioned chairs in solid oak. Family dinners, sorted — pay monthly, return any time at tenure end.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 1899, 'deposit' => 5000, 'save' => null],
            ['tenure' => 6, 'monthly' => 1499, 'deposit' => 5000, 'save' => 'Save 21%'],
            ['tenure' => 12, 'monthly' => 1249, 'deposit' => 4500, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 4, 'name' => 'Sterling 4-Door Wardrobe', 'category' => 'Wardrobes',
        'base_value' => 26000, 'image' => '902810.jpg',
        'gallery' => ['902810.jpg', '217110.jpg', '130220.jpg'],
        'desc' => 'Spacious 4-door wardrobe with mirror, drawers and a hanging rail. Keeps a growing home organised from day one.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 1399, 'deposit' => 3800, 'save' => null],
            ['tenure' => 6, 'monthly' => 1099, 'deposit' => 3800, 'save' => 'Save 21%'],
            ['tenure' => 12, 'monthly' => 899, 'deposit' => 3200, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 5, 'name' => 'Cloud Recliner Armchair', 'category' => 'Living',
        'base_value' => 18000, 'image' => '888379.jpg',
        'gallery' => ['888379.jpg', '869486.jpg', '130220.jpg'],
        'desc' => 'A single-seat recliner with a smooth push-back mechanism and deep cushioning — your personal corner to unwind.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 999, 'deposit' => 2800, 'save' => null],
            ['tenure' => 6, 'monthly' => 799, 'deposit' => 2800, 'save' => 'Save 20%'],
            ['tenure' => 12, 'monthly' => 649, 'deposit' => 2400, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 6, 'name' => 'Metro TV Entertainment Unit', 'category' => 'Living',
        'base_value' => 16000, 'image' => '869486.jpg',
        'gallery' => ['869486.jpg', '888379.jpg', '217110.jpg'],
        'desc' => 'A wall TV unit with open shelves and closed storage for consoles and decor. Clean lines that suit any living room.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 899, 'deposit' => 2500, 'save' => null],
            ['tenure' => 6, 'monthly' => 699, 'deposit' => 2500, 'save' => 'Save 22%'],
            ['tenure' => 12, 'monthly' => 579, 'deposit' => 2100, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 7, 'name' => 'Studious Work Desk', 'category' => 'Study',
        'base_value' => 12000, 'image' => '902810.jpg',
        'gallery' => ['902810.jpg', '130220.jpg', '217110.jpg'],
        'desc' => 'A compact work-from-home desk with a cable channel and a side drawer. Built for focus in any corner of the house.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 749, 'deposit' => 2000, 'save' => null],
            ['tenure' => 6, 'monthly' => 599, 'deposit' => 2000, 'save' => 'Save 20%'],
            ['tenure' => 12, 'monthly' => 499, 'deposit' => 1700, 'save' => 'Best value'],
        ],
    ],
    [
        'id' => 8, 'name' => 'Bloom Coffee Table', 'category' => 'Living',
        'base_value' => 9000, 'image' => '888379.jpg',
        'gallery' => ['888379.jpg', '130220.jpg', '869486.jpg'],
        'desc' => 'A round coffee table with a lower shelf — the finishing touch that pulls the living room together.',
        'plans' => [
            ['tenure' => 3, 'monthly' => 599, 'deposit' => 1500, 'save' => null],
            ['tenure' => 6, 'monthly' => 479, 'deposit' => 1500, 'save' => 'Save 20%'],
            ['tenure' => 12, 'monthly' => 399, 'deposit' => 1300, 'save' => 'Best value'],
        ],
    ],
];

/* ---- helpers ------------------------------------------------------------- */

if (!function_exists('rent_img')) {
    /** Resolve a rental product image to its URL (reuses existing product images). */
    function rent_img($file)
    {
        return 'admin/product_image/' . $file;
    }
}

if (!function_exists('rent_money')) {
    /** Format an integer rupee amount: 1499 -> ₹1,499 */
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
            1 => ['Browse',   'fa-search'],
            2 => ['Plan',     'fa-calendar'],
            3 => ['Rent Cart', 'fa-shopping-bag'],
            4 => ['Checkout', 'fa-check-circle'],
        ];
        echo '<div class="rent-progress">';
        foreach ($steps as $n => $s) {
            $cls = $n < $current ? 'done' : ($n == $current ? 'active' : '');
            $inner = $n < $current ? '<i class="fa fa-check"></i>' : $n;
            echo '<div class="step ' . $cls . '">';
            echo '<div class="dot">' . $inner . '</div>';
            echo '<div class="lbl">' . htmlspecialchars($s[0]) . '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}
?>
