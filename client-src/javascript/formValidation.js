// Get form elements
const signupForm = document.querySelector('.form-register');
const inputs = signupForm.querySelectorAll('input');

// Create error display function
function showError(input, message) {
    // Remove any existing error message
    const existingError = input.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    // Create and insert error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    input.parentElement.appendChild(errorDiv);
    input.classList.add('input-error');
}

// Clear error display
function clearError(input) {
    const errorDiv = input.parentElement.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
        input.classList.remove('input-error');
    }
}

// Client-side validation functions
function validatePassword(password) {
    if (password.length < 10) return "Password must be at least 10 characters long";
    if (!/[A-Z]/.test(password)) return "Password must contain at least one uppercase letter";
    if (!/[0-9]/.test(password)) return "Password must contain at least one number";
    if (!/[^a-zA-Z0-9]/.test(password)) return "Password must contain at least one special character";
    return "";
}

function validatePhone(phone) {
    if (!/^\d+$/.test(phone)) return "Phone number must contain only numbers";
    return "";
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) return "Please enter a valid email address";
    return "";
}

// Form submission handler
signupForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    let hasErrors = false;

    // Clear all existing errors
    document.querySelectorAll('.error-message').forEach(error => error.remove());
    inputs.forEach(input => input.classList.remove('input-error'));

    // Validate password
    const password = signupForm.querySelector('input[name="password"]');
    const confirmPassword = signupForm.querySelector('input[name="confirm_password"]');
    const passwordError = validatePassword(password.value);
    if (passwordError) {
        showError(password, passwordError);
        hasErrors = true;
    }
    if (password.value !== confirmPassword.value) {
        showError(confirmPassword, "Passwords do not match");
        hasErrors = true;
    }

    // Validate phone
    const phone = signupForm.querySelector('input[name="phone"]');
    const phoneError = validatePhone(phone.value);
    if (phoneError) {
        showError(phone, phoneError);
        hasErrors = true;
    }

    // Validate email
    const email = signupForm.querySelector('input[name="email"]');
    const emailError = validateEmail(email.value);
    if (emailError) {
        showError(email, emailError);
        hasErrors = true;
    }

    // Check file upload
    const fileUpload = document.getElementById('file-upload');
    if (!fileUpload.files[0]) {
        showError(fileUpload, "Please upload a valid ID");
        hasErrors = true;
    }

    // If no client-side errors, submit the form
    if (!hasErrors) {
        const formData = new FormData(signupForm);

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.text();

            // If the response contains an error message
            if (result.includes('exists') || result.includes('error') || result.includes('invalid')) {
                // Parse the response and show appropriate error
                if (result.includes('Email Address Already Exists')) {
                    showError(email, "Email address already exists");
                } else if (result.includes('Phone number already exists')) {
                    showError(phone, "Phone number already exists");
                } else {
                    // Show general error at the top of the form
                    const generalError = document.createElement('div');
                    generalError.className = 'error-message general-error';
                    generalError.textContent = result;
                    signupForm.insertBefore(generalError, signupForm.firstChild);
                }
            } else {
                // If successful, redirect
                window.location.href = 'index.php';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});

// Real-time validation
inputs.forEach(input => {
    input.addEventListener('input', () => {
        clearError(input);

        switch(input.name) {
            case 'phone':
                const phoneError = validatePhone(input.value);
                if (phoneError) showError(input, phoneError);
                break;
            case 'password':
                const passwordError = validatePassword(input.value);
                if (passwordError) showError(input, passwordError);
                break;
            case 'confirm_password':
                const password = signupForm.querySelector('input[name="password"]');
                if (input.value !== password.value) {
                    showError(input, "Passwords do not match");
                }
                break;
            case 'email':
                const emailError = validateEmail(input.value);
                if (emailError) showError(input, emailError);
                break;
        }
    });
});

const emailInput = document.querySelector('input[name="email"]');
emailInput.addEventListener('blur', async () => {
    if (emailInput.value) {
        const formData = new FormData();
        formData.append('email', emailInput.value);
        formData.append('checkEmail', 'true');

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.status === 'error') {
                showError(emailInput, result.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});

// Add this for phone number checking
const phoneInput = document.querySelector('input[name="phone"]');
phoneInput.addEventListener('blur', async () => {
    if (phoneInput.value) {
        const formData = new FormData();
        formData.append('phone', phoneInput.value);
        formData.append('checkPhone', 'true');

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.status === 'error') {
                showError(phoneInput, result.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
});