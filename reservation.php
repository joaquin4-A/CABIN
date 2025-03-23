<?php

session_start();
include("connect.php");

if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="16x16" href="../../../.image-cabin/favicon-16x16.png">
    <link rel="stylesheet" href="../../../.Stylesheet/book.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Allison&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../.Stylesheet/style.css">
    <link rel="stylesheet" href="../../../.Stylesheet/swiper-bundle.min.css">

    <script defer src="../../../javascript/access.js"></script>
    <script defer src="../../../javascript/booking.js"></script>
    <script defer src="../../../javascript/main.js"></script>
    <script defer src="../../../javascript/onlick.js"></script>

    <title> Book | Cabin by Royale </title>

</head>
<body>
<header class="header" id="header">
    <nav class="nav container">
        <a href="user.php">
            <img src="../../../.image-cabin/main_logo3.png" class="main-logo" alt="">
        </a>

        <div class="nav_menu" id="nav-menu">
            <!-- for 768 media screen! --->
            <i class="responsive bx bx-x" id="nav-close"></i>

            <ul class="nav_list">
                <li class="nav_item">
                    <a href="user.php?section=home" class="nav_link"> Home </a>
                </li>

                <li class="nav_item-book">
                    <a href="#" class="nav_book"> Book Now </a>
                </li>
            </ul>
        </div>
        <!-- responsive only -->
        <div class="nav_btns">
            <div class="user_toggle" id="login_toggle">
                <i class="bx bx-user"></i>
            </div>

            <div class="nav_my_reservation" id="my_reservation">
                <i class='bx bx-calendar-check'></i>
            </div>

            <div class="nav_toggle" id="nav-toggle">
                <i class='bx bx-grid-alt' ></i>
            </div>
        </div>

    </nav>
</header>


<div class="side_reservation " id="side_reservation">
    <i class="bx bx-x side_close" id="side-close"></i>
    <h2 class="side_title-center"> My Reservation </h2>

    <div class="side_container">
        <article class="side_card">
            <div class="side_details">
                <h3 class="side_title"> DATE </h3>
                <span class="side_confirmation"> VIEW DETAILS </span>
            </div>
        </article>
    </div>
</div>

<div class="login" id="login">
    <i class="bx bx-x login_close" id="close-credentials"></i>
    <div class="login-credentials">
        <div class="greetings-credential">

            Hello,
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];

                $query = mysqli_prepare($conn, "SELECT user_register.firstname FROM user_register WHERE user_register.email = ?");

                mysqli_stmt_bind_param($query, "s", $email);
                mysqli_stmt_execute($query);
                mysqli_stmt_bind_result($query, $firstname);

                while (mysqli_stmt_fetch($query)) {
                    echo $firstname . "!";
                }
                mysqli_stmt_close($query);
            }
            ?>

        </div>
        <div class="exit-user">
            <a href="exit.php" class="logout-link" onsubmit="showLoading(); setTimeout(hideLoading, 2000);">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

<div class="login" id="login">
    <i class="bx bx-x login_close" id="close-credentials"></i>
    <h2 class="login_title-center"> Login
        <div class="admin-icon">
            <a href="adminlogin.php">
                <i class='bx bxs-user-account'></i>
            </a>
        </div>
    </h2>

    <form action="login.php" class="login_form grid" method="POST" onsubmit="showLoading(); setTimeout(hideLoading, 2000);">
        <div class="login_content">
            <label for="" class="login_label">Email:
                <input required type="email" class="login_input" name="email">
            </label>
        </div>

        <div class="login_content">
            <label for="" class="login_label">Password:
                <input required type="password" class="login_input" name="password">
            </label>
        </div>

        <div class="button-login">
            <input type="submit" name="signIn" value="Sign in">
        </div>

        <div>
            <p class="signup">No account? <a href="" id="signupLink">Sign up</a> now</p>
        </div>

    </form>
</div>

