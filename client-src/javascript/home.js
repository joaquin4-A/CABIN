window.addEventListener('DOMContentLoaded', () => {
    const landingContainer = document.querySelector('.landing-container');
    const contactUs = document.querySelector('.contact_us-container');
    const navLinks = document.querySelectorAll('.nav_link');
    const bookNowLink = document.querySelector('.nav_book');
    const delay = 600;

    // Set first link as active by default if none is active
    if (!document.querySelector('.nav_link.active')) {
        navLinks[0].classList.add('active');
    }

    // Animation functions
    const triggerAnimationLanding = () => {
        if (landingContainer) {
            landingContainer.classList.remove('show');
            landingContainer.style.visibility = 'hidden';
            setTimeout(() => {
                landingContainer.style.visibility = 'visible';
                landingContainer.classList.add('show');
            }, delay);
        }
    };

    const triggerAnimationContact = () => {
        if (contactUs) {
            contactUs.classList.remove('show');
            contactUs.style.visibility = 'hidden';
            setTimeout(() => {
                contactUs.style.visibility = 'visible';
                contactUs.classList.add('show');
            }, delay);
        }
    };

    // Initial animation
    if (landingContainer) {
        setTimeout(() => {
            landingContainer.classList.add('show');
        }, delay);
    }

    // Handle all navigation clicks
    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const href = this.getAttribute('href');

            // Only handle active states if Book Now wasn't clicked
            if (!bookNowLink.classList.contains('clicked')) {
                navLinks.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');

                // Handle animations
                if (href === '#home') {
                    triggerAnimationLanding();
                } else if (href === '#contact') {
                    triggerAnimationContact();
                }

                // Scroll to section
                const targetSection = document.querySelector(href);
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        // If the .about-container is in the viewport and hasn't been animated yet
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            // Once the animation is triggered, stop observing this element
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.5
});

// Start observing the .about-container
const aboutContainer = document.querySelector('.about-container');
observer.observe(aboutContainer);

// for feedback
let selectedRating = 0;

function selectEmoji(element, value) {
    // Remove 'selected' class from all emojis
    document.querySelectorAll('.emoji-btn').forEach(btn => {
        btn.classList.remove('selected');
    });

    // Add 'selected' class to clicked emoji
    element.classList.add('selected');

    // Store the value
    selectedRating = value;
    document.getElementById('selected-value').value = value;
}

function submitFeedback() {
    const feedback = document.querySelector('.feedback-text').value;
    console.log('Rating:', selectedRating);
    console.log('Feedback:', feedback);
    // Here you would typically send this data to your server
    alert(`Thank you for your feedback! Rating: ${selectedRating}`);
}

function scrollUp () {
    const scrollUp = document.getElementById('scroll-up');
    if(this.scrollY >= 350) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll');
}
    window.addEventListener('scroll', scrollUp);






