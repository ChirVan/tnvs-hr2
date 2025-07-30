<?php
include '../connection.php';

if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);

    $sql = "SELECT id, title FROM examinations WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $examinations = [];
    while ($row = $result->fetch_assoc()) {
        $examinations[] = $row;
    }

    echo json_encode($examinations);
}
?>