<?php
session_start();
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Redirect if user didn't come from verification page
if (!isset($_SESSION['temp_user_data']) || !isset($_SESSION['verification_code'])) {
    header("Location: index.php");
    exit;
}

// Generate a new random 6-digit verification code
$verificationCode = rand(100000, 999999);

// Update the verification code in session
$_SESSION['verification_code'] = $verificationCode;
$email = $_SESSION['temp_user_data']['email'];

// Function to send verification email
function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cabinbyroyale11@gmail.com';
        $mail->Password = 'qnjo cgbh bcfc xzzt';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('cabinbyroyale11@gmail.com', 'Cabin By Royale');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification Code';
        $mail->Body = "Thank you for registering with Cabin By Royale!<br><br>
                      Your new verification code is: <b>{$verificationCode}</b><br><br>
                      Please enter this code to complete your registration.";
        $mail->AltBody = "Thank you for registering with Cabin By Royale! Your new verification code is: {$verificationCode}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Send verification email
$emailSent = sendVerificationEmail($email, $verificationCode);

if ($emailSent) {
    echo "<script>
        alert('A new verification code has been sent to your email.');
        window.location.href = 'verify.php';
    </script>";
    exit;
} else {
    echo "<script>
        alert('Failed to send verification email. Please try again.');
        window.location.href = 'verify.php';
    </script>";
    exit;
}
?>