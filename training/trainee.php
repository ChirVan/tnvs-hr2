<?php
// filepath: c:\xampp\htdocs\humanResource2\training\trainee.php

include '../session_manager.php'; // Include session management
include '../connection.php'; // Include the database connection

// Fetch applicants with status 'accepted'
$query = "
    SELECT 
        u.id, 
        u.full_name AS full_name, 
        u.email, 
        a.position_title AS position_title, 
        a.tracking_id
    FROM 
        users u
    JOIN 
        applications a 
    ON 
        u.id = a.user_id
    WHERE 
        a.status = 'accepted'
        AND u.id NOT IN (SELECT user_id FROM training_schedule)
";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $approved_applicants = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $approved_applicants = [];
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

    <style>
        .hidden {
            display: none;
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Training Management</h1>
                    </div>

                    <!-- Include Breadcrumb -->
                    <?php include '../breadcrumb.php'; ?>

                    <!-- Applicant UI -->
                    <div id="applicant-ui">
                        <div class="row" style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="font-weight-bold text-gray-800">List of Applicants</h5>
                                    <div class="d-flex align-items-center justify-content-end" style="flex: 1;">
                                        <div class="input-group mr-3" style="flex: 0 0 70%;">
                                            <input type="text" class="form-control" id="searchApplicant" placeholder="Search Applicant">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                                    <a class="dropdown-item" href="#">A-Z</a>
                                                    <a class="dropdown-item" href="#">Z-A</a>
                                                    <a class="dropdown-item" href="#">By Job Role</a>
                                                    <a class="dropdown-item" href="#">Unassigned</a>
                                                    <a class="dropdown-item" href="#">Assigned</a>
                                                    <a class="dropdown-item" href="#">Completed</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Assign Applicant Link -->
                                        <a href="assign.php" class="btn btn-primary" style="flex: 0 0 20%;">
                                            <i class="fas fa-user-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <form action="schedule_applicant.php" method="POST">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Applicant ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Position Title</th>
                                                <th>Tracking ID</th>
                                                <th>Training Date</th>
                                                <th>Training Time</th>
                                                <th>Location</th>
                                                <th>Scheduled By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($approved_applicants)): ?>
                                                <?php 
                                                    $employees_query = "SELECT 
                                                                            u.id AS employee_id, 
                                                                            u.full_name AS name 
                                                                        FROM users u
                                                                        JOIN user_accounts ua ON u.id = ua.user_id
                                                                        WHERE ua.role = 'employee'";
                                                    $employees_result = $conn->query($employees_query);
                                                    $employees = $employees_result->fetch_all(MYSQLI_ASSOC);
                                                ?>
                                                <?php foreach ($approved_applicants as $applicant): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($applicant['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($applicant['full_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($applicant['position_title']); ?></td>
                                                        <td><?php echo htmlspecialchars($applicant['tracking_id']); ?></td>
                                                        <td>
                                                            <input type="date" name="training_date[<?php echo $applicant['id']; ?>]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="training_time[<?php echo $applicant['id']; ?>]" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="location[<?php echo $applicant['id']; ?>]" class="form-control" placeholder="Enter location">
                                                        </td>
                                                        <td>
                                                            <select name="scheduled_by[<?php echo $applicant['id']; ?>]" class="form-control">
                                                                <option value="">Select Employee</option>
                                                                <?php 
                                                                    if ($_SESSION['role'] === 'admin') {
                                                                        foreach ($employees as $employee): ?>
                                                                            <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>">
                                                                                <?php echo htmlspecialchars($employee['name']); ?>
                                                                            </option>
                                                                        <?php endforeach; 
                                                                    } else {
                                                                        // Only the logged-in employee's name
                                                                        echo '<option value="' . htmlspecialchars($_SESSION['user_id']) . '" selected>' . 
                                                                                htmlspecialchars($_SESSION['full_name']) . 
                                                                                '</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="submit" name="schedule_applicant" value="<?php echo $applicant['id']; ?>" class="btn btn-success">
                                                                Schedule
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No approved applicants found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </form>
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
                        <span>Copyright &copy; Your Website 2025</span>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Custom jQuery Script -->
    <script>
        $(document).ready(function () {

                // Update the breadcrumb dynamically
                const breadcrumb = `
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Training</a></li>
                            <li class="breadcrumb-item"><a href="trainee.php">Trainee</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assign Training</li>
                        </ol>
                    </nav>
                `;
                $(".breadcrumb").parent().html(breadcrumb);
            });

            // Handle click event for Back button
            $("#backToApplicantBtn").on("click", function () {
                $("#assign-applicant-ui").addClass("hidden"); // Hide the Assign Applicant UI
                $("#applicant-ui").removeClass("hidden").show(); // Show the Applicant UI

                // Restore the original breadcrumb
                const breadcrumb = `
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Training</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Trainee</li>
                        </ol>
                    </nav>
                `;
                $(".breadcrumb").parent().html(breadcrumb);
            });
    </script>
</body>
</html>