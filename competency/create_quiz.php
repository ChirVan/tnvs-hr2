<?php

include '../connection.php';
include '../session_manager.php';
$course_id = $_GET['course_id'] ?? '';

// Fetch course title for display
$course_title = '';
if ($course_id) {
    $stmt = $conn->prepare("SELECT course_type FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->bind_result($course_title);
    $stmt->fetch();
    $stmt->close();
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
        .blank-content {
            text-align: center;
            margin-top: 50px;
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
                        <h1 class="h3 mb-0 text-gray-800">Competency Management</h1>
                    </div>

                    <?php include '../breadcrumb.php'; ?>

                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 bg-primary">
                                    <h4 class="m-0 font-weight-bold text-white">Create Quiz</h4>
                                </div>
                                <div class="card-body">
                                    <form action="save_quiz.php" method="POST">
                                        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
                                        <div class="form-group">
                                            <label for="course_title">Course</label>
                                            <input type="text" class="form-control" id="course_title" value="<?= htmlspecialchars($course_title) ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="quiz_title">Quiz Title</label>
                                            <input type="text" class="form-control" id="quiz_title" name="quiz_title" required>
                                        </div>
                                        <!-- Identification Questions Section -->
                                        <div class="form-group">
                                            <label>Identification Questions</label>
                                            <div id="questions-container">
                                                <div class="card mb-3 question-block">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Question</label>
                                                            <input type="text" name="questions[0][question_text]" class="form-control" required>
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm remove-question" style="display:none;">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" id="add-question">Add Another Question</button>
                                        </div>
                                        <!-- End Questions Section -->
                                        <button type="submit" class="btn btn-primary">Save Quiz</button>
                                        <a href="assessment.php" class="btn btn-secondary">Cancel</a>
                                    </form>
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
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Dynamic Identification Questions Script -->
    <script>
    let questionIndex = 1;
    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const block = document.createElement('div');
        block.className = 'card mb-3 question-block';
        block.innerHTML = `
            <div class="card-body">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" name="questions[${questionIndex}][question_text]" class="form-control" required>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-question">Remove</button>
            </div>
        `;
        container.appendChild(block);
        questionIndex++;
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-question');
        removeButtons.forEach(btn => {
            btn.style.display = (removeButtons.length > 1) ? 'inline-block' : 'none';
            btn.onclick = function() {
                btn.closest('.question-block').remove();
                updateRemoveButtons();
            };
        });
    }
    updateRemoveButtons();
    </script>

</body>
</html>