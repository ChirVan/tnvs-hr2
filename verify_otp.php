<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verify the OTP
$enteredOtp = $_POST['otp']; // The OTP entered by the user
if (isset($_SESSION['otp']) && $_SESSION['otp'] == $enteredOtp && time() < $_SESSION['otp_expiry']) {
    // OTP is valid
    unset($_SESSION['otp']); // Clear the OTP after successful verification
    unset($_SESSION['otp_expiry']); // Clear the OTP expiry time

    // Redirect to the dashboard
    header("Location: dashboard/index.php");
    exit;
} else {
    // OTP is invalid or expired
    $message = "<div class='alert alert-danger' role='alert'>Invalid or expired OTP. Please try again.</div>";
    $retryLink = "<a href='otp.php' class='btn btn-warning mt-3'>Go back to OTP verification</a>";
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
                                    <div class="text-center mb-4">
                                        <div>
                                            <?php echo $retryLink; ?>
                                        </div>
                                    </div>
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