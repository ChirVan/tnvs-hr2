<?php

include '../connection.php';

$user_id = intval($_POST['user_id']);
$course_type = $_POST['course_type'];

// Fetch full name of the applicant
$full_name = '';
$stmt2 = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$stmt2->bind_result($full_name);
$stmt2->fetch();
$stmt2->close();

// Check if applicant is already approved or rejected
$status = '';
$check_stmt = $conn->prepare("SELECT status FROM potential WHERE user_id = ?");
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
$check_stmt->bind_result($status);
$check_stmt->fetch();
$check_stmt->close();

$query = "
    SELECT 
        e.title AS exam_title,
        q.text AS question,
        qa.answer
    FROM quiz_answers qa
    JOIN questions q ON qa.question_id = q.id
    JOIN examinations e ON qa.exam_id = e.id
    WHERE qa.user_id = ?
    ORDER BY e.title, q.id
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$exams = [];
while ($row = $result->fetch_assoc()) {
    $exams[$row['exam_title']][] = [
        'question' => $row['question'],
        'answer' => $row['answer']
    ];
}

if (!empty($exams)) {
    foreach ($exams as $exam_title => $qa_list) {
        echo '<h5 class="mt-3 text-primary">' . htmlspecialchars($exam_title) . '</h5>';
        echo '<ul class="list-group mb-3">';
        $num = 1;
        foreach ($qa_list as $qa) {
            echo '<li class="list-group-item">';
            echo '<strong>Q' . $num++ . ':</strong> ' . htmlspecialchars($qa['question']) . '<br>';
            echo '<span class="text-success"><strong>Answer:</strong> ' . htmlspecialchars($qa['answer']) . '</span>';
            echo '</li>';
        }
        echo '</ul>';
    }
    // Approve and Reject buttons
    echo '<div class="text-center mt-4">';
    if ($status === 'approved') {
    echo '<button id="approve-btn" class="btn btn-secondary" disabled><i class="fas fa-check"></i> Approved</button> ';
    echo '<button id="reject-btn" class="btn btn-danger" disabled><i class="fas fa-times"></i> Reject</button>';
    } elseif ($status === 'rejected') {
        echo '<button id="approve-btn" class="btn btn-success" disabled><i class="fas fa-check"></i> Approve</button> ';
        echo '<button id="reject-btn" class="btn btn-secondary" disabled><i class="fas fa-times"></i> Rejected</button>';
    } else {
        echo '<button id="approve-btn" class="btn btn-success mr-2" 
            data-user="' . $user_id . '" 
            data-fullname="' . htmlspecialchars($full_name) . '" 
            data-course="' . htmlspecialchars($course_type) . '">
            <i class="fas fa-check"></i> Approve</button> ';
        // Updated reject button to open modal
        echo '<button id="reject-btn" class="btn btn-danger" 
            data-user="' . $user_id . '" 
            data-course="' . htmlspecialchars($course_type) . '" 
            data-toggle="modal" data-target="#rejectReasonModal">
            <i class="fas fa-times"></i> Reject</button>';
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-warning">No answers found for this applicant.</div>';
}
?>