<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $competency_id = $_POST['competency_id'];
    $examination_ids = $_POST['examination_id']; // This is an array

    foreach ($examination_ids as $exam_id) {
        $stmt = $conn->prepare("INSERT INTO assigned_examinations (competency_id, examination_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $competency_id, $exam_id);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>
        alert('Examinations assigned successfully.');
        window.location.href = 'competencyList.php';
    </script>";
}
?>