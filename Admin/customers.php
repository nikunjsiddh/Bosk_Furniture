<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

// ---- Orders count per customer ----
$order_counts = array();
$oc = mysqli_query($con, "select user_id, count(*) c from orders group by user_id");
if ($oc) {
    while ($r = mysqli_fetch_assoc($oc)) { $order_counts[strval($r['user_id'])] = intval($r['c']); }
}

// ---- Fetch all customers ----
$customers = array();
$uq = mysqli_query($con, "select * from user order by id desc") or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($uq)) { $customers[] = $row; }

// ---- Summary stats ----
$total_customers = count($customers);
$with_orders = 0;
$total_orders = 0;
foreach ($order_counts as $uid => $c) { $with_orders++; $total_orders += $c; }

function cust_clean($v) {
    $v = trim($v);
    if ($v === '' || strtoupper($v) === 'NA' || $v === '0') { return ''; }
    return $v;
}
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
        .stat-value{font-size:26px;font-weight:700;line-height:1;}
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

        .cust-avatar{width:44px;height:44px;border-radius:50%;object-fit:cover;border:1px solid #eef0f4;background:#f1f3f6;}
        .cust-name{font-weight:600;color:#2d2f39;}
        .cust-mail{color:#9aa0ab;font-size:12px;}
        .muted-cell{color:#7a7f8a;font-size:13px;}
        .orders-badge{background:#e7f8ee;color:#1aa260;font-weight:600;border-radius:20px;padding:5px 12px;font-size:12px;}
        .orders-zero{background:#f1f3f6;color:#9aa0ab;}

        .act-btn{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;border-radius:10px;border:0;font-size:16px;transition:all .15s ease;}
        .act-view{background:#eef3ff;color:#3b6fe0;}
        .act-view:hover{background:#3b6fe0;color:#fff;transform:translateY(-2px);box-shadow:0 6px 14px rgba(0,0,0,.12);}

        .modal-detail-row{padding:9px 0;border-bottom:1px dashed #eef0f4;}
        .modal-detail-row .lbl{color:#7a7f8a;font-size:13px;}
        .modal-detail-row .val{font-weight:600;color:#2d2f39;}
        .modal-avatar{width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid #eef3ff;}

        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        @keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
        @keyframes popIn{from{opacity:0;transform:scale(.96);}to{opacity:1;transform:scale(1);}}
        .stat-card{animation:fadeInUp .5s ease both;}
        .row > div:nth-child(1) > .stat-card{animation-delay:.05s;}
        .row > div:nth-child(2) > .stat-card{animation-delay:.13s;}
        .row > div:nth-child(3) > .stat-card{animation-delay:.21s;}
        .card.shadow-sm{animation:fadeInUp .55s ease both;animation-delay:.22s;}
        #myDataTable tbody tr{animation:fadeIn .45s ease both;}
        .cust-avatar{transition:transform .2s ease, box-shadow .2s ease;}
        #myDataTable tbody tr:hover .cust-avatar{transform:scale(1.1);box-shadow:0 4px 12px rgba(0,0,0,.15);}
        .cust-name{transition:color .15s ease;}
        #myDataTable tbody tr:hover .cust-name{color:#3b6fe0;}
        .modal-content{animation:popIn .28s ease both;}
        @media (prefers-reduced-motion: reduce){ .stat-card,.card.shadow-sm,#myDataTable tbody tr,.modal-content{animation:none;} .cust-avatar{transition:none;} }
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
                                <h3 class="fw-bold mb-0">Customers</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Summary stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-users-alt-4"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_customers; ?></div>
                                        <div class="stat-label text-muted">Total Customers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e7f8ee;color:#1aa260;"><i class="icofont-cart"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $with_orders; ?></div>
                                        <div class="stat-label text-muted">With Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-box"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_orders; ?></div>
                                        <div class="stat-label text-muted">Total Orders Placed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customers table -->
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="card bg-white shadow-sm" style="border:0;border-radius:14px;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Phone</th>
                                                    <th>Location</th>
                                                    <th>Joined</th>
                                                    <th>Orders</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($customers as $row):
                                                $id    = $row['id'];
                                                $name  = trim($row['firstname'] . ' ' . $row['lastname']);
                                                if ($name === '') { $name = 'Customer #' . $id; }
                                                $email = $row['email'];
                                                $phone = cust_clean($row['phone']);
                                                $city  = cust_clean($row['city']);
                                                $state = cust_clean($row['state']);
                                                $country = cust_clean($row['country']);
                                                $loc   = trim(implode(', ', array_filter(array($city, $state, $country))));
                                                $img   = $row['img'];
                                                $src   = ($img !== '' && $img !== 'noimg.jpg') ? 'customer_image/' . $img : 'customer_image/noimg.jpg';
                                                $ocount = isset($order_counts[strval($id)]) ? $order_counts[strval($id)] : 0;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img class="cust-avatar me-2" src="<?php echo $src;?>" alt="">
                                                            <div>
                                                                <div class="cust-name"><?php echo htmlspecialchars($name);?></div>
                                                                <div class="cust-mail"><?php echo htmlspecialchars($email);?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="muted-cell"><?php echo $phone !== '' ? htmlspecialchars($phone) : '—';?></span></td>
                                                    <td><span class="muted-cell"><?php echo $loc !== '' ? htmlspecialchars($loc) : '—';?></span></td>
                                                    <td><span class="muted-cell"><?php echo $row['joining_date'] ? date('d M Y', strtotime($row['joining_date'])) : '—';?></span></td>
                                                    <td><span class="orders-badge <?php echo $ocount === 0 ? 'orders-zero' : '';?>"><?php echo $ocount;?></span></td>
                                                    <td class="text-end">
                                                        <button type="button" class="act-btn act-view" data-bs-toggle="modal" data-bs-target="#cust<?php echo $id;?>" title="View details"><i class="icofont-eye-alt"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ============ Customer detail modals ============ -->
    <?php foreach ($customers as $row):
        $id    = $row['id'];
        $name  = trim($row['firstname'] . ' ' . $row['lastname']);
        if ($name === '') { $name = 'Customer #' . $id; }
        $email = $row['email'];
        $phone = cust_clean($row['phone']);
        $dob   = $row['dob'];
        $jd    = $row['joining_date'];
        $a1    = cust_clean($row['addressline1']);
        $a2    = cust_clean($row['addressline2']);
        $city  = cust_clean($row['city']);
        $state = cust_clean($row['state']);
        $country = cust_clean($row['country']);
        $pin   = cust_clean($row['pincode']);
        $img   = $row['img'];
        $src   = ($img !== '' && $img !== 'noimg.jpg') ? 'customer_image/' . $img : 'customer_image/noimg.jpg';
        $ocount = isset($order_counts[strval($id)]) ? $order_counts[strval($id)] : 0;
        $full_addr = trim(implode(', ', array_filter(array($a1, $a2, $city, $state, $country, $pin))));
    ?>
    <div class="modal fade" id="cust<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content" style="border:0;border-radius:14px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Customer Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="<?php echo $src; ?>" class="modal-avatar mb-2" alt="<?php echo htmlspecialchars($name); ?>">
                        <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($name); ?></h5>
                        <div class="text-muted"><?php echo htmlspecialchars($email); ?></div>
                        <span class="orders-badge <?php echo $ocount === 0 ? 'orders-zero' : '';?> mt-2 d-inline-block"><?php echo $ocount; ?> order<?php echo $ocount === 1 ? '' : 's'; ?></span>
                    </div>
                    <div class="modal-detail-row d-flex justify-content-between"><span class="lbl">Customer ID</span><span class="val">#<?php echo $id; ?></span></div>
                    <div class="modal-detail-row d-flex justify-content-between"><span class="lbl">Phone</span><span class="val"><?php echo $phone !== '' ? htmlspecialchars($phone) : '—'; ?></span></div>
                    <div class="modal-detail-row d-flex justify-content-between"><span class="lbl">Date of Birth</span><span class="val"><?php echo $dob && $dob !== '0000-00-00' ? date('d M Y', strtotime($dob)) : '—'; ?></span></div>
                    <div class="modal-detail-row d-flex justify-content-between"><span class="lbl">Joined</span><span class="val"><?php echo $jd ? date('d M Y', strtotime($jd)) : '—'; ?></span></div>
                    <div class="modal-detail-row">
                        <div class="lbl mb-1">Address</div>
                        <div class="val" style="font-weight:500;"><?php echo $full_addr !== '' ? htmlspecialchars($full_addr) : '—'; ?></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/dataTables.bundle.js"></script>
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
                    searchPlaceholder: "Search customers...",
                    lengthMenu: "Show _MENU_ customers"
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
