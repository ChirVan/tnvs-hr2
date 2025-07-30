<?php
date_default_timezone_set('Asia/Manila');
session_start();
include 'connection.php';

// Session timed out
if (isset($_GET['timeout']) && $_GET['timeout'] === 'true') {
    $error_message = "Session timed out. Please log in again.";
}

// Form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    echo "<pre>Email: " . htmlspecialchars($email) . "\nPassword: " . htmlspecialchars($password) . "</pre>";

    // Get user info and role from user_accounts and users
    $sql = "SELECT 
                ua.user_id, 
                u.full_name, 
                ua.email, 
                ua.hash_password,
                ua.role
            FROM user_accounts ua
            INNER JOIN users u ON ua.user_id = u.id
            WHERE ua.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['hash_password'])) {
            // Set session and store user data
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            
            // Add a dedicated variable for the logged-in username that won't be changed
            $_SESSION['logged_user_name'] = $row['full_name'];

            // --- Activity Log: Log the login event ---
            $activity = "Logged in to the system";
            $user_id = $row['user_id'];
            $created_at = date('Y-m-d H:i:s');
            $log_sql = "INSERT INTO activity_log (user_id, activity, created_at) VALUES (?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("iss", $user_id, $activity, $created_at);
            $log_stmt->execute();
            $log_stmt->close();
            // --- End Activity Log ---

            // Record Time In (attendance logging)
            $employee_id = $row['user_id'];
            $today = date('Y-m-d');
            $current_time = date('H:i:s');

            // Check if already timed in today
            $sql_time = "SELECT id FROM attendance_time_log WHERE employee_id = ? AND record_date = ?";
            $stmt_time = $conn->prepare($sql_time);
            $stmt_time->bind_param("is", $employee_id, $today);
            $stmt_time->execute();
            $stmt_time->store_result();

            if ($stmt_time->num_rows == 0) {
                // Not yet timed in, insert time in
                $insert_sql = "INSERT INTO attendance_time_log (employee_id, record_date, time_in) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("iss", $employee_id, $today, $current_time);
                $insert_stmt->execute();
                $insert_stmt->close();
            }
            $stmt_time->close();
            // End Record Time In

            // Redirect based on role
            if (strtolower($row['role']) === 'admin') {
                header("Location: dashboard/index.php");
            } else {
                header("Location: otp.php");
            }
            exit;
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No account found with that email!";
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

    <title>TNVS LOGIN</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary" style="background-image: url('img/logo.png'); background-size: cover; background-position: center;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 bg-light-subtle">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="img/logo.png" alt="Logo" class="img-fluid p-4">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <!-- Display error message -->
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" name="password" placeholder="Password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('togglePassword').addEventListener('click', function () {
                                                const passwordField = document.getElementById('exampleInputPassword');
                                                const icon = this.querySelector('i');
                                                if (passwordField.type === 'password') {
                                                    passwordField.type = 'text';
                                                    icon.classList.remove('fa-eye');
                                                    icon.classList.add('fa-eye-slash');
                                                } else {
                                                    passwordField.type = 'password';
                                                    icon.classList.remove('fa-eye-slash');
                                                    icon.classList.add('fa-eye');
                                                }
                                            });
                                        </script>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>