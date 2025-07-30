<?php
date_default_timezone_set('Asia/Manila');
session_start();

// Define the timeout duration
define('SESSION_TIMEOUT', 15000); // 300 seconds (5 minutes)

if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];

    if ($inactive_time > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header("Location: ../login.php?timeout=true");
        exit();
    }
}

// Update the last activity time
$_SESSION['last_activity'] = time();
?>