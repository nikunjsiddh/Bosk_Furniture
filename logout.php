<?php
// Guarded session_start so it never warns if already started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Clear session data, then destroy the session.
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();
header('Location: /');
exit();
?>