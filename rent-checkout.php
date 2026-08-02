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

include_once "connect.php";
include_once "design/rent-data.php";

/* ============================================================
   Load cart for summary (DB or demo)
   ============================================================ */
$_db_cart      = false;
$CART          = [];
$rent_total    = 0;
$deposit_total = 0;
$cart_id       = null;
$db_mode       = false;

if (isset($con) && $con) {
    $chk = mysqli_query($con, "SHOW TABLES LIKE 'carts'");
    if ($chk && mysqli_num_rows($chk) > 0) {
        $db_mode = true;

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
                SELECT ci.id item_id, ci.qty, ci.protection_addon,
                       p.id product_id, p.pname product_name, p.img1 product_image,
                       rp.id plan_id, rp.tenure_months, rp.monthly_rent, rp.deposit
                FROM cart_items ci
                JOIN products p      ON p.id  = ci.product_id
                JOIN rental_plans rp ON rp.id = ci.plan_id
                WHERE ci.cart_id = $cart_id
                ORDER BY ci.added_at ASC
            ");
            while ($row = mysqli_fetch_assoc($ir)) {
                $CART[] = [
                    'item_id' => (int)$row['item_id'],
                    'qty'     => (int)$row['qty'],
                    'product' => ['id' => (int)$row['product_id'], 'name' => $row['product_name'], 'image' => $row['product_image']],
                    'plan'    => ['id' => (int)$row['plan_id'], 'tenure' => (int)$row['tenure_months'], 'monthly' => (int)$row['monthly_rent'], 'deposit' => (int)$row['deposit']],
                ];
            }
        }
    }
}

/* Demo fallback */
if (empty($CART)) {
    $_p = rent_find(1);
    if ($_p) { $CART[] = ['item_id' => 0, 'qty' => 1, 'product' => ['id' => $_p['id'], 'name' => $_p['name'], 'image' => $_p['image']], 'plan' => $_p['plans'][2]]; }
    $_p = rent_find(2);
    if ($_p) { $CART[] = ['item_id' => 0, 'qty' => 1, 'product' => ['id' => $_p['id'], 'name' => $_p['name'], 'image' => $_p['image']], 'plan' => $_p['plans'][1]]; }
    if (empty($CART)) { $CART[] = ['item_id' => 0, 'qty' => 1, 'product' => ['id' => $RENTAL_PRODUCTS[0]['id'], 'name' => $RENTAL_PRODUCTS[0]['name'], 'image' => $RENTAL_PRODUCTS[0]['image']], 'plan' => $RENTAL_PRODUCTS[0]['plans'][0]]; }
}

foreach ($CART as $line) {
    $rent_total    += (int)$line['plan']['monthly'] * (int)$line['qty'];
    $deposit_total += (int)$line['plan']['deposit']  * (int)$line['qty'];
}

/* Demo order ref (for fallback confirmation) */
$order_ref = 'BR' . date('ymd') . str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

