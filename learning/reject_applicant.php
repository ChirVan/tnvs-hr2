<?php
include '../connection.php';

$user_id = $_POST['user_id'] ?? null;
$course_type = $_POST['course_type'] ?? '';
$reason = $_POST['reason'] ?? '';

if ($user_id && $course_type) {
    $rejected_at = date('Y-m-d H:i:s'); // Get current date and time
    $stmt = $conn->prepare("INSERT INTO rejected_applicants (user_id, course_type, reason, rejected_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $course_type, $reason, $rejected_at);
    $stmt->execute();
    $stmt->close();
    echo "success";
} else {
    echo "invalid";
}
?>