<?php
include '../connection.php';

$user_id = intval($_POST['user_id']);
$full_name = $_POST['full_name'];
$course_type = $_POST['course_type'];

$stmt = $conn->prepare("INSERT INTO potential (user_id, full_name, course_type) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $full_name, $course_type);
if ($stmt->execute()) {
    echo "approved_potential";
} else {
    http_response_code(500);
    echo "error";
}
$stmt->close();
?>