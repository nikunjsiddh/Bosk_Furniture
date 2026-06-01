<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['project_name'])) {
    header("Location: ../project-add.php");
    exit();
}

$project_name    = trim($_POST['project_name'] ?? '');
$pro_desc        = trim($_POST['pro_desc'] ?? '');
$interior_detail = trim($_POST['interior_detail'] ?? '');

$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

/**
 * Save an uploaded image to project_image/ and return its new filename.
 * Returns 'noimg.jpg' when no (valid) file was provided.
 */
function save_image($field, $allowed)
{
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && $_FILES[$field]['name'] !== '') {
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$field]['size'] < 5000000) {
            $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], '../project_image/' . $newname)) {
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

$sql  = "INSERT INTO projects (project_name, pro_desc, interior_detail, img1, img2, img3, img4, img5) VALUES (?,?,?,?,?,?,?,?)";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../project-add.php?added=0");
    exit();
}
mysqli_stmt_bind_param($stmt, "ssssssss", $project_name, $pro_desc, $interior_detail, $img1, $img2, $img3, $img4, $img5);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../project-list.php?added=" . ($ok ? "1" : "0"));
exit();
?>
