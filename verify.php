<?php
session_start();

include 'config.php';

if (isset($_POST['verify'])) {
  $otp1 = mysqli_real_escape_string($conn, $_POST['otp1']);
  $otp2 = mysqli_real_escape_string($conn, $_POST['otp2']);
  $otp3 = mysqli_real_escape_string($conn, $_POST['otp3']);
  $otp4 = mysqli_real_escape_string($conn, $_POST['otp4']);
  $otp_code = $otp1 . $otp2 . $otp3 . $otp4;

  if ($_SESSION['otp_code'] === $otp_code) {
      // OTP is correct, update user's verified status
      $email = $_SESSION['verify_email'];
      $update_sql = "UPDATE users SET verified=1 WHERE email='$email'";
      $update_result = mysqli_query($conn, $update_sql);

      if ($update_result) {
          // Redirect to verification success page
          header('Location: verification_success.php');
          exit();
      } else {
          echo "Error updating user's status.";
      }
  } else {
      echo "Invalid OTP code. Please try again.";
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify</title>
  <link rel="stylesheet" href="form.css">
</head>
<body>
  <div class="form">
    <h2>Verify Your Account</h2>
    <p>We emailed you the four-digit OTP code. Enter the code below to confirm your email address.</p>
    <form action="verify.php" method="post" autocomplete="off">
      <div class="fields-input">
        <input type="text" name="otp1" class="otp_field" maxlength="1" required>
        <input type="text" name="otp2" class="otp_field" maxlength="1" required>
        <input type="text" name="otp3" class="otp_field" maxlength="1" required>
        <input type="text" name="otp4" class="otp_field" maxlength="1" required>
      </div>
      <div class="submit">
        <input type="submit" value="Verify Now" class="button" name="verify">
      </div>
    </form>
  </div>
  <script src="js/verify.js"></script>
</body>
</html>

