<?php

include '../connection.php';
include '../session_manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'] ?? '';
    $quiz_title = $_POST['quiz_title'] ?? '';
    $questions = $_POST['questions'] ?? [];

    // Insert into examinations table (course_id, title)
    $stmt = $conn->prepare("INSERT INTO examinations (course_id, title) VALUES (?, ?)");
    $stmt->bind_param("is", $course_id, $quiz_title);
    if ($stmt->execute()) {
        $examination_id = $stmt->insert_id;
        $stmt->close();

        // Insert each question into questions table (column name is 'text')
        $q_stmt = $conn->prepare("INSERT INTO questions (examination_id, text) VALUES (?, ?)");
        foreach ($questions as $q) {
            $question_text = $q['question_text'];
            $q_stmt->bind_param("is", $examination_id, $question_text);
            $q_stmt->execute();
        }
        $q_stmt->close();

        // --- Activity Log: Log the quiz creation event ---
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $activity = "Created a new quiz: " . $quiz_title;
            $created_at = date('Y-m-d H:i:s');
            $log_sql = "INSERT INTO activity_log (user_id, activity, created_at) VALUES (?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("iss", $user_id, $activity, $created_at);
            $log_stmt->execute();
            $log_stmt->close();
        }
        // --- End Activity Log ---

        header("Location: assessment.php?success=1");
        exit;
    } else {
        $error = "Failed to save quiz. Please try again.";
    }
}
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>