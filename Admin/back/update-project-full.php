<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header("Location: ../project-list.php");
    exit();
}

$id = intval($_POST['id']);

// ---- Load existing row (need current image names) ----
$cur = mysqli_query($con, "SELECT * FROM projects WHERE id='" . $id . "'");
if (!$cur || mysqli_num_rows($cur) === 0) {
    header("Location: ../project-list.php?updated=0");
    exit();
}
$row = mysqli_fetch_assoc($cur);

// ---- Text fields ----
$project_name    = trim($_POST['project_name'] ?? '');
$pro_desc        = trim($_POST['pro_desc'] ?? '');
$interior_detail = trim($_POST['interior_detail'] ?? '');

// ---- Image handling helper ----
$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

/**
 * Resolve the final filename for an image slot.
 *  - new file uploaded -> validate + save, return new name
 *  - remove_$field checked -> 'noimg.jpg'
 *  - else keep current
 */
function resolve_image($field, $current, $allowed)
{
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && $_FILES[$field]['name'] !== '') {
        $name = $_FILES[$field]['name'];
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$field]['size'] < 5000000) {
            $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
            $dest    = '../project_image/' . $newname;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
                return $newname;
            }
        }
        return $current;
    }
    if (isset($_POST['remove_' . $field]) && $_POST['remove_' . $field] == '1') {
        return 'noimg.jpg';
    }
    return ($current !== '' ? $current : 'noimg.jpg');
}

$img1 = resolve_image('img1', $row['img1'], $allowed);
$img2 = resolve_image('img2', $row['img2'], $allowed);
$img3 = resolve_image('img3', isset($row['img3']) ? $row['img3'] : 'noimg.jpg', $allowed);
$img4 = resolve_image('img4', isset($row['img4']) ? $row['img4'] : 'noimg.jpg', $allowed);
$img5 = resolve_image('img5', isset($row['img5']) ? $row['img5'] : 'noimg.jpg', $allowed);

// ---- Update (prepared statement) ----
$sql = "UPDATE projects SET project_name=?, pro_desc=?, interior_detail=?, img1=?, img2=?, img3=?, img4=?, img5=? WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../project-list.php?updated=0");
    exit();
}
mysqli_stmt_bind_param($stmt, "ssssssssi", $project_name, $pro_desc, $interior_detail, $img1, $img2, $img3, $img4, $img5, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../project-list.php?updated=" . ($ok ? "1" : "0"));
exit();
?>
