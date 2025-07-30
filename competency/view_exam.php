<!-- filepath: c:\xampp\htdocs\humanResource2\competency\view_exam.php -->
<?php
include '../session_manager.php';
include '../connection.php';

// Check if exam_id is provided in the URL
if (!isset($_GET['exam_id'])) {
    die("Examination ID is required.");
}

$exam_id = intval($_GET['exam_id']);

// Fetch examination details
$exam_sql = "SELECT title FROM examinations WHERE id = ?";
$exam_stmt = $conn->prepare($exam_sql);
$exam_stmt->bind_param("i", $exam_id);
$exam_stmt->execute();
$exam_result = $exam_stmt->get_result();

if ($exam_result->num_rows === 0) {
    die("Examination not found.");
}

$exam = $exam_result->fetch_assoc();

// Fetch questions for the examination
$questions_sql = "SELECT id, text FROM questions WHERE examination_id = ?";
$questions_stmt = $conn->prepare($questions_sql);
$questions_stmt->bind_param("i", $exam_id);
$questions_stmt->execute();
$questions_result = $questions_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Examination</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Examination: <?php echo htmlspecialchars($exam['title']); ?></h1>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($questions_result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $questions_result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $counter++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['text']) . "</td>";
                                        echo "<td>
                                                <a href='edit_question.php?question_id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_question.php?question_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No questions available.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <a href="assessment.php" class="btn btn-secondary">Back to Examinations</a>

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

</body>
</html>