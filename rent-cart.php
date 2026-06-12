<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Your Rental Cart | Bosk Furniture on Rent';
$page_description = 'Review your rental cart — monthly rent, refundable deposit and free delivery — then continue to a quick one-time KYC at Bosk Furniture.';
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

/* ---- totals ---- */
$rent_total    = 0;
$deposit_total = 0;
foreach ($cart as $item) {
    $rent_total    += $item['plan']['monthly'];
    $deposit_total += $item['plan']['deposit'];
}
$due_today = $rent_total + $deposit_total;
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
                        <p>Review your pieces, monthly rent and refundable deposit. You can change anything before
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
                                        <div style="font-size:11.5px;color:var(--rt-dim);margin-top:4px;">
                                            + <?php echo rent_money($plan['deposit']); ?> deposit
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- ===================== ASIDE: order summary ===================== -->
                        <aside class="rent-aside">
                            <h3>Order summary</h3>

                            <div class="rent-srow">
                                <span class="k">First month's rent</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Refundable deposit</span>
                                <span class="v"><?php echo rent_money($deposit_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Delivery &amp; setup</span>
                                <span class="v" style="color:var(--rt-green);">FREE</span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Due today</span>
                                <span class="v"><?php echo rent_money($due_today); ?></span>
                            </div>

                            <div class="rent-refund-note">
                                <i class="fa fa-shield"></i>
                                <div>The <?php echo rent_money($deposit_total); ?> deposit is fully refundable — returned
                                    to you when you return the furniture in good condition at the end of your tenure.</div>
                            </div>

                            <a class="rent-btn rent-btn-block" href="kyc.php" style="margin-top:16px;">
                                Proceed to KYC <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent.php" style="margin-top:10px;">
                                <i class="fa fa-angle-left"></i> Continue browsing
                            </a>

                            <p style="font-size:11.8px;color:var(--rt-dim);line-height:1.55;text-align:center;margin:14px 0 0;">
                                Monthly rent auto-charged each cycle after the first month.
                            </p>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <!-- one-time KYC note -->
                    <div class="rent-note" style="margin-top:26px;">
                        <i class="fa fa-id-card-o"></i>
                        <div>Renting requires a quick <b>one-time KYC</b> — upload an ID &amp; address proof on the next
                            step so we can verify you and schedule free delivery. It takes about two minutes.</div>
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
