<?php

include '../session_manager.php';
include '../connection.php';

// Fetch unique examinees who have completed at least one quiz (status = 'Finished')
// Not evaluated applicants (List of Examinee)
$query = "
    SELECT 
        u.id AS applicant_id,
        u.full_name,
        c.course_type
    FROM assigned_examinations ae
    JOIN competency comp ON ae.competency_id = comp.id
    JOIN training_schedule ts ON comp.schedule_id = ts.id
    JOIN users u ON ts.user_id = u.id
    JOIN examinations e ON ae.examination_id = e.id
    JOIN courses c ON e.course_id = c.id
    WHERE ae.status = 'Finished'
      AND u.id NOT IN (
            SELECT user_id FROM potential
            UNION
            SELECT user_id FROM rejected_applicants
      )
    GROUP BY u.id, c.course_type
    ORDER BY u.id ASC
";
$result = $conn->query($query);

// Evaluated applicants (approved or rejected)
$query_evaluated = "
    SELECT 
        u.id AS applicant_id,
        u.full_name,
        c.course_type,
        'approved' AS status
    FROM assigned_examinations ae
    JOIN competency comp ON ae.competency_id = comp.id
    JOIN training_schedule ts ON comp.schedule_id = ts.id
    JOIN users u ON ts.user_id = u.id
    JOIN examinations e ON ae.examination_id = e.id
    JOIN courses c ON e.course_id = c.id
    WHERE ae.status = 'Finished'
      AND u.id IN (SELECT user_id FROM potential)
    GROUP BY u.id, c.course_type

    UNION

    SELECT 
        u.id AS applicant_id,
        u.full_name,
        ra.course_type,
        'rejected' AS status
    FROM rejected_applicants ra
    JOIN users u ON ra.user_id = u.id
";
$result_evaluated = $conn->query($query_evaluated);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Human Resources 2</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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

                    <!-- Examinee Table -->
                    <div id="applicant-progress-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center">List of Examinees</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Applicant ID</th>
                                                <th>Name</th>
                                                <th>Course</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result && $result->num_rows > 0): ?>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['applicant_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                        <td><?php echo htmlspecialchars(ucfirst($row['course_type'])); ?></td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-outline-primary btn-sm evaluate-btn"
                                                                data-user="<?php echo $row['applicant_id']; ?>"
                                                                data-fullname="<?php echo htmlspecialchars($row['full_name']); ?>"
                                                                data-course="<?php echo htmlspecialchars($row['course_type']); ?>"
                                                                data-toggle="modal"
                                                                data-target="#evaluateModal">
                                                                <i class="fas fa-eye"></i> Evaluate
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No examinees have completed a quiz yet.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Evaluated Applicants Table -->
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="text-center text-primary mb-3" style="font-weight:600;">Evaluated Applicants</h4>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover align-middle">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>Applicant ID</th>
                                                    <th>Name</th>
                                                    <th>Course</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($result_evaluated && $result_evaluated->num_rows > 0): ?>
                                                    <?php while ($row = $result_evaluated->fetch_assoc()): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($row['applicant_id']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                                            <td><?php echo htmlspecialchars(ucfirst($row['course_type'])); ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">No evaluated applicants found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Examinee Table -->

                    <!-- Evaluation Modal -->
                    <div class="modal fade" id="evaluateModal" tabindex="-1" role="dialog" aria-labelledby="evaluateModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="evaluateModalLabel">Applicant Answers</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" id="modal-body-content">
                            <div class="text-center">
                                <span class="spinner-border text-primary"></span>
                                <p>Loading answers...</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Reject Reason Modal -->
                    <div class="modal fade" id="rejectReasonModal" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="rejectForm">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="rejectReasonModalLabel">Reason for Rejection</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" name="user_id" id="reject_user_id">
                                <input type="hidden" name="course_type" id="reject_course_type">
                                <div class="form-group">
                                    <label for="reason">Please provide a reason:</label>
                                    <textarea class="form-control" name="reason" id="reason" rows="3" required></textarea>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Reject</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

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
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../js/sb-admin-2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Existing function to open the modal and load answers
                $('.evaluate-btn').on('click', function() {
                    var userId = $(this).data('user');
                    var courseType = $(this).data('course');
                    $('#modal-body-content').html('<div class="text-center"><span class="spinner-border text-primary"></span><p>Loading answers...</p></div>');
                    $.ajax({
                        url: 'view_answers.php',
                        method: 'POST',
                        data: { user_id: userId, course_type: courseType },
                        success: function(response) {
                            $('#modal-body-content').html(response);
                        },
                        error: function() {
                            $('#modal-body-content').html('<div class="alert alert-danger">Failed to load answers.</div>');
                        }
                    });
                });

                $(document).on('click', '#approve-btn', function() {
                    var userId = $(this).data('user');
                    var fullName = $(this).data('fullname');
                    var courseType = $(this).data('course');
                    var btn = $(this);
                    btn.prop('disabled', true).text('Approving...');
                    $.ajax({
                        url: 'approve_potential.php',
                        method: 'POST',
                        data: { user_id: userId, full_name: fullName, course_type: courseType },
                        success: function(response) {
                            if (response.trim() === "approved_potential") {
                                btn.removeClass('btn-success').addClass('btn-secondary').text('Approved');
                                btn.after('<div class="alert alert-success mt-3">Applicant approved as potential!</div>');
                            } else {
                                btn.prop('disabled', false).text('Approve');
                                btn.after('<div class="alert alert-danger mt-3">Unexpected response: ' + response + '</div>');
                            }
                        },
                        error: function() {
                            btn.prop('disabled', false).text('Approve');
                            btn.after('<div class="alert alert-danger mt-3">Approval failed.</div>');
                        }
                    });
                });

                $(document).on('click', '#reject-btn', function() {
                    var userId = $(this).data('user');
                    var fullName = $(this).data('fullname');
                    var courseType = $(this).data('course');
                    var btn = $(this);
                    btn.prop('disabled', true).text('Rejecting...');
                    $.ajax({
                        url: 'reject_potential.php',
                        method: 'POST',
                        data: { user_id: userId, full_name: fullName, course_type: courseType },
                        success: function(response) {
                            if (response.trim() === "rejected_potential") {
                                btn.removeClass('btn-danger').addClass('btn-secondary').text('Rejected');
                                btn.after('<div class="alert alert-warning mt-3">Applicant has been rejected.</div>');
                            } else {
                                btn.prop('disabled', false).text('Reject');
                                btn.after('<div class="alert alert-danger mt-3">Unexpected response: ' + response + '</div>');
                            }
                        },
                        error: function() {
                            btn.prop('disabled', false).text('Reject');
                            btn.after('<div class="alert alert-danger mt-3">Rejection failed.</div>');
                        }
                    });
                });

                // When reject button is clicked, fill modal fields and show modal
                $(document).on('click', '#reject-btn', function() {
                    var userId = $(this).data('user');
                    var courseType = $(this).data('course');
                    $('#reject_user_id').val(userId);
                    $('#reject_course_type').val(courseType);
                    $('#rejectReasonModal').modal('show');
                });

                // Handle reject form submission
                $('#rejectForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'reject_applicant.php',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#rejectReasonModal').modal('hide');
                            if (response.trim() === "success") {
                                alert('Applicant rejected successfully.');
                                location.reload();
                            } else {
                                alert('Failed to reject applicant: ' + response);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>