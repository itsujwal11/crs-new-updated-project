<?php
session_start();
include 'config.php';

if (isset($_POST['verify'])) {
    $otp_entered = mysqli_real_escape_string($conn, $_POST['otp']);

    // Validate OTP
    if ($otp_entered == $_SESSION['otp']) {
        // OTP is correct
        // Your logic after OTP verification (e.g., set user as verified)

        // Redirect user after successful verification
        header('Location: verification_success.php');
        exit();
    } else {
        // Incorrect OTP
        echo "Invalid OTP. Please try again.";
    }
}
?>
