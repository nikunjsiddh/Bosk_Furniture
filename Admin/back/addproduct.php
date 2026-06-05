<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['pname'])) {
    header("Location: ../product-add.php");
    exit();
}

$pname        = trim($_POST['pname'] ?? '');
$pcategory    = trim($_POST['pcategory'] ?? '');
$description  = trim($_POST['description'] ?? '');
$publish_date = str_replace('T', ' ', trim($_POST['publish_date'] ?? ''));
if ($publish_date === '') { $publish_date = date('Y-m-d H:i:s'); }
$sku          = trim($_POST['sku'] ?? '');
$stock        = intval($_POST['stock'] ?? 0);
$status       = intval($_POST['status'] ?? 0);
$old_price    = intval($_POST['old_price'] ?? 0);
$new_price    = intval($_POST['new_price'] ?? 0);
$mrp          = intval($_POST['mrp'] ?? 0);
if ($mrp <= 0) { $mrp = $new_price; }
$tags         = trim($_POST['tags'] ?? '');

$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

/**
 * Save an uploaded image to product_image/ and return its new filename.
 * Returns 'noimg.jpg' when no (valid) file was provided.
 */
function save_image($field, $allowed)
{
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && $_FILES[$field]['name'] !== '') {
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$field]['size'] < 5000000) {
            $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], '../product_image/' . $newname)) {
                return $newname;
            }
        }
    }
    return 'noimg.jpg';
}

$img1 = save_image('img1', $allowed);
$img2 = save_image('img2', $allowed);
$img3 = save_image('img3', $allowed);
$img4 = save_image('img4', $allowed);
$img5 = save_image('img5', $allowed);

$sql = "INSERT INTO products
            (pname, pcategory, img1, img2, img3, img4, img5, description, publish_date, sku, stock, status, old_price, new_price, mrp, tags)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../product-add.php?added=0");
    exit();
}
mysqli_stmt_bind_param(
    $stmt,
    "ssssssssssiiiiis",
    $pname, $pcategory, $img1, $img2, $img3, $img4, $img5,
    $description, $publish_date, $sku, $stock, $status,
    $old_price, $new_price, $mrp, $tags
);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../product-list.php?added=" . ($ok ? "1" : "0"));
exit();
?>
