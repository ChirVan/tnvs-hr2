<?php
// filepath: c:\xampp\htdocs\humanResource2\save_lesson.php
// Database connection
include '../connection.php';

// Get the lesson ID and updated content
$lessonId = isset($_POST['id']) ? intval($_POST['id']) : 0;
$lessonProper = isset($_POST['lesson_proper']) ? $_POST['lesson_proper'] : '';

if ($lessonId <= 0 || empty($lessonProper)) {
    die("Invalid input.");
}

// Update the lesson content in the database
$stmt = $conn->prepare("UPDATE lessons SET lesson_proper = ? WHERE id = ?");
$stmt->bind_param("si", $lessonProper, $lessonId);

if ($stmt->execute()) {
    echo "Lesson updated successfully.";
} else {
    echo "Error updating lesson: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>