<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Rental Checkout | Bosk Furniture';
$page_description = 'Confirm your delivery address and place your furniture rental request — our team calls you to arrange free delivery and setup.';
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

/* ---- totals: payable now = refundable deposit + 1st month rent ---- */
$rent_total = 0;   // monthly rent (sum of selected plans)
$dep_total  = 0;   // one-time refundable deposit
foreach ($CART as $line) {
    $rent_total += (int)$line['plan']['monthly'];
    $dep_total  += (int)$line['plan']['deposit'];
}
$pay_now = $dep_total + $rent_total;

/* demo order reference shown on confirmation */
$order_ref = 'BR' . date('ymd') . str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
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
                        <h2>Checkout &amp; payment</h2>
                        <p>Confirm your delivery address, choose how to pay the refundable deposit and first month's
                            rent, and your rental is booked.</p>
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
                            </div>

                            <!-- Payment method (mock UI) -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-credit-card"></i> Payment method</h3>
                                <div id="ckPayOpts">
                                    <div class="rent-pay-opt selected" onclick="ckPaySelect(this)">
                                        <div class="ic"><i class="fa fa-mobile" style="font-size:22px;"></i></div>
                                        <div>
                                            <b>UPI / UPI Autopay</b>
                                            <span>Recommended — monthly rent auto-debits, cancel anytime</span>
                                        </div>
                                        <div class="rad"></div>
                                    </div>
                                </div>
                                <div class="kyc-secure" style="margin-top:12px;">
                                    <i class="fa fa-lock"></i>
                                    <div>Payments are processed on a <b>secure gateway</b>. The deposit is held safely and
                                        auto-refunded within 5–7 days of pickup at tenure end.</div>
                                </div>
                            </div>

                        </div>

                        <!-- ===================== ASIDE ===================== -->
                        <aside class="rent-aside">
                            <h3>Rental summary</h3>

                            <?php foreach ($CART as $line): ?>
                                <div class="rent-srow">
                                    <span class="k" style="max-width:70%;"><?php echo htmlspecialchars($line['product']['name']); ?>
                                        · <?php echo (int)$line['plan']['tenure']; ?> mo</span>
                                    <span class="v"><?php echo rent_money($line['plan']['monthly']); ?>/mo</span>
                                </div>
                            <?php endforeach; ?>

                            <div class="rent-srow">
                                <span class="k">Monthly rent (from month 2)</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">1st month rent</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Refundable deposit (one-time)</span>
                                <span class="v"><?php echo rent_money($dep_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Payable now</span>
                                <span class="v"><?php echo rent_money($pay_now); ?></span>
                            </div>

                            <div class="rent-refund-note" style="margin-top:12px;">
                                <i class="fa fa-shield"></i>
                                <div><?php echo rent_money($dep_total); ?> of this is a <b>refundable deposit</b> —
                                    you get it back when the furniture is returned.</div>
                            </div>

                            <button type="button" id="confirmRentalBtn" class="rent-btn rent-btn-block" style="border:0;cursor:pointer;width:100%;margin-top:16px;">
                                <i class="fa fa-check-circle"></i> Pay <?php echo rent_money($pay_now); ?> &amp; Book
                            </button>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent-kyc.php" style="margin-top:10px;">
                                <i class="fa fa-angle-left"></i> Back to KYC &amp; slot
                            </a>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <div class="rent-note" style="margin-top:30px;">
                        <i class="fa fa-info-circle"></i>
                        <div>After payment: our team reviews your <b>KYC</b> (usually within a few hours), then delivers
                            &amp; installs in your chosen slot. You can track everything — billing, requests, renewals —
                            in <b>My Rentals</b>.</div>
                    </div>

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <!-- ===================== ORDER CONFIRMATION MODAL ===================== -->
        <style>
            .rent-modal-overlay{position:fixed;inset:0;background:rgba(40,20,10,.55);display:none;
                align-items:center;justify-content:center;z-index:99999;padding:20px;}
            .rent-modal-overlay.open{display:flex;}
            .rent-modal{background:#fff;max-width:440px;width:100%;border-radius:16px;
                padding:36px 30px 30px;text-align:center;position:relative;
                box-shadow:0 24px 60px rgba(0,0,0,.28);animation:rentPop .25s ease;}
            @keyframes rentPop{from{transform:translateY(14px) scale(.96);opacity:0}to{transform:none;opacity:1}}
            .rent-modal .tick{width:76px;height:76px;border-radius:50%;
                background:var(--rt-green,#2e9e5b);color:#fff;display:flex;align-items:center;
                justify-content:center;font-size:38px;margin:0 auto 18px;}
            .rent-modal h3{font-size:22px;color:var(--rt-heading,#3a2417);margin:0 0 8px;}
            .rent-modal p{font-size:14px;line-height:1.65;color:var(--rt-text,#5b4a3f);margin:0 0 6px;}
            .rent-modal .ord-ref{display:inline-block;margin:14px 0 18px;padding:8px 16px;
                background:var(--rt-soft,#f6efe9);border-radius:8px;font-weight:700;
                letter-spacing:.5px;color:var(--rt-brand,#532A1A);}
            .rent-modal .rent-btn{margin-top:6px;}
            .rent-modal .modal-x{position:absolute;top:12px;right:14px;border:0;background:none;
                font-size:22px;line-height:1;color:var(--rt-dim,#9a8c80);cursor:pointer;}
        </style>

        <div class="rent-modal-overlay" id="rentConfirmModal" role="dialog" aria-modal="true" aria-labelledby="rentConfirmTitle">
            <div class="rent-modal">
                <button type="button" class="modal-x" data-close aria-label="Close">&times;</button>
                <div class="tick"><i class="fa fa-check"></i></div>
                <h3 id="rentConfirmTitle">Rental booked!</h3>
                <p>Payment received — your rental order has been placed successfully.</p>
                <span class="ord-ref">Order ID: <?php echo htmlspecialchars($order_ref); ?></span>
                <p>Next: KYC review (a few hours), then free delivery &amp; installation in your chosen slot.</p>
                <a class="rent-btn rent-btn-block" href="my-rentals.php" style="margin-top:18px;">
                    View My Rentals <i class="fa fa-arrow-right"></i>
                </a>
                <a class="rent-btn-outline rent-btn rent-btn-block" href="rent.php" data-close style="margin-top:10px;">
                    Continue browsing
                </a>
            </div>
        </div>

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* Payment method selection (mock) */
        function ckPaySelect(opt) {
            document.querySelectorAll('#ckPayOpts .rent-pay-opt').forEach(function (o) {
                o.classList.remove('selected');
            });
            opt.classList.add('selected');
        }

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

        /* Order confirmation popup */
        (function () {
            var btn = document.getElementById('confirmRentalBtn');
            var overlay = document.getElementById('rentConfirmModal');
            if (!btn || !overlay) return;

            function open() {
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
            function close() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            btn.addEventListener('click', open);

            /* close on X / overlay click / Esc */
            overlay.querySelectorAll('[data-close]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    if (!el.getAttribute('href')) e.preventDefault();
                    close();
                });
            });
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) close();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') close();
            });
        })();
    </script>
</body>

</html>
