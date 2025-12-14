<?php
include 'connection.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];

    // Check email exists
    $sql = "SELECT * FROM role_based_table WHERE email_id='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<script>alert('Email Not Found');</script>";
        exit();
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store OTP & Email in SESSION
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + (15 * 60); // 15 minutes

    // Create mail object
    $mail = new PHPMailer(true);

    try {

        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'imran8096793447@gmail.com';
        $mail->Password = 'vltyyqqxrwuozvdt';  // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($mail->Username, 'Password Reset');
        $mail->addAddress($email);

        // Content
        $resetLink = "http://localhost/reset.php";

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Mail';
        $mail->Body = "
            <p>Hello,</p>
            <p>Use the OTP below to reset your password:</p>
            <h2>$otp</h2>
            <p>OR click the link below:</p>
            <a href='$resetLink'>Reset Password</a>
            <p>This OTP and link expire in 15 minutes.</p>
        ";

        $mail->send();

        echo "<script>alert('Reset link & OTP sent to email');</script>";
        header("Location: reset.php");
        exit();

    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>