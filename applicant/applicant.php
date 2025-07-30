<?php

include '../connection.php';
include '../session_manager.php';

$user_id = $_SESSION['user_id'];

// Fetch applicant name
$name_query = "SELECT full_name FROM users WHERE id = ?";
$name_stmt = $conn->prepare($name_query);
$name_stmt->bind_param("i", $user_id);
$name_stmt->execute();
$name_result = $name_stmt->get_result();
$applicant = $name_result->fetch_assoc();
$applicant_name = isset($applicant['full_name']) ? $applicant['full_name'] : 'Unknown';

// Fetch assigned course and its description
$course_query = "
    SELECT DISTINCT c.course_type, c.id AS course_id
    FROM assigned_examinations ae
    JOIN competency comp ON ae.competency_id = comp.id
    JOIN training_schedule ts ON comp.schedule_id = ts.id
    JOIN examinations e ON ae.examination_id = e.id
    JOIN courses c ON e.course_id = c.id
    WHERE ts.user_id = ?
    LIMIT 1
";
$course_stmt = $conn->prepare($course_query);
$course_stmt->bind_param("i", $user_id);
$course_stmt->execute();
$course_result = $course_stmt->get_result();
$course = $course_result->fetch_assoc();
$course_id = isset($course['course_id']) ? $course['course_id'] : null;

// Example course descriptions (replace with your own logic or fetch from DB)
$course_descriptions = [
    'driver' => 'Learn safe driving techniques and vehicle maintenance.',
    'mechanics' => 'Master the essentials of vehicle mechanics and repair.',
    'dispatcher' => 'Coordinate and manage transport operations efficiently.',
    'financeOfficer' => 'Handle financial operations and reporting.',
    'HRStaff' => 'Manage human resources and staff development.',
    'coreOperations' => 'Oversee core business operations and logistics.'
];

// Fetch assigned assessments (examinations) with status
$exam_query = "
    SELECT e.title, e.id AS exam_id, ae.status
    FROM assigned_examinations ae
    JOIN competency comp ON ae.competency_id = comp.id
    JOIN training_schedule ts ON comp.schedule_id = ts.id
    JOIN examinations e ON ae.examination_id = e.id
    WHERE ts.user_id = ?
";
$exam_stmt = $conn->prepare($exam_query);
$exam_stmt->bind_param("i", $user_id);
$exam_stmt->execute();
$exam_result = $exam_stmt->get_result();

// Fetch ALL competency programs for the assigned user
$competency_programs = [];
$competency_query = "
    SELECT comp.competency_program, comp.lesson_proper
    FROM competency comp
    JOIN training_schedule ts ON comp.schedule_id = ts.id
    WHERE ts.user_id = ?
";
$competency_stmt = $conn->prepare($competency_query);
$competency_stmt->bind_param("i", $user_id);
$competency_stmt->execute();
$competency_result = $competency_stmt->get_result();
while ($row = $competency_result->fetch_assoc()) {
    $competency_programs[] = $row;
}

