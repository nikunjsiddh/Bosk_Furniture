<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

function dash_scalar($con, $sql) {
    $r = mysqli_query($con, $sql);
    $row = $r ? mysqli_fetch_row($r) : null;
    return $row ? $row[0] : 0;
}

// ---- Top counts ----
$count_products   = (int) dash_scalar($con, "SELECT COUNT(*) FROM products");
$count_categories = (int) dash_scalar($con, "SELECT COUNT(*) FROM category");
$count_projects   = (int) dash_scalar($con, "SELECT COUNT(*) FROM projects");
$count_orders     = (int) dash_scalar($con, "SELECT COUNT(*) FROM orders");
$count_customers  = (int) dash_scalar($con, "SELECT COUNT(*) FROM user");
$revenue          = (int) dash_scalar($con, "SELECT IFNULL(SUM(price*quantity),0) FROM order_items");

// ---- Products by category (donut) ----
$catLabels = array(); $catCounts = array();
$r = mysqli_query($con, "SELECT TRIM(pcategory) cat, COUNT(*) c FROM products GROUP BY TRIM(pcategory) ORDER BY c DESC");
while ($x = mysqli_fetch_assoc($r)) {
    $catLabels[]  = ($x['cat'] !== '' ? $x['cat'] : 'Uncategorized');
    $catCounts[]  = (int) $x['c'];
}

// ---- Stock by category (bar) ----
$stockLabels = array(); $stockVals = array();
$r = mysqli_query($con, "SELECT TRIM(pcategory) cat, SUM(stock) s FROM products GROUP BY TRIM(pcategory) ORDER BY s DESC");
while ($x = mysqli_fetch_assoc($r)) {
    $stockLabels[] = ($x['cat'] !== '' ? $x['cat'] : 'Uncategorized');
    $stockVals[]   = (int) $x['s'];
}

// ---- Customer signups by month (area) ----
$signupLabels = array(); $signupVals = array();
$r = mysqli_query($con, "SELECT DATE_FORMAT(joining_date,'%Y-%m') m, COUNT(*) c FROM user WHERE joining_date IS NOT NULL AND joining_date<>'0000-00-00' GROUP BY m ORDER BY m");
while ($x = mysqli_fetch_assoc($r)) {
    $signupLabels[] = date('M Y', strtotime($x['m'] . '-01'));
    $signupVals[]   = (int) $x['c'];
}

// ---- Order totals map + recent orders ----
$otot = array();
$r = mysqli_query($con, "SELECT order_id, SUM(price*quantity) t FROM order_items GROUP BY order_id");
while ($x = mysqli_fetch_assoc($r)) { $otot[$x['order_id']] = (int) $x['t']; }

