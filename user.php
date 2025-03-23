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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Home | Cabin by Royale</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../../.image-cabin/favicon-16x16.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Allison&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../.Stylesheet/style.css">
    <link rel="stylesheet" href="../../../.Stylesheet/user.css">

    <link rel="stylesheet" href="../../../.Stylesheet/swiper-bundle.min.css">
    <script defer src="../../../javascript/main.js"></script>
    <script defer src="../../../javascript/kuula-virtual_tour/kuula.js"></script>
    <script defer src="../../../javascript/home.js"></script>

</head>
<body>

<header class="header" id="header">
    <nav class="nav container">

        <a href="user.php" class="nav_logo">
            <img src="../../../.image-cabin/main_logo3.png" class="main-logo" alt="">
        </a>

        <div class="nav_menu" id="nav-menu">
            <!-- for 768 media screen! --->
            <i class="responsive bx bx-x" id="nav-close"></i>

            <ul class="nav_list">
                <li class="nav_item">
                    <a href="#home" class="nav_link" > Home </a>
                </li>

                <li class="nav_item">
                    <a href="#house" class="nav_link"> House Rules </a>
                </li>

                <li class="nav_item">
                    <a href="#overview" class="nav_link"> Overview </a>
                </li>

                <li class="nav_item">
                    <a href="#about" class="nav_link"> About </a>
                </li>

                <li class="nav_item">
                    <a href="#contact" class="nav_link"> Contact Us </a>
                </li>

                <li class="nav_item-book">
                    <a href="reservation.php" class="nav_book"> Book Now </a>
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

<!--  NOTE IN THE USER.PHP LOGIN IS SAME AS THE INDEX !-->
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
            <a href="exit.php" class="logout-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

