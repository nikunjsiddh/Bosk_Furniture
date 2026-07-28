<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'My Rentals Dashboard | Bosk Furniture on Rent';
$page_description = 'Track your active furniture rentals, upcoming payments, invoices and end-of-tenure choices — return, extend or buy out — all in one Bosk account dashboard.';
$page_robots      = 'noindex, follow';
$page_canonical   = '/my-rentals';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'My Rentals', 'url' => '/my-rentals']
];
include_once "design/rent-data.php";
/* Rentals + invoices come from the shared demo data in design/rent-data.php
   ($MY_RENTALS, $MY_INVOICES) — swap for DB queries later, same shape. */

/* ---- dashboard stats ------------------------------------------------------ */
$active_count = 0;
$monthly_out  = 0;
$deposit_held = 0;
$next_billing = null;
foreach ($MY_RENTALS as $r) {
    if ($r['status'] === 'active' || $r['status'] === 'renewal_due') {
        $active_count++;
        $monthly_out  += $r['monthly'];
        $deposit_held += $r['deposit'];
        if ($next_billing === null) {
            $next_billing = $r['next_billing'];
        }
    }
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

                    <!-- ===================== HEADER ===================== -->
                    <div class="rent-section-head" style="margin-bottom:26px;">
                        <span class="eyebrow">Your account</span>
                        <h2>My Rentals</h2>
                        <p>Everything about your rented furniture in one place — billing, service requests
                            and end-of-tenure choices.</p>
                    </div>

                    <!-- ===================== STATS ===================== -->
                    <div class="myrent-stats">
                        <div class="myrent-stat"><b><?php echo $active_count; ?></b><span>Active rentals</span></div>
                        <div class="myrent-stat"><b><?php echo rent_money($monthly_out); ?></b><span>Rent / month</span></div>
                        <div class="myrent-stat"><b><?php echo rent_money($deposit_held); ?></b><span>Deposit held (refundable)</span></div>
                        <div class="myrent-stat"><b style="font-size:17px;padding-top:5px;"><?php echo htmlspecialchars($next_billing ? $next_billing : '—'); ?></b><span>Next billing date</span></div>
                    </div>

                    <!-- ===================== RENTAL CARDS ===================== -->
                    <?php foreach ($MY_RENTALS as $r):
                        $prod = rent_find($r['product_id']);
                        if (!$prod) {
                            continue;
                        }
                        $statusLbl = ['active' => 'Active', 'renewal_due' => 'Renewal due', 'returned' => 'Returned'];
                        $statusCls = ['active' => 'active', 'renewal_due' => 'renewal', 'returned' => 'returned'];
                        $isLive = ($r['status'] !== 'returned');
                    ?>
                        <div class="myrent-card">
                            <img class="pic" src="<?php echo rent_img($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?> on rent" loading="lazy">
                            <div>
                                <span class="myrent-status <?php echo $statusCls[$r['status']]; ?>">
                                    <i class="fa fa-circle" style="font-size:7px;"></i> <?php echo $statusLbl[$r['status']]; ?>
                                </span>
                                <h4><?php echo htmlspecialchars($prod['name']); ?></h4>
                                <div class="myrent-meta">
                                    <span>Order <b><?php echo htmlspecialchars($r['ref']); ?></b></span>
                                    <span>Plan <b><?php echo (int)$r['tenure']; ?> months</b> (<?php echo (int)$r['months_done']; ?> done)</span>
                                    <span>Rent <b><?php echo rent_money($r['monthly']); ?>/mo</b></span>
                                    <?php if ($isLive): ?>
                                        <span>Next billing <b><?php echo htmlspecialchars($r['next_billing']); ?></b></span>
                                    <?php else: ?>
                                        <span>Deposit <b style="color:var(--rt-green);">refunded</b></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($isLive): ?>
                                    <!-- free in-tenure service requests (RentoMojo pattern) -->
                                    <div class="myrent-requests">
                                        <a class="myrent-req" onclick="mrRequest('Repair')"><i class="fa fa-wrench"></i> Repair</a>
                                        <a class="myrent-req" onclick="mrRequest('Relocation')"><i class="fa fa-exchange"></i> Relocate (free)</a>
                                        <a class="myrent-req" onclick="mrRequest('Tenure extension')"><i class="fa fa-calendar-plus-o"></i> Extend</a>
                                        <a class="myrent-req" onclick="mrRequest('Return pickup')"><i class="fa fa-undo"></i> Return</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="myrent-actions">
                                <?php if ($r['status'] === 'renewal_due'): ?>
                                    <a class="rent-btn rent-btn-sm" onclick="mrRequest('Renewal at discounted rent')">
                                        <i class="fa fa-refresh"></i> Renew &amp; save
                                    </a>
                                <?php elseif ($r['status'] === 'active'): ?>
                                    <a class="rent-btn rent-btn-sm" onclick="mrRequest('Rent payment')">
                                        <i class="fa fa-credit-card"></i> Pay rent
                                    </a>
                                <?php else: ?>
                                    <a class="rent-btn rent-btn-outline rent-btn-sm" href="rent-product?id=<?php echo (int)$prod['id']; ?>">
                                        <i class="fa fa-refresh"></i> Rent again
                                    </a>
                                <?php endif; ?>
                                <a class="rent-btn rent-btn-outline rent-btn-sm" onclick="mrRequest('Rental agreement download')">
                                    <i class="fa fa-file-text-o"></i> Agreement
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- ===================== END-OF-TENURE OPTIONS ===================== -->
                    <div class="rent-panel" style="margin-top:30px;">
                        <h3><i class="fa fa-recycle" style="color:var(--rt-brand);"></i> A tenure is ending — what would you like to do?</h3>
                        <div class="eot-grid">
                            <div class="eot-card" onclick="mrRequest('Renewal at discounted rent')">
                                <div class="ic"><i class="fa fa-refresh"></i></div>
                                <h4>Extend &amp; save</h4>
                                <p>Renew for 6 or 12 months at a <b>discounted rent</b> — the longer you keep it, the less you pay.</p>
                            </div>
                            <div class="eot-card" onclick="mrRequest('Return pickup')">
                                <div class="ic"><i class="fa fa-undo"></i></div>
                                <h4>Return it</h4>
                                <p>Free pickup &amp; quality check. Your <b>deposit is auto-refunded</b> within 5–7 days.</p>
                            </div>
                            <div class="eot-card" onclick="mrRequest('Buyout quote')">
                                <div class="ic"><i class="fa fa-shopping-cart"></i></div>
                                <h4>Buy it</h4>
                                <p>Love it? Pay the remaining value (rent already paid is adjusted) and <b>own it</b>.</p>
                            </div>
                        </div>
                        <div class="rent-note" style="margin-top:20px;">
                            <i class="fa fa-info-circle"></i>
                            <div>These choices unlock as each rental nears its last billing date — we remind you about
                                <b>30 days before</b>, so you can decide without any rush.</div>
                        </div>
                    </div>

                    <!-- ===================== INVOICES ===================== -->
                    <div class="rent-panel" style="margin-top:26px;">
                        <h3><i class="fa fa-file-text-o"></i> Invoices &amp; payments</h3>
                        <div class="rent-invoices-wrap">
                            <table class="rent-invoices">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Period</th>
                                        <th>Order</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($MY_INVOICES as $inv): ?>
                                        <tr>
                                            <td><b style="color:var(--rt-heading);"><?php echo htmlspecialchars($inv['no']); ?></b></td>
                                            <td><?php echo htmlspecialchars($inv['period']); ?></td>
                                            <td><?php echo htmlspecialchars($inv['ref']); ?></td>
                                            <td><b><?php echo rent_money($inv['amount']); ?></b></td>
                                            <td><span class="rent-pill <?php echo $inv['status'] === 'paid' ? 'paid' : 'due'; ?>">
                                                <?php echo $inv['status'] === 'paid' ? 'Paid' : 'Due'; ?></span></td>
                                            <td>
                                                <?php if ($inv['status'] === 'paid'): ?>
                                                    <a class="myrent-req" onclick="mrRequest('Invoice download')"><i class="fa fa-download"></i> PDF</a>
                                                <?php else: ?>
                                                    <a class="myrent-req" onclick="mrRequest('Rent payment')"><i class="fa fa-credit-card"></i> Pay now</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="rent-note" style="margin-top:26px;">
                        <i class="fa fa-headphones"></i>
                        <div>Need help with a rental? <a href="contact.php" style="color:var(--rt-brand);font-weight:600;">Send us a message</a> —
                            repairs, relocation and maintenance are <b>free</b> on every active plan.</div>
                    </div>

                </div><!-- /.rent-wrap -->
            </section>

        </div><!-- /.rent-scope -->

        <!-- ===================== REQUEST CONFIRMATION MODAL (UI demo) ===================== -->
        <div class="rent-modal-overlay2" id="mrModal" role="dialog" aria-modal="true" aria-labelledby="mrModalTitle">
            <div class="rent-modal2">
                <button type="button" class="modal-x" onclick="mrClose()" aria-label="Close">&times;</button>
                <div class="tick"><i class="fa fa-check"></i></div>
                <h3 id="mrModalTitle">Request raised!</h3>
                <p><span id="mrModalWhat">Your request</span> has been logged. Our team will reach out
                    within 24 hours to schedule it.</p>
                <a class="rent-btn rent-btn-block" onclick="mrClose()" style="margin-top:14px;cursor:pointer;">Okay, got it</a>
            </div>
        </div>

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>

    <script>
        /* service-request modal (UI demo — no backend) */
        function mrRequest(what) {
            var span = document.getElementById('mrModalWhat');
            if (span) span.textContent = 'Your "' + what + '" request';
            var m = document.getElementById('mrModal');
            if (m) { m.classList.add('open'); document.body.style.overflow = 'hidden'; }
        }
        function mrClose() {
            var m = document.getElementById('mrModal');
            if (m) { m.classList.remove('open'); document.body.style.overflow = ''; }
        }
        (function () {
            var m = document.getElementById('mrModal');
            if (!m) return;
            m.addEventListener('click', function (e) { if (e.target === m) mrClose(); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') mrClose(); });
        })();
    </script>
</body>

</html>
