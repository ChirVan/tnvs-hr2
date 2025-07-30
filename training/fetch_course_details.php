<?php
// Include your database connection file
include '../connection.php'; // Adjust the path if needed

// Check if the 'course' parameter is sent via POST
if (isset($_POST['course'])) {
    $course = $_POST['course'];

    // Prepare the SQL query to fetch lessons based on the course_type
    $query = "
        SELECT 
            lessons.id, 
            courses.course_type, 
            lessons.competency_program, 
            lessons.description, 
            lessons.type
        FROM lessons
        INNER JOIN courses ON lessons.course_id = courses.id
        WHERE courses.course_type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data and store it in an array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Return the data as JSON
    echo json_encode($data);
} else {
    // Return an error if the 'course' parameter is missing
    echo json_encode(['error' => 'No course specified']);
}
?>