<main>

    <section id="first-background-image" class="first-background">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                <!-- LANDING PAGE -->
                <section class="swiper-slide" id="home">
                    <section class="landing-page">
                        <div class="landing-container" id="landing">
                            <div class="text-landing">
                                <h1>Welcome to <br>Cabin by Royale.</h1>
                                <p>Your serene retreat in Antipolo, offering relaxation and luxury.</p>
                            </div>
                            <div class="image-landing">
                                <img src="../../../.image-cabin/main-asset/main-asset.jpg" alt="Placeholder Image">
                            </div>
                        </div>
                    </section>
                </section>

                <!-- CONTACT US SWIPER -->
                <section class="swiper-slide" id="contact">
                    <div class="contact_us-container">
                        <div class="contact-box">
                            <div class="contact-left"> </div>

                            <div class="contact-right">
                                <h2 class="contact-title"> Contact Us </h2>

                                <div class="contact-info">
                                    <div class="info-left">
                                        <p><strong>Address:</strong> Staycation Road, Antipolo, Rizal </p>
                                        <p><strong>Email:</strong> cabinbyroyale@gmail.com </p>
                                        <p><strong>Phone:</strong> +63 927 180 7048 </p>
                                    </div>
                                </div>

                                <label>
                                    <input type="text" class="field" placeholder="NAME:  ">
                                    <input type="text" class="field" placeholder=" EMAIL: ">
                                    <input type="text" class="field" placeholder=" PHONE: ">
                                    <textarea class="field area" placeholder=" MESSAGE: "></textarea>
                                </label>

                                <button class="contact-btn"> Send </button>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="card-section" id="house">
        <div class="card-container">
            <div class="card">
                <h2 class="card-title">House Rules</h2>

                <div class="content">
                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/no-weapons.png" class="rules-icon" alt="">
                        <p class="para">
                            No Weapons
                        </p>
                    </div>

                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/no-littering.png" class="rules-icon" alt="">
                        <p class="para">
                            No littering,
                            Please clean as you go
                        </p>
                    </div>

                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/clock.png" class="rules-icon" alt="">
                        <p class="para">
                            Please adhere to our
                            check-in and check-out times
                        </p>
                    </div>

                </div>


                <div class="content">
                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/audience.png" class="rules-icon" alt="">
                        <p class="para">
                            Maximum of 15 persons are
                            allowed to stay in Cabin
                        </p>
                    </div>

                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/no-smoking.png" class="rules-icon" alt="">
                        <p class="para">
                            No smoking inside the Cabin
                        </p>
                    </div>

                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/noise.png" class="rules-icon" alt="">
                        <p class="para">
                            Disturbing noise must be<br>
                            turned off before 10pm
                        </p>
                    </div>
                </div>

                <div class="content">
                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/destroy.png" class="rules-icon" alt="">
                        <p class="para">
                            Please do not break any property
                        </p>
                    </div>

                    <div class="item-content">
                        <img src="../../../.image-cabin/house-rules/no-fire.png" class="rules-icon" alt="">
                        <p class="para">
                            Be responsible to put
                            out your grill fires
                        </p>
                    </div>

                </div>

                <a href="https://drive.google.com/file/d/1ZluCNrerl5LbmAXjBEF4i4kGn_gPjLqf/view?usp=sharing" download>
                    <button  id="downloadButtonRules" title="Download House-Rules PDF?"> Download PDF</button>
                </a>
            </div>

    </section>

    <section id="second-background-image" class="second-background">
        <section class="gallery" id="overview">
            <h2 class="gallery-title"> Overview </h2>

            <div class="gallery-container">
                <div class="gallery-card-event">
                    <div class="gallery-content">
                        <p class="gallery-heading">Event Setup<br>Previews
                        </p>
                        <p class="gallery-para">
                        </p>
                        <button class="gallery-btn" id="openFullscreen-event">See more</button>
                    </div>
                </div>

                <div class="gallery-card-cabin">
                    <div class="gallery-content">
                        <p class="gallery-heading">Virtual <br> Tour
                        </p>
                        <p class="gallery-para">
                        </p>
                        <button class="gallery-btn" id="openFullscreen-virtual">See more</button>
                    </div>
                </div>

                <div class="gallery-card-promo">
                    <img src="../../../.image-cabin/main-asset/INFORMATION-CLIENT.jpg" alt="Gallery Image">
                    <button class="view-button" onclick="openModal(this.previousElementSibling)">View</button>
                </div>

                <div id="fullscreenModal" class="modal">
                    <span class="close-promo" onclick="closeModal()">&times;</span>
                    <img class="modal-content" id="modalImage" alt="" src="">
                </div>

            </div>
        </section>

        <div class="amenity-line-container">
            <div class="amenity-line"></div>
            <a href="https://drive.google.com/file/d/1NLdARpF-bPxN_osKAmXtkFPPUZ9VXr0r/view?usp=sharing" download>
                <button class="cabin-amenity-button">Cabin Amenities</button>
            </a>
        </div>
    </section>

    <!-- Company Overview Section -->
    <section class="company-overview" id="about">
        <div class="about-container">
            <!-- Company Overview Section -->
            <div class="about-inner-container">
                <div class="left-content">
                    <!-- Left content goes here -->
                    <h2 class="about-title"> About us </h2>
                    <p>Welcome to Cabin by Royale, your perfect getaway in Antipolo! Our cozy,
                        fully air-conditioned cabin is designed for comfort and relaxation. Whether you're planning a family vacation,
                        a romantic retreat, or a weekend escape with friends, our cabin offers everything you need to unwind.
                        Enjoy the peaceful surroundings and make lasting memories in a tranquil setting,
                        just a short drive from the city.
                        <br><br> <br>
                        We deeply appreciate the trust and support of our customers. Your satisfaction is our top priority,
                        and we’re honored to be part of your memorable experiences.
                        Thank you for choosing Cabin By Royale, and we look forward to welcoming you back soon!
                    </p>

                    <div class="social-overlay">
                        <a href="" class="facebook">
                            <i class='bx bxl-facebook-circle' ></i>
                        </a>

                        <a href="" class="instagram">
                            <i class='bx bxl-instagram' ></i>
                        </a>
                    </div>

                </div>
                <div class="right-content">
                    <div class="image-container">
                        <img src="../../../.image-cabin/main-asset/aboutus-bg-inner.jpg" alt="">

                        <div class="overlay-content">
                            <!-- Right content goes here inside the image -->
                            <div class="overlay-left">
                                <p>Our Vision is to Provide a Calm and Unparalleled Staycation Experience.</p>
                                <a href="#overview">
                                    <img alt src="../../../.image-cabin/main-asset/16-asset.jpg">
                                </a>
                                <div class="text-hover"> View more </div>
                            </div>
                            <div class="overlay-right">

                                <div class="feedback-container">
                                    <h2>How was your experience?</h2>
                                    <div class="emoji-container">
                                        <button class="emoji-btn" onclick="selectEmoji(this, 1)">😢</button>
                                        <button class="emoji-btn" onclick="selectEmoji(this, 2)">😕</button>
                                        <button class="emoji-btn" onclick="selectEmoji(this, 3)">😐</button>
                                        <button class="emoji-btn" onclick="selectEmoji(this, 4)">😊</button>
                                        <button class="emoji-btn" onclick="selectEmoji(this, 5)">😃</button>
                                    </div>
                                    <input type="hidden" id="selected-value" name="rating" value="0">
                                    <textarea class="feedback-text" placeholder="Please share your feedback with us..."></textarea>
                                    <button class="submit-btn" onclick="submitFeedback()">Submit </button>
                                </div>

                                <div class="other-company">
                                    <h3>Associates</h3>

                                    <div class="associates-container">
                                        <a href="" class="house-royale">
                                            <img alt src="../../../.image-cabin/main-asset/houseofroyale.jpg">
                                        </a>
                                        <a href="" class="drizzled">
                                            <img alt src="../../../.image-cabin/main-asset/drizzledchicken.jpg">
                                        </a>
                                        <a href="" class="maico">
                                            <img alt src="../../../.image-cabin/main-asset/maico.jpg">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Other Businesses -->
    <section class="team-section">

    </section>


</main>
<!-- FOOTER -->
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
<a href="#" class="scroll-up" id="scroll-up">
    <i class="bx bx-up-arrow-alt scroll-up_icon"></i>
</a>

<script src="../../../javascript/swiper-bundle.min.js"></script>


</body>
</html>

