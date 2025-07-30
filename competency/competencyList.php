<?php

include '../connection.php';

// Fetch competencies NOT already assigned in assigned_examinations
$query = "
    SELECT 
        c.id AS competency_id,
        ts.user_id AS applicant_id,
        u.full_name AS applicant_name,
        c.course_type,
        c.competency_files
    FROM 
        competency c
    INNER JOIN training_schedule ts ON c.schedule_id = ts.id
    INNER JOIN users u ON ts.user_id = u.id
    WHERE NOT EXISTS (
        SELECT 1 FROM assigned_examinations ae WHERE ae.competency_id = c.id
    )
";
$result = $conn->query($query);
$assigned_applicants = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all examination titles for the dropdown
$exam_query = "SELECT id, title FROM examinations";
$exam_result = $conn->query($exam_query);
$examinations = [];
if ($exam_result && $exam_result->num_rows > 0) {
    while ($exam = $exam_result->fetch_assoc()) {
        $examinations[] = $exam;
    }
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

                    <!-- Competency List Table -->
                    <div id="competency-list-content">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Search Course Name" aria-label="Search Competencies">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <select class="custom-select ml-2" aria-label="Filter">
                                        <option selected>Filter by Course</option>
                                        <option value="1">Driver</option>
                                        <option value="2">Dispatcher</option>
                                        <option value="3">Mechanics</option>
                                        <option value="4">HR Staff</option>
                                        <option value="5">Finance Officer</option>
                                        <option value="6">Core Operations</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                <table class="table table-bordered" id="assignedTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Competency ID</th>
                                <th>Applicant ID</th>
                                <th>Applicant Name</th>
                                <th>Course Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($assigned_applicants)): ?>
                                <?php foreach ($assigned_applicants as $applicant): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($applicant['competency_id']); ?></td>
                                        <td><?php echo htmlspecialchars($applicant['applicant_id']); ?></td>
                                        <td><?php echo htmlspecialchars($applicant['applicant_name']); ?></td>
                                        <td><?php echo htmlspecialchars($applicant['course_type']); ?></td>
                                        <td>
                                            <!-- Assign Button with Modal Trigger -->
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#assignExamModal<?php echo htmlspecialchars($applicant['competency_id']); ?>">
                                                Assign
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="assignExamModal<?php echo htmlspecialchars($applicant['competency_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="assignExamModalLabel<?php echo htmlspecialchars($applicant['competency_id']); ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="assign_exam_action.php" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignExamModalLabel<?php echo htmlspecialchars($applicant['competency_id']); ?>">Assign Examination</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Competency ID</label>
                                                                    <input type="text" class="form-control" name="competency_id" value="<?php echo htmlspecialchars($applicant['competency_id']); ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Applicant ID</label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicant['applicant_id']); ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Applicant Name</label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicant['applicant_name']); ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Course Type</label>
                                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($applicant['course_type']); ?>" readonly>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="examination_id">Select Examination(s)</label>
                                                                    <select class="form-control" name="examination_id[]" id="examination_id" multiple required>
                                                                        <?php
                                                                        // Fetch only examinations where course_id matches the id of the course with the given course_type
                                                                        $course_type = $applicant['course_type'];
                                                                        $exam_query = "
                                                                            SELECT e.id, e.title
                                                                            FROM examinations e
                                                                            JOIN courses c ON e.course_id = c.id
                                                                            WHERE c.course_type = ?
                                                                        ";
                                                                        $exam_stmt = $conn->prepare($exam_query);
                                                                        $exam_stmt->bind_param("s", $course_type);
                                                                        $exam_stmt->execute();
                                                                        $exam_result = $exam_stmt->get_result();
                                                                        while ($exam = $exam_result->fetch_assoc()) {
                                                                            echo '<option value="' . htmlspecialchars($exam['id']) . '">' . htmlspecialchars($exam['title']) . '</option>';
                                                                        }
                                                                        $exam_stmt->close();
                                                                        ?>
                                                                    </select>
                                                                    <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Assign Examination</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No assigned applicants found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Competency List Table -->

                </div>
                <!-- End of Page Content -->

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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>
</html>