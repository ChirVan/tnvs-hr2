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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Training Management</h1>
                    </div>

                    <?php include '../breadcrumb.php'; ?>
                    
                    <div class="row">

                        <!-- Content Row -->
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Courses Under Training Programs</h6>
                                    <a href="#" class="btn btn-primary btn-sm">Add Course</a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Course ID</th>
                                                <th>Course Name</th>
                                                <th>Program Name</th>
                                                <th>Description</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>C01</td>
                                                <td>Effective Communication</td>
                                                <td>Leadership Development</td>
                                                <td>Improve communication skills for leaders</td>
                                                <td>2 Days</td>
                                                <td class="text-success">Active</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Course"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Course"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C02</td>
                                                <td>Advanced Technical Skills</td>
                                                <td>Technical Skills Training</td>
                                                <td>Deep dive into advanced technical topics</td>
                                                <td>3 Days</td>
                                                <td class="text-danger">Inactive</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Course"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Course"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C03</td>
                                                <td>Customer Interaction Skills</td>
                                                <td>Customer Service Excellence</td>
                                                <td>Train employees on handling customer interactions</td>
                                                <td>1 Day</td>
                                                <td class="text-success">Active</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Course"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Course"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>C04</td>
                                                <td>Safety Compliance Basics</td>
                                                <td>Workplace Safety</td>
                                                <td>Introduction to workplace safety regulations</td>
                                                <td>1 Day</td>
                                                <td class="text-success">Active</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Details"><i class="fas fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Course"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Course"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End of Content Row -->


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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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