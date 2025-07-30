<?php
// filepath: c:\xampp\htdocs\humanResource2\training\serve_lesson.php

include '../session_manager.php';
include '../connection.php';

// Get the lesson ID from the query string
$lessonId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($lessonId <= 0) {
    die("Invalid lesson ID.");
}

// Fetch the lesson content, course type, and lesson title using a JOIN query
$stmt = $conn->prepare("
    SELECT 
        lessons.lesson_proper, 
        lessons.competency_program AS lesson_title, 
        courses.course_type 
    FROM lessons
    INNER JOIN courses ON lessons.course_id = courses.id
    WHERE lessons.id = ?
");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Lesson not found.");
}

$lesson = $result->fetch_assoc();
$lessonTitle = $lesson['lesson_title']; // Example: "Defensive Driving Techniques Lesson"
$courseName = $lesson['course_type'];   // Example: "Driver Course"
$lessonContent = $lesson['lesson_proper']; // The lesson content in HTML format
$stmt->close();
$conn->close();

// Define breadcrumb structure
$breadcrumbs = [
    ['name' => 'Dashboard', 'link' => '/humanResource2/dashboard/index.php'],
    ['name' => 'Training', 'link' => '#'],
    ['name' => 'Courses', 'link' => '/humanResource2/training/courses.php'],
    ['name' => $courseName, 'link' => ''], // Course name
    ['name' => $lessonTitle, 'link' => ''] // Lesson title
];
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

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <?php foreach ($breadcrumbs as $breadcrumb): ?>
                                <?php if (!empty($breadcrumb['link'])): ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo htmlspecialchars($breadcrumb['link']); ?>">
                                            <?php echo htmlspecialchars($breadcrumb['name']); ?>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php echo htmlspecialchars($breadcrumb['name']); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- Save as PDF Button -->
                    <form action="save.php" method="POST">
                        <input type="hidden" name="lesson_title" value="<?php echo htmlspecialchars($lessonTitle); ?>">
                        <input type="hidden" name="lesson_content" value="<?php echo htmlspecialchars($lessonContent); ?>">
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-file-pdf"></i> Save as PDF
                        </button>
                    </form>

                    <!-- Lesson Content -->
                    <div>
                        <?php echo $lessonContent; ?>
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
    <script src="/humanResource2/vendor/jquery/jquery.min.js"></script>
    <script src="/humanResource2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/humanResource2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/humanResource2/js/sb-admin-2.min.js"></script>

</body>
</html>