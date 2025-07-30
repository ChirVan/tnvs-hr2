<?php

include '../connection.php'; // your database connection file

// PHPMailer manually
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_applicant'])) {
    $applicant_id = $_POST['schedule_applicant'];
    $training_date = $_POST['training_date'][$applicant_id] ?? null;
    $training_time = $_POST['training_time'][$applicant_id] ?? null;
    $location = $_POST['location'][$applicant_id] ?? null;
    // $scheduled_by = $_POST['scheduled_by'][$applicant_id] ?? null;

    // Validate the inputs
    if (empty($training_date) || empty($training_time) || empty($location) /*empty($scheduled_by)*/) {
        echo "<div class='alert alert-danger'>All fields, including 'Scheduled By', are required for scheduling.</div>";
        exit;
    }

    // Insert the training schedule into the training_schedule table
    $query = "INSERT INTO training_schedule (user_id, training_date, training_time, location) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
        exit;
    }

    $stmt->bind_param("isss", $applicant_id, $training_date, $training_time, $location);

    if ($stmt->execute()) {
        // Fetch applicant details (adjust table/column names as needed)
        $applicant_query = "SELECT email, full_name FROM users WHERE id = ?";
        $applicant_stmt = $conn->prepare($applicant_query);
        $applicant_stmt->bind_param("i", $applicant_id);
        $applicant_stmt->execute();
        $applicant_result = $applicant_stmt->get_result();
        $applicant = $applicant_result->fetch_assoc();

        // --- Activity Log: Log the scheduling event ---
        session_start();
        $scheduler_id = $_SESSION['user_id'] ?? null; // The logged-in user who scheduled
        $activity = "Scheduled training for applicant: " . ($applicant['full_name'] ?? "ID $applicant_id") .
                    " on $training_date at $training_time, Location: $location";
        $created_at = date('Y-m-d H:i:s');
        if ($scheduler_id) {
            $log_sql = "INSERT INTO activity_log (user_id, activity, created_at) VALUES (?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("iss", $scheduler_id, $activity, $created_at);
            $log_stmt->execute();
            $log_stmt->close();
        }
        // --- End Activity Log ---

        /* Fetch scheduler details from test_employees
        $scheduler_query = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM test_employees WHERE employee_id = ?";
        $scheduler_stmt = $conn->prepare($scheduler_query);
        $scheduler_stmt->bind_param("i", $scheduled_by);
        $scheduler_stmt->execute();
        $scheduler_result = $scheduler_stmt->get_result();
        $scheduler = $scheduler_result->fetch_assoc();
        */

        // Send email notification
        $mail = new PHPMailer(true); // Enable exceptions for better error handling
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'humanresourceotp@gmail.com'; // Replace with your email
            $mail->Password = 'mesd ewvw axbo dfpe'; // Replace with your email password
            $mail->SMTPSecure = 'tls'; // Use TLS encryption
            $mail->Port = 587; // Use the appropriate port for TLS

            // Set SSL options to disable verification
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom('humanresourceotp@gmail.com', 'Transport Go HR Department'); // Replace with your sender email and name
            $mail->addAddress($applicant['email'], $applicant['full_name']); // Applicant's email and name

            $mail->isHTML(true);
            $mail->Subject = 'Training Assessment Schedule Confirmation';
            $mail->Body = "
            <p>Dear {$applicant['full_name']},</p>
            <p>We are pleased to inform you that your training assessment has been scheduled as follows:</p>
            <ul>
                <li><strong>Date & Time:</strong> {$training_date} at {$training_time}</li>
                <li><strong>Location:</strong> {$location}</li>
            </ul>
            <p>Kindly arrive early and ensure you bring a copy of this email as proof of confirmation. If you have any questions or require further assistance, please do not hesitate to reach out.</p>
            <p>We look forward to seeing you soon.</p>
            <p>Best regards,</p>
            <p> Hr Team <br>
            HR Department<br>
            Transport Go</p>
            ";

            $mail->send();
            echo "<script>
            alert('Applicant has been scheduled successfully.');
            window.location.href = 'assign.php';
            </script>";
        } catch (Exception $e) {
            echo "<script>
            alert('Training scheduled successfully for Applicant ID: $applicant_id, but email notification failed. Error: {$mail->ErrorInfo}');
            window.location.href = 'assign.php';
            </script>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error scheduling training: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>