/* Pre-fill name/mobile from session if logged in */
$pre_name   = '';
$pre_mobile = '';
if (isset($con, $_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $ur  = mysqli_query($con, "SELECT firstname, lastname, phone FROM user WHERE id=$uid LIMIT 1");
    if ($ur && ($ux = mysqli_fetch_assoc($ur))) {
        $pre_name   = trim($ux['firstname'] . ' ' . $ux['lastname']);
        $pre_mobile = $ux['phone'] ?? '';
    }
}
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/header.php"; ?>
    <link rel="stylesheet" href="css/rental.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body class="inner-page">
    <div id="wrapper">
        <?php include_once "design/nav.php"; ?>
        <div class="clearfix"></div>

        <div class="rent-scope">

            <section class="rent-section">
                <div class="rent-wrap">

                    <?php rent_steps(4); ?>

                    <div class="rent-section-head" style="margin-top:18px;">
                        <span class="eyebrow">Final step</span>
                        <h2>Checkout</h2>
                        <p>Confirm where we should deliver and set up your pieces, then place your rental
                            request — our team will call you to take it forward.</p>
                    </div>

                    <!-- Form-level error/success message -->
                    <div id="ckMsg" style="display:none;margin-bottom:18px;padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:600;"></div>

                    <div class="rent-cols">

                        <!-- ===================== MAIN ===================== -->
                        <div>

                            <!-- Delivery address -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-map-marker"></i> Delivery address</h3>
                                <div class="kyc-grid">
                                    <div class="kyc-field">
                                        <label for="ck-name">Full name</label>
                                        <input type="text" id="ck-name" name="name" placeholder="e.g. Nikunj Patel" value="<?php echo htmlspecialchars($pre_name); ?>">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-mobile">Mobile number</label>
                                        <input type="tel" id="ck-mobile" name="mobile" placeholder="10-digit mobile" maxlength="10" value="<?php echo htmlspecialchars($pre_mobile); ?>">
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

                            <!-- Verification / KYC section (New as required by Spec) -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-id-card"></i> Quick KYC & Verification <span style="font-size:12px;font-weight:400;color:var(--rt-dim);">(Upload document images for instant dispatch)</span></h3>
                                <div class="kyc-grid" style="grid-template-columns:1fr 1fr;">
                                    <div class="kyc-field">
                                        <label for="ck-doc-type">Document Type</label>
                                        <select id="ck-doc-type" name="doc_type">
                                            <option value="aadhaar">Aadhaar Card</option>
                                            <option value="pan">PAN Card</option>
                                            <option value="driving_licence">Driving License</option>
                                            <option value="voter_id">Voter ID</option>
                                            <option value="passport">Passport</option>
                                        </select>
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-doc-front">Front Image / PDF</label>
                                        <input type="file" id="ck-doc-front" name="doc_front" accept="image/*,.pdf">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-doc-back">Back Image / PDF <span style="font-size:11px;color:var(--rt-dim);">(Optional)</span></label>
                                        <input type="file" id="ck-doc-back" name="doc_back" accept="image/*,.pdf">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-selfie">Selfie Photo</label>
                                        <input type="file" id="ck-selfie" name="selfie" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery slot (optional) -->
                            <div class="rent-panel" style="margin-bottom:22px;">
                                <h3><i class="fa fa-calendar"></i> Preferred delivery slot <span style="font-size:12px;font-weight:400;color:var(--rt-dim);">(optional)</span></h3>
                                <div class="kyc-grid" style="grid-template-columns:1fr 1fr;">
                                    <div class="kyc-field">
                                        <label for="ck-slot-date">Preferred date</label>
                                        <input type="date" id="ck-slot-date" name="slot_date"
                                            min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>"
                                            max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                                    </div>
                                    <div class="kyc-field">
                                        <label for="ck-slot-time">Time preference</label>
                                        <select id="ck-slot-time" name="slot_time">
                                            <option value="">No preference</option>
                                            <option value="Morning (9am–12pm)">Morning (9am–12pm)</option>
                                            <option value="Afternoon (12pm–4pm)">Afternoon (12pm–4pm)</option>
                                            <option value="Evening (4pm–7pm)">Evening (4pm–7pm)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Cart summary on this page -->
                            <div class="rent-panel">
                                <h3><i class="fa fa-shopping-bag"></i> Items in your rental cart</h3>
                                <?php foreach ($CART as $line): ?>
                                    <div class="rent-line" style="padding:12px 0;">
                                        <img class="rent-line-img" src="<?php echo rent_img($line['product']['image']); ?>"
                                            alt="<?php echo htmlspecialchars($line['product']['name']); ?>" loading="lazy">
                                        <div class="rent-line-main">
                                            <h4 style="margin:0 0 4px;"><?php echo htmlspecialchars($line['product']['name']); ?></h4>
                                            <span class="rent-chip"><i class="fa fa-calendar"></i> <?php echo (int)$line['plan']['tenure']; ?>-month plan</span>
                                            <?php if ($line['qty'] > 1): ?>
                                                <span class="rent-chip">×<?php echo (int)$line['qty']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="rent-line-price">
                                            <div class="mo"><?php echo rent_money($line['plan']['monthly'] * $line['qty']); ?><small>/mo</small></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <!-- ===================== ASIDE ===================== -->
                        <aside class="rent-aside">
                            <h3>Rental summary</h3>

                            <div class="rent-srow">
                                <span class="k">Monthly rent</span>
                                <span class="v"><?php echo rent_money($rent_total); ?></span>
                            </div>
                            <div class="rent-srow">
                                <span class="k">Refundable deposit</span>
                                <span class="v"><?php echo rent_money($deposit_total); ?></span>
                            </div>
                            <div class="rent-srow total">
                                <span class="k">Due at checkout</span>
                                <span class="v"><?php echo rent_money($rent_total + $deposit_total); ?></span>
                            </div>

                            <p style="font-size:12.5px;color:var(--rt-dim);margin:10px 0 16px;line-height:1.55;">
                                <b style="color:var(--rt-heading);"><?php echo rent_money($rent_total); ?>/month</b>
                                for your chosen tenure. Our team confirms the details before delivery.
                            </p>

                            <button type="button" id="confirmRentalBtn" class="rent-btn rent-btn-block"
                                style="border:0;cursor:pointer;width:100%;">
                                <i class="fa fa-check-circle"></i> Confirm Rental Request
                            </button>
                        </aside>

                    </div><!-- /.rent-cols -->

                    <div class="rent-note" style="margin-top:30px;">
                        <i class="fa fa-info-circle"></i>
                        <div>You'll receive a request confirmation by SMS &amp; email. Our team then calls you to confirm
                            the rental and schedule <b>free delivery &amp; setup</b> at your convenience — usually within
                            2&ndash;4 working days.</div>
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
            .kyc-grid select{width:100%;padding:10px 12px;border:1px solid var(--rt-line,#e2d8d1);
                border-radius:8px;font-size:14px;background:#fff;color:var(--rt-text,#5b4a3f);
                appearance:none;}
        </style>

        <div class="rent-modal-overlay" id="rentConfirmModal" role="dialog" aria-modal="true" aria-labelledby="rentConfirmTitle">
            <div class="rent-modal">
                <button type="button" class="modal-x" data-close aria-label="Close">&times;</button>
                <div class="tick"><i class="fa fa-check"></i></div>
                <h3 id="rentConfirmTitle">Rental request confirmed!</h3>
                <p>Thank you — your rental request has been placed successfully.</p>
                <span class="ord-ref">Order ID: <span id="modalOrderRef"><?php echo htmlspecialchars($order_ref); ?></span></span>
                <p>Our team will call you shortly to confirm the details.</p>
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
        var _dbMode = <?php echo $db_mode ? 'true' : 'false'; ?>;

        /* Keep mobile / pincode inputs numeric */
        (function () {
            ['ck-mobile', 'ck-pincode'].forEach(function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', function () {
                    el.value = el.value.replace(/[^0-9]/g, '');
                });
            });
        })();

        /* Confirm button */
        (function () {
            var btn     = document.getElementById('confirmRentalBtn');
            var overlay = document.getElementById('rentConfirmModal');
            var msgEl   = document.getElementById('ckMsg');
            if (!btn || !overlay) return;

            function openModal(ref) {
                if (ref) document.getElementById('modalOrderRef').textContent = ref;
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
            function close() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            function showMsg(text, type) {
                if (!msgEl) return;
                msgEl.textContent = text;
                msgEl.style.display = 'block';
                if (type === 'ok') {
                    msgEl.style.background = '#e6f7ee'; msgEl.style.color = '#1aa260'; msgEl.style.border = '1px solid #a3d9b8';
                } else {
                    msgEl.style.background = '#fdeef0'; msgEl.style.color = '#c0392b'; msgEl.style.border = '1px solid #f5b7b1';
                }
                msgEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                showMsg('', '');

                var name    = (document.getElementById('ck-name')    || {}).value || '';
                var mobile  = (document.getElementById('ck-mobile')  || {}).value || '';
                var pincode = (document.getElementById('ck-pincode') || {}).value || '';
                var city    = (document.getElementById('ck-city')    || {}).value || '';
                var address = (document.getElementById('ck-address') || {}).value || '';
                var slotDate = (document.getElementById('ck-slot-date') || {}).value || '';
                var slotTime = (document.getElementById('ck-slot-time') || {}).value || '';

                if (!name.trim() || !mobile.trim() || !address.trim()) {
                    showMsg('Please fill in your full name, mobile number and delivery address.', 'err');
                    return;
                }
                if (!/^\d{10}$/.test(mobile.trim())) {
                    showMsg('Enter a valid 10-digit mobile number.', 'err');
                    return;
                }

                if (!_dbMode) {
                    /* Demo / no DB — just show modal */
                    openModal(null);
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Initiating Payment…';

                var totalPayable = <?php echo ($rent_total + $deposit_total); ?>;

                // Step 1: Create Razorpay Order
                var orderFd = new FormData();
                orderFd.append('amount', totalPayable);

                fetch('back/create-razorpay-order.php', { method: 'POST', body: orderFd })
                    .then(function(r) { return r.json(); })
                    .then(function(orderRes) {
                        if (!orderRes.success) {
                            showMsg(orderRes.message || 'Payment initiation failed.', 'err');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                            return;
                        }

                        // Step 2: Open Razorpay Modal
                        var options = {
                            "key": orderRes.key,
                            "amount": orderRes.amount,
                            "currency": "INR",
                            "name": "Bosk Furniture",
                            "description": "Furniture Rental Deposit & 1st Month Rent",
                            "order_id": orderRes.razorpay_order_id,
                            "handler": function (rzpRes) {
                                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verifying Payment…';
                                
                                // Step 3: Verify Payment Signature
                                fetch('back/verify-razorpay-payment.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify(rzpRes)
                                })
                                .then(function(r) { return r.json(); })
                                .then(function(verifyRes) {
                                    if (!verifyRes.success) {
                                        showMsg('Payment verification failed: ' + verifyRes.message, 'err');
                                        btn.disabled = false;
                                        btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                                        return;
                                    }

                                    // Step 4: Finalize Order Placement
                                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Placing Order…';
                                    var slot = '';
                                    if (slotDate) slot = slotDate + (slotTime ? ' ' + slotTime : '');

                                    var fd = new FormData();
                                    fd.append('action',              'place_order');
                                    fd.append('full_name',           name.trim());
                                    fd.append('mobile',              mobile.trim());
                                    fd.append('address',             address.trim());
                                    fd.append('city',                city.trim());
                                    fd.append('pincode',             pincode.trim());
                                    fd.append('delivery_slot',       slot);
                                    fd.append('razorpay_payment_id', rzpRes.razorpay_payment_id);

                                    var docType  = (document.getElementById('ck-doc-type')  || {}).value || 'aadhaar';
                                    var docFront = (document.getElementById('ck-doc-front') || {}).files[0];
                                    var docBack  = (document.getElementById('ck-doc-back')  || {}).files[0];
                                    var selfie   = (document.getElementById('ck-selfie')    || {}).files[0];

                                    fd.append('doc_type', docType);
                                    if (docFront) fd.append('doc_front', docFront);
                                    if (docBack)  fd.append('doc_back',  docBack);
                                    if (selfie)   fd.append('selfie',    selfie);

                                    fetch('back/rent-handler.php', { method: 'POST', body: fd })
                                        .then(function(r) { return r.json(); })
                                        .then(function(res) {
                                            if (res.ok) {
                                                openModal(res.data.order_ref || null);
                                            } else {
                                                showMsg(res.msg || 'Could not place order. Please contact support.', 'err');
                                                btn.disabled = false;
                                                btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                                            }
                                        })
                                        .catch(function() {
                                            showMsg('Network error while saving order.', 'err');
                                            btn.disabled = false;
                                            btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                                        });
                                });
                            },
                            "modal": {
                                "ondismiss": function() {
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                                }
                            },
                            "method": {
                                "netbanking": true,
                                "card": true,
                                "upi": true,
                                "wallet": true,
                                "paylater": true
                            },
                            "config": {
                                "display": {
                                    "sequence": ["method.upi", "method.card", "method.netbanking"],
                                    "preferences": {
                                        "show_default_blocks": true
                                    }
                                }
                            },
                            "prefill": {
                                "name": name.trim(),
                                "contact": mobile.trim()
                            },
                            "theme": {
                                "color": "#532A1A"
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    })
                    .catch(function(err) {
                        showMsg('Network error starting payment.', 'err');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-check-circle"></i> Pay & Confirm Booking';
                    });
            });

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
