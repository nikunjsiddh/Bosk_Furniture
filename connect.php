<?php
// Silence mysqli's exception-throwing behavior in PHP 8.1+ so a bad
// connection produces a clear error message instead of a blank/white page.
mysqli_report(MYSQLI_REPORT_OFF);

// ----------------------------------------------------------------------
// Environment-aware database connection.
//
//  * On localhost (XAMPP / WAMP) -> connect with root/no-password.
//  * On the live Hostinger server -> connect with the credentials in
//    config/db.local.php.
//
// Detection is based on the HTTP host. "localhost" and "127.0.0.1" are
// treated as development. Anything else is treated as production.
//
// config/db.local.php is NOT in git (see .gitignore) and config/.htaccess
// blocks it from the browser. Create it once on the server (see
// HOW-TO-UPLOAD-LIVE.md, "3. Live database password file"):
//
//     <?php
//     return [
//         'host'     => 'localhost',
//         'user'     => 'your_database_user',
//         'password' => 'your_database_password',
//         'database' => 'your_database_name',
//     ];
//
// Same idea as config/mail.local.php for the SMTP password.
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
    // Plain include (not include_once) so a second include of this file in
    // the same request still gets the settings array back.
    $__bosk_db_file = __DIR__ . '/config/db.local.php';
    $__bosk_db = is_file($__bosk_db_file) ? include $__bosk_db_file : null;

    if (!is_array($__bosk_db) || !isset($__bosk_db['user'], $__bosk_db['password'], $__bosk_db['database'])) {
        die("Database connection failed: live database settings are missing. "
            . "Create config/db.local.php on the server (see HOW-TO-UPLOAD-LIVE.md).");
    }

    $con = mysqli_connect(
        isset($__bosk_db['host']) ? $__bosk_db['host'] : 'localhost',
        $__bosk_db['user'],
        $__bosk_db['password'],
        $__bosk_db['database']
    );

    unset($__bosk_db, $__bosk_db_file);
}

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
