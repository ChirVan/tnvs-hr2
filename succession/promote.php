<!-- filepath: c:\xampp\htdocs\humanResource2\training\courses.php -->
<?php
include '../session_manager.php';
include '../connection.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the candidate ID
    $candidate_id = intval($_GET['id']);

    // Insert a new promotion record into the promotions table
    $insert_sql = "INSERT INTO promotions (id, date_created) VALUES (?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("i", $candidate_id);

    if ($insert_stmt->execute()) {
        // Redirect to the promotions page with a success message
        header("Location: promote.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Check if the 'approve_id' parameter is set in the POST request for updating the status
if (isset($_POST['approve_id'])) {
    $promotion_id = intval($_POST['approve_id']);

    // Update the status of the promotion to 'Approved'
    $update_sql = "UPDATE promotions SET status = 'Approved' WHERE promotion_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $promotion_id);

    if ($update_stmt->execute()) {
        // Redirect to the promotions page with a success message
        header("Location: promote.php?success=2");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Query to join promotions and potential tables
$sql = "SELECT p.promotion_id, p.id, pot.position, pot.name, 
               pot.readiness_level, p.date_created
        FROM promotions p
        JOIN potential pot ON p.id = pot.id";
$result = $conn->query($sql);
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
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .table-container {
            margin-bottom: 30px;
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
                        <h1 class="h3 mb-0 text-gray-800">Succession Planning</h1>
                    </div>

                    <?php include '../breadcrumb.php'; ?>
                    
                   <!-- Promotion Suggestion Section -->
                    <div class="table-container">
                        <h5 class="section-title">Promotion Suggestion</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Promotion ID</th>
                                    <th>Candidate ID</th>
                                    <th>Name</th>
                                    <th>Suggested Position</th>
                                    <th>Readiness Level</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['promotion_id'] . "</td>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['position'] . "</td>";
                                        echo "<td>" . $row['readiness_level'] . "</td>";
                                        echo "<td>" . $row['date_created'] . "</td>";
                                        echo "<td>
                                                <form method='POST' action='promote.php' style='display:inline;'>
                                                    <input type='hidden' name='approve_id' value='" . $row['promotion_id'] . "'>
                                                    <button type='submit' class='btn btn-sm btn-success'>
                                                        <i class='fas fa-paper-plane'></i> Send to HR1
                                                    </button>
                                                </form>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No promotion suggestions found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>
</html>