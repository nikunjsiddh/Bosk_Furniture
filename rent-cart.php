<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Your Rental Cart | Bosk Furniture on Rent';
$page_description = 'Review your rental cart — monthly rent and free delivery — then continue to checkout at Bosk Furniture.';
$page_robots      = 'noindex, follow';
$page_canonical   = '/rent-cart';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'Rental Cart', 'url' => '/rent-cart']
];
include_once "design/rent-data.php";

/* ---- demo cart: 2 items, each on the 6-month plan (plan index 1) ---- */
$CART_PLAN_INDEX = 1; // 6-month plan
$cart = [];
foreach ([1, 4] as $cid) {
    $prod = rent_find($cid);
    if (!$prod) {
        continue;
    }
    $plan = isset($prod['plans'][$CART_PLAN_INDEX]) ? $prod['plans'][$CART_PLAN_INDEX] : $prod['plans'][0];
    $cart[] = ['product' => $prod, 'plan' => $plan];
}

/* ---- totals (rent only) ---- */
$rent_total = 0;
foreach ($cart as $item) {
    $rent_total += $item['plan']['monthly'];
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

                    <div class="rent-cols">

                        <!-- ===================== MAIN: cart items ===================== -->
                        <div class="rent-panel">
                            <h3><i class="fa fa-shopping-bag"></i> Rental items (<?php echo count($cart); ?>)</h3>

                            <?php foreach ($cart as $item):
                                $p     = $item['product'];
                                $plan  = $item['plan'];
                            ?>
                                <div class="rent-line">
                                    <img class="rent-line-img" src="<?php echo rent_img($p['image']); ?>"
                                        alt="<?php echo htmlspecialchars($p['name']); ?> on rent" loading="lazy">
                                    <div class="rent-line-main">
                                        <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                                        <div class="tags">
                                            <span class="rent-chip"><i class="fa fa-calendar"></i> <?php echo (int)$plan['tenure']; ?>-month plan</span>
                                            <span class="rent-chip"><i class="fa fa-truck"></i> Free delivery</span>
                                        </div>
                                        <a class="rent-line-remove"><i class="fa fa-trash-o"></i> Remove</a>
                                    </div>
                                    <div class="rent-line-price">
                                        <div class="mo"><?php echo rent_money($plan['monthly']); ?><small>/mo</small></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- ===================== ASIDE: order summary ===================== -->
                        <aside class="rent-aside">
                            <h3>Order summary</h3>

                            <div class="rent-srow">
                                <span class="k">Monthly rent</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Total rent / month</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>

                            <a class="rent-btn rent-btn-block" href="rent-checkout" style="margin-top:16px;">
                                Proceed to Checkout <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent" style="margin-top:10px;">
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

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>
</body>

</html>
