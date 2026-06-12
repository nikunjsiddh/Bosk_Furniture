<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Rental Checkout | Bosk Furniture';
$page_description = 'Confirm your delivery address and set up secure recurring payment for your furniture rental — pay first month plus refundable deposit today.';
$page_canonical   = '/rent-checkout';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'Checkout', 'url' => '/rent-checkout']
];
include_once "design/rent-data.php";

/* ---- demo rental cart (same shape as rent-cart): item = product + chosen plan ---- */
$CART = [];
$_p = rent_find(1);                       // Aspen 3-Seater Fabric Sofa
if ($_p) { $CART[] = ['product' => $_p, 'plan' => $_p['plans'][2]]; }   // 12-month plan
$_p = rent_find(2);                       // Nordic Queen Bed with Storage
if ($_p) { $CART[] = ['product' => $_p, 'plan' => $_p['plans'][1]]; }   // 6-month plan
if (empty($CART)) { $CART[] = ['product' => $GLOBALS['RENTAL_PRODUCTS'][0], 'plan' => $GLOBALS['RENTAL_PRODUCTS'][0]['plans'][0]]; }

/* ---- totals ---- */
$rent_total    = 0;   // first month's rent (sum of monthly)
$deposit_total = 0;   // refundable deposits
foreach ($CART as $line) {
    $rent_total    += (int)$line['plan']['monthly'];
    $deposit_total += (int)$line['plan']['deposit'];
}
$pay_today = $rent_total + $deposit_total;     // delivery is FREE
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

                    <?php rent_steps(5); ?>

                    <div class="rent-section-head" style="margin-top:18px;">
                        <span class="eyebrow">Final step</span>
                        <h2>Checkout</h2>
                        <p>Confirm where we should deliver and set up your pieces, then pay your first month's
                            rent and refundable deposit to confirm the rental.</p>
                    </div>

                    <div class="rent-cols">

                        <!-- ===================== MAIN ===================== -->
                        <div>

                            <!-- Delivery address -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-map-marker"></i> Delivery address</h3>
                                <div class="kyc-grid">
                                    <div class="kyc-field">
                                        <label for="ck-name">Full name</label>
                                        <input type="text" id="ck-name" name="name" placeholder="e.g. Nikunj Patel" value="">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-mobile">Mobile number</label>
                                        <input type="tel" id="ck-mobile" name="mobile" placeholder="10-digit mobile" maxlength="10">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-pincode">Pincode</label>
                                        <input type="text" id="ck-pincode" name="pincode" placeholder="364001" maxlength="6">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-city">City</label>
                                        <input type="text" id="ck-city" name="city" placeholder="Bhavnagar" value="">
                                    </div>
                                    <div class="kyc-field" style="grid-column:1 / -1;">
                                        <label for="ck-address">Full address (house / flat, street, area &amp; landmark)</label>
                                        <input type="text" id="ck-address" name="address" placeholder="Flat no., building, street, area, landmark">
                                    </div>
                                </div>
                                <div class="rent-note" style="margin-top:16px;">
                                    <i class="fa fa-truck"></i>
                                    <div>Free delivery &amp; professional setup is included. Our team will call on this number
                                        to schedule a convenient slot after payment.</div>
                                </div>
                            </div>

                            <!-- Payment -->
                            <div class="rent-panel">
                                <h3><i class="fa fa-credit-card"></i> Payment</h3>
                                <p style="font-size:14px;line-height:1.7;color:var(--rt-text);margin:0 0 16px;">
                                    Renting is a simple recurring setup — you pay once today and the monthly rent is
                                    auto-charged after that, so you never have to remember a due date.
                                </p>

                                <div style="display:flex;flex-direction:column;gap:14px;">
                                    <div style="display:flex;gap:12px;align-items:flex-start;">
                                        <i class="fa fa-check-circle" style="color:var(--rt-green);font-size:18px;margin-top:2px;"></i>
                                        <div style="font-size:13.5px;line-height:1.6;">
                                            <b style="color:var(--rt-heading);">Pay today:</b> your first month's rent
                                            <b><?php echo rent_money($rent_total); ?></b> + a fully refundable deposit
                                            <b><?php echo rent_money($deposit_total); ?></b>.
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:12px;align-items:flex-start;">
                                        <i class="fa fa-refresh" style="color:var(--rt-accent);font-size:17px;margin-top:2px;"></i>
                                        <div style="font-size:13.5px;line-height:1.6;">
                                            <b style="color:var(--rt-heading);">From next month:</b> the monthly rent
                                            <b><?php echo rent_money($rent_total); ?>/month</b> is auto-charged via secure
                                            recurring billing (e.g. Razorpay Subscriptions / UPI AutoPay).
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:12px;align-items:flex-start;">
                                        <i class="fa fa-recycle" style="color:var(--rt-accent);font-size:17px;margin-top:2px;"></i>
                                        <div style="font-size:13.5px;line-height:1.6;">
                                            <b style="color:var(--rt-heading);">Total freedom:</b> cancel, return, extend or
                                            buy out any time at tenure end — billing stops the moment you return.
                                        </div>
                                    </div>
                                </div>

                                <div class="kyc-secure">
                                    <i class="fa fa-lock"></i>
                                    <div>Payments are processed over a secure, encrypted connection. Bosk Furniture never
                                        stores your full card or UPI details.</div>
                                </div>
                            </div>

                        </div>

                        <!-- ===================== ASIDE ===================== -->
                        <aside class="rent-aside">
                            <h3>Payment summary</h3>

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
                                <span class="k">Pay today</span>
                                <span class="v"><?php echo rent_money($pay_today); ?></span>
                            </div>

                            <p style="font-size:12.5px;color:var(--rt-dim);margin:10px 0 16px;line-height:1.55;">
                                Then <b style="color:var(--rt-heading);"><?php echo rent_money($rent_total); ?>/month</b>
                                auto-charged on your billing date until your tenure ends.
                            </p>

                            <a class="rent-btn rent-btn-block" href="my-rentals.php">
                                <i class="fa fa-lock"></i> Pay &amp; Confirm Rental
                            </a>

                            <div class="rent-refund-note">
                                <i class="fa fa-shield"></i>
                                <div>The <?php echo rent_money($deposit_total); ?> deposit is 100% refundable — returned
                                    to your account once you return the furniture in good condition.</div>
                            </div>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <div class="rent-note" style="margin-top:30px;">
                        <i class="fa fa-info-circle"></i>
                        <div>You'll receive an order confirmation by SMS &amp; email as soon as payment succeeds. Our team
                            then calls you to schedule <b>free delivery &amp; setup</b> at your convenience — usually within
                            2&ndash;4 working days.</div>
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
        /* Keep mobile / pincode inputs numeric (demo-only convenience) */
        (function () {
            ['ck-mobile', 'ck-pincode'].forEach(function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', function () {
                    el.value = el.value.replace(/[^0-9]/g, '');
                });
            });
        })();
    </script>
</body>

</html>
