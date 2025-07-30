<?php

include 'session_manager.php';
include 'connection.php';

// Get user info from session
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

// Build query based on role
if ($role === 'admin') {
    $sql = "SELECT al.id, u.full_name, al.activity, al.created_at
            FROM activity_log al
            LEFT JOIN users u ON al.user_id = u.id
            ORDER BY al.created_at DESC";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT al.id, u.full_name, al.activity, al.created_at
            FROM activity_log al
            LEFT JOIN users u ON al.user_id = u.id
            WHERE al.user_id = ?
            ORDER BY al.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employee Self-Service Dashboard">
    <meta name="author" content="">

    <title>Activity Log</title>

    <!-- Vendor fonts -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid m-4">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">Activity Log</h6>
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Activity</th>
                                            <th scope="col">Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result && $result->num_rows > 0):
                                            $count = 1;
                                            while ($row = $result->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $count++; ?></th>
                                            <td><?php echo htmlspecialchars($row['full_name'] ?? 'Unknown'); ?></td>
                                            <td><?php echo htmlspecialchars($row['activity']); ?></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                        <?php endwhile; else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No activity logs found.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

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