<div class="register-form" id="signupForm">
    <span class="close-register" id="close-register">&times;</span>
    <form method="post" action="register.php" class="form-register" onsubmit="showLoading(); setTimeout(hideLoading, 2000);">

        <p class="title-register"> Create Account </p>
        <p class="message-register">Signup now and to get full access. </p>
        <div class="flex-register">

            <label >
                <input required placeholder="" type="text" class="input-register" name="firstname">
                <span>Firstname:</span>
            </label>

            <label>
                <input required placeholder="" type="text" class="input-register" name="lastname">
                <span>Lastname:</span>
            </label>

        </div>

        <label>
            <input required placeholder="" type="email" class="input-register-main" name="email">
            <span>Email:</span>
        </label >

        <label>
            <input required  maxlength="11"  placeholder="" type="tel" class="input-register-main" name="phone">
            <span>Mobile Number:</span>
        </label >

        <label >
            <input required placeholder="" type="password" class="input-register-main" name="password">
            <span>Password:</span>
        </label>
        <label>
            <input required placeholder="" type="password" class="input-register-main" name="confirm_password">
            <span>Confirm password:</span>
        </label>

        <div class="valid-id-register"> <span>Valid ID</span> </div>
        <label for="file-upload" class="file-button">Choose File</label>
        <input required placeholder="" type="file" id="file-upload" class="no-file-chosen" accept="image/*" onchange="displayFileName()">
        <div id="file-name" class="file-name"></div>

        <div class="terms-container">
            <div class="terms-header" onclick="toggleTerms()">
                <h2>Terms & Conditions</h2>
                <span id="toggle-icon">▼</span>
            </div>

            <div id="terms-content" class="terms-content">
                <h3> User Agreement </h3>
                <p>- By using our service, you agree to the following terms and conditions.</p>

                <h3> Privacy Policy </h3>
                <p>- We respect your privacy and protect your personal information.</p>

                <h3> Usage Rights </h3>
                <p>- All content is protected by intellectual property laws.</p>
            </div>

            <div class="terms-checkbox">
                <input
                        type="checkbox"
                        id="accept-checkbox"
                        onchange="toggleCheckbox()"
                >
                <label for="accept-checkbox">I have read and agree to the Terms and Conditions.</label>
            </div>
        </div>

        <button class="submit-register" name="signUp" id="submit-button" disabled>Submit</button>
        <p class="signin-register">Already have an account? <a href="#" id="retrieve-login">Sign in</a> </p>

    </form>
</div>

