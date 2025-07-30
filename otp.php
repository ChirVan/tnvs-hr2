<?php
session_start();
include 'connection.php';

// Include PHPMailer manually
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Use the user's session data
$userEmail = $_SESSION['email'];
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];
$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';

// Redirect admin users to the dashboard
if ($userRole === 'admin') {
    header("Location: dashboard/index.php");
    exit;
}

// Generate a random OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp; // Store the OTP in the session
$_SESSION['otp_expiry'] = time() + 300; // Set expiry time (5 minutes)

// Function to send OTP via email
function sendOtpEmail($email, $otp, $firstName, $lastName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'humanresourceotp@gmail.com';
        $mail->Password = 'mesd ewvw axbo dfpe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // SMTP options
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // Recipients
        $mail->setFrom('humanresourceotp@gmail.com', 'HR2 OTP Verification');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Hello $firstName $lastName,<br>Your OTP code is: <strong>$otp</strong>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Send the OTP via email
if (sendOtpEmail($userEmail, $otp, $firstName, $lastName)) {
    $message = "OTP sent to your email!";
} else {
    $message = "Failed to send OTP via email. Please try again.";
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

    <title>TNVS OTP</title>

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
                                        <h1 class="h4 text-gray-900 mb-4">Verify OTP!</h1>
                                    </div>
                                    <div class="text-center mb-4">
                                        <p class="text-success"><?php echo $message; ?></p>
                                    </div>
                                    <form action="verify_otp.php" method="POST" class="user">
                                        <div class="form-group">
                                            <label for="otp" class="form-label">Enter OTP:</label>
                                            <input type="text" name="otp" id="otp" class="form-control form-control-user" placeholder="Enter OTP" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Verify OTP
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