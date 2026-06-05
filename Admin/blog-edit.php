<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

$bid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = mysqli_query($con, "SELECT * FROM blog WHERE id='" . $bid . "'");
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: Blog-list.php");
    exit();
}
$b = mysqli_fetch_assoc($res);

$title  = $b['blog_title'];
$desc   = $b['blog_description'];
$bdate  = $b['blog_date'];
$img    = $b['img'];
$hasImg = ($img !== '' && $img !== 'noimg.jpg');
$src    = $hasImg ? 'blog_image/' . $img : 'blog_image/noimg.jpg';
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

            <form action="back/editblog.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="id" value="<?php echo $bid; ?>">

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <div class="d-flex align-items-center">
                                    <a href="Blog-list.php" class="btn btn-light border me-3"><i class="icofont-arrow-left"></i></a>
                                    <h3 class="fw-bold mb-0">Edit Blog <span class="text-muted fw-light fs-5">#<?php echo $bid; ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">

                        <!-- Content -->
                        <div class="col-xl-7 col-lg-7">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Blog Content</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Blog Title <span class="req">*</span></label>
                                            <input type="text" name="blog_title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Blog Description <span class="req">*</span></label>
                                            <textarea name="blog_description" class="form-control" rows="8" required><?php echo htmlspecialchars($desc); ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Publish Date &amp; Time</label>
                                            <input type="datetime-local" name="blog_date" class="form-control" value="<?php echo ($bdate && $bdate !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($bdate)) : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="col-xl-5 col-lg-5">
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 fw-bold">Cover Image</h6>
                                    <small class="text-muted">jpg, png, webp, gif &middot; max 5MB</small>
                                </div>
                                <div class="card-body">
                                    <div class="img-slot">
                                        <div class="slot-label">Current Image</div>
                                        <img src="<?php echo $src; ?>" class="preview mb-2" id="preview" alt="<?php echo htmlspecialchars($title); ?>" onerror="this.src='product_image/noimg.jpg'">
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
                            <a href="Blog-list.php" class="btn btn-light border">Cancel</a>
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
