var link = document.getElementById("signupLink");

// When the user clicks on the "Sign Up Now" link, open the modal
link.onclick = function(event) {
    event.preventDefault(); // Prevent default behavior
    signF.style.display = "block";
}

function openModalTerms() {
    document.getElementById('termsModal').style.display = 'block';
}

function closeModalTerms(event) {
    event.preventDefault();
    document.getElementById('termsModal').style.display = 'none';
}

function toggleCheckbox() {
    const checkbox = document.getElementById('accept-checkbox');
    const submitButton = document.getElementById('submit-button');
    if (submitButton) {
        submitButton.disabled = !checkbox.checked;
    }
}

