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

/* ---- totals: monthly rent + refundable deposit (payable now = deposit + 1st month) ---- */
$rent_total = 0;
$dep_total  = 0;
foreach ($cart as $item) {
    $rent_total += $item['plan']['monthly'];
    $dep_total  += $item['plan']['deposit'];
}
$shield_total = (int)round($rent_total * RENT_SHIELD_RATE); // BOSK Shield add-on (10%/mo)
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
                                            <span class="rent-chip dep"><i class="fa fa-shield"></i> <?php echo rent_money($plan['deposit']); ?> refundable deposit</span>
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

                            <!-- BOSK Shield add-on (cart level) -->
                            <div class="rent-addon" id="rcShield" onclick="rcShieldToggle()" style="margin-bottom:14px;background:#fff;">
                                <div class="ic"><i class="fa fa-shield"></i></div>
                                <div>
                                    <b>BOSK Shield</b>
                                    <span>Damage protection for all items</span>
                                </div>
                                <div class="price">+<?php echo rent_money($shield_total); ?>/mo</div>
                            </div>

                            <div class="rent-srow" style="margin-top:8px;">
                                <span class="k">Monthly rent</span>
                                <span class="v" id="rcMonthly"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow" id="rcShieldRow" style="display:none;">
                                <span class="k">BOSK Shield / month</span>
                                <span class="v"><?php echo rent_money($shield_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Refundable deposit (one-time)</span>
                                <span class="v"><?php echo rent_money($dep_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Payable now (deposit + 1st month)</span>
                                <span class="v" id="rcPayNow"><?php echo rent_money($dep_total + $rent_total); ?></span>
                            </div>

                            <a class="rent-btn rent-btn-block" href="rent-kyc.php" style="margin-top:16px;">
                                Continue — KYC &amp; Delivery Slot <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent.php" style="margin-top:10px;">
                                <i class="fa fa-angle-left"></i> Continue browsing
                            </a>

                            <p style="font-size:11.8px;color:var(--rt-dim);line-height:1.55;text-align:center;margin:14px 0 0;">
                                The deposit is 100% refundable at return. Nothing is charged until the final step.
                            </p>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <!-- next-step note -->
                    <div class="rent-note" style="margin-top:26px;">
                        <i class="fa fa-id-card-o"></i>
                        <div>Next: a quick <b>KYC &amp; delivery slot</b> step — verify your mobile, upload ID &amp; address
                            proof and pick a delivery window. It keeps rentals safe for everyone and takes about 2 minutes.</div>
                    </div>

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* cart summary state (demo, UI only) */
        var RC = {
            rent: <?php echo (int)$rent_total; ?>,
            deposit: <?php echo (int)$dep_total; ?>,
            shield: <?php echo (int)$shield_total; ?>,
            shieldOn: false
        };

        function rcMoney(n) { return '₹' + Math.round(n).toLocaleString('en-IN'); }

        function rcRefresh() {
            var monthly = RC.rent + (RC.shieldOn ? RC.shield : 0);
            document.getElementById('rcMonthly').textContent = rcMoney(RC.rent);
            document.getElementById('rcShieldRow').style.display = RC.shieldOn ? '' : 'none';
            document.getElementById('rcPayNow').textContent = rcMoney(RC.deposit + monthly);
        }

        function rcShieldToggle() {
            RC.shieldOn = !RC.shieldOn;
            document.getElementById('rcShield').classList.toggle('on', RC.shieldOn);
            rcRefresh();
        }
    </script>
</body>

</html>
