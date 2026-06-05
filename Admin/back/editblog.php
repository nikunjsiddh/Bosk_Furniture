<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header("Location: ../Blog-list.php");
    exit();
}

$id               = intval($_POST['id']);
$blog_title       = trim($_POST['blog_title'] ?? '');
$blog_description = trim($_POST['blog_description'] ?? '');
$blog_date        = str_replace('T', ' ', trim($_POST['blog_date'] ?? ''));

// load current row (for existing image / date)
$cur = mysqli_query($con, "SELECT * FROM blog WHERE id='" . $id . "'");
if (!$cur || mysqli_num_rows($cur) === 0) {
    header("Location: ../Blog-list.php?updated=0");
    exit();
}
$row = mysqli_fetch_assoc($cur);
if ($blog_date === '') { $blog_date = $row['blog_date']; }

$allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif');

// resolve image: new upload replaces; otherwise keep current
$img = $row['img'];
if (isset($_FILES['img']) && $_FILES['img']['error'] === 0 && $_FILES['img']['name'] !== '') {
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed) && $_FILES['img']['size'] < 5000000) {
        $newname = rand(111111, 999999) . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['img']['tmp_name'], '../blog_image/' . $newname)) {
            $img = $newname;
        }
    }
}

$sql  = "UPDATE blog SET blog_title=?, blog_description=?, blog_date=?, img=? WHERE id=?";
$stmt = mysqli_prepare($con, $sql);
if (!$stmt) {
    header("Location: ../Blog-list.php?updated=0");
    exit();
}
mysqli_stmt_bind_param($stmt, "ssssi", $blog_title, $blog_description, $blog_date, $img, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../Blog-list.php?updated=" . ($ok ? "1" : "0"));
exit();
?>
