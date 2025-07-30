<?php
include '../connection.php';

$course_type = $_GET['course_type'] ?? '';
$data = [];

if ($course_type) {
    $stmt = $conn->prepare(
        "SELECT DISTINCT l.competency_program 
         FROM lessons l
         INNER JOIN courses c ON l.course_id = c.id
         WHERE c.course_type = ?"
    );
    $stmt->bind_param("s", $course_type);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($data);
?>