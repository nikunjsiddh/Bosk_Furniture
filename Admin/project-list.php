<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

// ---- Fetch all projects (newest first) ----
$projects = array();
$result = mysqli_query($con, "select * from projects order by id desc") or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
    $projects[] = $row;
}

// ---- Summary stats ----
$total_projects = count($projects);
$with_images = 0;
foreach ($projects as $p) {
    if ($p['img1'] !== '' && $p['img1'] !== 'noimg.jpg') { $with_images++; }
}
$missing_images = $total_projects - $with_images;
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>

    <!--plugin css file -->
    <link rel="stylesheet" href="assets/plugin/nouislider/nouislider.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">

    <style>
        .stat-card{border:0;border-radius:14px;overflow:hidden;transition:transform .15s ease, box-shadow .15s ease;}
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(0,0,0,.08);}
        .stat-icon{width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;}
        .stat-value{font-size:26px;font-weight:700;line-height:1;}
        .stat-label{font-size:13px;letter-spacing:.3px;}

        #myDataTable thead th{
            text-transform:uppercase;font-size:11.5px;letter-spacing:.6px;
            color:#6c757d;font-weight:700;white-space:nowrap;border-bottom:2px solid #eef0f4;
        }
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
        .page-item .page-link{
            color:#3b6fe0 !important;background:#fff !important;border:1px solid #e4e7ec !important;
            margin:0 3px;border-radius:9px !important;min-width:40px;height:40px;
            display:flex;align-items:center;justify-content:center;
            font-weight:600;font-size:13.5px;transition:all .15s ease;
        }
        .page-item .page-link:hover{background:#eef3ff !important;border-color:#3b6fe0 !important;color:#3b6fe0 !important;transform:translateY(-1px);}
        .page-item.active .page-link{background:#3b6fe0 !important;border-color:#3b6fe0 !important;color:#fff !important;box-shadow:0 4px 12px rgba(59,111,224,.35);}
        .page-item.disabled .page-link{color:#c2c8d0 !important;background:#fff !important;border-color:#eef0f4 !important;cursor:not-allowed;transform:none;}

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
        .prod-thumb{transition:transform .2s ease, box-shadow .2s ease;}
        .prod-thumb:hover{transform:scale(1.12);box-shadow:0 6px 18px rgba(0,0,0,.18);}
        .prod-name{transition:color .15s ease;}
        #myDataTable tbody tr:hover .prod-name{color:#3b6fe0;}
        .idx-badge{transition:transform .15s ease;}
        #myDataTable tbody tr:hover .idx-badge{transform:scale(1.12);}
        .cat-badge,.desc-cell{transition:color .15s ease;}
        .btn-primary{transition:transform .15s ease, box-shadow .15s ease;}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(59,111,224,.35);}
        .modal-content{animation:popIn .28s ease both;}
        .detail-img{transition:transform .18s ease, box-shadow .18s ease;}
        .detail-img:hover{transform:scale(1.06);box-shadow:0 6px 16px rgba(0,0,0,.16);}
        @media (prefers-reduced-motion: reduce){
            .stat-card,.card.shadow-sm,#myDataTable tbody tr,.modal-content{animation:none;}
            .prod-thumb:hover,.detail-img:hover,.btn-primary:hover{transform:none;}
        }

        .prod-thumb{
            width:62px;height:62px;object-fit:cover;border-radius:10px;
            border:1px solid #eef0f4;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.05);
        }
        .prod-name{font-weight:600;color:#2d2f39;}
        .idx-badge{background:#eef3ff;color:#3b6fe0;font-weight:600;border-radius:8px;padding:4px 10px;font-size:12px;}
        .desc-cell{color:#7a7f8a;font-size:13px;}

        .act-btn{
            width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;
            border-radius:10px;border:0;font-size:16px;transition:all .15s ease;
        }
        .act-btn + .act-btn{margin-left:6px;}
        .act-btn:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(0,0,0,.12);}
        .act-view{background:#eef3ff;color:#3b6fe0;}
        .act-view:hover{background:#3b6fe0;color:#fff;}
        .act-edit{background:#e7f8ee;color:#1aa260;}
        .act-edit:hover{background:#1aa260;color:#fff;}
        .act-del{background:#fdeaea;color:#e23b3b;}
        .act-del:hover{background:#e23b3b;color:#fff;}

        .modal-detail-row{padding:9px 0;border-bottom:1px dashed #eef0f4;}
        .modal-detail-row .lbl{color:#7a7f8a;font-size:13px;}
        .detail-img{height:140px;width:140px;object-fit:cover;border-radius:10px;border:1px solid #eef0f4;}
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
                                <h3 class="fw-bold mb-0">Projects</h3>
                                <a href="project-add.php" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="icofont-plus me-2"></i> Add Project
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Summary stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-architecture-alt"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_projects; ?></div>
                                        <div class="stat-label text-muted">Total Projects</div>
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
                                        <div class="stat-label text-muted">With Images</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-warning"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $missing_images; ?></div>
                                        <div class="stat-label text-muted">Missing Image</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Projects table -->
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
                                                    <th style="display:none;">Project Id</th>
                                                    <th>Project Name</th>
                                                    <th>Description</th>
                                                    <th style="display:none;">Interior Details</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $count = 0; foreach ($projects as $row):
                                                $count++;
                                                $id              = $row['id'];
                                                $project_name    = $row['project_name'];
                                                $pro_desc        = $row['pro_desc'];
                                                $interior_detail = $row['interior_detail'];
                                                $img1            = $row['img1'];
                                                $short_desc      = mb_strimwidth(strip_tags($pro_desc), 0, 70, '…');
                                            ?>
                                                <tr id="delete<?php echo $id;?>">
                                                    <td><span class="idx-badge"><?php echo $count; ?></span></td>
                                                    <td>
                                                        <img class="prod-thumb" src="project_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars($project_name); ?>" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#viewproject<?php echo $id;?>" title="View details">
                                                    </td>
                                                    <td style="display:none;"><?php echo $id;?></td>
                                                    <td><span class="prod-name" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#viewproject<?php echo $id;?>" title="View details"><?php echo $project_name;?></span></td>
                                                    <td><span class="desc-cell"><?php echo htmlspecialchars($short_desc); ?></span></td>
                                                    <td style="display:none;"><?php echo $interior_detail;?></td>
                                                    <td class="text-end">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#viewproject<?php echo $id;?>" class="act-btn act-view" title="View"><i class="icofont-eye-alt"></i></button>
                                                        <a href="project-edit.php?id=<?php echo $id;?>" class="act-btn act-edit" title="Edit"><i class="icofont-ui-edit"></i></a>
                                                        <button type="button" onclick="deleteproject(<?php echo $id;?>)" class="act-btn act-del deleterow" title="Delete"><i class="icofont-ui-delete"></i></button>
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

    <!-- ============ View Modals (one per project) ============ -->
    <?php foreach ($projects as $row):
        $id              = $row['id'];
        $project_name    = $row['project_name'];
        $pro_desc        = $row['pro_desc'];
        $interior_detail = $row['interior_detail'];
        $img1            = $row['img1'];
        $img2            = $row['img2'];

        $gallery = array();
        foreach (array($row['img1'], $row['img2'], $row['img3'], $row['img4'], $row['img5']) as $im) {
            if ($im !== '' && $im !== 'noimg.jpg') { $gallery[] = $im; }
        }
        if (empty($gallery)) { $gallery[] = 'noimg.jpg'; }
    ?>
    <div class="modal fade" id="viewproject<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border:0;border-radius:14px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <img id="mainimg<?php echo $id; ?>" src="project_image/<?php echo $gallery[0]; ?>" class="img-fluid rounded w-100 mb-2" style="border:1px solid #eef0f4;aspect-ratio:4/3;object-fit:cover;" alt="<?php echo htmlspecialchars($project_name); ?>">
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($gallery as $g): ?>
                                    <img src="project_image/<?php echo $g; ?>" class="detail-img" style="cursor:pointer;" onclick="document.getElementById('mainimg<?php echo $id; ?>').src=this.src;" alt="">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h4 class="fw-bold mb-1"><?php echo $project_name; ?></h4>
                            <span class="idx-badge mb-3 d-inline-block">Project #<?php echo $id; ?></span>

                            <div class="modal-detail-row">
                                <div class="lbl mb-1">Description</div>
                                <div style="color:#4a4f5a;line-height:1.6;"><?php echo trim($pro_desc) !== '' ? $pro_desc : '—'; ?></div>
                            </div>
                            <div class="modal-detail-row">
                                <div class="lbl mb-1">Interior Details</div>
                                <div style="color:#4a4f5a;line-height:1.6;"><?php echo trim($interior_detail) !== '' ? $interior_detail : '—'; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="project-edit.php?id=<?php echo $id; ?>" class="btn btn-primary"><i class="icofont-ui-edit me-1"></i> Edit</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/dataTables.bundle.js"></script>

    <script src="js/deleteproject.js"></script>

    <!-- Jquery Page Js -->
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myDataTable').DataTable({
                responsive: false,
                order: [],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                columnDefs: [
                    { targets: [1, -1], orderable: false }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search projects...",
                    lengthMenu: "Show _MENU_ projects"
                }
            });
        });
    </script>

    <?php if (isset($_GET['updated'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['updated'] === '1'): ?>
            toastr["success"]("Project updated successfully!", "Saved");
        <?php else: ?>
            toastr["error"]("Could not update the project. Please try again.", "Failed");
        <?php endif; ?>
    </script>
    <?php endif; ?>

    <?php if (isset($_GET['added'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['added'] === '1'): ?>
            toastr["success"]("Project added successfully!", "Added");
        <?php else: ?>
            toastr["error"]("Could not add the project. Please try again.", "Failed");
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
