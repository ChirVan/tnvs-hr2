<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$user_id = $_SESSION['user_id'];

include '../connection.php';

$exam_id = intval($_POST['exam_id']);
$question_ids = $_POST['question_ids'];
$answers = $_POST['answers'];

if (!empty($question_ids) && !empty($answers)) {
    $stmt = $conn->prepare("INSERT INTO quiz_answers (user_id, exam_id, question_id, answer) VALUES (?, ?, ?, ?)");
    foreach ($question_ids as $qid) {
        $answer = isset($answers[$qid]) ? $answers[$qid] : '';
        $stmt->bind_param("iiis", $user_id, $exam_id, $qid, $answer);
        $stmt->execute();
    }
    $stmt->close();

    // Update assigned_examinations status to 'Finished'
    $update_stmt = $conn->prepare("
        UPDATE assigned_examinations ae
        JOIN competency comp ON ae.competency_id = comp.id
        JOIN training_schedule ts ON comp.schedule_id = ts.id
        SET ae.status = 'Finished'
        WHERE ae.examination_id = ? AND ts.user_id = ?
    ");
    $update_stmt->bind_param("ii", $exam_id, $user_id);
    $update_stmt->execute();
    $update_stmt->close();

    echo "<div class='alert alert-success'>Your answers have been submitted!</div>";
    echo "<script>setTimeout(function(){ window.location.href = 'applicant.php'; }, 2000);</script>";
} else {
    echo "<div class='alert alert-danger'>No answers submitted.</div>";
}
?>