<?php
include '../connection.php';
include '../session_manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_id = $_POST['schedule_id'] ?? null;
    $course_type = $_POST['course_type'] ?? null;
    //$assigned_by = $_POST['assigned_by'] ?? null;

    // Check if already assigned
    $check_query = "SELECT id FROM competency WHERE schedule_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("i", $schedule_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>
            alert('This applicant has already been assigned.');
            window.location.href = 'assign.php';
        </script>";
        exit;
    }
    $check_stmt->close();

    // Validate inputs
    if (empty($schedule_id) || empty($course_type) /*empty($assigned_by)*/) {
        echo "<script>
            alert('All fields are required.');
            window.history.back();
        </script>";
        exit;
    }

    // Get course_id from courses table using course_type
    $course_query = "SELECT id FROM courses WHERE course_type = ?";
    $course_stmt = $conn->prepare($course_query);
    $course_stmt->bind_param("s", $course_type);
    $course_stmt->execute();
    $course_stmt->bind_result($course_id);
    $course_stmt->fetch();
    $course_stmt->close();

    if (empty($course_id)) {
        echo "<script>
            alert('Invalid course type selected.');
            window.history.back();
        </script>";
        exit;
    }

    // Get competency_program and lesson_proper from lessons table using course_id
    $lesson_query = "SELECT competency_program, lesson_proper FROM lessons WHERE course_id = ?";
    $lesson_stmt = $conn->prepare($lesson_query);
    $lesson_stmt->bind_param("i", $course_id);
    $lesson_stmt->execute();
    $lesson_stmt->bind_result($competency_program, $lesson_proper);
    $lesson_stmt->fetch();
    $lesson_stmt->close();

    // Insert into competency table (no file uploads)
    $query = "INSERT INTO competency (schedule_id, course_type, competency_program, lesson_proper) VALUES ( ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "<script>
            alert('Error preparing statement: " . $conn->error . "');
            window.history.back();
        </script>";
        exit;
    }

    $stmt->bind_param("isss", $schedule_id, $course_type, $competency_program, $lesson_proper);

    if ($stmt->execute()) {
        echo "<script>
            alert('Applicant assigned successfully.');
            window.location.href = 'assign.php';
        </script>";
    } else {
        echo "<script>
            alert('Error assigning applicant: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}
?>