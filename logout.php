<?php
session_start();
include 'connection.php';

// Record logout time if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logout_time = date('H:i:s'); // Only time, since your table uses TIME for time_out

    // Update the latest login record for this user where time_out is '00:00:00'
    $sql = "UPDATE attendance_time_log 
            SET time_out = ? 
            WHERE id = (
                SELECT id FROM (
                    SELECT id FROM attendance_time_log 
                    WHERE employee_id = ? AND time_out = '00:00:00' 
                    ORDER BY id DESC LIMIT 1
                ) AS t
            )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $logout_time, $user_id);
    $stmt->execute();
}

// Destroy session and redirect
session_unset();
session_destroy();
header("Location: login.php");
exit;
?>