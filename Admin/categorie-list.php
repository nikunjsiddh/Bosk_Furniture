<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

// ---- Fetch all categories ----
$categories = array();
$result = mysqli_query($con, "select * from category order by id desc") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
    $categories[] = $row;
}

// ---- Product counts per category (matched by trimmed name) ----
$prod_counts = array();
$pc = mysqli_query($con, "select pcategory, count(*) c from products group by pcategory");
if ($pc) {
    while ($r = mysqli_fetch_assoc($pc)) {
        $prod_counts[strtolower(trim($r['pcategory']))] = intval($r['c']);
    }
}

// ---- Summary stats ----
$total_categories = count($categories);
$with_images = 0;
foreach ($categories as $c) {
    if ($c['img'] !== '' && $c['img'] !== 'noimg.jpg') { $with_images++; }
}
$total_products = 0;
foreach ($prod_counts as $n => $cnt) { $total_products += $cnt; }
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

        .prod-thumb{width:62px;height:62px;object-fit:cover;border-radius:10px;border:1px solid #eef0f4;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.05);}
        .prod-name{font-weight:600;color:#2d2f39;}
        .idx-badge{background:#eef3ff;color:#3b6fe0;font-weight:600;border-radius:8px;padding:4px 10px;font-size:12px;}
        .count-badge{background:#e7f8ee;color:#1aa260;font-weight:600;border-radius:20px;padding:5px 12px;font-size:12px;}
        .count-zero{background:#f1f3f6;color:#9aa0ab;}

        .act-btn{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;border-radius:10px;border:0;font-size:16px;transition:all .15s ease;}
        .act-btn + .act-btn{margin-left:6px;}
        .act-btn:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(0,0,0,.12);}
        .act-edit{background:#e7f8ee;color:#1aa260;}
        .act-edit:hover{background:#1aa260;color:#fff;}
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
        .prod-thumb{transition:transform .2s ease, box-shadow .2s ease;}
        .prod-thumb:hover{transform:scale(1.12);box-shadow:0 6px 18px rgba(0,0,0,.18);}
        .prod-name{transition:color .15s ease;}
        #myDataTable tbody tr:hover .prod-name{color:#3b6fe0;}
        .idx-badge{transition:transform .15s ease;}
        #myDataTable tbody tr:hover .idx-badge{transform:scale(1.12);}
        .btn-primary{transition:transform .15s ease, box-shadow .15s ease;}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(59,111,224,.35);}
        @media (prefers-reduced-motion: reduce){
            .stat-card,.card.shadow-sm,#myDataTable tbody tr{animation:none;}
            .prod-thumb:hover,.btn-primary:hover{transform:none;}
        }
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
                                <h3 class="fw-bold mb-0">Categories</h3>
                                <a href="categories-add.php" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="icofont-plus me-2"></i> Add Category
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Summary stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-tags"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_categories; ?></div>
                                        <div class="stat-label text-muted">Total Categories</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e7f8ee;color:#1aa260;"><i class="icofont-image"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $with_images; ?></div>
                                        <div class="stat-label text-muted">With Image</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-box"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_products; ?></div>
                                        <div class="stat-label text-muted">Products Categorized</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories table -->
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="card bg-white shadow-sm" style="border:0;border-radius:14px;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Category Name</th>
                                                    <th>Products</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $count = 0; foreach ($categories as $row):
                                                $count++;
                                                $id    = $row['id'];
                                                $name  = $row['name'];
                                                $img   = $row['img'];
                                                $src   = ($img !== '' && $img !== 'noimg.jpg') ? 'category_image/' . $img : 'category_image/noimg.jpg';
                                                $pcount = isset($prod_counts[strtolower(trim($name))]) ? $prod_counts[strtolower(trim($name))] : 0;
                                            ?>
                                                <tr id="delete<?php echo $id;?>">
                                                    <td><span class="idx-badge"><?php echo $count; ?></span></td>
                                                    <td><img class="prod-thumb" src="<?php echo $src;?>" alt="<?php echo htmlspecialchars($name); ?>"></td>
                                                    <td><span class="prod-name"><?php echo htmlspecialchars($name);?></span></td>
                                                    <td><span class="count-badge <?php echo $pcount === 0 ? 'count-zero' : '';?>"><?php echo $pcount; ?> product<?php echo $pcount === 1 ? '' : 's'; ?></span></td>
                                                    <td class="text-end">
                                                        <a href="categories-edit.php?id=<?php echo $id;?>" class="act-btn act-edit" title="Edit"><i class="icofont-ui-edit"></i></a>
                                                        <button type="button" onclick="deletecategory(<?php echo $id;?>)" class="act-btn act-del deleterow" title="Delete"><i class="icofont-ui-delete"></i></button>
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
    <script src="js/deletecategory.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myDataTable').DataTable({
                responsive: false,
                order: [],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [ { targets: [1, -1], orderable: false } ],
                language: {
                    search: "",
                    searchPlaceholder: "Search categories...",
                    lengthMenu: "Show _MENU_ categories"
                }
            });
        });
    </script>

    <?php if (isset($_GET['updated'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['updated'] === '1'): ?>
            toastr["success"]("Category updated successfully!", "Saved");
        <?php else: ?>
            toastr["error"]("Could not update the category. Please try again.", "Failed");
        <?php endif; ?>
    </script>
    <?php endif; ?>

    <?php if (isset($_GET['added'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['added'] === '1'): ?>
            toastr["success"]("Category added successfully!", "Added");
        <?php else: ?>
            toastr["error"]("Could not add the category. Please try again.", "Failed");
        <?php endif; ?>
    </script>
    <?php endif; ?>

</body>

</html>
<?php
}
else{
     header("Location: index.php");
    exit();
}
?>