$recent_orders = array();
$r = mysqli_query($con, "SELECT o.order_id,o.user_id,o.date_time,u.firstname,u.lastname FROM orders o LEFT JOIN user u ON u.id=o.user_id ORDER BY o.id DESC LIMIT 6");
while ($x = mysqli_fetch_assoc($r)) {
    $x['total'] = isset($otot[$x['order_id']]) ? $otot[$x['order_id']] : 0;
    $recent_orders[] = $x;
}
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        .stat-card{border:0;border-radius:14px;overflow:hidden;transition:transform .15s ease, box-shadow .15s ease;}
        .stat-card:hover{transform:translateY(-4px);box-shadow:0 10px 26px rgba(0,0,0,.10);}
        .stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;}
        .stat-value{font-size:22px;font-weight:700;line-height:1;color:#2d2f39;}
        .stat-label{font-size:12px;letter-spacing:.3px;color:#7a7f8a;}

        .chart-card{border:0;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.05);}
        .chart-card .card-header{background:transparent;border-bottom:1px solid #f0f2f5;}
        .chart-title{font-weight:700;color:#2d2f39;margin:0;font-size:15px;}
        /* force pie % labels to be crisp white (theme CSS forces them grey otherwise) */
        #chartCategory .apexcharts-datalabels text{fill:#ffffff !important;font-weight:800 !important;}

        .ro-item{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px dashed #eef0f4;transition:background .12s ease;}
        .ro-item:last-child{border-bottom:0;}
        .ro-id{font-family:monospace;font-weight:700;color:#3b6fe0;font-size:12.5px;}
        .ro-cust{font-size:12px;color:#7a7f8a;}
        .ro-total{font-weight:700;color:#1aa260;}
        .ro-total::before{content:'\20B9';margin-right:1px;}

        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .stat-card{animation:fadeInUp .5s ease both;}
        .row > div:nth-child(1) > .stat-card{animation-delay:.04s;}
        .row > div:nth-child(2) > .stat-card{animation-delay:.10s;}
        .row > div:nth-child(3) > .stat-card{animation-delay:.16s;}
        .row > div:nth-child(4) > .stat-card{animation-delay:.22s;}
        .row > div:nth-child(5) > .stat-card{animation-delay:.28s;}
        .row > div:nth-child(6) > .stat-card{animation-delay:.34s;}
        .chart-card{animation:fadeInUp .55s ease both;animation-delay:.3s;}
        @media (prefers-reduced-motion: reduce){ .stat-card,.chart-card{animation:none;} }
    </style>
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">

        <!-- sidebar -->
        <?php include_once"design/sidebar.php"?>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <?php include_once"design/nav.php"?>

            <!-- Body: Body -->
            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Page heading -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Dashboard</h3>
                                <span class="text-muted small">Welcome back, Bosk Furniture admin</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stat cards (clickable -> section pages) -->
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="product-list.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-box"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo $count_products; ?></div><div class="stat-label">Products</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="categorie-list.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#f3eefe;color:#8b5cf6;"><i class="icofont-tags"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo $count_categories; ?></div><div class="stat-label">Categories</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="project-list.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e6f7fb;color:#06b6d4;"><i class="icofont-architecture-alt"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo $count_projects; ?></div><div class="stat-label">Projects</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="order-list.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-cart"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo $count_orders; ?></div><div class="stat-label">Orders</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="customers.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fdeef0;color:#e23b3b;"><i class="icofont-users-alt-4"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo $count_customers; ?></div><div class="stat-label">Customers</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a href="order-invoices.php" class="card stat-card bg-white h-100 text-decoration-none">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e7f8ee;color:#1aa260;"><i class="icofont-money"></i></div>
                                    <div class="ms-3"><div class="stat-value">&#8377;<?php echo number_format($revenue); ?></div><div class="stat-label">Revenue</div></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Charts row 1 -->
                    <div class="row g-3 mb-3">
                        <div class="col-xl-8">
                            <div class="card chart-card h-100">
                                <div class="card-header py-3"><h6 class="chart-title">Customer Signups <span class="text-muted fw-light">(monthly)</span></h6></div>
                                <div class="card-body"><div id="chartSignups"></div></div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card chart-card h-100">
                                <div class="card-header py-3"><h6 class="chart-title">Products by Category</h6></div>
                                <div class="card-body"><div id="chartCategory"></div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts row 2 -->
                    <div class="row g-3 mb-3">
                        <div class="col-xl-7">
                            <div class="card chart-card h-100">
                                <div class="card-header py-3"><h6 class="chart-title">Stock by Category</h6></div>
                                <div class="card-body"><div id="chartStock"></div></div>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="card chart-card h-100">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="chart-title">Recent Orders</h6>
                                    <a href="order-list.php" class="btn btn-sm btn-light border">View all</a>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($recent_orders)): ?>
                                        <p class="text-muted mb-0">No orders yet.</p>
                                    <?php else: foreach ($recent_orders as $o):
                                        $oname = trim(($o['firstname'] ?? '') . ' ' . ($o['lastname'] ?? ''));
                                        if ($oname === '') { $oname = 'User #' . $o['user_id']; }
                                        $enc = base64_encode($o['user_id']);
                                    ?>
                                        <div class="ro-item">
                                            <div>
                                                <a href="order-details.php?astringdata=<?php echo $o['order_id'];?>&astringdata1=<?php echo $enc;?>" class="ro-id">#<?php echo $o['order_id'];?></a>
                                                <div class="ro-cust"><?php echo htmlspecialchars($oname);?> &middot; <?php echo date('d M Y', strtotime($o['date_time']));?></div>
                                            </div>
                                            <span class="ro-total"><?php echo number_format($o['total']);?></span>
                                        </div>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/apexcharts.bundle.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        (function () {
            if (typeof ApexCharts === 'undefined') { return; }
            var baseFont = 'inherit';

            // 1) Customer signups — area
            var signupLabels = <?php echo json_encode($signupLabels); ?>;
            var signupVals   = <?php echo json_encode($signupVals); ?>;
            if (document.querySelector('#chartSignups')) {
                new ApexCharts(document.querySelector('#chartSignups'), {
                    chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: baseFont },
                    series: [{ name: 'New Customers', data: signupVals }],
                    xaxis: { categories: signupLabels, labels: { style: { colors: '#9aa0ab' } } },
                    yaxis: { labels: { style: { colors: '#9aa0ab' } } },
                    colors: ['#3b6fe0'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] } },
                    grid: { borderColor: '#eef0f4', strokeDashArray: 4 },
                    markers: { size: 4, colors: ['#3b6fe0'], strokeWidth: 2, strokeColors: '#fff' },
                    tooltip: { theme: 'light' }
                }).render();
            }

            // 2) Products by category — pie (solid slices, % labels)
            var catLabels = <?php echo json_encode($catLabels); ?>;
            var catCounts = <?php echo json_encode($catCounts); ?>;
            if (document.querySelector('#chartCategory') && catCounts.length) {
                new ApexCharts(document.querySelector('#chartCategory'), {
                    chart: { type: 'pie', height: 330, fontFamily: baseFont, animations: { enabled: true, speed: 600 } },
                    series: catCounts,
                    labels: catLabels,
                    colors: ['#3b6fe0', '#1aa260', '#d98a00', '#e23b3b', '#8b5cf6', '#06b6d4', '#ec4899'],
                    legend: { position: 'bottom', fontSize: '13px', markers: { radius: 6 } },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) { return Math.round(val) + '%'; },
                        style: { fontSize: '16px', fontWeight: 800, colors: ['#ffffff'] },
                        dropShadow: { enabled: true, top: 1, left: 1, blur: 3, color: '#000000', opacity: 0.7 }
                    },
                    stroke: { width: 2, colors: ['#fff'] },
                    states: { hover: { filter: { type: 'darken', value: 0.92 } } },
                    tooltip: { theme: 'light', y: { formatter: function (v) { return v + ' product' + (v === 1 ? '' : 's'); } } },
                    responsive: [{ breakpoint: 480, options: { legend: { position: 'bottom' } } }]
                }).render();
            }

            // 3) Stock by category — bar
            var stockLabels = <?php echo json_encode($stockLabels); ?>;
            var stockVals   = <?php echo json_encode($stockVals); ?>;
            if (document.querySelector('#chartStock') && stockVals.length) {
                new ApexCharts(document.querySelector('#chartStock'), {
                    chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: baseFont },
                    series: [{ name: 'Stock Units', data: stockVals }],
                    xaxis: { categories: stockLabels, labels: { style: { colors: '#9aa0ab' } } },
                    yaxis: { labels: { style: { colors: '#9aa0ab' } } },
                    colors: ['#1aa260'],
                    plotOptions: { bar: { borderRadius: 8, columnWidth: '45%', distributed: false } },
                    dataLabels: { enabled: false },
                    grid: { borderColor: '#eef0f4', strokeDashArray: 4 },
                    tooltip: { theme: 'light' }
                }).render();
            }
        })();
    </script>

</body>

</html>
<?php
}
else{
     header("Location: index.php");
    exit();
}
?>
