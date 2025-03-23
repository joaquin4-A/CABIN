<?php
session_start();

// Redirect if user didn't come from registration
if (!isset($_SESSION['temp_user_data']) || !isset($_SESSION['verification_code'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verify | Cabin By Royale</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../../.image-cabin/favicon-16x16.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Allison&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        :root {
            --body-font: 'Poppins', sans-serif;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: var(--body-font), sans-serif;
        }

        main {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .admin-background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .admin-background-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .otp-container {
            width: 400px;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            border-left: 5px solid #8B4513;
            border-top: 5px solid #8B4513;
        }

        .otp-back {
            font-size: 1.8rem;
            font-weight: bold;
            cursor: pointer;
            z-index: 1;
            color: black;
        }

        .title-otp h3{
            font-weight: 600;
            color: #43302e;
            font-size: 1.25rem;
        }

        form p {
            color: gray;
            padding: 0 0 5px 0;
        }

        .otp-label {
            font-size: 16px;
            color: gray;
            padding-left: 5px;
        }

        .input-otp {
            padding: 15px;
            width: 90%;
            border-radius: 10px;
            color: black;
            font-size: 16px;
            border: 2px solid #43302e;
            outline: none;
            font-weight: 600;
        }

        .input-otp:focus {
            border-color: #4CAF50; /* Change border color when focused */
            background-color: white; /* Change background color */
        }

        .set-otp-button {
            display: flex;
            padding: 20px 10px 10px 20px;
            justify-content: flex-end;
        }

        .otp-button {
            border: none;
            outline: none;
            background-color: saddlebrown;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            width: 105px;
            height: 55px;
            cursor: pointer;
        }

        .img-cabin img {
            width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 50%;
        }

        .input-otp::placeholder {
            color: gray;
            font-size: 14px;
            font-style: normal;
            opacity: 1;
            font-weight: 600;
        }

        .resend {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .resend a {
            color: #8B4513;
            text-decoration: none;
            font-weight: 600;
        }

        .resend a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="admin-background-container">
    <img src="../../../.image-cabin/main-asset/4-asset.jpg" alt="background" class="blur">
</div>

<main>
    <div class="otp-container">
        <form action="register.php" method="post">
            <a href="javascript:history.back()" class="otp-back" id="otp-back">←</a>
            <div class="img-cabin">
                <img src="../../../.image-cabin/main-asset/main-asset.jpg" alt="Cabin By Royale Logo">
            </div>

            <div class="title-otp">
                <h3>Confirmation: </h3>
            </div>
            <p>A verification key has been sent to your email for authentication.</p>

            <div class="otp-input">
                <label class="otp-label">OTP ✓
                    <input class="input-otp" required placeholder="Verification code: " type="tel" maxlength="6" name="otp-input">
                </label>
            </div>

            <div class="set-otp-button">
                <button type="submit" class="otp-button" name="verify">
                    Verify
                </button>
            </div>

            <div class="resend">
                <p>Didn't receive code? <a href="resend-otp.php">Resend OTP</a></p>
            </div>
        </form>
    </div>
</main>

<script>
    // You can add JavaScript functionality here if needed
    document.getElementById('otp-back').addEventListener('click', function() {
        window.history.back();
    });
</script>
</body>
</html>