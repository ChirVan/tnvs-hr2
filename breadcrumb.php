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

           <!-- Main Content -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/humanResource2/dashboard.php">Dashboard</a></li>
                    <?php
                    // Check the current page and render breadcrumbs accordingly
                    $currentPage = basename($_SERVER['PHP_SELF']);
                    $lessonTitle = isset($lessonTitle) ? $lessonTitle : ''; // Ensure $lessonTitle is defined

                    if ($currentPage == 'courses.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/training/index.php">Training</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Courses</li>';
                    } elseif ($currentPage == 'serve_lesson.php') {
                        $lessonTitle = $lessonTitle . ' lesson'; ;
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/training/index.php">Training</a></li>';
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/training/courses.php">Courses</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($lessonTitle) . '</li>';
                    } elseif ($currentPage == 'trainee.php') {
                        echo '<li class="breadcrumb-item"><a href="#">Training</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Trainee</li>';
                    } elseif ($currentPage == 'reassessment.php') {
                        echo '<li class="breadcrumb-item"><a href="#">Training</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Request Re-Assessment</li>';
                    } elseif ($currentPage == 'competencyList.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/competency/index.php">Competency</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Competency List</li>';
                    } elseif ($currentPage == 'assessment.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/competency/index.php">Competency</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Competency Assessment</li>';
                    } elseif ($currentPage == 'takeExam.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/learning/index.php">Learning</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Take Assessment</li>';
                    } elseif ($currentPage == 'progress.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/learning/index.php">Learning</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Learning Progress</li>';
                    } elseif ($currentPage == 'promote.php') {
                        echo '<li class="breadcrumb-item"><a href="/humanResource2/succession/index.php">Succession Planning</a></li>';
                        echo '<li class="breadcrumb-item active" aria-current="page">Successor Candidate</li>';
                    } else {
                        echo '<li class="breadcrumb-item active" aria-current="page">Unknown Page</li>';
                    }
                    ?>
                </ol>
            </nav>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>