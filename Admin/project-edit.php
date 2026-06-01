<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

$pid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = mysqli_query($con, "SELECT * FROM projects WHERE id='" . $pid . "'");
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: project-list.php");
    exit();
}
$p = mysqli_fetch_assoc($res);

$project_name    = $p['project_name'];
$pro_desc        = $p['pro_desc'];
$interior_detail = $p['interior_detail'];
$images          = array($p['img1'], $p['img2'], $p['img3'], $p['img4'], $p['img5']);
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once"design/header.php"?>
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        .edit-card{border:0;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.05);}
        .edit-card .card-header{border-bottom:1px solid #f0f2f5;}
        .img-slot{border:1px dashed #d7dce3;border-radius:12px;padding:12px;text-align:center;background:#fafbfc;transition:border-color .15s ease;}
        .img-slot:hover{border-color:#3b6fe0;}
        .img-slot .preview{width:100%;height:180px;object-fit:cover;border-radius:9px;background:#fff;border:1px solid #eef0f4;}
        .img-slot .slot-label{font-size:12px;font-weight:600;color:#6c757d;margin-bottom:6px;}
        .remove-wrap{font-size:12.5px;}
        .req{color:#e23b3b;}
        .save-bar{position:sticky;bottom:0;z-index:5;}
        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .edit-card{animation:fadeInUp .45s ease both;}
        .row.g-3.mb-3 > div:nth-child(2) .edit-card{animation-delay:.1s;}
        .img-slot .preview{transition:transform .2s ease;}
        .img-slot:hover .preview{transform:scale(1.05);}
        .btn-primary{transition:transform .15s ease, box-shadow .15s ease;}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(59,111,224,.35);}
        @media (prefers-reduced-motion: reduce){ .edit-card{animation:none;} .img-slot:hover .preview,.btn-primary:hover{transform:none;} }
    </style>
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">

        <?php include_once"design/sidebar.php"?>

        <div class="main px-lg-4 px-md-4">

            <?php include_once"design/nav.php"?>

            <form action="back/update-project-full.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="id" value="<?php echo $pid; ?>">

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <div class="d-flex align-items-center">
                                    <a href="project-list.php" class="btn btn-light border me-3"><i class="icofont-arrow-left"></i></a>
                                    <h3 class="fw-bold mb-0">Edit Project <span class="text-muted fw-light fs-5">#<?php echo $pid; ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">

                        <!-- Info -->
                        <div class="col-12">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Project Information</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Project Name <span class="req">*</span></label>
                                            <input type="text" name="project_name" class="form-control" value="<?php echo htmlspecialchars($project_name); ?>" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Project Description <span class="req">*</span></label>
                                            <textarea name="pro_desc" class="form-control" rows="5"><?php echo htmlspecialchars($pro_desc); ?></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Interior Details <span class="req">*</span></label>
                                            <textarea name="interior_detail" class="form-control" rows="5"><?php echo htmlspecialchars($interior_detail); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="col-12">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 fw-bold">Project Images <span class="text-muted fw-light">(up to 5)</span></h6>
                                    <small class="text-muted">jpg, png, webp, gif &middot; max 5MB</small>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <?php for ($i = 0; $i < 5; $i++):
                                            $slot   = $i + 1;
                                            $cur    = $images[$i];
                                            $hasImg = ($cur !== '' && $cur !== 'noimg.jpg');
                                            $src    = $hasImg ? 'project_image/' . $cur : 'project_image/noimg.jpg';
                                        ?>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="img-slot">
                                                <div class="slot-label">Image <?php echo $slot; ?><?php echo $i === 0 ? ' (Main)' : ''; ?></div>
                                                <img src="<?php echo $src; ?>" class="preview mb-2" id="preview<?php echo $slot; ?>" alt="">
                                                <input type="file" name="img<?php echo $slot; ?>" accept="image/*"
                                                       class="form-control form-control-sm mb-2"
                                                       onchange="previewImg(this,'preview<?php echo $slot; ?>')">
                                                <?php if ($hasImg): ?>
                                                <div class="form-check remove-wrap text-start">
                                                    <input class="form-check-input" type="checkbox" name="remove_img<?php echo $slot; ?>" value="1" id="rm<?php echo $slot; ?>">
                                                    <label class="form-check-label text-danger" for="rm<?php echo $slot; ?>">Remove this image</label>
                                                </div>
                                                <?php else: ?>
                                                <div class="remove-wrap text-muted text-start">No image — upload to add</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                    <small class="text-muted d-block mt-2">Leave a slot empty to keep the current image. Choose a file to replace/add, or tick “Remove” to clear it.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom save bar -->
                    <div class="card edit-card save-bar mb-3">
                        <div class="card-body d-flex justify-content-end gap-2 py-2">
                            <a href="project-list.php" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="icofont-save me-2"></i>Save Changes</button>
                        </div>
                    </div>

                </div>
            </div>
            </form>

        </div>
    </div>

    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>
    <script>
        function previewImg(input, targetId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(targetId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                var rm = input.parentNode.querySelector('input[type=checkbox]');
                if (rm) { rm.checked = false; }
            }
        }
    </script>
</body>
</html>
