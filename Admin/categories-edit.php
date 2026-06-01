<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

$cid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = mysqli_query($con, "SELECT * FROM category WHERE id='" . $cid . "'");
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: categorie-list.php");
    exit();
}
$c = mysqli_fetch_assoc($res);

$name   = $c['name'];
$img    = $c['img'];
$hasImg = ($img !== '' && $img !== 'noimg.jpg');
$src    = $hasImg ? 'category_image/' . $img : 'category_image/noimg.jpg';
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
        .img-slot .preview{width:100%;height:200px;object-fit:cover;border-radius:9px;background:#fff;border:1px solid #eef0f4;}
        .img-slot .slot-label{font-size:12px;font-weight:600;color:#6c757d;margin-bottom:6px;}
        .req{color:#e23b3b;}
        .save-bar{position:sticky;bottom:0;z-index:5;}
        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .edit-card{animation:fadeInUp .45s ease both;}
        .col-xl-5 .edit-card{animation-delay:.1s;}
        .img-slot .preview{transition:transform .2s ease;}
        .img-slot:hover .preview{transform:scale(1.04);}
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

            <form action="back/editcategory.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="id" value="<?php echo $cid; ?>">

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <div class="d-flex align-items-center">
                                    <a href="categorie-list.php" class="btn btn-light border me-3"><i class="icofont-arrow-left"></i></a>
                                    <h3 class="fw-bold mb-0">Edit Category <span class="text-muted fw-light fs-5">#<?php echo $cid; ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">

                        <!-- Info -->
                        <div class="col-xl-7 col-lg-7">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Category Information</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Category Name <span class="req">*</span></label>
                                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="col-xl-5 col-lg-5">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 fw-bold">Category Image</h6>
                                    <small class="text-muted">jpg, png, webp, gif &middot; max 5MB</small>
                                </div>
                                <div class="card-body">
                                    <div class="img-slot">
                                        <div class="slot-label">Current Image</div>
                                        <img src="<?php echo $src; ?>" class="preview mb-2" id="preview" alt="<?php echo htmlspecialchars($name); ?>">
                                        <input type="file" name="img" accept="image/*" class="form-control form-control-sm" onchange="previewImg(this,'preview')">
                                    </div>
                                    <small class="text-muted d-block mt-2">Leave empty to keep the current image, or choose a file to replace it.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom save bar -->
                    <div class="card edit-card save-bar mb-3">
                        <div class="card-body d-flex justify-content-end gap-2 py-2">
                            <a href="categorie-list.php" class="btn btn-light border">Cancel</a>
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
                reader.onload = function (e) { document.getElementById(targetId).src = e.target.result; };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