// Status color mapping
$colors = [
    'Finished' => 'success',
    'Not Started' => 'danger'
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- TNVS Logo and Text -->
                    <img src="../img/logor.png" alt="TNVS Logo" class="mr-2" style="height: 100px;">
                    <span class="navbar-text font-weight-bold text-primary">TNVS</span>

                    <!-- Applicant Portal Text -->
                    <div class="mx-auto text-center">
                        <span class="navbar-text h4 font-weight-bold text-gradient-primary ml-5" style="background: linear-gradient(to right, #4e73df, #1cc88a); -webkit-background-clip: text; color: transparent;">Applicant Portal</span>
                    </div>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle ml-3">
                        <i class="fa fa-bars"></i>
                    </button>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Assigned Quizzes and Assessments</h1>

                    <!-- Training Management Dashboard -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Assigned Courses and Assessments</h6>
                        </div>
                        <p class="mb-2 font-weight-bold text-primary ml-4">
                            <span class="text-info">
                                Applicant: <?php echo htmlspecialchars($applicant_name); ?> (ID: <?php echo htmlspecialchars($user_id); ?>)
                            </span>
                        </p>
                        <div class="card-body">
                            <div class="row">

                                <!-- Assigned Course -->
                                <div class="col-lg-12 mb-4">
                                    <span class="text-xs font-weight-bold text-primary text-uppercase">Assigned Course:</span>
                                    <span class="h5 font-weight-bold text-gray-800 ml-2">
                                        <?php echo isset($course['course_type']) ? ucfirst($course['course_type']) . ' Course' : 'No Course Assigned'; ?>
                                    </span>
                                    <p class="mt-2 text-gray-600">
                                        <?php
                                        if (isset($course['course_type']) && isset($course_descriptions[$course['course_type']])) {
                                            echo $course_descriptions[$course['course_type']];
                                        } else {
                                            echo 'No description available.';
                                        }
                                        ?>
                                    </p>
                                </div>

                                <!-- Assigned Assessments -->
                                <?php while ($exam = $exam_result->fetch_assoc()):
                                    $status = isset($exam['status']) ? $exam['status'] : 'Not Started';
                                    $color = isset($colors[$status]) ? $colors[$status] : 'secondary';
                                ?>
                                <div class="col-lg-4 mb-4">
                                    <div class="card border-left-<?php echo $color; ?> shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="text-xs font-weight-bold text-<?php echo $color; ?> text-uppercase mb-1">
                                                <?php echo htmlspecialchars($exam['title']); ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Status: <?php echo htmlspecialchars($status); ?></div>
                                            <p class="mt-2 text-gray-600">
                                                <!-- You can add exam description here if available -->
                                                No description available.
                                            </p>
                                            <a href="attempt_quiz.php?exam_id=<?php echo $exam['exam_id']; ?>"
                                                class="btn btn-<?php echo $color; ?> btn-sm <?php echo ($status === 'Finished') ? 'disabled' : ''; ?>"
                                                <?php echo ($status === 'Finished') ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                                                Attempt Quiz
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Training Materials Table Container -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Training Materials</h6>
                        </div>
                        <div class="card-body">
                            <!-- Course Cards for ALL Competency Programs (full width) -->
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <?php if (!empty($competency_programs)): ?>
                                        <?php foreach ($competency_programs as $index => $comp): ?>
                                            <div class="card shadow-lg border-0 rounded-4 bg-light position-relative overflow-hidden w-100 mb-4">
                                                <!-- Decorative Ribbon -->
                                                <div style="position:absolute;top:0;right:-40px;transform:rotate(45deg);background:#4e73df;color:#fff;padding:8px 40px 8px 40px;font-weight:bold;box-shadow:0 2px 8px rgba(0,0,0,0.1);z-index:2;">
                                                    Competency
                                                </div>
                                                <div class="card-header bg-gradient-primary text-white d-flex align-items-center rounded-top-4" style="background: linear-gradient(90deg, #4e73df 60%, #1cc88a 100%);">
                                                    <i class="fas fa-award me-2" style="font-size:1.7rem;"></i>
                                                    <span class="fw-bold fs-5">Competency Program</span>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2 text-primary"><?php echo htmlspecialchars($comp['competency_program']); ?></h5>
                                                    <p class="card-text text-muted mb-3">
                                                        This program is designed to enhance your skills and knowledge in this area.
                                                    </p>
                                                    <button class="btn btn-outline-primary shadow-sm" type="button" onclick="toggleLessonProper(<?php echo $index; ?>)">
                                                        <span id="toggleBtnText<?php echo $index; ?>">Show Lesson Details</span>
                                                    </button>
                                                    <div id="lessonProper<?php echo $index; ?>" class="mt-3 p-3 bg-white border rounded-3" style="display:none;">
                                                        <hr>
                                                        <?php echo $comp['lesson_proper']; ?>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white border-0 rounded-bottom-4 text-end text-muted small shadow-sm">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    Assigned on: <?php echo date('F j, Y'); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">No competency programs found for this course.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function toggleLessonProper(index) {
                        var lessonDiv = document.getElementById('lessonProper' + index);
                        var btnText = document.getElementById('toggleBtnText' + index);
                        if (lessonDiv.style.display === 'none') {
                            lessonDiv.style.display = 'block';
                            btnText.textContent = 'Hide Lesson Details';
                        } else {
                            lessonDiv.style.display = 'none';
                            btnText.textContent = 'Show Lesson Details';
                        }
                    }
                    </script>

                </div>

            </div>

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

    <!-- Vendor Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

</body>
</html>