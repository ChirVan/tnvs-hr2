<?php

require '../libs/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lessonTitle = isset($_POST['lesson_title']) ? $_POST['lesson_title'] : 'Untitled Lesson';
    $lessonContent = isset($_POST['lesson_content']) ? $_POST['lesson_content'] : '';

    // Create a new Word document
    $phpWord = new PhpWord();

    // Add a section to the document
    $section = $phpWord->addSection();

    // Add the lesson title
    $section->addTitle($lessonTitle, 1);

    // Add the lesson content
    $section->addText($lessonContent, ['name' => 'Arial', 'size' => 12]);

    // Save the document to the project folder
    $fileName = str_replace(' ', '_', strtolower($lessonTitle)) . '.docx';
    $filePath = __DIR__ . '/../uploads/' . $fileName; // Use absolute path

    // Ensure the uploads directory exists
    if (!file_exists(__DIR__ . '/../uploads')) {
        mkdir(__DIR__ . '/../uploads', 0777, true);
    }

    // Save the Word document
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    try {
        $writer->save($filePath);
        echo "Document saved successfully at: " . $filePath . "<br>";

        // Provide a download link
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        readfile($filePath);
        exit;
    } catch (Exception $e) {
        die("Failed to save the document: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>