<!-- filepath: c:\xampp\htdocs\humanResource2\competency\assessment.php -->
<?php
include '../session_manager.php';
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

                    <!-- Examination Content -->
                    <div id="examination-content">
                        <div class="row" id="exam-container">
                            <!-- Driver Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-primary shadow h-100 py-2 text-decoration-none exam-card" data-course-id="1" style="background: url('../img/exambg-1.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(1, 'Driver Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-truck fa-2x text-primary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Driver Examination</h6>
                                            <p>Access and edit driver-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Mechanics Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-success shadow h-100 py-2 text-decoration-none exam-card" data-course-id="2" style="background: url('../img/exambg-2.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(2, 'Mechanics Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-tools fa-2x text-success mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Mechanics Examination</h6>
                                            <p>Access and edit mechanics-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Dispatcher Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-primary shadow h-100 py-2 text-decoration-none exam-card" data-course-id="3" style="background: url('../img/exambg-3.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(3, 'Dispatcher Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-truck fa-2x text-primary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Dispatcher Examination</h6>
                                            <p>Access and edit driver-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- HR Staff Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-info shadow h-100 py-2 text-decoration-none exam-card" data-course-id="4" style="background: url('../img/exambg-4.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(4, 'HR Staff Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-user-tie fa-2x text-info mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">HR Staff Examination</h6>
                                            <p>Access and edit HR staff-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Financials Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-danger shadow h-100 py-2 text-decoration-none exam-card" data-course-id="5" style="background: url('../img/exambg-5.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(5, 'Financials Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-chart-line fa-2x text-danger mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Financials Examination</h6>
                                            <p>Access and edit financial-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Core Operations Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-secondary shadow h-100 py-2 text-decoration-none exam-card" data-course-id="6" style="background: url('../img/exambg-6.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(6, 'Core Operations Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-cogs fa-2x text-secondary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Core Operations Examination</h6>
                                            <p>Access and edit core operations-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- Fleet Manager Examination -->
                            <div class="col-md-3 mb-4">
                                <a href="#" class="card border-left-secondary shadow h-100 py-2 text-decoration-none exam-card" data-course-id="7" style="background: url('../img/exambg-6.jpg'); background-size: cover; color: black;" onclick="fetchExaminations(7, 'Fleet Manager Examination'); return false;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-ship fa-2x text-secondary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Fleet Manager Examination</h6>
                                            <p>Access and edit fleet manager-related exams.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Examination Table -->
                    <div id="dynamic-exam-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center" id="exam-title"></h3>
                                <p class="text-center">Here you can manage the selected course-related exams.</p>
                                <div class="mb-3 text-center" id="exam-action-buttons">
                                    <!-- Button will be inserted here by JS -->
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Quiz Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam-table-body">
                                        <!-- Dynamic content will be loaded here -->
                                    </tbody>
                                </table>
                                <button class="btn btn-secondary" onclick="showExaminationContent();">Back to Examination List</button>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Content -->
                    <div id="quiz-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center" id="quiz-title"></h3>
                                <p class="text-center" id="quiz-description"></p>
                                <ul id="quiz-questions">
                                    <!-- Questions will be dynamically loaded here -->
                                </ul>
                                <button class="btn btn-secondary" onclick="showDriverExam();">Back to Driver Examination</button>
                            </div>
                        </div>
                    </div>

                    <!-- Include quiz script -->
                    <script src="quiz.js"></script>

                    <script>
                        function fetchExaminations(courseId, courseTitle) {
                            // Hide the main examination content and show the dynamic table
                            document.getElementById('examination-content').style.display = 'none';
                            document.getElementById('dynamic-exam-content').style.display = 'block';
                            document.getElementById('exam-title').innerText = courseTitle;

                            // Only show Create Quiz button
                            document.getElementById('exam-action-buttons').innerHTML = `
                                <a href="create_quiz.php?course_id=${courseId}" class="btn btn-primary">Create Quiz</a>
                            `;


                            // Fetch data from the server
                            fetch(`fetch_examinations.php?course_id=${courseId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const tableBody = document.getElementById('exam-table-body');
                                    tableBody.innerHTML = ''; // Clear existing rows

                                    if (data.length > 0) {
                                        data.forEach((exam, index) => {
                                            const row = `
                                                <tr>
                                                    <td>${index + 1}</td>
                                                    <td>${exam.title}</td>
                                                    <td>
                                                        <a href="view_exam.php?exam_id=${exam.id}" class="btn btn-primary btn-sm">View</a>
                                                        <a href="edit_exam.php?exam_id=${exam.id}" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="delete_exam.php?exam_id=${exam.id}" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            `;
                                            tableBody.innerHTML += row;
                                        });
                                    } else {
                                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center">No examinations available.</td></tr>';
                                    }
                                })
                                .catch(error => console.error('Error fetching examinations:', error));
                        }

                        function showExaminationContent() {
                            // Show the main examination content and hide the dynamic table
                            document.getElementById('examination-content').style.display = 'block';
                            document.getElementById('dynamic-exam-content').style.display = 'none';
                        }
                    </script>

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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>
</html>