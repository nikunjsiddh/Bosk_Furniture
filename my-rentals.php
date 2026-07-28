<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'My Rentals Dashboard | Bosk Furniture on Rent';
$page_description = 'Track your active furniture rentals, upcoming payments and end-of-tenure choices — return, extend or buy out — all in one Bosk account dashboard.';
$page_robots      = 'noindex, follow';
$page_canonical   = '/my-rentals';
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Rent Furniture', 'url' => '/rent'],
    ['name' => 'My Rentals', 'url' => '/my-rentals']
];
include_once "design/rent-data.php";

/* ---- demo active rentals (template data; no DB) -------------------------- */
function myrent_make($product, $tenureIdx, $start, $next, $paid, $status)
{
    $plan = $product['plans'][$tenureIdx];
    return [
        'product' => $product,
        'plan'    => $plan,
        'start'   => $start,
        'next'    => $next,
        'paid'    => $paid,
        'total'   => $plan['tenure'],
        'status'  => $status,
    ];
}

$MY_RENTALS = [
    // Aspen Sofa — 6-month plan, mid-tenure, active
    myrent_make(rent_find(1), 1, '12 Feb 2026', '12 Jul 2026', 3, 'active'),
    // Nordic Queen Bed — 12-month plan, payment overdue
    myrent_make(rent_find(2), 2, '03 Jan 2026', '03 Jun 2026', 5, 'overdue'),
    // Oakwood Dining Set — 6-month plan, active, near tenure end
    myrent_make(rent_find(3), 1, '20 Jan 2026', '20 Jul 2026', 5, 'active'),
];

/* ---- summary strip figures ---------------------------------------------- */
$activeCount   = 0;
$totalMonthly  = 0;
foreach ($MY_RENTALS as $r) {
    if ($r['status'] !== 'returned') {
        $activeCount++;
        $totalMonthly += $r['plan']['monthly'];
    }
}
// Soonest next payment (overdue rental in the demo set)
$nextPayDate   = '03 Jun 2026';
$nextPayAmount = $MY_RENTALS[1]['plan']['monthly'];
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
                        <div class="rent-summary-box" style="flex:1 1 220px;max-width:300px;margin-bottom:0;">
                            <div class="rent-srow" style="padding:2px 0;">
                                <span class="k"><i class="fa fa-calendar" style="color:var(--rt-accent);"></i> Next payment</span>
                            </div>
                            <div class="v" style="font-size:24px;font-weight:800;color:var(--rt-brand);"><?php echo rent_money($nextPayAmount); ?></div>
                            <div style="font-size:12px;color:var(--rt-dim);margin-top:2px;">due <?php echo htmlspecialchars($nextPayDate); ?></div>
                        </div>
                        <div class="rent-summary-box" style="flex:1 1 220px;max-width:300px;margin-bottom:0;">
                            <div class="rent-srow" style="padding:2px 0;">
                                <span class="k"><i class="fa fa-credit-card" style="color:var(--rt-accent);"></i> Total monthly</span>
                            </div>
                            <div class="v" style="font-size:24px;font-weight:800;color:var(--rt-brand);"><?php echo rent_money($totalMonthly); ?><small style="font-size:12px;font-weight:600;color:var(--rt-dim);">/mo</small></div>
                        </div>
                    </div>

                    <!-- ===================== RENTAL CARDS ===================== -->
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
                                    <a href="rent-checkout" class="rent-btn rent-btn-sm"><i class="fa fa-credit-card"></i> Pay now</a>
                                <?php endif; ?>
                                <a href="rent-product?id=<?php echo (int)$prod['id']; ?>" class="rent-btn rent-btn-outline rent-btn-sm"><i class="fa fa-eye"></i> View details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

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

        <?php include_once "design/footer.php"; ?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>

        <?php include_once "design/pre_loader.php"; ?>
        <?php include_once "design/script.php"; ?>
    </div>
</body>

</html>
