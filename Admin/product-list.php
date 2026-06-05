<?php
session_start();
if (isset($_SESSION['email'])) {
include_once("connect.php");

// ---- Fetch all products (newest first) ----
$products = array();
$cmd = "select * from products order by id desc";
$result = mysqli_query($con, $cmd) or die(mysqli_error($con));
while ($row = mysqli_fetch_array($result)) {
    $products[] = $row;
}

// ---- Summary stats ----
$total_products = count($products);
$in_stock       = 0;
$out_stock      = 0;
$cat_set        = array();
foreach ($products as $p) {
    if (intval($p['stock']) > 0) { $in_stock++; } else { $out_stock++; }
    if (trim($p['pcategory']) !== '') { $cat_set[$p['pcategory']] = true; }
}
$total_categories = count($cat_set);
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
        /* ===== Product List custom styling (admin only) ===== */
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
        .row > div:nth-child(2) > .stat-card{animation-delay:.12s;}
        .row > div:nth-child(3) > .stat-card{animation-delay:.19s;}
        .row > div:nth-child(4) > .stat-card{animation-delay:.26s;}
        .card.shadow-sm{animation:fadeInUp .55s ease both;animation-delay:.26s;}
        #myDataTable tbody tr{animation:fadeIn .45s ease both;}
        .prod-thumb{transition:transform .2s ease, box-shadow .2s ease;}
        .prod-thumb:hover{transform:scale(1.12);box-shadow:0 6px 18px rgba(0,0,0,.18);}
        .prod-name{transition:color .15s ease;}
        #myDataTable tbody tr:hover .prod-name{color:#3b6fe0;}
        .stock-badge,.cat-badge{transition:transform .15s ease;}
        #myDataTable tbody tr:hover .stock-badge{transform:scale(1.06);}
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
        .cat-badge{
            background:#eef3ff;color:#3b6fe0;font-weight:600;border-radius:20px;
            padding:5px 12px;font-size:12px;
        }
        .date-cell{color:#7a7f8a;font-size:13px;white-space:nowrap;}

        .stock-badge{font-weight:600;border-radius:20px;padding:5px 12px;font-size:12px;min-width:42px;display:inline-block;text-align:center;}
        .stock-in{background:#e7f8ee;color:#1aa260;}
        .stock-low{background:#fff5e6;color:#d98a00;}
        .stock-out{background:#fdeaea;color:#e23b3b;}

        .price-old{color:#9aa0ab;text-decoration:line-through;font-size:13px;}
        .price-old::before{content:'\20B9';margin-right:1px;}
        .price-old:empty::before{content:'';}
        .price-new{color:#1aa260;font-weight:700;}
        .price-new::before{content:'\20B9';margin-right:1px;}
        .price-new:empty::before{content:'';}

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
        .modal-detail-row .val{font-weight:600;color:#2d2f39;}
        .detail-img{height:120px;width:120px;object-fit:cover;border-radius:10px;border:1px solid #eef0f4;}
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
                                <h3 class="fw-bold mb-0">Products</h3>
                                <a href="product-add.php" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="icofont-plus me-2"></i> Add Product
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Summary stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-box"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_products; ?></div>
                                        <div class="stat-label text-muted">Total Products</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e7f8ee;color:#1aa260;"><i class="icofont-check-circled"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $in_stock; ?></div>
                                        <div class="stat-label text-muted">In Stock</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fdeaea;color:#e23b3b;"><i class="icofont-close-circled"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $out_stock; ?></div>
                                        <div class="stat-label text-muted">Out of Stock</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card stat-card bg-white">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff5e6;color:#d98a00;"><i class="icofont-tags"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo $total_categories; ?></div>
                                        <div class="stat-label text-muted">Categories</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products table -->
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="card bg-white shadow-sm" style="border:0;border-radius:14px;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th style="display:none;">Product Id</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th style="display:none;">Product Description</th>
                                                    <th>Publish Date</th>
                                                    <th style="display:none;">SKU</th>
                                                    <th>Stock</th>
                                                    <th style="display:none;">Status</th>
                                                    <th>Old Price</th>
                                                    <th>New Price</th>
                                                    <th style="display:none;">Tags</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($products as $row):
                                                $id           = $row['id'];
                                                $pname        = $row['pname'];
                                                $pcategory    = $row['pcategory'];
                                                $img1         = $row['img1'];
                                                $description  = $row['description'];
                                                $publish_date = $row['publish_date'];
                                                $sku          = $row['sku'];
                                                $stock        = intval($row['stock']);
                                                $status       = $row['status'];
                                                $old_price    = $row['old_price'];
                                                $new_price    = $row['new_price'];
                                                $tags         = $row['tags'];

                                                // stock badge class
                                                if ($stock <= 0)      { $stock_cls = 'stock-out'; }
                                                elseif ($stock <= 5)  { $stock_cls = 'stock-low'; }
                                                else                  { $stock_cls = 'stock-in'; }
                                            ?>
                                                <tr id="delete<?php echo $id;?>">
                                                    <td>
                                                        <img class="prod-thumb" src="product_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars($pname); ?>" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#expedit<?php echo $id;?>" title="View details">
                                                    </td>
                                                    <td style="display:none;"><?php echo $id;?></td>
                                                    <td><span class="prod-name" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#expedit<?php echo $id;?>" title="View details"><?php echo $pname;?></span></td>
                                                    <td><span class="cat-badge"><?php echo $pcategory;?></span></td>
                                                    <td style="display:none;"><?php echo $description;?></td>
                                                    <td><span class="date-cell"><?php echo ($publish_date && $publish_date !== '0000-00-00 00:00:00') ? date('d M Y, h:i A', strtotime($publish_date)) : '—';?></span></td>
                                                    <td style="display:none;"><?php echo $sku;?></td>
                                                    <td><span class="stock-badge <?php echo $stock_cls;?>"><?php echo $stock;?></span></td>
                                                    <td style="display:none;"><?php echo $status;?></td>
                                                    <td><span class="price-old"><?php echo $old_price;?></span></td>
                                                    <td><span class="price-new"><?php echo $new_price;?></span></td>
                                                    <td style="display:none;"><?php echo $tags;?></td>
                                                    <td class="text-end">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#expedit<?php echo $id;?>" class="act-btn act-view" title="View"><i class="icofont-eye-alt"></i></button>
                                                        <a href="product-edit.php?id=<?php echo $id;?>" class="act-btn act-edit" title="Edit"><i class="icofont-ui-edit"></i></a>
                                                        <button type="button" onclick="deleteproduct(<?php echo $id;?>)" class="act-btn act-del deleterow" title="Delete"><i class="icofont-ui-delete"></i></button>
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

    <!-- ============ View Modals (one per product) ============ -->
    <?php foreach ($products as $row):
        $id           = $row['id'];
        $pname        = $row['pname'];
        $pcategory    = $row['pcategory'];
        $img1         = $row['img1'];
        $img2         = $row['img2'];
        $img3         = $row['img3'];
        $img4         = $row['img4'];
        $img5         = $row['img5'];
        $description  = $row['description'];
        $publish_date = $row['publish_date'];
        $sku          = $row['sku'];
        $stock        = $row['stock'];
        $status       = $row['status'];
        $old_price    = $row['old_price'];
        $new_price    = $row['new_price'];
        $mrp          = isset($row['mrp']) ? $row['mrp'] : '';
        $tags         = $row['tags'];

        // build gallery list, skipping empty / placeholder duplicates
        $gallery = array();
        foreach (array($img1,$img2,$img3,$img4,$img5) as $im) {
            if ($im !== '' && $im !== 'noimg.jpg') { $gallery[] = $im; }
        }
        if (empty($gallery)) { $gallery[] = 'noimg.jpg'; }

        // computed values
        $discount = 0;
        if (intval($old_price) > 0 && intval($new_price) > 0 && intval($new_price) < intval($old_price)) {
            $discount = round((($old_price - $new_price) / $old_price) * 100);
        }
        $stock_int = intval($stock);
        if ($stock_int <= 0)     { $v_stock_cls = 'stock-out'; $v_stock_txt = 'Out of Stock'; }
        elseif ($stock_int <= 5) { $v_stock_cls = 'stock-low'; $v_stock_txt = 'Low ('.$stock_int.')'; }
        else                     { $v_stock_cls = 'stock-in';  $v_stock_txt = 'In Stock ('.$stock_int.')'; }
        $is_active   = (intval($status) === 1);
        $status_cls  = $is_active ? 'stock-in' : 'stock-out';
        $status_txt  = $is_active ? 'Active' : 'Inactive';
    ?>
    <div class="modal fade" id="expedit<?php echo $id; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border:0;border-radius:14px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Images -->
                        <div class="col-md-5">
                            <div class="position-relative">
                                <img id="mainimg<?php echo $id; ?>" src="product_image/<?php echo $gallery[0]; ?>" class="img-fluid rounded w-100 mb-2" style="border:1px solid #eef0f4;aspect-ratio:1/1;object-fit:cover;" alt="<?php echo htmlspecialchars($pname); ?>">
                                <?php if ($discount > 0): ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:13px;border-radius:8px;"><?php echo $discount; ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($gallery as $g): ?>
                                    <img src="product_image/<?php echo $g; ?>" class="detail-img" style="cursor:pointer;" onclick="document.getElementById('mainimg<?php echo $id; ?>').src=this.src;" alt="">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Details -->
                        <div class="col-md-7">
                            <h4 class="fw-bold mb-1"><?php echo $pname; ?></h4>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <span class="cat-badge"><?php echo $pcategory !== '' ? $pcategory : 'Uncategorized'; ?></span>
                                <span class="stock-badge <?php echo $status_cls; ?>"><?php echo $status_txt; ?></span>
                                <span class="stock-badge <?php echo $v_stock_cls; ?>"><?php echo $v_stock_txt; ?></span>
                            </div>

                            <div class="d-flex align-items-center flex-wrap gap-3 my-3">
                                <span class="price-new" style="font-size:26px;"><?php echo $new_price; ?></span>
                                <?php if (intval($old_price) > 0): ?>
                                    <span class="price-old" style="font-size:17px;"><?php echo $old_price; ?></span>
                                <?php endif; ?>
                                <?php if ($discount > 0): ?>
                                    <span class="badge bg-success" style="border-radius:8px;">Save <?php echo $discount; ?>%</span>
                                <?php endif; ?>
                            </div>

                            <div class="modal-detail-row d-flex justify-content-between">
                                <span class="lbl">SKU</span><span class="val"><?php echo trim($sku) !== '' ? $sku : '—'; ?></span>
                            </div>
                            <div class="modal-detail-row d-flex justify-content-between">
                                <span class="lbl">MRP</span><span class="val"><?php echo intval($mrp) > 0 ? '&#8377;'.$mrp : '—'; ?></span>
                            </div>
                            <div class="modal-detail-row d-flex justify-content-between">
                                <span class="lbl">Stock Quantity</span><span class="val"><?php echo $stock; ?> units</span>
                            </div>
                            <div class="modal-detail-row d-flex justify-content-between">
                                <span class="lbl">Publish Date</span><span class="val"><?php echo ($publish_date && $publish_date !== '0000-00-00 00:00:00') ? date('d M Y, h:i A', strtotime($publish_date)) : '—'; ?></span>
                            </div>
                            <div class="modal-detail-row d-flex justify-content-between">
                                <span class="lbl">Product ID</span><span class="val">#<?php echo $id; ?></span>
                            </div>
                            <div class="modal-detail-row">
                                <div class="lbl mb-1">Tags</div>
                                <div>
                                    <?php
                                    $tag_list = array_filter(array_map('trim', preg_split('/[,]+/', $tags)));
                                    if (!empty($tag_list)) {
                                        foreach ($tag_list as $t) {
                                            echo '<span class="cat-badge me-1 mb-1 d-inline-block">'.$t.'</span>';
                                        }
                                    } else { echo '—'; }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-detail-row">
                                <div class="lbl mb-1">Description</div>
                                <div style="color:#4a4f5a;line-height:1.6;"><?php echo trim($description) !== '' ? $description : '—'; ?></div>
                            </div>
                        </div>
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

    <script src="js/deleteproduct.js"></script>

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
                    { targets: [0, -1], orderable: false }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search products...",
                    lengthMenu: "Show _MENU_ products"
                }
            });
        });
    </script>

    <?php if (isset($_GET['updated'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['updated'] === '1'): ?>
            toastr["success"]("Product updated successfully!", "Saved");
        <?php else: ?>
            toastr["error"]("Could not update the product. Please try again.", "Failed");
        <?php endif; ?>
    </script>
    <?php endif; ?>

    <?php if (isset($_GET['added'])): ?>
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        <?php if ($_GET['added'] === '1'): ?>
            toastr["success"]("Product added successfully!", "Added");
        <?php else: ?>
            toastr["error"]("Could not add the product. Please try again.", "Failed");
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
