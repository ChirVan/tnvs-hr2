<!-- filepath: c:\xampp\htdocs\humanResource2\training\courses.php -->
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

                    <!-- Ready to Assess Exam List -->
                    <div id="ready-to-assess-content">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Assign Assessment Button -->
                                <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#assignAssessmentModal">
                                    <i class="fas fa-plus"></i> Assign Assessment
                                </button>

                                <!-- Assign Assessment Modal -->
                                <div class="modal fade" id="assignAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="assignAssessmentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="assignAssessmentModalLabel">Assign Assessment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-3">
                                                            <label for="applicantId">Applicant ID</label>
                                                            <input type="text" class="form-control" id="applicantId" placeholder="Enter Applicant ID">
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="assessmentId">Assessment ID</label>
                                                            <input type="text" class="form-control" id="assessmentId" placeholder="Enter Assessment ID">
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="competencyId">Comp ID</label>
                                                            <input type="text" class="form-control" id="competencyId" placeholder="Enter Competency ID">
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="course">Course</label>
                                                            <input type="text" class="form-control" id="course" placeholder="Enter Course">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="examTitle">Exam Title</label>
                                                            <input type="text" class="form-control" id="examTitle" placeholder="Enter Exam Title">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="examDate">Exam Date</label>
                                                            <input type="date" class="form-control" id="examDate">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Search Applicant Name" aria-label="Search Applicants">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Applicant ID</th>
                                                <th>Course</th>
                                                <th>Exam Title</th>
                                                <th>Exam Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example Row 1 -->
                                            <tr>
                                                <td>301</td>
                                                <td>Driver</td>
                                                <td>Defensive Driving Assessment</td>
                                                <td>2025-03-15</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            
                                            <!-- Example Row 2 -->
                                            <tr>
                                                <td>302</td>
                                                <td>Mechanics</td>
                                                <td>Engine Diagnostics Exam</td>
                                                <td>2025-03-20</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            
                                            <!-- Example Row 3 -->
                                            <tr>
                                                <td>303</td>
                                                <td>Dispatcher</td>
                                                <td>Route Planning Assessment</td>
                                                <td>2025-03-25</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            
                                            <!-- Example Row 4 -->
                                            <tr>
                                                <td>304</td>
                                                <td>HR Staff</td>
                                                <td>Recruitment and Selection Exam</td>
                                                <td>2025-03-30</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            
                                            <!-- Example Row 5 -->
                                            <tr>
                                                <td>305</td>
                                                <td>Core Operations</td>
                                                <td>Leadership Styles Assessment</td>
                                                <td>2025-04-05</td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Ready to Assess Exam List -->

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

    <!-- Include materials.js -->
    <script src="materials.js"></script>

</body>
</html>