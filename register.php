<?php
session_start();
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/SMTP.php';

// Function to check if the phone number is numeric
function validatePhone($phone) {
    if (!is_numeric($phone)) {
        return "Phone number must contain only numbers!";
    }
    return null;
}

// Function to check if the phone number already exists in the database
function checkPhoneExists($phone, $conn) {
    // Prepared statement to check if phone exists
    $checkPhone = "SELECT * FROM user_register WHERE phone = ?";
    $stmt = $conn->prepare($checkPhone);
    $stmt->bind_param("s", $phone); // "s" means string (phone number)
    $stmt->execute();
    $phoneResult = $stmt->get_result();

    if ($phoneResult && $phoneResult->num_rows > 0) {
        return "Phone number already exists!";
    }
    return null;
}

// Function to check if the email already exists in the database
function checkEmailExists($email, $conn) {
    // Prepared statement to check if email exists
    $checkEmail = "SELECT * FROM user_register WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email); // "s" means string (email)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return "Email Address Already Exists!";
    }
    return null;
}

function validatePassword($password, $confirmPassword) {
    // Check if passwords match
    if ($password !== $confirmPassword) {
        return "Passwords do not match!";
    }

    // Password requirements:
    // 1. At least 10 characters long
    // 2. Must contain at least one uppercase letter
    // 3. Must contain at least one lowercase letter
    // 4. Must contain at least one number
    // 5. Must contain at least one special character

    // Check length
    if (strlen($password) < 10) {
        return "Password must be at least 10 characters long!";
    }

    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter!";
    }

    // Check for at least one number
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number!";
    }

    // Check for at least one special character
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return "Password must contain at least one special character!";
    }

    // If all checks pass, return null (no error)
    return null;
}

function storeTemporaryUserData($userData) {
    $_SESSION['temp_user_data'] = $userData;
}

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
                      Your verification code is: <b>{$verificationCode}</b><br><br>
                      Please enter this code to complete your registration.";
        $mail->AltBody = "Thank you for registering with Cabin By Royale! Your verification code is: {$verificationCode}";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function registerUser($userData, $conn) {
    // Extract user data
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];
    $phone = $userData['phone'];
    $email = $userData['email'];
    $password = md5($userData['password']); // Encrypt the password
    $valid_id_image = $userData['valid_id_image'];

    $insertQuery = "INSERT INTO user_register 
                    (firstname, lastname, phone, email, password, valid_id_image)
                    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssss", $firstname, $lastname, $phone, $email, $password, $valid_id_image);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Process registration form submission
if (isset($_POST['signUp'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $valid_id_type = $_POST['valid_id'];

    // Validate image upload first
    if (!isset($_FILES['valid_id_image']) || $_FILES['valid_id_image']['error'] == UPLOAD_ERR_NO_FILE) {
        echo "<script>alert('Please upload a valid ID image.');</script>";
        exit;
    }

    $valid_id = $_FILES['valid_id_image'];

    // Allowed file types
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];

    // Check file type
    if (!in_array($valid_id['type'], $allowedTypes)) {
        echo "<script>alert('Invalid file type. Only PNG and JPEG images are allowed.');</script>";
        exit;
    }

    // Maximum file size (5MB)
    $maxFileSize = 5 * 1024 * 1024;
    if ($valid_id['size'] > $maxFileSize) {
        echo "<script>alert('File size exceeds 5MB limit.');</script>";
        exit;
    }

    // Read the image file
    $image_data = file_get_contents($valid_id['tmp_name']);

    // Validate other fields...
    $phoneValidation = validatePhone($phone);
    if ($phoneValidation) {
        echo "<script>alert('{$phoneValidation}');</script>";
        exit;
    }

    $phoneExists = checkPhoneExists($phone, $conn);
    if ($phoneExists) {
        echo "<script>alert('{$phoneExists}');</script>";
        exit;
    }

    $emailExists = checkEmailExists($email, $conn);
    if ($emailExists) {
        echo "<script>alert('{$emailExists}');</script>";
        exit;
    }

    $passwordValidation = validatePassword($password, $confirmPassword);
    if ($passwordValidation) {
        echo "<script>alert('{$passwordValidation}');</script>";
        exit;
    }

    // Store user data temporarily
    $userData = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'phone' => $phone,
        'email' => $email,
        'password' => $password,
        'valid_id_type' => $valid_id_type,
        'valid_id_image' => $image_data
    ];

    storeTemporaryUserData($userData);

    // Generate a random 6-digit verification code
    $verificationCode = rand(100000, 999999);

    // Store the verification code in session
    $_SESSION['verification_code'] = $verificationCode;

    // Send verification email
    $emailSent = sendVerificationEmail($email, $verificationCode);

    if ($emailSent) {
        // Redirect to verification page
        header("Location: verify.php");
        exit;
    } else {
        echo "<script>alert('Failed to send verification email. Please try again.');</script>";
    }
}

// Process OTP verification
if (isset($_POST['verify'])) {
    $enteredOTP = $_POST['otp-input'];
    $storedOTP = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : '';

    if ($enteredOTP == $storedOTP) {
        // Get stored user data
        $userData = $_SESSION['temp_user_data'];

        // Register the user in the database
        $registered = registerUser($userData, $conn);

        if ($registered) {
            // Clear temporary session data
            unset($_SESSION['temp_user_data']);
            unset($_SESSION['verification_code']);

            // Registration success - output JavaScript for modal and redirect
            echo "<script>
                alert('Account created successfully! You can now log in.');
                window.location.href = 'index.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Failed to create account. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid verification code. Please try again.');</script>";
    }
}
?>