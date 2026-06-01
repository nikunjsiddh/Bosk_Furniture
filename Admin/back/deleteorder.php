<?php
session_start();
include("../connect.php");

// auth guard
if (!isset($_SESSION['email'])) {
    http_response_code(403);
    exit('Unauthorized');
}

if (isset($_POST['order_id'])) {
    $oid = trim($_POST['order_id']);

    // delete line items first, then the order itself (prepared statements)
    $s1 = mysqli_prepare($con, "DELETE FROM order_items WHERE order_id=?");
    mysqli_stmt_bind_param($s1, "s", $oid);
    mysqli_stmt_execute($s1);
    mysqli_stmt_close($s1);

    $s2 = mysqli_prepare($con, "DELETE FROM orders WHERE order_id=?");
    mysqli_stmt_bind_param($s2, "s", $oid);
    $ok = mysqli_stmt_execute($s2);
    mysqli_stmt_close($s2);

    if ($ok) {
        ?>
        <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        toastr["success"]("Order Deleted Successfully...!", "Order")
        </script>
        <?php
    } else {
        ?>
        <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "4000" };
        toastr["error"]("Something Went Wrong...!", "Failed")
        </script>
        <?php
    }
}
?>
