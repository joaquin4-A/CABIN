<?php
session_start();
include 'connect.php';

$emailError = '';
$passwordError = '';

if(isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Prepare the query to find the user by email
    $stmt = $conn->prepare("SELECT * FROM user_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If email exists, check password
    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password matches the one stored in the database
        if($password == $row['password']) {
            $_SESSION['email'] = $email;
            header("Location: user.php");
            exit;
        } else {
            // Password does not match
            $passwordError = 'Incorrect password.';
        }
    } else {
        // Email not found
        $emailError = 'Email not found.';
    }
    $stmt->close();

    // Redirect to index.php with error messages and email
    header("Location: index.php?error=1&email=" . urlencode($email) . "&email_error=" . urlencode($emailError) . "&password_error=" . urlencode($passwordError));
    exit;
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

    <link rel="stylesheet" href="../../../.Stylesheet/swiper-bundle.min.css">
    <script defer src="../../../javascript/main.js"></script>
    <script defer src="../../../javascript/kuula-virtual_tour/kuula.js"></script>
    <script defer src="../../../javascript/onlick.js"></script>
    <script defer src="../../../javascript/home.js"></script>
    <script defer src="../../../javascript/unauthorized.js"></script>
    <script defer src="../../../javascript/forindex.js"></script>


</head>
<body>

        <header class="header" id="header">
            <nav class="nav container">
                <a href="index.php">
                    <img src="../../../.image-cabin/main_logo3.png" class="main-logo" alt="">
                </a>

                <div class="nav_menu" id="nav-menu">
                    <!-- for 768 media screen! --->
                    <i class="responsive bx bx-x" id="nav-close"></i>

                    <ul class="nav_list">
                        <li class="nav_item">
                            <a href="#home" class="nav_link"> Home </a>
                        </li>

                        <li class="nav_item" >
                            <a href="#house"  class="nav_link" > House Rules </a>
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
                            <?php if(isset($_SESSION['email'])): ?>
                                <a href="reservation.php" class="nav_book"> Book Now </a>
                            <?php else: ?>
                                <a href="#" class="nav_book"> Book Now </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <!-- responsive only -->
                <div class="nav_btns">
                    <div class="login_toggle" id="login_toggle">
                        <i class='bx bx-log-in'></i>
                        <span class="tooltip-text">Sign in</span>
                    </div>

                    <div class="nav_toggle" id="nav-toggle">
                        <i class='bx bx-grid-alt' ></i>
                    </div>
                </div>

            </nav>
        </header>

        <div class="login" id="login">
        <i class="bx bx-x login_close" id="close-credentials"></i>
        <h2 class="login_title-center"> Login
            <div class="admin-icon">
                <a href="adminlogin.php">
                <i class='bx bxs-user-account'></i>
                </a>
            </div>
        </h2>

            <form action="index.php" class="login_form grid" method="POST">
                <div class="login_content">
                    <label class="login_label">Email:
                        <input required type="email" class="login_input" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
                    </label>
                    <?php if(isset($_GET['error']) && isset($_GET['email_error'])) { echo "<p class='error-login-contents'>" . htmlspecialchars($_GET['email_error']) . "</p>"; } ?>
                </div>

                <div class="login_content">
                    <label class="login_label">Password:
                        <input required type="password" class="login_input" name="password">
                    </label>
                    <?php if(isset($_GET['error']) && isset($_GET['password_error'])) { echo "<p class='error-login-contents'>" . htmlspecialchars($_GET['password_error']) . "</p>"; } ?>
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
            <form action="register.php" method="post" enctype="multipart/form-data" class="form-register">

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

                    <div class="valid-id-register">
                    <span> Valid ID <p> Maximum file size (5MB): </p></span>
                    </div>
                            <div class="id-identifier">
                                <select name="valid_id" id="valid-id">
                                    <option value=""> Select ID </option>
                                    <option value="passport">Philippine Passport</option>
                                    <option value="drivers_license">Driver’s License</option>
                                    <option value="sss_id">SSS ID</option>
                                    <option value="gsis_id">GSIS ID</option>
                                    <option value="umid">Unified Multi-Purpose ID (UMID)</option>
                                    <option value="postal_id">Postal ID</option>
                                    <option value="philhealth_id">PhilHealth ID</option>
                                    <option value="tin_id">Taxpayer Identification Number (TIN) ID</option>
                                    <option value="voters_id">Voter’s ID</option>
                                    <option value="school_id">School ID</option>
                                    <option value="senior_citizen_id">Senior Citizen ID</option>
                                    <option value="pwd_id">Person with Disability (PWD) ID</option>
                                </select>
                                <span class="error-valid-id" id="idError">Please select a valid ID.</span>
                            </div>

                    <label for="file-upload" class="file-button">Choose File</label>
                    <input required placeholder="" type="file" name="valid_id_image" id="file-upload" class="no-file-chosen" accept=".png,.jpg,.jpeg" onchange="displayFileName()">
                    <div id="file-name" class="file-name"> </div>


                <div class="terms-container">
                    <div class="terms-header" onclick="openModalTerms()">
                        <h2>Terms & Conditions</h2>
                    </div>

                    <div id="termsModal" class="modal-terms-container">
                        <div class="modal-terms-contents">
                            <h2>Terms & Conditions</h2>
                            <div class="modal-terms-main">
                                <h3>User Agreement</h3>
                                <p>* By using our service, you agree to the following terms and conditions.</p>

                                <h3>Privacy Policy</h3>
                                <p>* We respect your privacy and protect your personal information.</p>

                                <h3>Usage Rights</h3>
                                <p>* All content is protected by intellectual property laws.</p>
                            </div>
                            <button class="close-terms" onclick="closeModalTerms(event)"> Close </button>
                        </div>
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

                    <button class="submit-register" name="signUp" id="submit-button" >Next</button>
                    <p class="signin-register">Already have an account? <a href="#" id="retrieve-login">Sign in</a> </p>

                </form>
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
                                <h1>Welcome to <br> Cabin by Royale.</h1>
                                <p>Your serene retreat in Antipolo, offering relaxation and luxury. 🏕️</p>
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

