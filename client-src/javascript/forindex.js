document.getElementById('valid-id').addEventListener('change', function() {
    const validId = this.value;
    const errorMessage = document.getElementById('idError');

    // Show error if no valid ID is selected
    if (!validId) {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
});
