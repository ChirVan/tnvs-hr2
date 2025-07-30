
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- filepath: /c:/xampp/htdocs/humanResource2/index.php -->
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard/index.php">
                <div class="sidebar-brand-icon">
                    <img src="../img/logor.png" alt="Logo" style="width: 100px; height: 100px;">
                </div>
                <div class="sidebar-brand-text mx-3">TNVS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="../dashboard/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Main Content
            </div>

            <!-- Training Management -->
            <li class="nav-item <?php echo in_array(basename($_SERVER['PHP_SELF']), ['trainee.php', 'courses.php', 'program.php', 'materials.php', 'reassessment.php']) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTraining"
                    aria-expanded="true" aria-controls="collapseTraining">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Training</span>
                </a>
                <div id="collapseTraining" class="collapse <?php echo in_array(basename($_SERVER['PHP_SELF']), ['courses.php', 'trainee.php', 'materials.php', 'reassessment.php']) ? 'show' : ''; ?>" aria-labelledby="headingTraining" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'trainee.php' ? 'active' : ''; ?>" href="../training/trainee.php">
                            <i class="fas fa-user-graduate"></i> Trainee
                        </a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'courses.php' ? 'active' : ''; ?>" href="../training/courses.php">
                                <i class="fas fa-book"></i> Courses
                            </a>
                        <?php endif; ?>
                        <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'reassessment.php' ? 'active' : ''; ?>" href="reassessment.php">
                            <i class="fas fa-redo-alt"></i> Request Re-Assessment
                        </a>
                    </div>
                </div>
            </li>
            

            <!-- Competency Management -->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item <?php echo in_array(basename($_SERVER['PHP_SELF']), ['competencyList.php', 'assessment.php', 'assignAssessment.php']) ? 'active' : ''; ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompetency"
                        aria-expanded="true" aria-controls="collapseCompetency">
                        <i class="fas fa-fw fa-brain"></i>
                        <span>Competency</span>
                    </a>
                    <div id="collapseCompetency" class="collapse <?php echo in_array(basename($_SERVER['PHP_SELF']), ['competencyList.php', 'assessment.php', 'assignAssessment.php']) ? 'show' : ''; ?>" aria-labelledby="headingTraining" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'competencyList.php' ? 'active' : ''; ?>" href="../competency/competencyList.php">
                                <i class="fas fa-user-graduate"></i> Competency List
                            </a>
                            <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'assessment.php' ? 'active' : ''; ?>" href="../competency/assessment.php">
                                <i class="fas fa-book"></i> Competency Assessment
                            </a>
                        </div>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item <?php echo in_array(basename($_SERVER['PHP_SELF']), ['competencyList.php', 'assessment.php']) ? 'active' : ''; ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompetency"
                        aria-expanded="true" aria-controls="collapseCompetency">
                        <i class="fas fa-fw fa-brain"></i>
                        <span>Competency</span>
                    </a>
                    <div id="collapseCompetency" class="collapse <?php echo in_array(basename($_SERVER['PHP_SELF']), ['competencyList.php', 'assessment.php']) ? 'show' : ''; ?>" aria-labelledby="headingTraining" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'competencyList.php' ? 'active' : ''; ?>" href="../competency/competencyList.php">
                                <i class="fas fa-user-graduate"></i> Competency List
                            </a>

                        </div>
                    </div>
                </li>
            <?php endif; ?>


            <!-- Succession Planning -->
            <li class="nav-item <?php echo in_array(basename($_SERVER['PHP_SELF']), ['promote.php', '']) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuccession"
                    aria-expanded="true" aria-controls="collapseSuccession">
                    <i class="fas fa-fw fa-user-shield"></i>
                    <span>Succession</span>
                </a>
                <div id="collapseSuccession" class="collapse <?php echo in_array(basename($_SERVER['PHP_SELF']), ['promote.php', 'candidates.php']) ? 'show' : ''; ?>" aria-labelledby="headingTraining" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'promote.php' ? 'active' : ''; ?>" href="../succession/promote.php">
                            <i class="fas fa-user-tie"></i> Successor Candidate
                        </a>
                        <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'candidates.php' ? 'active' : ''; ?>" href="../succession/candidates.php">
                            <i class="fas fa-users"></i> List of Candidates
                        </a>
                    </div>
                </div>
            </li>

            <!-- Learning Management -->
            <li class="nav-item <?php echo in_array(basename($_SERVER['PHP_SELF']), ['progress.php', 'list_of_examinee.php']) ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLearning"
                    aria-expanded="true" aria-controls="collapseLearning">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Learning</span>
                </a>
                <div id="collapseLearning" class="collapse <?php echo in_array(basename($_SERVER['PHP_SELF']), ['progress.php', 'list_of_examinee.php']) ? 'show' : ''; ?>" aria-labelledby="headingTraining" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?php echo basename($_SERVER['PHP_SELF']) == 'list_of_examinee.php' ? 'active' : ''; ?>" href="../learning/list_of_examinee.php">
                            <i class="fas fa-edit"></i> List of Exams Result
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Employee Access
            </div>

            <!-- ESS -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'essDashboard.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="../ess/essDashboard.php">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>ESS</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>