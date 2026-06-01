<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header("Location: ../product-list.php");
    exit();
}

$id = intval($_POST['id']);

// ---- Load existing row (need current image names) ----
$cur = mysqli_query($con, "SELECT * FROM products WHERE id='" . $id . "'");
if (!$cur || mysqli_num_rows($cur) === 0) {
    header("Location: ../product-list.php?updated=0");
    exit();
}
$row = mysqli_fetch_assoc($cur);

// ---- Text fields ----
$pname        = trim($_POST['pname'] ?? '');
$pcategory    = trim($_POST['pcategory'] ?? '');
$description  = trim($_POST['description'] ?? '');
$publish_date = trim($_POST['publish_date'] ?? '');
$sku          = trim($_POST['sku'] ?? '');
$stock        = intval($_POST['stock'] ?? 0);
$status       = intval($_POST['status'] ?? 0);
$old_price    = intval($_POST['old_price'] ?? 0);
$new_price    = intval($_POST['new_price'] ?? 0);
$mrp          = intval($_POST['mrp'] ?? 0);
if ($mrp <= 0) { $mrp = $new_price; }
$tags         = trim($_POST['tags'] ?? '');

// ---- Image handling helper ----
$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

/**
 * Resolve the final filename for an image slot.
 *  - if a new file was uploaded for $field -> validate + save, return new name
 *  - else if remove_$field checked        -> return 'noimg.jpg'
 *  - else                                  -> keep $current
 */
function resolve_image($field, $current, $allowed)
{
    // 1) new upload?
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && $_FILES[$field]['name'] !== '') {
        $name = $_FILES[$field]['name'];
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$field]['size'] < 5000000) {
            $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
            $dest    = '../product_image/' . $newname;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
                return $newname;
            }
        }
        // upload failed/invalid -> keep current
        return $current;
    }
    // 2) explicit remove?
    if (isset($_POST['remove_' . $field]) && $_POST['remove_' . $field] == '1') {
        return 'noimg.jpg';
    }
    // 3) unchanged
    return ($current !== '' ? $current : 'noimg.jpg');
}

$img1 = resolve_image('img1', $row['img1'], $allowed);
$img2 = resolve_image('img2', $row['img2'], $allowed);
$img3 = resolve_image('img3', $row['img3'], $allowed);
$img4 = resolve_image('img4', $row['img4'], $allowed);
$img5 = resolve_image('img5', $row['img5'], $allowed);

// ---- Update (prepared statement) ----
$sql = "UPDATE products SET
            pname=?, pcategory=?, img1=?, img2=?, img3=?, img4=?, img5=?,
            description=?, publish_date=?, sku=?, stock=?, status=?,
            old_price=?, new_price=?, mrp=?, tags=?
        WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../product-list.php?updated=0");
    exit();
}
mysqli_stmt_bind_param(
    $stmt,
    "ssssssssssiiiiisi",
    $pname, $pcategory, $img1, $img2, $img3, $img4, $img5,
    $description, $publish_date, $sku, $stock, $status,
    $old_price, $new_price, $mrp, $tags,
    $id
);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../product-list.php?updated=" . ($ok ? "1" : "0"));
exit();
?>
