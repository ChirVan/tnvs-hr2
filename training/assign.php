<?php
include '../session_manager.php';
include '../connection.php';

// Fetch scheduled applicants who are NOT yet assigned (not in competency table)
$query = "
    SELECT 
        ts.id AS schedule_id,
        ts.user_id AS applicant_id,
        u.full_name AS name,
        a.position_title AS position_title,
        ts.training_date
    FROM 
        training_schedule ts
    JOIN 
        users u ON ts.user_id = u.id
    JOIN 
        applications a ON u.id = a.user_id
    WHERE 
        a.status = 'accepted'
        AND ts.id NOT IN (SELECT schedule_id FROM competency)
";
$result = $conn->query($query);
$scheduled_applicants = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all course types and their competency_programs
$course_programs = [];
$course_types_query = "
    SELECT c.course_type, l.competency_program
    FROM courses c
    JOIN lessons l ON l.course_id = c.id
";
$course_types_result = $conn->query($course_types_query);
if ($course_types_result && $course_types_result->num_rows > 0) {
    while ($row = $course_types_result->fetch_assoc()) {
        $course_programs[$row['course_type']][] = $row['competency_program'];
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
                <div class="container mt-5">
                    <h1 class="h3 mb-4 text-gray-800">Scheduled Applicants</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Scheduled Applicants</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="scheduledTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Schedule ID</th>
                                            <th>Applicant ID</th>
                                            <th>Name</th>
                                            <th>Position Title</th>
                                            <th>Training Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($scheduled_applicants)): ?>
                                            <?php foreach ($scheduled_applicants as $scheduled): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($scheduled['schedule_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($scheduled['applicant_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($scheduled['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($scheduled['position_title']); ?></td>
                                                    <td><?php echo htmlspecialchars($scheduled['training_date']); ?></td>
                                                    <td>
                                                        <!-- Assign Button with Modal Trigger -->
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#assignModal<?php echo htmlspecialchars($scheduled['schedule_id']); ?>">
                                                            Assign
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="assignModal<?php echo htmlspecialchars($scheduled['schedule_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel<?php echo htmlspecialchars($scheduled['schedule_id']); ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" role="document"> <!-- Large modal -->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="assignModalLabel<?php echo htmlspecialchars($scheduled['schedule_id']); ?>">Assign Applicant</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="assign_action.php" method="POST" enctype="multipart/form-data">
                                                                        <div class="modal-body">

                                                                            <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($scheduled['schedule_id']); ?>">
                                                                            
                                                                            <!-- First Row: 3 Columns -->
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="applicant_id">Applicant ID</label>
                                                                                    <input type="text" class="form-control" id="applicant_id" value="<?php echo htmlspecialchars($scheduled['applicant_id']); ?>" readonly>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="full_name">Full Name</label>
                                                                                    <input type="text" class="form-control" id="full_name" value="<?php echo htmlspecialchars($scheduled['name']); ?>" readonly>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label for="position_title">Position Title</label>
                                                                                    <input type="text" class="form-control" id="position_title" value="<?php echo htmlspecialchars($scheduled['position_title']); ?>" readonly>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Second Row: Course Type, Assigned By -->
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="course_type_<?php echo $scheduled['schedule_id']; ?>">Course Type</label>
                                                                                    <select class="form-control" name="course_type" id="course_type_<?php echo $scheduled['schedule_id']; ?>" required onchange="showCompetencyProgram('<?php echo $scheduled['schedule_id']; ?>')">
                                                                                        <option value="">Select Course Type</option>
                                                                                        <?php foreach ($course_programs as $type => $program): ?>
                                                                                            <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="assigned_by_<?php echo $scheduled['schedule_id']; ?>">Assigned By</label>
                                                                                    <select class="form-control" name="assigned_by" id="assigned_by_<?php echo $scheduled['schedule_id']; ?>">
                                                                                        <option value="">Select User</option>
                                                                                        <?php 
                                                                                            if ($_SESSION['role'] === 'admin') {
                                                                                                // Fetch all employees for admin
                                                                                                $employees_query = "SELECT id AS employee_id, full_name AS name FROM users WHERE role = 'employee'";
                                                                                                $employees_result = $conn->query($employees_query);
                                                                                                if ($employees_result && $employees_result->num_rows > 0) {
                                                                                                    while ($employee = $employees_result->fetch_assoc()) {
                                                                                                        echo '<option value="' . htmlspecialchars($employee['employee_id']) . '">' .
                                                                                                            htmlspecialchars($employee['name']) .
                                                                                                            '</option>';
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                // Only the logged-in employee's name
                                                                                                echo '<option value="' . htmlspecialchars($_SESSION['user_id']) . '" selected>' .
                                                                                                    htmlspecialchars($_SESSION['full_name']) .
                                                                                                    '</option>';
                                                                                            }
                                                                                                
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Third Row: Competency Program Display -->
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="competency_files" class="font-weight-bold">Competency Program</label>
                                                                                    <div class="card border-primary shadow-sm mb-3">
                                                                                        <div class="card-body p-3">
                                                                                            <div id="competency_program_cell_<?php echo $scheduled['schedule_id']; ?>" 
                                                                                                class="text-center text-primary font-italic"
                                                                                                style="font-size: 1.15rem; min-height: 40px;">
                                                                                                Select a course type to view competency program
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <small class="form-text text-muted">
                                                                                        The competency program will be shown here after selecting a course type.
                                                                                    </small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Hidden Input -->
                                                                            <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($scheduled['schedule_id']); ?>">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary">Assign</button>
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
                                                <td colspan="6" class="text-center">No scheduled applicants found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $query = "
                    SELECT 
                        MIN(ae.id) AS assigned_exam_id,
                        ae.competency_id,
                        c.schedule_id,
                        c.course_type,
                        ts.location,
                        a.id AS application_id,
                        te.first_name,
                        te.last_name
                    FROM assigned_examinations ae
                    INNER JOIN competency c ON ae.competency_id = c.id
                    INNER JOIN training_schedule ts ON c.schedule_id = ts.id
                    INNER JOIN applications a ON ts.user_id = a.user_id
                    INNER JOIN test_employees te ON ts.user_id = te.employee_id
                    GROUP BY ae.competency_id, c.schedule_id, c.course_type, ts.location, a.id, te.first_name, te.last_name
                    ORDER BY assigned_exam_id ASC
                ";
                $result = $conn->query($query);
                $assigned_applicants = $result->fetch_all(MYSQLI_ASSOC);
                ?>

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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const assignButtons = document.querySelectorAll('.assign-btn');

        assignButtons.forEach(button => {
            button.addEventListener('click', function () {
                const applicantId = this.getAttribute('data-id');
                const applicantName = this.getAttribute('data-name');
                const jobRole = this.getAttribute('data-job-role');

                // Populate modal fields
                document.getElementById('applicant_id').value = applicantId;
            });
        });
    });

    function showCompetencyProgram(scheduleId) {
        var coursePrograms = <?php echo json_encode($course_programs); ?>;
        var select = document.getElementById('course_type_' + scheduleId);
        var cell = document.getElementById('competency_program_cell_' + scheduleId);
        var selectedType = select.value;
        cell.classList.remove('font-weight-bold');
        if (selectedType && coursePrograms[selectedType] && coursePrograms[selectedType].length > 0) {
            let html = '<ul class="mb-0">';
            coursePrograms[selectedType].forEach(function(program) {
                html += '<li>' + program + '</li>';
            });
            html += '</ul>';
            cell.innerHTML = html;
            cell.classList.add('font-weight-bold');
        } else {
            cell.textContent = 'Select a course type to view competency program';
        }
    }
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="/humanResource2/vendor/jquery/jquery.min.js"></script>
    <script src="/humanResource2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/humanResource2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/humanResource2/js/sb-admin-2.min.js"></script>

</body>
</html>