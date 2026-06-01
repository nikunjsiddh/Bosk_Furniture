<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

// ---- Order totals per order_id (from line items) ----
$totals = array();
$tq = mysqli_query($con, "select order_id, count(*) items, sum(price*quantity) total from order_items group by order_id");
if ($tq) {
    while ($r = mysqli_fetch_assoc($tq)) {
        $totals[$r['order_id']] = array('items' => intval($r['items']), 'total' => intval($r['total']));
    }
}

// ---- Fetch all orders with customer name ----
$orders = array();
$oq = mysqli_query($con, "select o.*, u.firstname, u.lastname, u.email from orders o left join user u on u.id=o.user_id order by o.id desc") or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($oq)) {
    $orders[] = $row;
}

// ---- Summary stats ----
$total_orders  = count($orders);
$total_revenue = 0;
$total_items   = 0;
foreach ($totals as $t) { $total_revenue += $t['total']; $total_items += $t['items']; }
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">

    <style>
        .stat-card{border:0;border-radius:14px;overflow:hidden;transition:transform .15s ease, box-shadow .15s ease;}
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(0,0,0,.08);}
        .stat-icon{width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;}
        .stat-value{font-size:24px;font-weight:700;line-height:1;}
        .stat-label{font-size:13px;letter-spacing:.3px;}

        #myDataTable thead th{text-transform:uppercase;font-size:11.5px;letter-spacing:.6px;color:#6c757d;font-weight:700;white-space:nowrap;border-bottom:2px solid #eef0f4;}
        #myDataTable tbody tr{transition:background .12s ease;}
        #myDataTable tbody tr:hover{background:#f7f9fc;}
        #myDataTable td{vertical-align:middle;}

        /* ===== DataTables controls + pagination ===== */
        .dataTables_wrapper .dataTables_length select{border-radius:8px;border:1px solid #e4e7ec;padding:4px 28px 4px 10px;outline:none;}
        .dataTables_wrapper .dataTables_filter input{border-radius:8px;border:1px solid #e4e7ec;padding:6px 12px;outline:none;transition:border-color .15s ease,box-shadow .15s ease;}
        .dataTables_wrapper .dataTables_filter input:focus{border-color:#3b6fe0;box-shadow:0 0 0 3px rgba(59,111,224,.12);}
        .dataTables_wrapper .dataTables_info{color:#7a7f8a;font-size:13px;padding-top:18px;}
        .dataTables_wrapper .dataTables_paginate{padding-top:14px;}
        .dataTables_wrapper .dataTables_paginate .pagination{margin-bottom:0;}
        .page-item .page-link{color:#3b6fe0 !important;background:#fff !important;border:1px solid #e4e7ec !important;margin:0 3px;border-radius:9px !important;min-width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:13.5px;transition:all .15s ease;}
        .page-item .page-link:hover{background:#eef3ff !important;border-color:#3b6fe0 !important;color:#3b6fe0 !important;transform:translateY(-1px);}
        .page-item.active .page-link{background:#3b6fe0 !important;border-color:#3b6fe0 !important;color:#fff !important;box-shadow:0 4px 12px rgba(59,111,224,.35);}
        .page-item.disabled .page-link{color:#c2c8d0 !important;background:#fff !important;border-color:#eef0f4 !important;cursor:not-allowed;transform:none;}

        .order-id{font-weight:700;color:#3b6fe0;font-family:monospace;font-size:13px;}
        .cust-name{font-weight:600;color:#2d2f39;}
        .cust-mail{color:#9aa0ab;font-size:12px;}
        .date-cell{color:#7a7f8a;font-size:13px;white-space:nowrap;}
        .items-badge{background:#eef3ff;color:#3b6fe0;font-weight:600;border-radius:20px;padding:5px 12px;font-size:12px;}
        .total-cell{font-weight:700;color:#1aa260;}
        .total-cell::before{content:'\20B9';margin-right:1px;}
        .status-badge{background:#e7f8ee;color:#1aa260;font-weight:600;border-radius:20px;padding:5px 12px;font-size:11.5px;}

        .act-btn{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;border-radius:10px;border:0;font-size:16px;transition:all .15s ease;}
        .act-btn + .act-btn{margin-left:6px;}
        .act-btn:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(0,0,0,.12);}
        .act-view{background:#eef3ff;color:#3b6fe0;}
        .act-view:hover{background:#3b6fe0;color:#fff;}
        .act-inv{background:#fff5e6;color:#d98a00;}
        .act-inv:hover{background:#d98a00;color:#fff;}
        .act-del{background:#fdeaea;color:#e23b3b;}
        .act-del:hover{background:#e23b3b;color:#fff;}

        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
        .stat-card{animation:fadeInUp .5s ease both;}
        .row > div:nth-child(1) > .stat-card{animation-delay:.05s;}
        .row > div:nth-child(2) > .stat-card{animation-delay:.13s;}
        .row > div:nth-child(3) > .stat-card{animation-delay:.21s;}
        .card.shadow-sm{animation:fadeInUp .55s ease both;animation-delay:.22s;}
        #myDataTable tbody tr{animation:fadeIn .45s ease both;}
        .order-id{transition:color .15s ease;}
        #myDataTable tbody tr:hover .order-id{color:#2851c8;}
        .btn-primary{transition:transform .15s ease, box-shadow .15s ease;}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(59,111,224,.35);}
        @media (prefers-reduced-motion: reduce){ .stat-card,.card.shadow-sm,#myDataTable tbody tr{animation:none;} .btn-primary:hover{transform:none;} }
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
                                <h3 class="fw-bold mb-0">Orders</h3>
                                <a href="order-invoices.php" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="icofont-file-document me-2"></i> Invoices
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Summary stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-cart"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_orders; ?></div>
                                        <div class="stat-label text-muted">Total Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e7f8ee;color:#1aa260;"><i class="icofont-money"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value">&#8377;<?php echo number_format($total_revenue); ?></div>
                                        <div class="stat-label text-muted">Total Revenue</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-box"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_items; ?></div>
                                        <div class="stat-label text-muted">Items Ordered</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders table -->
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="card bg-white shadow-sm" style="border:0;border-radius:14px;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($orders as $row):
                                                $order_id = $row['order_id'];
                                                $user_id  = $row['user_id'];
                                                $encoded_user_id = base64_encode($user_id);
                                                $name  = trim(($row['firstname'] ?? '') . ' ' . ($row['lastname'] ?? ''));
                                                if ($name === '') { $name = 'User #' . $user_id; }
                                                $email = $row['email'] ?? '';
                                                $date  = $row['date_time'];
                                                $items = isset($totals[$order_id]) ? $totals[$order_id]['items'] : 0;
                                                $total = isset($totals[$order_id]) ? $totals[$order_id]['total'] : 0;
                                            ?>
                                                <tr id="delete<?php echo $order_id;?>">
                                                    <td><a href="order-details.php?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $encoded_user_id;?>" class="order-id">#<?php echo $order_id;?></a></td>
                                                    <td>
                                                        <div class="cust-name"><?php echo htmlspecialchars($name);?></div>
                                                        <?php if ($email !== ''): ?><div class="cust-mail"><?php echo htmlspecialchars($email);?></div><?php endif; ?>
                                                    </td>
                                                    <td><span class="date-cell"><?php echo date('d M Y', strtotime($date));?></span></td>
                                                    <td><span class="items-badge"><?php echo $items;?></span></td>
                                                    <td><span class="total-cell"><?php echo number_format($total);?></span></td>
                                                    <td><span class="status-badge">Placed</span></td>
                                                    <td class="text-end">
                                                        <a href="order-details.php?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $encoded_user_id;?>" class="act-btn act-view" title="View details"><i class="icofont-eye-alt"></i></a>
                                                        <a href="invoice.php?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $user_id;?>" class="act-btn act-inv" title="Invoice"><i class="icofont-print"></i></a>
                                                        <button type="button" onclick="deleteorder('<?php echo $order_id;?>')" class="act-btn act-del deleterow" title="Delete"><i class="icofont-ui-delete"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="return"></div>
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
    <script src="assets/bundles/dataTables.bundle.js"></script>
    <script src="js/deleteorder.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myDataTable').DataTable({
                responsive: false,
                order: [],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [ { targets: [-1], orderable: false } ],
                language: {
                    search: "",
                    searchPlaceholder: "Search orders...",
                    lengthMenu: "Show _MENU_ orders"
                }
            });
        });
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
