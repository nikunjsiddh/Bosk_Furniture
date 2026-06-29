<?php
// Silence mysqli's exception-throwing behavior in PHP 8.1+ so a bad
// connection produces a clear error message instead of a blank/white page.
mysqli_report(MYSQLI_REPORT_OFF);

// ----------------------------------------------------------------------
// Environment-aware database connection.
//
//  * On localhost (XAMPP / WAMP) -> connect with root/no-password.
//  * On the live Hostinger server -> connect with the production credentials.
//
// Detection is based on the HTTP host. "localhost" and "127.0.0.1" are
// treated as development. Anything else is treated as production.
// ----------------------------------------------------------------------

$__bosk_host = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';

if ($__bosk_host === 'localhost'
    || strpos($__bosk_host, 'localhost:') === 0
    || $__bosk_host === '127.0.0.1'
    || strpos($__bosk_host, '127.0.0.1:') === 0) {

    // ---- Local XAMPP ----
    $con = mysqli_connect("localhost", "root", "", "bosk_furniture");

} else {

    // ---- Live (Hostinger) production ----
    $con = mysqli_connect("localhost", "u583659604_bosk", "Bosk@1234", "u583659604_furniture");
}

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>