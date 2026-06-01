<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header("Location: ../categorie-list.php");
    exit();
}

$id   = intval($_POST['id']);
$name = trim($_POST['name'] ?? '');

// load current row (for existing image)
$cur = mysqli_query($con, "SELECT * FROM category WHERE id='" . $id . "'");
if (!$cur || mysqli_num_rows($cur) === 0) {
    header("Location: ../categorie-list.php?updated=0");
    exit();
}
$row = mysqli_fetch_assoc($cur);

$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

// resolve image: new upload replaces; otherwise keep current
$img = $row['img'];
if (isset($_FILES['img']) && $_FILES['img']['error'] === 0 && $_FILES['img']['name'] !== '') {
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed) && $_FILES['img']['size'] < 5000000) {
        $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['img']['tmp_name'], '../category_image/' . $newname)) {
            $img = $newname;
        }
    }
}

$sql  = "UPDATE category SET name=?, img=? WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../categorie-list.php?updated=0");
    exit();
}
mysqli_stmt_bind_param($stmt, "ssi", $name, $img, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../categorie-list.php?updated=" . ($ok ? "1" : "0"));
exit();
?>
