<!-- filepath: c:\xampp\htdocs\humanResource2\ess\essDashboard.php -->
<?php
include '../session_manager.php';
include '../connection.php';

$employee_id = $_SESSION['user_id'] ?? null;
$attendance_records = [];

// Check if employee has any leave request
$has_leave_request = false;
if ($employee_id) {
    $sql = "SELECT COUNT(*) as cnt FROM leave_requests WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->bind_result($cnt);
    $stmt->fetch();
    $has_leave_request = ($cnt > 0);
    $stmt->close();
}

if ($employee_id) {
    $sql = "SELECT record_date, time_in, time_out FROM attendance_time_log WHERE employee_id = ? ORDER BY record_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $attendance_records[] = $row;
    }
    $stmt->close();
}

$leave_requests = [];
if ($employee_id) {
    $sql = "SELECT leave_type, start_date, end_date, reason, leave_status FROM leave_requests WHERE employee_id = ? ORDER BY request_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $leave_requests[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employee Self-Service Dashboard">
    <meta name="author" content="">

    <title>Employee Self-Service</title>

    <!-- Vendor fonts -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        .tab-content {
            margin-top: 20px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .card-header {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        .table-container {
            margin-bottom: 30px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include '../navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Employee Self-Service Dashboard</h1>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-pills mb-3" id="essTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="work-schedule-tab" data-bs-toggle="pill" data-bs-target="#work-schedule" type="button" role="tab" aria-controls="work-schedule" aria-selected="true">Work Schedule</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="leave-request-tab" data-bs-toggle="pill" data-bs-target="#leave-request" type="button" role="tab" aria-controls="leave-request" aria-selected="false">Leave Request</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="employee-profile-tab" data-bs-toggle="pill" data-bs-target="#employee-profile" type="button" role="tab" aria-controls="employee-profile" aria-selected="false">Employee Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="certification-record-tab" data-bs-toggle="pill" data-bs-target="#certification-record" type="button" role="tab" aria-controls="certification-record" aria-selected="false">Certification Record</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="time-attendance-tab" data-bs-toggle="pill" data-bs-target="#time-attendance" type="button" role="tab" aria-controls="time-attendance" aria-selected="false">Time & Attendance</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="essTabContent">
                        <!-- Work Schedule -->
<div class="tab-pane fade show active" id="work-schedule" role="tabpanel" aria-labelledby="work-schedule-tab">
    <div class="card">
        <div class="card-header">Work Schedule</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Work Schedule</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all work schedules (customize WHERE for specific employee if needed)
                    $result = $conn->query("SELECT work_day, start_time, end_time FROM schedule_management ORDER BY FIELD(work_day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");
                    while ($row = $result->fetch_assoc()):
                        // Determine shift type
                        $start = strtotime($row['start_time']);
                        $end = strtotime($row['end_time']);
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['work_day']) ?></td>
                        <td><?= date('h:i A', strtotime($row['start_time'])) ?></td>
                        <td><?= date('h:i A', strtotime($row['end_time'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

                        <!-- Leave Request -->
                        <div class="tab-pane fade" id="leave-request" role="tabpanel" aria-labelledby="leave-request-tab">
                            <div class="card">
                                <div class="card-header">Leave Request</div>
                                <div class="card-body">
                                    <!-- Request Leave Button triggers modal -->
                                    <div class="request-leave-button">
                                        <button class="btn btn-primary mb-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#requestLeaveModal"
                                                <?php echo $has_leave_request ? 'disabled title="You already have a leave request."' : ''; ?>>
                                            <i class="fas fa-plus"></i> Request Leave
                                        </button>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Reason</th>
                                                <th>Start of Leave</th>
                                                <th>End of Leave</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($leave_requests)): ?>
                                                <?php foreach ($leave_requests as $leave): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                                                        <td><?php echo htmlspecialchars($leave['reason']); ?></td>
                                                        <td><?php echo htmlspecialchars($leave['start_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($leave['end_date']); ?></td>
                                                        <td>
                                                            <?php
                                                            $status = $leave['leave_status'];
                                                            if ($status === 'Pending') {
                                                                echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                            } elseif ($status === 'Approved') {
                                                                echo '<span class="badge bg-success">Approved</span>';
                                                            } elseif ($status === 'Rejected') {
                                                                echo '<span class="badge bg-danger">Rejected</span>';
                                                            } else {
                                                                echo htmlspecialchars($status);
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No leave requests found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Leave Request Modal -->
                        <div class="modal fade" id="requestLeaveModal" tabindex="-1" aria-labelledby="requestLeaveModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="submit_leave_request.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="requestLeaveModalLabel">Request Leave</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee_id); ?>">
                                    <div class="mb-3">
                                        <label for="leave_type" class="form-label">Leave Type</label>
                                        <input type="text" class="form-control" id="leave_type" name="leave_type" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        </div>

                        <!-- Employee Profile -->
                        <div class="tab-pane fade" id="employee-profile" role="tabpanel" aria-labelledby="employee-profile-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Employee Profile</span>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Last Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>EMP001</td>
                                                <td>John Doe</td>
                                                <td>+123456789</td>
                                                <td>john.doe@example.com</td>
                                                <td>123 Main St, City</td>
                                                <td>2025-04-12</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Certification Record -->
                        <div class="tab-pane fade" id="certification-record" role="tabpanel" aria-labelledby="certification-record-tab">
                            <div class="card">
                                <div class="card-header">Certification Record</div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Certification ID</th>
                                                <th>Employee ID</th>
                                                <th>Certification Name</th>
                                                <th>Progress Status</th>
                                                <th>Completion Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>CR001</td>
                                                <td>EMP001</td>
                                                <td>Project Management</td>
                                                <td>Completed</td>
                                                <td>2025-03-30</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Time & Attendance -->
                        <div class="tab-pane fade" id="time-attendance" role="tabpanel" aria-labelledby="time-attendance-tab">
                            <div class="card">
                                <div class="card-header">Time & Attendance</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($attendance_records)): ?>
                                                <?php foreach ($attendance_records as $record): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($record['record_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($record['time_in']); ?></td>
                                                        <td><?php echo htmlspecialchars($record['time_out']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No attendance records found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- End of Tab Content -->

                </div>
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="logout.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Logout</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; TNVS 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Vendor Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>