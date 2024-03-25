<?php
session_start();
include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
    $user_type = mysqli_real_escape_string($conn, $_POST['login_type']); // Capture the selected user type (user or admin)
    
    // Check if password matches confirm password
    if ($password === $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Generate OTP
        $otp = rand(1000, 9999);
        $_SESSION['otp'] = $otp;
        $_SESSION['register_email'] = $email;

        // Send OTP to user's email
        $to = $email;
        $subject = "Verification OTP";
        $message = "Your OTP for registration is: $otp";
        $headers = "From: your@example.com";

        if (mail($to, $subject, $message, $headers)) {
            $msg = "<div class='alert alert-success'>An OTP has been sent to your email address. Please verify your email.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Failed to send OTP email. Please check your SMTP settings.</div>";
        }
        
        // Insert user data into database
        $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_password', '$user_type')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect to verification page
            header('Location: verify.php');
            exit();
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong during registration. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form - Crime Reporting System</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/register_style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p>Register To Crime Reporting System. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            
                            <div class="input-field">
                                <select name="login_type" required>
                                    <option value="" disabled selected>Select Registration Type</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="login.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>