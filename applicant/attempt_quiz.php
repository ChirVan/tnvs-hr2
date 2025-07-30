<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

include '../connection.php';

if (!isset($_GET['exam_id'])) {
    echo "No exam selected.";
    exit;
}

$exam_id = intval($_GET['exam_id']);

// Fetch exam title
$exam_query = "SELECT title FROM examinations WHERE id = ?";
$exam_stmt = $conn->prepare($exam_query);
$exam_stmt->bind_param("i", $exam_id);
$exam_stmt->execute();
$exam_result = $exam_stmt->get_result();
$exam = $exam_result->fetch_assoc();
$exam_title = isset($exam['title']) ? $exam['title'] : 'Unknown Exam';

// Fetch questions for this exam
$question_query = "SELECT id, text FROM questions WHERE examination_id = ?";
$question_stmt = $conn->prepare($question_query);
$question_stmt->bind_param("i", $exam_id);
$question_stmt->execute();
$question_result = $question_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Attempt Quiz - <?php echo htmlspecialchars($exam_title); ?></title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- TNVS Logo and Text -->
                    <img src="../img/logor.png" alt="TNVS Logo" class="mr-2" style="height: 100px;">
                    <span class="navbar-text font-weight-bold text-primary">TNVS</span>

                    <!-- Applicant Portal Text -->
                    <div class="mx-auto text-center">
                        <span class="navbar-text h4 font-weight-bold text-gradient-primary ml-5" style="background: linear-gradient(to right, #4e73df, #1cc88a); -webkit-background-clip: text; color: transparent;">Applicant Portal</span>
                    </div>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle ml-3">
                        <i class="fa fa-bars"></i>
                    </button>

                </nav>
                <!-- End of Topbar -->

                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">
                                        <i class="fas fa-question-circle mr-2"></i>
                                        <?php echo htmlspecialchars($exam_title); ?>
                                    </h3>
                                    <p class="mb-0 small">Please answer all questions below. Your progress will be saved upon submission.</p>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="submit_quiz.php">
                                        <?php 
                                        $qnum = 1;
                                        while ($question = $question_result->fetch_assoc()): ?>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="badge badge-info mr-2" style="font-size:1rem;"><?php echo $qnum++; ?></span>
                                                    <label class="font-weight-bold mb-0"><?php echo htmlspecialchars($question['text']); ?></label>
                                                </div>
                                                <input type="hidden" name="question_ids[]" value="<?php echo $question['id']; ?>">
                                                <input type="text" name="answers[<?php echo $question['id']; ?>]" class="form-control" placeholder="Type your answer here..." required>
                                            </div>
                                        <?php endwhile; ?>
                                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success px-5">
                                                <i class="fas fa-paper-plane mr-1"></i> Submit Answers
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    <small>All answers are confidential. If you have questions, contact support@tnvs.com</small>
                                </div>
                            </div>
                        </div>
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

</body>
</html>