<!-- ACCOUNT LOADING CREATION -->
<div id="loading" class="spinner"></div>


        <main>

            <section id="reservation" class="reservation-class">

                <div class="reservation-wrapper">
                    <div class="reservation-title-container" onclick="toggleDropdown();">
                        <h2 class="reservation-title">Reserve a Staycation </h2>
                        <i class='bx bx-detail dropdown-icon'></i>
                    </div>

                    <div class="line-separator"></div>

                    <div class="make-reservation-contents hidden">
                        <div class="reservation-inner-contents">
                            <h3>Check Availability</h3>
                            <p>Begin by reviewing the availability of your desired dates on our calendar.</p>

                            <h3>Contact Us</h3>
                            <p>For reservations, kindly reach out to us via phone at (121-313-12313) or through our online chat for assistance with the booking process.</p>

                            <h3>Confirm Reservation</h3>
                            <p>Once your reservation is confirmed, a receipt will be available on your "My Reservations" dashboard.
                                This receipt can be downloaded for your reference.</p>

                            <h3 class="important-notice">!! Important Notice !!</h3>
                            <p>Please ensure that you have received a confirmed reservation before making any payments. Deposits are non-refundable.</p>
                        </div>
                    </div>
                </div>

                <div class="toggle-arrow" id="toggleBtn">
                    &#9664; <!-- Left-pointing arrow -->
                </div>

                <div class="process-reservation" id="processReserve">
                    <h2 class="process-title"> Booking </h2>

                    <form class="process-information" id="reservationForm" method="post" action="process-reservation.php" enctype="multipart/form-data" onsubmit="showLoading(); setTimeout(hideLoading, 2000" required);>

                        <div class="transaction-process">
                            <label for="" class="transaction-label">Email:
                                <input required type="email" class="transaction-input" name="email" id="email">
                            </label>
                        </div>

                        <div class="date-group">
                            <div class="date-input">
                                <label for="check-in">Check In:</label>
                                <input type="date" id="check-in" name="check-in" required>
                            </div>
                            <div class="date-input">
                                <label for="check-out">Check Out:</label>
                                <input type="date" id="check-out" name="check-out" required>
                            </div>
                        </div>

                        <div class="rates-group">
                            <select id="rates-select" name="rates-select" required>
                                <option value="" disabled selected>Select Rates:</option>
                                <option value="day">DAY 👉🏼 (9AM-5pm)</option>
                                <option value="night">NIGHT 👉🏼 (8PM-6AM)</option>
                                <option value="weekdays">WEEKDAYS (9AM-6AM/8PM-5PM) 21HRS 🌓</option>
                                <option value="weekends">WEEKENDS (9AM-6AM/8PM-5PM) 21HRS 🌓</option>
                            </select>
                        </div>

                        <div class="guest-group">
                            <div>
                                <label for="adult-guests" class="form-label">Adults:</label>
                                <input type="number" id="adult-guests" class="form-input" min="1" name="adult-guests" required>
                            </div>
                            <div>
                                <label for="child-guests" class="form-label">Kids:</label>
                                <input type="number" id="child-guests" class="form-input" min="0" max="10" name="child-guests" required>
                            </div>
                        </div>



                        <div class="trigger-container">
                            <a href="#" id="openModal" class="trigger-link">QR CODE</a>
                        </div>

                        <div class="fullscreen-modal" id="fullscreenModal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title">QR CODE</h2>
                                    <button class="close-btn" id="closeModal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <img src="../../../.image-cabin/main-asset/CABIN-OR-CODE.png" alt="Modal Image" class="modal-image" id="modalImage">
                                    <p class="modal-description">
                                        !! Important Notice !!
                                        Before making any payments, please make sure you have a confirmed reservation with us. Deposits made are non-refundable.
                                        To pay, simply scan the QR code for a secure and easy payment process.
                                    </p>
                                    <div class="modal-actions">
                                        <button class="modal-btn modal-btn-primary" id="primaryAction">Learn More</button>
                                        <button class="modal-btn modal-btn-secondary" id="secondaryAction">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="process-receipt">
                            <label for="file-upload-receipt" class="process-upload-label">
                                Upload Receipt:
                            </label>

                            <input
                                    type="file"
                                    id="file-upload-receipt"
                                    class="process-file-input"
                                    accept=".jpg,.jpeg,.png"
                                    name="file-upload-receipt"
                            >

                            <span id="file-name-receipt" class="file-name">
                            No file chosen
                            </span>
                            </div>


                        <div class="special-request-container">
                            <label for="special-request" class="special-request-label">
                                Special Request:
                            </label>
                            <textarea
                                    id="special-request"
                                    class="special-request-textarea"
                                    placeholder="Enter your special request here"
                                    name="special-request"
                            ></textarea>
                        </div>

                        <div>
                            <button class="process-transaction">Process</button>
                        </div>

                    </form>
                </div>

                <div class="calendar-container">
                    <div class="date-search">
                        <input type="date" id="date-search-input" placeholder="Select Check-in Date">
                        <button class="date-search-btn" id="date-search-btn">Search</button>
                    </div>
                    <div class="error-message" id="error-message">
                        Please select a future date.
                    </div>

                    <div class="calendar">
                        <div class="calendar-header">
                            <div class="occupied-toggle">
                                <label class="toggle-switch">
                                    <input id="check" type="checkbox">
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="occupied-toggle-text">Show Occupied</span>
                            </div>
                            <div class="calendar-header-month" id="calendar-month">
                                <!-- Month and year will be dynamically populated -->
                            </div>
                        </div>

                        <div class="calendar-grid" id="calendar-days-header">
                            <!-- Day names will be dynamically populated -->
                        </div>
                        <div class="calendar-grid" id="calendar-days">
                            <!-- Days will be dynamically populated -->
                        </div>
                    </div>
                </div>

            </section>
        </main>


       <!-- FOOTER  -->
       <footer class="footer section">
           <div class="footer_container grid">
               <div class="footer_content">
                   <a href="#" class="footer_logo">
                       <img src="../../../.image-cabin/main_logo3.png" class="footer_main-logo" alt="">
                   </a>
                   <p class="footer_description"> Enjoy the Stay <br> of your life. </p>
               </div>
               <span class="footer_copy"> &#169 CabinByRoyale. All rights reserved.</span>
       </footer>

<script src="../../../javascript/swiper-bundle.min.js"></script>

</body>
</html>
