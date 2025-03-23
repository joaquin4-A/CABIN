
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleBtn');
    const processReserve = document.getElementById('processReserve');

    // Your existing toggle functionality
    setTimeout(() => {
        processReserve.classList.add('open');
        toggleBtn.style.right = '410px';
        toggleBtn.innerHTML = '&#9654;';
    }, 500);

    toggleBtn.addEventListener('click', function () {
        processReserve.classList.toggle('open');

        if (processReserve.classList.contains('open')) {
            toggleBtn.style.right = '410px';
            toggleBtn.innerHTML = '&#9654;';
        } else {
            toggleBtn.style.right = '10px';
            toggleBtn.innerHTML = '&#9664;';
        }
    });

});


window.addEventListener('DOMContentLoaded', (event) => {
    const fileInput = document.getElementById('file-upload-receipt');
    const fileNameElement = document.getElementById('file-name-receipt');

    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const fileName = this.files[0].name;
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // size in MB

            fileNameElement.textContent = `${fileName} (${fileSize} MB)`;
            fileNameElement.style.color = fileSize > 10 ? 'red' : '#666';
        } else {
            fileNameElement.textContent = 'No file chosen';
            fileNameElement.style.color = '#666';
        }
    });
});

const openModalBtn = document.getElementById('openModal');
const fullscreenModal = document.getElementById('fullscreenModal');
const modalImage = document.getElementById('modalImage');
const closeModalBtns = [
    document.getElementById('closeModal'),
    document.getElementById('secondaryAction')
];
const primaryActionBtn = document.getElementById('primaryAction');

// Open Modal
openModalBtn.addEventListener('click', () => {
    fullscreenModal.classList.add('active');
});

// Close Modal Functions
function closeModal() {
    fullscreenModal.classList.remove('active');
    // Ensure image is not zoomed when modal closes
    modalImage.classList.remove('zoomed');
}

// Close modal buttons
closeModalBtns.forEach(btn => {
    btn.addEventListener('click', closeModal);
});

// Close modal on background click
fullscreenModal.addEventListener('click', (event) => {
    if (event.target === fullscreenModal) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && fullscreenModal.classList.contains('active')) {
        closeModal();
    }
});

// Image Zoom Functionality
modalImage.addEventListener('click', () => {
    modalImage.classList.toggle('zoomed');
});

// Primary Action Button (you can customize this)
primaryActionBtn.addEventListener('click', () => {
    alert('Learn More action triggered!');
});

document.addEventListener('DOMContentLoaded', function() {
    const ratesSelect = document.getElementById('rates-select');
    const adultGuests = document.getElementById('adult-guests');

    // Define rates (matching PHP values)
    const rates = {
        'day': 6800,
        'night': 7800,
        'weekdays': 12000,
        'weekends': 12800
    };

    const EXCESS_GUEST_CHARGE = 300;

    // Create total amount container and insert it before the QR button
    const totalAmountContainer = document.createElement('div');
    totalAmountContainer.className = 'total-amount-container';

    // Create total amount display
    const totalAmountDisplay = document.createElement('div');
    totalAmountDisplay.className = 'total-amount-display';
    totalAmountContainer.appendChild(totalAmountDisplay);

    // Insert the container before the trigger-container
    const triggerContainer = document.querySelector('.trigger-container');
    triggerContainer.parentNode.insertBefore(totalAmountContainer, triggerContainer);

    function calculateTotal() {
        const rateType = ratesSelect.value;
        const numAdults = parseInt(adultGuests.value) || 0;

        // Only show total if we have a rate type and at least 1 adult
        if (!rateType || numAdults < 1) {
            totalAmountDisplay.textContent = '';
            totalAmountContainer.style.display = 'none';
            return;
        }

        let totalAmount = rates[rateType];

        // Check for excess adult guests (over 15 pax)
        if (numAdults > 15) {
            // Add base excess charge for going over 15 guests
            totalAmount += EXCESS_GUEST_CHARGE;

            // Add charge for each additional adult over 15
            const excessAdultCharge = (numAdults - 15) * 300;
            totalAmount += excessAdultCharge;
        }

        totalAmountContainer.style.display = 'block';
        totalAmountDisplay.innerHTML = `
            <div class="amount-title">Total Amount:</div>
            <div class="amount-value">₱${totalAmount.toLocaleString()}</div>
        `;
    }

    // Add event listeners
    ratesSelect.addEventListener('change', calculateTotal);
    adultGuests.addEventListener('input', calculateTotal);
});

