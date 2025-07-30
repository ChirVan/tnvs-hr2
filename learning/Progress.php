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
                        <h1 class="h3 mb-0 text-gray-800">Learning Management</h1>
                    </div>

                    <?php include '../breadcrumb.php'; ?>

                    <!-- Potential Successor Table -->
                    <div id="potential-successor-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center">Potential Successor</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Applicant ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example Row 1 -->
                                            <tr>
                                                <td>201</td>
                                                <td>John Doe</td>
                                                <td>Operations Manager</td>
                                                <td><span class="badge badge-success">Ready</span></td>
                                                <td><button class="btn btn-primary btn-sm">Send</button></td>
                                            </tr>
                                            
                                            <!-- Example Row 2 -->
                                            <tr>
                                                <td>202</td>
                                                <td>Jane Smith</td>
                                                <td>Finance Analyst</td>
                                                <td><span class="badge badge-warning">In Training</span></td>
                                                <td><button class="btn btn-primary btn-sm">Send</button></td>
                                            </tr>
                                            
                                            <!-- Example Row 3 -->
                                            <tr>
                                                <td>203</td>
                                                <td>Michael Brown</td>
                                                <td>Logistics Coordinator</td>
                                                <td><span class="badge badge-secondary">Not Ready</span></td>
                                                <td><button class="btn btn-primary btn-sm">Send</button></td>
                                            </tr>
                                            
                                            <!-- Example Row 4 -->
                                            <tr>
                                                <td>204</td>
                                                <td>Emily Davis</td>
                                                <td>HR Specialist</td>
                                                <td><span class="badge badge-success">Ready</span></td>
                                                <td><button class="btn btn-primary btn-sm">Send</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Potential Successor Table -->

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