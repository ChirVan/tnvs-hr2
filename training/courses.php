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
    <link href="/humanResource2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/humanResource2/css/sb-admin-2.min.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Training Management</h1>
                    </div>

                    <?php include '../breadcrumb.php'; ?>

                    <!-- Dynamic Content -->
                    <div id="dynamic-content">
                        <div class="row row-cols-1 row-cols-md-5 g-4" id="card-container">
                            <!-- Driver Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-primary shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="driver" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-truck fa-2x text-primary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Driver Courses</h6>
                                            <ul class="list-unstyled">
                                                <li>Defensive Driving</li>
                                                <li>Vehicle Maintenance</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- Mechanics Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-secondary shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="mechanics" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-tools fa-2x text-secondary mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Mechanics Courses</h6>
                                            <ul class="list-unstyled">
                                                <li>Engine Diagnostics</li>
                                                <li>Repair Techniques</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- Dispatcher Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-warning shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="dispatcher" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-headset fa-2x text-warning mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Dispatcher Courses</h6>
                                            <ul class="list-unstyled">
                                                <li>Time Management</li>
                                                <li>Communication Skills</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- Finance Officer Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-success shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="financeOfficer" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-dollar-sign fa-2x text-success mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Finance Officer Courses</h6>
                                            <ul class="list-unstyled">
                                                <li>Budgeting</li>
                                                <li>Financial Reporting</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- HR Staff Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-info shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="HRStaff" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-user-tie fa-2x text-info mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">HR Staff Courses</h6>
                                            <ul class="list-unstyled">
                                                <li>Recruitment</li>
                                                <li>Employee Relations</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- Core Operations Courses -->
                            <div class="col mb-4">
                                <button class="card border-left-danger shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="coreOperations" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-cogs fa-2x text-danger mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Core Operations</h6>
                                            <ul class="list-unstyled">
                                                <li>Process Optimization</li>
                                                <li>Operational Efficiency</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div class="col mb-4">
                                <button class="card border-left-danger shadow h-100 py-4 text-decoration-none course-card" 
                                        data-course="fleetManager" 
                                        style="background: url('../img/coursebg-2.jpg'); background-size: cover; color: black; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; height: 200px; width: 200px;">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <i class="fas fa-clipboard-list fa-2x text-danger mb-3" style="background-color: rgba(0, 0, 0, 0.28); padding: 10px; border-radius: 50%;"></i>
                                            <h6 class="font-weight-bold">Fleet Manager Course</h6>
                                            <ul class="list-unstyled">
                                                <li>Fleet Planning</li>
                                                <li>Asset Management</li>
                                            </ul>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End of Dynamic Content -->

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

    <script src="/humanResource2/training/course-handler.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="/humanResource2/vendor/jquery/jquery.min.js"></script>
    <script src="/humanResource2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/humanResource2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/humanResource2/js/sb-admin-2.min.js"></script>

</body>
</html>