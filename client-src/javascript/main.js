    /* BACKGROUND HEADER */
    function scrollHeader() {
        const header = document.getElementById("header");
        if (this.scrollY >= 50) header.classList.add('scroll-header'); else header.classList.remove('scroll-header');
    }

    window.addEventListener("scroll", scrollHeader);

    /* SHOW SIDE*/
    const reservation = document.getElementById("side_reservation"),
          myservation = document.getElementById("my_reservation"),
          reservationclose = document.getElementById("side-close");

    if(myservation){
        myservation.addEventListener("click", () => {
            reservation.classList.add("show-side")
        })
    }

    if(reservationclose){
       reservationclose.addEventListener("click", () => {
           reservation.classList.remove("show-side")
       })
    }

    /* SHOW LOGIN */
    const login = document.getElementById("login"),

         mylogin = document.getElementById("login_toggle"),
         loginclose = document.getElementById("close-credentials"),

         signupclose = document.getElementById("signupLink"),
         signinBtn = document.getElementById("retrieve-login"),

        loginAccess = document.querySelector(".login-access");


    // Show login when already account is made by pressing signup retrieve
    if(mylogin){
        mylogin.addEventListener("click", () => {
            login.classList.add("show-login");
        });
    }

    if(loginAccess){
        loginAccess.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent default link behavior
            login.classList.add("show-login");
        });
    }

    if(loginclose){
        loginclose.addEventListener("click", () => {
            login.classList.remove("show-login");
        });
    }

    if(signupclose){
        signupclose.addEventListener("click", () => {
            login.classList.remove("show-login"); // Close the login modal
        });
    }


    if (window.location.search.includes('error=1')) {
        login.classList.add("show-login");
    }


    /* SHOW REGISTER */
    const register = document.getElementById("signupForm");
          registeradd = document.getElementById("signupLink");
          registerrem = document.getElementById("close-register");

    if(registeradd){
        registeradd.addEventListener("click", () => {
            register.classList.add("show-register");
        });
    }

    if(registerrem){
        registerrem.addEventListener("click", () => {
            register.classList.remove("show-register");
            login.classList.remove("show-login");
        });
    }


    // Register contents //
     signF = document.getElementById("signupForm");


    // When the user clicks "Sign In" button in the signup form
    if(signinBtn) {
        signinBtn.addEventListener("click", () => {
            signF.style.display = "none"; // Hide the signup form
            login.classList.add("show-login"); // Show the login form
        })
    }

    // Get references to the elements
    const submitButton = document.getElementById("submit-button");
    const registerForm = document.getElementById("signupForm");
    const otpForm = document.querySelector(".otp-form");
    const otpBackButton = document.getElementById("otp-back");

    // Add event listener to the submit button
    if (submitButton) {
        submitButton.addEventListener("click", function(event) {
            // Prevent the default form submission
            // Hide the registration form
            registerForm.classList.remove("show-register");

            // Show the OTP form
            otpForm.classList.add("show-otp");
        });
    }

    // Add event listener to go back to registration form
    if (otpBackButton) {
        otpBackButton.addEventListener("click", function() {
            // Hide OTP form
            otpForm.classList.remove("show-otp");

            // Show registration form again
            registerForm.classList.add("show-register");
        });
    }

    var home = new Swiper(".mySwiper", {
        spaceBetween: 30,
        pagination: {
            clickable: true,
        },
        simulateTouch: false,
    });

    /* SHOW MENU*/
    const navMenu = document.getElementById("nav-menu"),
          navToggle = document.getElementById("nav-toggle"),
          navResponsive = document.getElementById("nav-close");

    if(navToggle){
       navToggle.addEventListener("click", () => {
            navMenu.classList.add("show-menu")
        })
    }

    if(navResponsive){
        navResponsive.addEventListener("click", () => {
            navMenu.classList.remove("show-menu")
        })
    }

    // Function to open modal
    function openModal(img) {
        const modal = document.getElementById("fullscreenModal");  // Updated to match HTML ID
        const modalImg = document.getElementById("modalImage");

        modal.style.display = "flex";  // Changed to flex to match modal styling
        if (img && img.src) {  // Added check in case img is undefined
            modalImg.src = img.src;
        }
    }

    // Function to close modal
    function closeModal(e) {  // Added event parameter
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        document.getElementById("fullscreenModal").style.display = "none";
    }


    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        // Open modal button
        const openBtn = document.getElementById('openModal');
        if (openBtn) {
            openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        }

        // Close buttons
        const closeBtn = document.getElementById('closeModal');
        const secondaryCloseBtn = document.getElementById('secondaryAction');

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (secondaryCloseBtn) {
            secondaryCloseBtn.addEventListener('click', closeModal);
        }

        // Prevent clicks inside modal from closing it
        const modalContent = document.querySelector('.modal-content');
        if (modalContent) {
            modalContent.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }

        // Close modal when clicking outside
        const modal = document.getElementById('fullscreenModal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(e);
                }
            });
        }
    });

    function displayFileName() {
        const fileInput = document.getElementById('file-upload');
        const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        document.getElementById('file-name').textContent = `Selected file: ${fileName}`;
    }
















