<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include_once("connect.php");

$pid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = mysqli_query($con, "SELECT * FROM products WHERE id='" . $pid . "'");
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: product-list.php");
    exit();
}
$p = mysqli_fetch_assoc($res);

$pname        = $p['pname'];
$pcategory    = $p['pcategory'];
$images       = array($p['img1'], $p['img2'], $p['img3'], $p['img4'], $p['img5']);
$description  = $p['description'];
$publish_date = $p['publish_date'];
$sku          = $p['sku'];
$stock        = $p['stock'];
$status       = intval($p['status']);
$old_price    = $p['old_price'];
$new_price    = $p['new_price'];
$mrp          = $p['mrp'];
$tags         = $p['tags'];
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
        .remove-wrap{font-size:12.5px;}
        .req{color:#e23b3b;}
        .save-bar{position:sticky;bottom:0;z-index:5;}
    </style>
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">

        <?php include_once"design/sidebar.php"?>

        <div class="main px-lg-4 px-md-4">

            <?php include_once"design/nav.php"?>

            <form action="back/update-product-full.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="id" value="<?php echo $pid; ?>">

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Header -->
                    <div class="row align-items-center">
                        <div class="border-0 mb-3">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <div class="d-flex align-items-center">
                                    <a href="product-list.php" class="btn btn-light border me-3"><i class="icofont-arrow-left"></i></a>
                                    <h3 class="fw-bold mb-0">Edit Product <span class="text-muted fw-light fs-5">#<?php echo $pid; ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">

                        <!-- LEFT: main info + images -->
                        <div class="col-xl-8 col-lg-7">

                            <!-- Basic info -->
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Basic Information</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Product Name <span class="req">*</span></label>
                                            <input type="text" name="pname" class="form-control" value="<?php echo htmlspecialchars($pname); ?>" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Description <span class="req">*</span></label>
                                            <textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Images -->
                            <div class="card edit-card mb-3">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 fw-bold">Product Images</h6>
                                    <small class="text-muted">Up to 5 images &middot; jpg, png, webp, gif &middot; max 5MB</small>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <?php for ($i = 0; $i < 5; $i++):
                                            $slot   = $i + 1;
                                            $cur    = $images[$i];
                                            $hasImg = ($cur !== '' && $cur !== 'noimg.jpg');
                                            $src    = $hasImg ? 'product_image/' . $cur : 'product_image/noimg.jpg';
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

                        <!-- RIGHT: pricing, inventory, meta -->
                        <div class="col-xl-4 col-lg-5">

                            <div class="card edit-card mb-3">
                                <div class="card-header py-3"><h6 class="m-0 fw-bold">Pricing</h6></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Old Price (&#8377;)</label>
                                            <input type="number" name="old_price" class="form-control" value="<?php echo htmlspecialchars($old_price); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">New Price (&#8377;) <span class="req">*</span></label>
                                            <input type="number" name="new_price" class="form-control" value="<?php echo htmlspecialchars($new_price); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">MRP (&#8377;)</label>
                                            <input type="number" name="mrp" class="form-control" value="<?php echo htmlspecialchars($mrp); ?>">
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
                                            <select name="pcategory" class="form-select">
                                                <?php
                                                $matched = false;
                                                $catres = mysqli_query($con, "SELECT name FROM category ORDER BY name");
                                                while ($c = mysqli_fetch_assoc($catres)) {
                                                    $sel = (trim($c['name']) === trim($pcategory)) ? 'selected' : '';
                                                    if ($sel) { $matched = true; }
                                                    echo '<option value="' . htmlspecialchars($c['name']) . '" ' . $sel . '>' . htmlspecialchars($c['name']) . '</option>';
                                                }
                                                // keep current value even if not in category table
                                                if (!$matched && trim($pcategory) !== '') {
                                                    echo '<option value="' . htmlspecialchars(trim($pcategory)) . '" selected>' . htmlspecialchars(trim($pcategory)) . ' (current)</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="1" <?php echo $status === 1 ? 'selected' : ''; ?>>Active / Published</option>
                                                <option value="0" <?php echo $status !== 1 ? 'selected' : ''; ?>>Inactive / Hidden</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Tags <small class="text-muted">(comma separated)</small></label>
                                            <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($tags); ?>">
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
                                            <input type="text" name="sku" class="form-control" value="<?php echo htmlspecialchars($sku); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Stock Quantity</label>
                                            <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($stock); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Publish Date</label>
                                            <input type="date" name="publish_date" class="form-control" value="<?php echo htmlspecialchars($publish_date); ?>">
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
                            <button type="submit" class="btn btn-primary px-4"><i class="icofont-save me-2"></i>Save Changes</button>
                        </div>
                    </div>

                </div>
            </div>
            </form>

        </div>
    </div>

    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="javascript/template.js"></script>
    <script src="toastr/toastr.min.js"></script>
    <script>
        function previewImg(input, targetId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(targetId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                // if replacing, auto-untick any remove checkbox in the same slot
                var rm = input.parentNode.querySelector('input[type=checkbox]');
                if (rm) { rm.checked = false; }
            }
        }
    </script>
</body>
</html>
