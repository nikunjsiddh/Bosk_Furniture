<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");
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
        .img-slot .preview{width:100%;height:150px;object-fit:cover;border-radius:9px;background:#fff;border:1px solid #eef0f4;}
        .img-slot .slot-label{font-size:12px;font-weight:600;color:#6c757d;margin-bottom:6px;}
        .req{color:#e23b3b;}
        .save-bar{position:sticky;bottom:0;z-index:5;}
        /* ===== Animations & visual effects ===== */
        @keyframes fadeInUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        .edit-card{animation:fadeInUp .45s ease both;}
        .col-xl-4 .edit-card{animation-delay:.1s;}
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

            <form action="back/addproduct.php" method="post" enctype="multipart/form-data" id="addForm">

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <div class="d-flex align-items-center">
                                    <a href="product-list.php" class="btn btn-light border me-3"><i class="icofont-arrow-left"></i></a>
                                    <h3 class="fw-bold mb-0">Add Product</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">

                        <!-- LEFT: info + images -->
                        <div class="col-xl-8 col-lg-7">

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Basic Information</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Product Name <span class="req">*</span></label>
                                            <input type="text" name="pname" class="form-control" placeholder="e.g. 3-Seater Fabric Sofa" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="5" placeholder="Describe the product..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 fw-bold">Product Images <span class="text-muted fw-light">(up to 5)</span></h6>
                                    <small class="text-muted">jpg, png, webp, gif &middot; max 5MB</small>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="img-slot">
                                                <div class="slot-label">
                                                    <?php if ($i === 1): ?>Main Image <span class="req">*</span>
                                                    <?php else: ?>Image <?php echo $i; ?> <small class="text-muted">(optional)</small><?php endif; ?>
                                                </div>
                                                <img src="product_image/noimg.jpg" class="preview mb-2" id="preview<?php echo $i; ?>" alt="">
                                                <input type="file" name="img<?php echo $i; ?>" accept="image/*" class="form-control form-control-sm" onchange="previewImg(this,'preview<?php echo $i; ?>')" <?php echo $i === 1 ? 'required' : ''; ?>>
                                            </div>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                    <small class="text-muted d-block mt-2">The main image is shown on the product list. Images 2–5 are optional.</small>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT: pricing, organize, inventory -->
                        <div class="col-xl-4 col-lg-5">

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Pricing</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Old Price (&#8377;)</label>
                                            <input type="number" name="old_price" class="form-control" value="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">New Price (&#8377;) <span class="req">*</span></label>
                                            <input type="number" name="new_price" class="form-control" value="0" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">MRP (&#8377;)</label>
                                            <input type="number" name="mrp" class="form-control" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Organize</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Category <span class="req">*</span></label>
                                            <select name="pcategory" class="form-select" required>
                                                <option value="" disabled selected>Select a category…</option>
                                                <?php
                                                $catres = mysqli_query($con, "SELECT name FROM category ORDER BY name");
                                                while ($c = mysqli_fetch_assoc($catres)) {
                                                    echo '<option value="' . htmlspecialchars($c['name']) . '">' . htmlspecialchars($c['name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="1" selected>Active / Published</option>
                                                <option value="0">Inactive / Hidden</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Tags <small class="text-muted">(comma separated)</small></label>
                                            <input type="text" name="tags" class="form-control" placeholder="sofa, fabric, 3-seater">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Inventory & Schedule</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">SKU</label>
                                            <input type="text" name="sku" class="form-control" placeholder="e.g. BSK-SOFA-001">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Stock Quantity</label>
                                            <input type="number" name="stock" class="form-control" value="0">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Publish Date</label>
                                            <input type="date" name="publish_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Bottom save bar -->
                    <div class="card edit-card save-bar mb-3">
                        <div class="card-body d-flex justify-content-end gap-2 py-2">
                            <a href="product-list.php" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="icofont-plus me-2"></i>Add Product</button>
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
