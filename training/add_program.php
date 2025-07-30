<?php
include '../session_manager.php';
include '../connection.php'; // Include your database connection file

$course = $_GET['course'] ?? 'Unknown Course'; // Get the course type from the query parameter
$message = ''; // To store success or error messages

// Fetch the course ID based on the course type
$courseId = null;
if ($course !== 'Unknown Course') {
    $stmt = $conn->prepare("SELECT id FROM courses WHERE course_type = ?");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $courseId = $row['id'];
    } else {
        $message = '<div class="alert alert-danger">Invalid course type.</div>';
    }

    $stmt->close();
}

// Define breadcrumb structure
$breadcrumbs = [
    ['name' => 'Dashboard', 'link' => '/humanResource2/dashboard.php'],
    ['name' => 'Training', 'link' => '/humanResource2/training/index.php'],
    ['name' => 'Courses', 'link' => '/humanResource2/training/courses.php'],
    ['name' => ucfirst($course), 'link' => ''], // Dynamically add the course name
    ['name' => 'Add Program', 'link' => ''] // Add Program step
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $courseId) {
    $competencyProgram = $_POST['competencyProgram'] ?? '';
    $description = $_POST['description'] ?? '';
    $type = $_POST['programType'] ?? ''; // Matches the "type" field in your database
    $lessonProper = $_POST['lessonProper'] ?? '';

    // Validate required fields
    if ($competencyProgram && $description && $type && $lessonProper) {
        // Prepare the SQL query
        $query = "INSERT INTO lessons (course_id, competency_program, description, type, lesson_proper, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())";

        // Use prepared statements to prevent SQL injection
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("issss", $courseId, $competencyProgram, $description, $type, $lessonProper);

            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Program added successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
            }

            $stmt->close();
        } else {
            $message = '<div class="alert alert-danger">Error preparing the query: ' . $conn->error . '</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Please fill in all required fields.</div>';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = '<div class="alert alert-danger">Invalid course type. Cannot add program.</div>';
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
    <link href="/humanResource2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/humanResource2/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- TinyMCE -->
    <script src="../tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#lessonProper',
            plugins: 'lists link image table',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link image | table | alignjustify',
            height: 300,
            setup: function (editor) {
                editor.ui.registry.addButton('alignjustify', {
                    text: 'Justify',
                    onAction: function () {
                        editor.execCommand('JustifyFull');
                    }
                });
            }
        });
    </script>

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

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <?php foreach ($breadcrumbs as $breadcrumb): ?>
                                <?php if (!empty($breadcrumb['link'])): ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?= htmlspecialchars($breadcrumb['link']) ?>"><?= htmlspecialchars($breadcrumb['name']) ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($breadcrumb['name']) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- Display Success or Error Message -->
                    <?php echo $message; ?>

                    <!-- Add Program Modal (Full Screen) -->
                    <div class="modal-dialog modal-xl" role="document"> <!-- Use modal-xl for extra width -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProgramModalLabel">Add Program</h5>
                            </div>
                            <div class="modal-body">
                                <form id="addProgramForm" action="add_program.php?course=<?php echo urlencode($course); ?>" method="POST">
                                    <!-- First Row: Three Columns -->
                                    <div class="row">
                                        <!-- Course Type (Disabled) -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="courseType">Course Type</label>
                                                <input type="text" class="form-control" id="courseType" name="courseType" value="<?php echo htmlspecialchars($course); ?>" disabled>
                                                <input type="hidden" name="courseType" value="<?php echo htmlspecialchars($course); ?>">
                                            </div>
                                        </div>

                                        <!-- Competency Program -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="competencyProgram">Competency Program</label>
                                                <input type="text" class="form-control" id="competencyProgram" name="competencyProgram" placeholder="Enter Competency Program" required>
                                            </div>
                                        </div>

                                        <!-- Program Type -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="programType">Program Type</label>
                                                <select class="form-control" id="programType" name="programType" required>
                                                    <option value="" disabled selected>Select Program Type</option>
                                                    <option value="Soft Skill">Soft Skill</option>
                                                    <option value="Technical Skill">Technical Skill</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Second Row: Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description" required></textarea>
                                    </div>

                                    <!-- Third Row: Lesson Proper (TinyMCE) -->
                                    <div class="form-group">
                                        <label for="lessonProper">Lesson Proper</label>
                                        <textarea id="lessonProper" name="lessonProper"></textarea>
                                    </div>

                                    <!-- Footer: Save Button -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Program</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End of Add Program Modal -->

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

    <script src="/humanResource2/vendor/jquery/jquery.min.js"></script>
    <script src="/humanResource2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/humanResource2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/humanResource2/js/sb-admin-2.min.js"></script>

</body>
</html>