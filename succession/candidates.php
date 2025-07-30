<!-- filepath: c:\xampp\htdocs\humanResource2\ess\essDashboard.php -->
<?php
include '../session_manager.php';
include '../connection.php';

// Table 1: Candidates NOT ready
$sql_pending = "
    SELECT 
        p.id,
        u.full_name AS name,
        p.course_type,
        p.status
    FROM potential p
    JOIN users u ON p.user_id = u.id
    WHERE p.status != 'ready'
    ORDER BY p.id DESC
";
$result_pending = $conn->query($sql_pending);

// Table 2: Candidates ready (approved)
$sql_ready = "
    SELECT 
        p.id,
        u.full_name AS name,
        p.course_type,
        p.status
    FROM potential p
    JOIN users u ON p.user_id = u.id
    WHERE p.status = 'ready'
    ORDER BY p.id DESC
";
$result_ready = $conn->query($sql_ready);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_id = intval($_POST['candidate_id']);
    $remarks = $conn->real_escape_string($_POST['remarks']);

    // Update the status to 'ready' and insert comments/remarks
    $sql = "UPDATE potential SET status='ready', comments='$remarks' WHERE id=$candidate_id";
    if ($conn->query($sql)) {
        header("Location: candidates.php?success=1");
        exit;
    } else {
        header("Location: candidates.php?error=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employee Self-Service Dashboard">
    <meta name="author" content="">

    <title>Sucession Planning</title>

    <!-- Vendor fonts -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <style>
        .tab-content {
            margin-top: 20px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .card-header {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        .table-container {
            margin-bottom: 30px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
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
                <div class="container-fluid m-4">
                <h1 class="mb-4">List of Successor Candidates</h1>
                <div class="table-responsive shadow rounded mb-5" style="margin: 24px;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" style="width: 5%;">ID</th>
                                <th scope="col" style="width: 30%;">Name</th>
                                <th scope="col" style="width: 25%;">Job Position</th>
                                <th scope="col" style="width: 20%;">Status</th>
                                <th scope="col" style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_pending->num_rows > 0) {
                                $modalIndex = 0;
                                while ($row = $result_pending->fetch_assoc()) {
                                    $modalId = "sendToCoreModal" . $modalIndex;
                                    $status = strtolower($row['status']);
                                    switch ($status) {
                                        case 'ready':
                                            $badge = "<span class='badge bg-success px-3 py-2'>Ready</span>";
                                            break;
                                        case 'pending':
                                            $badge = "<span class='badge bg-warning text-dark px-3 py-2'>Pending</span>";
                                            break;
                                        case 'rejected':
                                            $badge = "<span class='badge bg-danger px-3 py-2'>Rejected</span>";
                                            break;
                                        default:
                                            $badge = "<span class='badge bg-secondary px-3 py-2'>" . htmlspecialchars(ucfirst($row['status'])) . "</span>";
                                    }
                                    echo "<tr>";
                                    echo "<td class='fw-bold text-primary'>" . $row['id'] . "</td>";
                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['course_type']) . "</td>";
                                    echo "<td>$badge</td>";
                                    echo "<td>
                                            <button type='button' class='btn btn-sm btn-outline-primary' data-bs-toggle='modal' data-bs-target='#$modalId'>
                                                <i class='fas fa-paper-plane'></i> Send to Core Human Capital
                                            </button>
                                            <!-- Modal -->
                                            <div class='modal fade' id='$modalId' tabindex='-1' aria-labelledby='{$modalId}Label' aria-hidden='true'>
                                                <div class='modal-dialog'>
                                                    <div class='modal-content'>
                                                        <form action='' method='POST'>
                                                            <div class='modal-header bg-primary text-white'>
                                                                <h5 class='modal-title' id='{$modalId}Label'>Send to Core Human Capital</h5>
                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <input type='hidden' name='candidate_id' value='" . $row['id'] . "'>
                                                                <p>Are you sure you want to send <strong>" . htmlspecialchars($row['name']) . "</strong> to Core Human Capital?</p>
                                                                <div class='mb-3'>
                                                                    <label for='remarks$modalIndex' class='form-label'>Remarks:</label>
                                                                    <textarea class='form-control' id='remarks$modalIndex' name='remarks' rows='3'></textarea>
                                                                </div>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                                <button type='submit' class='btn btn-primary'>Send</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>";
                                    echo "</tr>";
                                    $modalIndex++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted'>No pending candidates found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <h2 class="mb-4">Approved Successor Candidates</h2>
                <div class="table-responsive shadow rounded" style="margin: 24px;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" style="width: 5%;">ID</th>
                                <th scope="col" style="width: 30%;">Name</th>
                                <th scope="col" style="width: 25%;">Job Position</th>
                                <th scope="col" style="width: 20%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_ready->num_rows > 0) {
                                while ($row = $result_ready->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='fw-bold text-success'>" . $row['id'] . "</td>";
                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['course_type']) . "</td>";
                                    echo "<td><span class='badge bg-success px-3 py-2'>Ready</span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No approved candidates found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </div>
                <!-- Tab Content -->

                    <!-- End of Tab Content -->

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

    <!-- Vendor Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>