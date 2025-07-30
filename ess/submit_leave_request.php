<?php
// filepath: c:\xampp\htdocs\humanResource2\ess\submit_leave_request.php
include '../connection.php';
include '../session_manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'] ?? null;
    $leave_type = $_POST['leave_type'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $leave_status = 'Pending';

    // Basic validation
    if (!$employee_id || !$leave_type || !$start_date || !$end_date || !$reason) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, reason, leave_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $employee_id, $leave_type, $start_date, $end_date, $reason, $leave_status);

    if ($stmt->execute()) {
        echo "<script>alert('Leave request submitted successfully.'); window.location.href='essDashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to submit leave request.'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    header("Location: essDashboard.php");
    exit;
}
?>