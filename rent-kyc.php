<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'KYC & Delivery Slot | Bosk Furniture on Rent';
$page_description = 'Verify your mobile, upload KYC documents and pick a delivery slot for your Bosk Furniture rental — a quick 2-minute step before checkout.';
$page_canonical   = '/rent-kyc';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'KYC & Delivery Slot', 'url' => '/rent-kyc']
];
include_once "design/rent-data.php";

/* ---- demo cart summary (same items as rent-cart) ---- */
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
$rent_total = 0;
$dep_total  = 0;
foreach ($cart as $item) {
    $rent_total += $item['plan']['monthly'];
    $dep_total  += $item['plan']['deposit'];
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

                    <!-- flow progress: step 4 (KYC & Slot) -->
                    <?php rent_steps(4); ?>

                    <div class="rent-section-head" style="margin-bottom:28px;">
                        <span class="eyebrow">Step 4 · Takes ~2 minutes</span>
                        <h2>Verify &amp; pick your delivery slot</h2>
                        <p>A quick one-time verification keeps rentals safe for everyone. Your documents are
                            encrypted and used only for this rental.</p>
                    </div>

                    <div class="rent-cols">

                        <!-- ===================== MAIN ===================== -->
                        <div>

                            <!-- 1 · Mobile OTP verification (mock) -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-mobile" style="font-size:20px;"></i> Verify your mobile number</h3>
                                <div id="otpStage1">
                                    <div class="rent-otp-row">
                                        <div class="kyc-field" style="flex:1 1 220px;margin-bottom:0;">
                                            <label for="kyc-mobile">Mobile number</label>
                                            <input type="tel" id="kyc-mobile" placeholder="10-digit mobile" maxlength="10">
                                        </div>
                                        <button type="button" class="rent-btn rent-btn-sm" style="height:48px;" onclick="kycSendOtp()">
                                            Send OTP
                                        </button>
                                    </div>
                                </div>
                                <div id="otpStage2" style="display:none;margin-top:16px;">
                                    <label style="display:block;font-size:12.5px;font-weight:600;color:var(--rt-text);margin-bottom:8px;">
                                        Enter the 4-digit OTP sent to your mobile <span style="color:var(--rt-dim);">(demo — any digits work)</span>
                                    </label>
                                    <div class="rent-otp-row">
                                        <div class="rent-otp-boxes" id="otpBoxes">
                                            <input type="tel" maxlength="1" inputmode="numeric">
                                            <input type="tel" maxlength="1" inputmode="numeric">
                                            <input type="tel" maxlength="1" inputmode="numeric">
                                            <input type="tel" maxlength="1" inputmode="numeric">
                                        </div>
                                        <button type="button" class="rent-btn rent-btn-sm" style="height:48px;" onclick="kycVerifyOtp()">
                                            Verify
                                        </button>
                                    </div>
                                </div>
                                <div id="otpDone" style="display:none;margin-top:4px;">
                                    <span class="rent-verified"><i class="fa fa-check-circle"></i> Mobile verified</span>
                                </div>
                            </div>

                            <!-- 2 · KYC documents (mock upload tiles) -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-id-card-o"></i> Upload KYC documents</h3>
                                <div class="kyc-docs">
                                    <div class="kyc-doc" onclick="kycDocToggle(this)">
                                        <i class="fa fa-check-circle done-tick"></i>
                                        <div class="ic"><i class="fa fa-credit-card"></i></div>
                                        <b>ID proof</b>
                                        <span>Aadhaar / PAN / Driving licence</span>
                                    </div>
                                    <div class="kyc-doc" onclick="kycDocToggle(this)">
                                        <i class="fa fa-check-circle done-tick"></i>
                                        <div class="ic"><i class="fa fa-home"></i></div>
                                        <b>Address proof</b>
                                        <span>Utility bill / rent agreement</span>
                                    </div>
                                    <div class="kyc-doc" onclick="kycDocToggle(this)">
                                        <i class="fa fa-check-circle done-tick"></i>
                                        <div class="ic"><i class="fa fa-camera"></i></div>
                                        <b>Selfie</b>
                                        <span>A clear photo of you</span>
                                    </div>
                                </div>
                                <div class="kyc-secure">
                                    <i class="fa fa-lock"></i>
                                    <div>Documents are <b>256-bit encrypted</b> and reviewed only by our verification team.
                                        KYC is checked before dispatch — you can also complete it after payment.</div>
                                </div>
                            </div>

                            <!-- 3 · Delivery slot -->
                            <div class="rent-panel">
                                <h3><i class="fa fa-calendar-check-o"></i> Pick a delivery &amp; installation slot</h3>
                                <p style="font-size:13px;color:var(--rt-dim);margin:-6px 0 14px;">
                                    Delivering to <b style="color:var(--rt-heading);"><?php echo htmlspecialchars(rent_city()); ?></b> —
                                    free delivery, installation &amp; a quality check at your door.
                                </p>
                                <div class="rent-slot-picker">

                                    <!-- calendar -->
                                    <div class="rent-cal">
                                        <div class="rent-cal-head">
                                            <button type="button" class="rent-cal-nav" id="calPrev" onclick="calNav(-1)" aria-label="Previous month"><i class="fa fa-angle-left"></i></button>
                                            <b id="calTitle"></b>
                                            <button type="button" class="rent-cal-nav" id="calNext" onclick="calNav(1)" aria-label="Next month"><i class="fa fa-angle-right"></i></button>
                                        </div>
                                        <div class="rent-cal-week">
                                            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                                        </div>
                                        <div class="rent-cal-grid" id="calGrid"></div>
                                    </div>

                                    <!-- time slots -->
                                    <div class="rent-timebox">
                                        <div class="rent-time-label">
                                            <i class="fa fa-clock-o"></i> Pick a time slot
                                            <span>(available 10 AM – 7 PM)</span>
                                        </div>
                                        <div class="rent-times" id="kycTimes"></div>

                                        <div class="rent-slot-picked">
                                            <i class="fa fa-calendar-check-o"></i>
                                            <div>
                                                <span>Your delivery slot</span>
                                                <b id="slotPickedText">—</b>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- ===================== ASIDE ===================== -->
                        <aside class="rent-aside">
                            <h3>Your rental</h3>

                            <?php foreach ($cart as $item): ?>
                                <div class="rent-srow">
                                    <span class="k" style="max-width:70%;"><?php echo htmlspecialchars($item['product']['name']); ?>
                                        · <?php echo (int)$item['plan']['tenure']; ?> mo</span>
                                    <span class="v"><?php echo rent_money($item['plan']['monthly']); ?>/mo</span>
                                </div>
                            <?php endforeach; ?>

                            <div class="rent-srow">
                                <span class="k">Refundable deposit</span>
                                <span class="v"><?php echo rent_money($dep_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Payable at next step</span>
                                <span class="v"><?php echo rent_money($dep_total + $rent_total); ?></span>
                            </div>

                            <a class="rent-btn rent-btn-block" href="rent-checkout.php" style="margin-top:16px;">
                                Continue to Payment <i class="fa fa-arrow-right"></i>
                            </a>
                            <a class="rent-btn-outline rent-btn rent-btn-block" href="rent-cart.php" style="margin-top:10px;">
                                <i class="fa fa-angle-left"></i> Back to cart
                            </a>

                            <p style="font-size:11.8px;color:var(--rt-dim);line-height:1.55;text-align:center;margin:14px 0 0;">
                                KYC approval is usually done within a few hours.
                            </p>
                        </aside>

                    </div><!-- /.rent-cols -->

                </div>
            </section>

        </div><!-- /.rent-scope -->

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* ---- OTP mock flow ---- */
        function kycSendOtp() {
            var mob = document.getElementById('kyc-mobile');
            if (!mob.value || mob.value.replace(/[^0-9]/g, '').length < 10) {
                mob.style.borderColor = 'var(--rt-red)';
                setTimeout(function () { mob.style.borderColor = ''; }, 1200);
                return;
            }
            document.getElementById('otpStage2').style.display = '';
            var first = document.querySelector('#otpBoxes input');
            if (first) first.focus();
        }

        function kycVerifyOtp() {
            var boxes = document.querySelectorAll('#otpBoxes input');
            var filled = Array.prototype.every.call(boxes, function (b) { return b.value !== ''; });
            if (!filled) {
                boxes.forEach(function (b) { if (!b.value) b.style.borderColor = 'var(--rt-red)'; });
                setTimeout(function () { boxes.forEach(function (b) { b.style.borderColor = ''; }); }, 1200);
                return;
            }
            document.getElementById('otpStage1').style.display = 'none';
            document.getElementById('otpStage2').style.display = 'none';
            document.getElementById('otpDone').style.display = '';
        }

        /* auto-advance between OTP boxes */
        (function () {
            var boxes = document.querySelectorAll('#otpBoxes input');
            boxes.forEach(function (b, i) {
                b.addEventListener('input', function () {
                    b.value = b.value.replace(/[^0-9]/g, '');
                    if (b.value && boxes[i + 1]) boxes[i + 1].focus();
                });
                b.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && !b.value && boxes[i - 1]) boxes[i - 1].focus();
                });
            });
            var mob = document.getElementById('kyc-mobile');
            if (mob) {
                mob.addEventListener('input', function () {
                    mob.value = mob.value.replace(/[^0-9]/g, '');
                });
            }
        })();

        /* ---- KYC doc tiles: click marks as uploaded (UI demo) ---- */
        function kycDocToggle(tile) {
            tile.classList.toggle('uploaded');
        }

        /* ---- delivery slot: calendar + time window (demo, UI only) ---- */
        var CAL_MONTHS = ['January', 'February', 'March', 'April', 'May', 'June',
                          'July', 'August', 'September', 'October', 'November', 'December'];
        var CAL_DAYS   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var CAL_TIMES  = ['10 AM – 1 PM', '1 PM – 4 PM', '4 PM – 7 PM'];

        var CAL = (function () {
            var today = new Date(); today.setHours(0, 0, 0, 0);
            var min = new Date(today); min.setDate(min.getDate() + 1);   // deliveries start tomorrow
            var max = new Date(today); max.setDate(max.getDate() + 30);  // book up to 30 days ahead
            return {
                min: min,
                max: max,
                sel: new Date(min),
                view: new Date(min.getFullYear(), min.getMonth(), 1),
                time: CAL_TIMES[0]
            };
        })();

        function calSameDay(a, b) {
            return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
        }

        function calRender() {
            var y = CAL.view.getFullYear(), m = CAL.view.getMonth();
            document.getElementById('calTitle').textContent = CAL_MONTHS[m] + ' ' + y;

            var grid = document.getElementById('calGrid');
            grid.innerHTML = '';
            var firstDow = new Date(y, m, 1).getDay();
            var lastDate = new Date(y, m + 1, 0).getDate();

            for (var b = 0; b < firstDow; b++) {
                grid.appendChild(document.createElement('span'));
            }
            for (var d = 1; d <= lastDate; d++) {
                var date = new Date(y, m, d);
                var cell = document.createElement('button');
                cell.type = 'button';
                cell.className = 'rent-cal-day';
                cell.textContent = d;
                if (date < CAL.min || date > CAL.max) {
                    cell.classList.add('off');
                    cell.disabled = true;
                } else {
                    if (calSameDay(date, CAL.sel)) cell.classList.add('selected');
                    cell.onclick = (function (picked) {
                        return function () { CAL.sel = picked; calRender(); slotSummary(); };
                    })(date);
                }
                grid.appendChild(cell);
            }

            /* keep navigation inside the bookable window */
            var minMonth = CAL.min.getFullYear() * 12 + CAL.min.getMonth();
            var maxMonth = CAL.max.getFullYear() * 12 + CAL.max.getMonth();
            var curMonth = y * 12 + m;
            document.getElementById('calPrev').disabled = curMonth <= minMonth;
            document.getElementById('calNext').disabled = curMonth >= maxMonth;
        }

        function calNav(step) {
            CAL.view = new Date(CAL.view.getFullYear(), CAL.view.getMonth() + step, 1);
            calRender();
        }

        function calTimeRender() {
            var wrap = document.getElementById('kycTimes');
            wrap.innerHTML = '';
            CAL_TIMES.forEach(function (t) {
                var chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'rent-time' + (t === CAL.time ? ' selected' : '');
                chip.innerHTML = '<i class="fa fa-clock-o"></i> ' + t;
                chip.onclick = function () { CAL.time = t; calTimeRender(); slotSummary(); };
                wrap.appendChild(chip);
            });
        }

        function slotSummary() {
            var d = CAL.sel;
            document.getElementById('slotPickedText').textContent =
                CAL_DAYS[d.getDay()] + ', ' + d.getDate() + ' ' + CAL_MONTHS[d.getMonth()].slice(0, 3) + ' · ' + CAL.time;
        }

        calRender();
        calTimeRender();
        slotSummary();
    </script>
</body>

</html>
