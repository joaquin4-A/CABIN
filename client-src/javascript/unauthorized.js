// Function to show login required modal
function showLoginRequiredModal() {
    const loginRequiredModal = document.createElement('div');
    loginRequiredModal.className = 'login-required-modal';
    loginRequiredModal.innerHTML = `
        <div class="login-required-content">  
            <div class="icon-login-required">
               <i class='bx bx-block'></i>
            </div>   
            <div class="contents-unauthorized">
                <h2>Login Required!</h2>
                <p>Please log in to access the booking platform.</p>
                <button class="close-login-required"> Close </button>
            </div>      
        </div>
    `;
    document.body.appendChild(loginRequiredModal);

    // Function to close modal and clean up
    function closeModal() {
        loginRequiredModal.remove();
        const login = document.getElementById('login');
        login.classList.add('show-login');
    }

    // Close button functionality
    const closeBtn = loginRequiredModal.querySelector('.close-login-required');
    closeBtn.onclick = closeModal;

    // Window click handler
    loginRequiredModal.addEventListener('click', (event) => {
        if (event.target === loginRequiredModal) {
            closeModal();
        }
    });
}

// Handle scroll to section
function scrollToSection(sectionId) {
    const section = document.querySelector(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Handle nav links
    const navLinks = document.querySelectorAll('.nav_link');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const href = link.getAttribute('href');

            // If it's a same-page anchor link
            if (href.startsWith('#')) {
                scrollToSection(href);
            }
        });
    });

    // Handle book now button separately
    const bookNowBtn = document.querySelector('.nav_book');
    if (bookNowBtn) {
        bookNowBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // PHP will handle the href based on session status
            const href = bookNowBtn.getAttribute('href');
            if (href === '#') {
                showLoginRequiredModal();
            } else {
                window.location.href = href;
            }
        });
    }

    // Handle login toggle
    const loginToggle = document.getElementById('login_toggle');
    if (loginToggle) {
        loginToggle.addEventListener('click', () => {
            const login = document.getElementById('login');
            login.classList.add('show-login');
        });
    }
});

