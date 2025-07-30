<?php
include '../session_manager.php';
include '../connection.php';

// 1. Training: Count of all applicants with status 'accepted' who are not yet scheduled for training
$training_count = 0;
$training_sql = "
    SELECT u.id
    FROM users u
    JOIN applications a ON u.id = a.user_id
    WHERE a.status = 'accepted'
    
";
if ($result = $conn->query($training_sql)) {
    $training_count = $result->num_rows;
}

// 2. Competency: Count of all examinations
$competency_count = 0;
$competency_sql = "SELECT id, title FROM examinations;";
$stmt = $conn->prepare($competency_sql);
// No parameters to bind, so remove bind_param
$stmt->execute();
$result = $stmt->get_result();
$competency_count = $result ? $result->num_rows : 0;
$stmt->close();

// 3. Succession: Count of approved successors
$potential_data = [];
$succession_count = 0;
$query = "SELECT id FROM potential WHERE status = 'ready'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $potential_data[] = $row;
    }
    $succession_count = count($potential_data);
}

// 4. Learning: Count of assigned examinees
$learning_count = 0;
$learning_sql = "SELECT COUNT(*) FROM assigned_examinations"; // Replace with your actual table if different
if ($result = $conn->query($learning_sql)) {
    $learning_count = $result->fetch_row()[0];
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Human Resources 2</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary font-weight-bold">Human Resources 2 Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row">
                        <!-- Training Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Training</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $training_count; ?></div>
                                            <div class="small text-muted mt-1">List of Trainees</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Competency Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Competency</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $competency_count; ?></div>
                                            <div class="small text-muted mt-1">Competency Tracks</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Succession Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Succession</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $succession_count; ?></div>
                                            <div class="small text-muted mt-1">Successors Identified</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Learning Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Learning</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $learning_count; ?></div>
                                            <div class="small text-muted mt-1">Assessment Passer</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Tables -->
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Trainee Table -->
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Today's Trainees</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $today = date('Y-m-d');
                                        $trainee_sql = "
                                            SELECT ts.*, u.full_name
                                            FROM training_schedule ts
                                            JOIN users u ON ts.user_id = u.id
                                            WHERE ts.training_date = '$today'
                                        ";
                                        $trainee_result = $conn->query($trainee_sql);
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Trainee Name</th>
                                                        <th>Training Date</th>
                                                        <th>Training Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($trainee_result && $trainee_result->num_rows > 0):
                                                        $i = 1;
                                                        while ($row = $trainee_result->fetch_assoc()):
                                                            echo "<tr>
                                                                    <td>{$i}</td>
                                                                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                                                                    <td>" . htmlspecialchars($row['training_date']) . "</td>
                                                                    <td>" . htmlspecialchars($row['training_time']) . "</td>
                                                                </tr>";
                                                            $i++;
                                                        endwhile;
                                                    else:
                                                        echo "<tr><td colspan='4' class='text-center'>No trainees for today.</td></tr>";
                                                    endif;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Competency Table -->
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Assigned Examinee</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $assigned_sql = "
                                            SELECT 
                                                u.id AS user_id,
                                                u.full_name, 
                                                c.course_type, 
                                                MAX(ae.assigned_at) AS assigned_at
                                            FROM assigned_examinations ae
                                            INNER JOIN competency c ON ae.competency_id = c.id
                                            INNER JOIN training_schedule ts ON c.schedule_id = ts.id
                                            INNER JOIN users u ON ts.user_id = u.id
                                            WHERE ae.status = 'Not Started'
                                            GROUP BY ae.competency_id
                                        ";
                                        $assigned_result = $conn->query($assigned_sql);
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Applicant Name</th>
                                                        <th>Examination</th>
                                                        <th>Assigned Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($assigned_result && $assigned_result->num_rows > 0) {
                                                        $i = 1;
                                                        while ($row = $assigned_result->fetch_assoc()) {
                                                            echo "<tr>
                                                                    <td>" . htmlspecialchars($row['user_id']) . "</td>
                                                                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                                                                    <td>" . htmlspecialchars($row['course_type']) . "</td>
                                                                    <td>" . htmlspecialchars($row['assigned_at']) . "</td>
                                                                </tr>";
                                                            $i++;
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4' class='text-center'>No assigned applicants.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

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

</body>
</html>