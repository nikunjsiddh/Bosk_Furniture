<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['name'])) {
    header("Location: ../categories-add.php");
    exit();
}

$name = trim($_POST['name'] ?? '');

$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

/**
 * Save an uploaded image to category_image/ and return its new filename.
 * Returns 'noimg.jpg' when no (valid) file was provided.
 */
function save_image($field, $allowed)
{
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && $_FILES[$field]['name'] !== '') {
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES[$field]['size'] < 5000000) {
            $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], '../category_image/' . $newname)) {
                return $newname;
            }
        }
    }
    return 'noimg.jpg';
}

$img = save_image('img', $allowed);

$sql  = "INSERT INTO category (name, img) VALUES (?, ?)";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../categories-add.php?added=0");
    exit();
}
mysqli_stmt_bind_param($stmt, "ss", $name, $img);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../categorie-list.php?added=" . ($ok ? "1" : "0"));
exit();
?>
