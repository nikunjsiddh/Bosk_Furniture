<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'My Rentals | Bosk Furniture';
$page_description = 'Track your active furniture rentals, upcoming payments and end-of-tenure choices — return, extend or buy out — all in one Bosk account dashboard.';
$page_canonical   = '/my-rentals';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'My Rentals', 'url' => '/my-rentals']
];

include_once "connect.php";
include_once "design/rent-data.php";

/* ============================================================
   Load orders from DB; demo fallback if tables absent.
   ============================================================ */
$_db_mode   = false;
$MY_RENTALS = [];

if (isset($con) && $con) {
    if (!isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
        $e = mysqli_real_escape_string($con, $_SESSION['email']);
        $uq = mysqli_query($con, "SELECT id FROM user WHERE email='$e'");
        if ($uq && $row = mysqli_fetch_assoc($uq)) {
            $_SESSION['user_id'] = (int)$row['id'];
        }
    }

    if (isset($_SESSION['user_id'])) {
        $chk = mysqli_query($con, "SHOW TABLES LIKE 'rental_orders'");
        if ($chk && mysqli_num_rows($chk) > 0) {
            $_db_mode = true;
            $uid = (int)$_SESSION['user_id'];
            $oq  = mysqli_query($con, "SELECT * FROM rental_orders WHERE user_id=$uid ORDER BY created_at DESC");
            while ($ord = mysqli_fetch_assoc($oq)) {
                $oid   = (int)$ord['id'];
                $items = [];
                $iq = mysqli_query($con, "
                    SELECT roi.*, p.pname product_name, p.img1 product_image
                    FROM rental_order_items roi
                    JOIN products p ON p.id = roi.product_id
                    WHERE roi.order_id = $oid
                    ORDER BY roi.id
                ");
                while ($row = mysqli_fetch_assoc($iq)) {
                    $items[] = $row;
                }
                $ord['items'] = $items;
                $MY_RENTALS[] = $ord;
            }
        }
    }
}

/* ---- Demo fallback ---- */
if (!$_db_mode) {
    function myrent_make($product, $tenureIdx, $start, $next, $paid, $status)
    {
        $plan = $product['plans'][$tenureIdx];
        return [
            'order_ref' => 'BR' . strtolower(substr(md5($product['id'] . $start), 0, 6)),
            'product'   => $product,
            'plan'      => $plan,
            'start'     => $start,
            'next'      => $next,
            'paid'      => $paid,
            'total'     => $plan['tenure'],
            'status'    => $status,
            'items'     => [],
        ];
    }
    $MY_RENTALS = [
        myrent_make(rent_find(1), 1, '12 Feb 2026', '12 Aug 2026', 3, 'active'),
        myrent_make(rent_find(2), 2, '03 Jan 2026', '03 Aug 2026', 5, 'overdue'),
        myrent_make(rent_find(3), 1, '20 Jan 2026', '20 Aug 2026', 5, 'active'),
    ];
}

/* ---- Summary strip ---- */
$activeCount  = 0;
$totalMonthly = 0;
$nextPayDate   = null;
$nextPayAmount = 0;

if ($_db_mode) {
    foreach ($MY_RENTALS as $r) {
        $st = $r['status'];
        if (!in_array($st, ['returned', 'cancelled'])) {
            $activeCount++;
            $totalMonthly += (int)$r['total_monthly_rent'];
        }
        if ($st === 'overdue' && !$nextPayDate) {
            $nextPayDate   = $r['updated_at'] ?? 'Overdue';
            $nextPayAmount = (int)$r['total_monthly_rent'];
        }
    }
} else {
    foreach ($MY_RENTALS as $r) {
        if ($r['status'] !== 'returned') {
            $activeCount++;
            $totalMonthly += $r['plan']['monthly'];
        }
        if ($r['status'] === 'overdue' && !$nextPayDate) {
            $nextPayDate   = $r['next'];
            $nextPayAmount = $r['plan']['monthly'];
        }
    }
}
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/header.php"; ?>
    <link rel="stylesheet" href="css/rental.css">
    <style>
        .myrent-lifecycle{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;}
        .lifecycle-btn{padding:6px 14px;border-radius:7px;border:1.5px solid var(--rt-line);
            font-size:12px;font-weight:600;cursor:pointer;background:transparent;
            color:var(--rt-dim);transition:all .18s;}
        .lifecycle-btn:hover{border-color:var(--rt-brand);color:var(--rt-brand);background:var(--rt-soft);}
        .lifecycle-btn.danger:hover{border-color:#e23b3b;color:#e23b3b;background:#fdeef0;}
        /* Lifecycle request modal */
        .lc-modal-overlay{position:fixed;inset:0;background:rgba(40,20,10,.5);display:none;
            align-items:center;justify-content:center;z-index:99999;padding:20px;}
        .lc-modal-overlay.open{display:flex;}
        .lc-modal{background:#fff;max-width:420px;width:100%;border-radius:14px;padding:28px 26px;
            position:relative;box-shadow:0 20px 50px rgba(0,0,0,.22);animation:rentPop .22s ease;}
        @keyframes rentPop{from{transform:translateY(12px) scale(.96);opacity:0}to{transform:none;opacity:1}}
        .lc-modal h3{font-size:18px;color:var(--rt-heading);margin:0 0 14px;}
        .lc-modal textarea{width:100%;padding:10px 12px;border:1px solid var(--rt-line);border-radius:8px;
            resize:vertical;min-height:80px;font-size:13.5px;font-family:inherit;color:var(--rt-text);}
        .lc-modal .modal-x{position:absolute;top:10px;right:14px;border:0;background:none;
            font-size:22px;cursor:pointer;color:var(--rt-dim);}
    </style>
</head>

<body class="inner-page">
    <div id="wrapper">
        <?php include_once "design/nav.php"; ?>
        <div class="clearfix"></div>

        <div class="rent-scope">

            <section class="rent-section">
                <div class="rent-wrap">

                    <!-- ===================== HEADER ===================== -->
                    <div class="rent-section-head" style="margin-bottom:26px;">
                        <span class="eyebrow">Your account</span>
                        <h2>My Rentals</h2>
                        <p>Track your active rentals, upcoming payments, and end-of-tenure choices.</p>
                    </div>

                    <!-- ===================== SUMMARY STRIP ===================== -->
                    <div style="display:flex;flex-wrap:wrap;gap:14px;justify-content:center;margin-bottom:34px;">
                        <div class="rent-summary-box" style="flex:1 1 220px;max-width:300px;margin-bottom:0;">
                            <div class="rent-srow" style="padding:2px 0;">
                                <span class="k"><i class="fa fa-check-circle" style="color:var(--rt-green);"></i> Active rentals</span>
                            </div>
                            <div class="v" style="font-size:24px;font-weight:800;color:var(--rt-brand);"><?php echo $activeCount; ?></div>
                        </div>
                        <?php if ($nextPayDate): ?>
                        <div class="rent-summary-box" style="flex:1 1 220px;max-width:300px;margin-bottom:0;">
                            <div class="rent-srow" style="padding:2px 0;">
                                <span class="k"><i class="fa fa-calendar" style="color:var(--rt-accent);"></i> Next payment</span>
                            </div>
                            <div class="v" style="font-size:24px;font-weight:800;color:var(--rt-brand);"><?php echo rent_money($nextPayAmount); ?></div>
                            <div style="font-size:12px;color:var(--rt-dim);margin-top:2px;">due <?php echo htmlspecialchars((string)$nextPayDate); ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="rent-summary-box" style="flex:1 1 220px;max-width:300px;margin-bottom:0;">
                            <div class="rent-srow" style="padding:2px 0;">
                                <span class="k"><i class="fa fa-credit-card" style="color:var(--rt-accent);"></i> Total monthly</span>
                            </div>
                            <div class="v" style="font-size:24px;font-weight:800;color:var(--rt-brand);"><?php echo rent_money($totalMonthly); ?><small style="font-size:12px;font-weight:600;color:var(--rt-dim);">/mo</small></div>
                        </div>
                    </div>

                    <?php if (empty($MY_RENTALS)): ?>
                        <div class="rent-empty" style="display:block;margin:30px auto;">
                            <div class="ic"><i class="fa fa-home"></i></div>
                            <h3>No active rentals yet</h3>
                            <p>Browse our catalogue and start renting premium furniture today.</p>
                            <a href="rent.php" class="rent-btn" style="margin-top:18px;"><i class="fa fa-search"></i> Browse Catalogue</a>
                        </div>

                    <?php elseif ($_db_mode): ?>

                    <!-- ===================== DB RENTAL CARDS ===================== -->
                    <?php foreach ($MY_RENTALS as $r):
                        $isOver = ($r['status'] === 'overdue');
                        $ordId  = (int)$r['id'];
                    ?>
                        <div class="myrent-card" id="myrentCard<?php echo $ordId; ?>">
                            <!-- Items -->
                            <div style="flex:1;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                    <span style="font-size:12px;font-weight:700;color:var(--rt-dim);font-family:monospace;">
                                        <?php echo htmlspecialchars($r['order_ref']); ?>
                                    </span>
                                    <?php if ($isOver): ?>
                                        <span class="myrent-status overdue"><i class="fa fa-exclamation-circle"></i> Payment overdue</span>
                                    <?php elseif ($r['status'] === 'kyc_pending'): ?>
                                        <span class="myrent-status" style="background:#fff8e1;color:#b36d00;border:1px solid #ffd54f;"><i class="fa fa-clock-o"></i> KYC Under Review</span>
                                    <?php elseif ($r['status'] === 'confirmed' || $r['status'] === 'active'): ?>
                                        <span class="myrent-status active"><i class="fa fa-check-circle"></i> Active</span>
                                    <?php elseif ($r['status'] === 'cancelled'): ?>
                                        <span class="myrent-status" style="background:#fdeef0;color:#c0392b;border:1px solid #f5b7b1;"><i class="fa fa-times-circle"></i> Rejected / Cancelled</span>
                                    <?php elseif ($r['status'] === 'pending'): ?>
                                        <span class="myrent-status" style="background:#fff8e1;color:#8a5e00;border-color:#ffd54f;"><i class="fa fa-clock-o"></i> Pending</span>
                                    <?php elseif ($r['status'] === 'returned'): ?>
                                        <span class="myrent-status" style="background:#f0f4f8;color:#6b7280;border-color:#d1d5db;"><i class="fa fa-undo"></i> Returned</span>
                                    <?php else: ?>
                                        <span class="myrent-status" style="background:#f0f4f8;color:#6b7280;"><?php echo htmlspecialchars($r['status']); ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($r['status'] === 'kyc_pending'): ?>
                                    <div style="background:#fff8e1;border:1px solid #ffe082;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#7f4c00;">
                                        <i class="fa fa-shield"></i> <b>KYC Verification in Progress:</b> Our verification team is reviewing your uploaded documents. Dispatch will be scheduled upon approval.
                                    </div>
                                <?php elseif ($r['status'] === 'cancelled'): ?>
                                    <div style="background:#fdeef0;border:1px solid #f5b7b1;border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;color:#922b21;">
                                        <i class="fa fa-exclamation-triangle"></i> <b>KYC Verification / Order Rejected:</b> Your verification or order request could not be approved. Any initial payment made will be refunded to your source account within 5–7 working days.
                                    </div>
                                <?php endif; ?>

                                <?php foreach ($r['items'] as $it): ?>
                                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                                        <img src="<?php echo rent_img($it['product_image']); ?>"
                                            alt="<?php echo htmlspecialchars($it['product_name']); ?>"
                                            style="width:60px;height:60px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                                        <div>
                                            <h4 style="margin:0 0 3px;font-size:14.5px;"><?php echo htmlspecialchars($it['product_name']); ?></h4>
                                            <div class="myrent-meta">
                                                <span>Plan <b><?php echo (int)$it['tenure_months']; ?> mo</b></span>
                                                <span>Monthly <b><?php echo rent_money($it['monthly_rent']); ?></b></span>
                                                <?php if ($it['start_date']): ?><span>From <b><?php echo date('d M Y', strtotime($it['start_date'])); ?></b></span><?php endif; ?>
                                                <?php if ($it['end_date']): ?><span>Until <b><?php echo date('d M Y', strtotime($it['end_date'])); ?></b></span><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Lifecycle request buttons -->
                                <?php if (!in_array($r['status'], ['returned','cancelled'])): ?>
                                <div class="myrent-lifecycle">
                                    <button class="lifecycle-btn" onclick="lcRequest(<?php echo $ordId; ?>, 'return', 'Return furniture')"><i class="fa fa-undo"></i> Return</button>
                                    <button class="lifecycle-btn" onclick="lcRequest(<?php echo $ordId; ?>, 'extension', 'Extend tenure')"><i class="fa fa-calendar-plus-o"></i> Extend</button>
                                    <button class="lifecycle-btn" onclick="lcRequest(<?php echo $ordId; ?>, 'buyout', 'Buy out')"><i class="fa fa-shopping-cart"></i> Buy out</button>
                                    <button class="lifecycle-btn" onclick="lcRequest(<?php echo $ordId; ?>, 'repair', 'Request repair')"><i class="fa fa-wrench"></i> Repair</button>
                                    <button class="lifecycle-btn" onclick="lcRequest(<?php echo $ordId; ?>, 'relocation', 'Relocate furniture')"><i class="fa fa-truck"></i> Relocate</button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php else: ?>

                    <!-- ===================== DEMO RENTAL CARDS ===================== -->
                    <?php foreach ($MY_RENTALS as $r):
                        $prod   = $r['product'];
                        $plan   = $r['plan'];
                        $isOver = ($r['status'] === 'overdue');
                    ?>
                        <div class="myrent-card">
                            <img class="pic" src="<?php echo rent_img($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" loading="lazy">
                            <div>
                                <h4><?php echo htmlspecialchars($prod['name']); ?></h4>
                                <?php if ($isOver): ?>
                                    <span class="myrent-status overdue"><i class="fa fa-exclamation-circle"></i> Payment overdue</span>
                                <?php else: ?>
                                    <span class="myrent-status active"><i class="fa fa-check-circle"></i> Active</span>
                                <?php endif; ?>
                                <div class="myrent-meta">
                                    <span>Plan <b><?php echo (int)$plan['tenure']; ?> months</b></span>
                                    <span>Monthly <b><?php echo rent_money($plan['monthly']); ?></b></span>
                                    <span>Started <b><?php echo htmlspecialchars($r['start']); ?></b></span>
                                    <span>Next billing <b><?php echo htmlspecialchars($r['next']); ?></b></span>
                                    <span>Progress <b><?php echo (int)$r['paid']; ?> / <?php echo (int)$r['total']; ?> months</b></span>
                                </div>
                            </div>
                            <div class="myrent-actions">
                                <?php if ($isOver): ?>
                                    <a href="rent-checkout.php" class="rent-btn rent-btn-sm"><i class="fa fa-credit-card"></i> Pay now</a>
                                <?php endif; ?>
                                <a href="rent-product.php?id=<?php echo (int)$prod['id']; ?>" class="rent-btn rent-btn-outline rent-btn-sm"><i class="fa fa-eye"></i> View details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php endif; ?>

                    <!-- ===================== END-OF-TENURE OPTIONS ===================== -->
                    <div class="rent-panel" style="margin-top:30px;">
                        <h3><i class="fa fa-recycle" style="color:var(--rt-brand);"></i> End of tenure options</h3>
                        <div class="eot-grid">
                            <div class="eot-card">
                                <div class="ic"><i class="fa fa-undo"></i></div>
                                <h4>Return</h4>
                                <p>Send it back, deposit refunded in full (less any damage).</p>
                            </div>
                            <div class="eot-card">
                                <div class="ic"><i class="fa fa-calendar-plus-o"></i></div>
                                <h4>Extend</h4>
                                <p>Keep it longer on a fresh tenure at the same monthly rent.</p>
                            </div>
                            <div class="eot-card">
                                <div class="ic"><i class="fa fa-shopping-cart"></i></div>
                                <h4>Buyout</h4>
                                <p>Love it? Pay the remaining value (rent already paid is adjusted) and own it.</p>
                            </div>
                        </div>
                        <div class="rent-note" style="margin-top:20px;">
                            <i class="fa fa-info-circle"></i>
                            <div>These choices unlock as each rental nears the end of its tenure — we'll remind you about 30 days before your last billing date, so you have time to <b>return</b>, <b>extend</b> or <b>buy out</b> without any rush.</div>
                        </div>
                    </div>

                </div><!-- /.rent-wrap -->
            </section>

        </div><!-- /.rent-scope -->

        <!-- Lifecycle Request Modal -->
        <div class="lc-modal-overlay" id="lcModal" role="dialog" aria-modal="true">
            <div class="lc-modal">
                <button type="button" class="modal-x" onclick="lcClose()">&times;</button>
                <h3 id="lcModalTitle">Submit Request</h3>
                <p style="font-size:13.5px;color:var(--rt-dim);margin:0 0 12px;" id="lcModalDesc">Tell us more about your request.</p>
                <textarea id="lcNotes" placeholder="Optional — any additional notes…"></textarea>
                <div id="lcMsg" style="display:none;margin-top:10px;padding:8px 12px;border-radius:7px;font-size:13px;font-weight:600;"></div>
                <button id="lcSubmitBtn" type="button" class="rent-btn rent-btn-block" style="margin-top:14px;border:0;cursor:pointer;width:100%;" onclick="lcSubmit()">
                    Submit Request
                </button>
            </div>
        </div>

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
    var _lcOrderId = null;
    var _lcType    = null;

    function lcRequest(orderId, type, label) {
        _lcOrderId = orderId;
        _lcType    = type;
        var t = document.getElementById('lcModalTitle');
        var d = document.getElementById('lcModalDesc');
        var n = document.getElementById('lcNotes');
        var m = document.getElementById('lcMsg');
        if (t) t.textContent = label;
        if (d) d.textContent = 'Describe your request and our team will reach out within 24 hours.';
        if (n) n.value = '';
        if (m) m.style.display = 'none';
        document.getElementById('lcModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function lcClose() {
        document.getElementById('lcModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function lcSubmit() {
        var btn   = document.getElementById('lcSubmitBtn');
        var notes = (document.getElementById('lcNotes') || {}).value || '';
        var msgEl = document.getElementById('lcMsg');

        if (!_lcOrderId || !_lcType) { lcClose(); return; }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting…';

        var fd = new FormData();
        fd.append('action',   'lifecycle_request');
        fd.append('order_id', _lcOrderId);
        fd.append('type',     _lcType);
        fd.append('notes',    notes);

        fetch('back/rent-handler.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (msgEl) {
                    msgEl.textContent = res.msg || (res.ok ? 'Request submitted!' : 'Error — please try again.');
                    msgEl.style.display = 'block';
                    if (res.ok) {
                        msgEl.style.background = '#e6f7ee'; msgEl.style.color = '#1aa260'; msgEl.style.border = '1px solid #a3d9b8';
                        setTimeout(lcClose, 2000);
                    } else {
                        msgEl.style.background = '#fdeef0'; msgEl.style.color = '#c0392b'; msgEl.style.border = '1px solid #f5b7b1';
                    }
                }
                btn.disabled = false;
                btn.innerHTML = 'Submit Request';
            })
            .catch(function() {
                if (msgEl) {
                    msgEl.textContent = 'Network error. Please try again.';
                    msgEl.style.display = 'block';
                    msgEl.style.background = '#fdeef0'; msgEl.style.color = '#c0392b'; msgEl.style.border = '1px solid #f5b7b1';
                }
                btn.disabled = false;
                btn.innerHTML = 'Submit Request';
            });
    }

    /* Close modal on overlay click */
    document.getElementById('lcModal').parentElement.addEventListener('click', function(e) {
        if (e.target === this) lcClose();
    });
    </script>
</body>

</html>
