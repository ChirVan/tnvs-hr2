<?php
require '../libs/fpdf.php'; // Include the FPDF library
include '../connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lesson_id'])) {
    $lesson_id = $_POST['lesson_id'];

    // Fetch the lesson content from the database
    $query = "SELECT competency_program, description, type, lesson_proper FROM lessons WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $lesson = $result->fetch_assoc();

        // Create a new PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Add content to the PDF
        $pdf->Cell(0, 10, 'Competency Program: ' . $lesson['competency_program'], 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Type: ' . $lesson['type'], 0, 1);
        $pdf->Ln(10); // Add a line break
        $pdf->MultiCell(0, 10, 'Description: ' . $lesson['description']);
        $pdf->Ln(10); // Add a line break
        $pdf->MultiCell(0, 10, 'Lesson Content: ' . $lesson['lesson_proper']);

        // Save the PDF to a folder
        $file_name = 'lesson_' . $lesson_id . '.pdf';
        $file_path = '../uploads/' . $file_name;
        $pdf->Output('F', $file_path); // Save the PDF file to the folder

        // Return the file path as a response
        echo json_encode(['success' => true, 'file_path' => $file_path]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Lesson not found.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>