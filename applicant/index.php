<?php

include '../connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = trim($_POST['user_id']);
    $full_name = trim($_POST['full_name']);

    // Step 1: Check if both user_id and full_name match a user
    $user_sql = "SELECT id, full_name FROM users WHERE id = ? AND full_name = ? LIMIT 1";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("is", $user_id, $full_name);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();

    if ($user_result->num_rows > 0) {
        // Step 2: Check if user_id exists in competency via training_schedule
        $sql = "
            SELECT 1
            FROM training_schedule ts
            INNER JOIN competency c ON c.schedule_id = ts.id
            WHERE ts.user_id = ?
            LIMIT 1
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = $full_name;
            header("Location: applicant.php");
            exit();
        } else {
            $error = "You do not have any assigned competency yet.";
        }
    } else {
        $error = "User ID and Full Name do not match our records.";
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

    <title>Applicant Login</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Applicant Login</h1>
                                    </div>
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                    <form class="user" method="POST" action="">
                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-user" name="user_id" id="user_id" placeholder="Enter Your User ID" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="full_name" placeholder="Enter Your Full Name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Access Assessments
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">Need Help? Contact Support</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
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