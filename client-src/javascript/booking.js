function toggleDropdown() {
    const dropdownContents = document.querySelector('.make-reservation-contents');
    const dropdownIcon = document.querySelector('.dropdown-icon');

    dropdownContents.classList.toggle('hidden');
    dropdownIcon.classList.toggle('rotated');
}

class ReservationCalendar {
    constructor() {
        this.currentDate = new Date();
        this.dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        this.occupiedDates = [
            // Example occupied dates (you can modify this)
            new Date(2024, 0, 15),
            new Date(2024, 0, 16),
            new Date(2024, 0, 20)
        ];

        this.initializeEventListeners();
        this.renderCalendar();
    }

    initializeEventListeners() {
        const occupiedToggle = document.getElementById('check');
        const calendar = document.querySelector('.calendar');

        occupiedToggle.addEventListener('change', (e) => {
            calendar.classList.toggle('show-occupied', e.target.checked);
        });

        const dateSearchBtn = document.getElementById('date-search-btn');
        const dateSearchInput = document.getElementById('date-search-input');
        const errorMessage = document.getElementById('error-message');

        dateSearchBtn.addEventListener('click', () => {
            // Reset error message
            errorMessage.style.display = 'none';

            // Get selected date
            const selectedDateInput = dateSearchInput.value;

            if (!selectedDateInput) {
                errorMessage.textContent = 'Please select a date.';
                errorMessage.style.display = 'block';
                return;
            }

            const selectedDate = new Date(selectedDateInput);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Validate date is in the future
            if (selectedDate < today) {
                errorMessage.textContent = 'Please select a future date.';
                errorMessage.style.display = 'block';
                return;
            }

            // Update calendar
            this.currentDate = selectedDate;
            this.renderCalendar();
        });
    }

    renderCalendar() {
        const monthDisplay = document.getElementById('calendar-month');
        const daysHeaderDisplay = document.getElementById('calendar-days-header');
        const daysDisplay = document.getElementById('calendar-days');

        // Clear previous content
        monthDisplay.innerHTML = this.currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
        daysHeaderDisplay.innerHTML = '';
        daysDisplay.innerHTML = '';

        // Add day names header
        this.dayNames.forEach(dayName => {
            const dayNameCell = document.createElement('div');
            dayNameCell.classList.add('calendar-day-name');
            dayNameCell.textContent = dayName;
            daysHeaderDisplay.appendChild(dayNameCell);
        });

        // Get first day of the month and total days in month
        const firstDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1);
        const lastDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0);

        // Add empty cells for days before first day
        for (let i = 0; i < firstDay.getDay(); i++) {
            daysDisplay.appendChild(document.createElement('div'));
        }

        // Create day cells
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('calendar-day');
            dayCell.textContent = day;

            // Highlight today's date
            const checkDate = new Date(
                this.currentDate.getFullYear(),
                this.currentDate.getMonth(),
                day
            );

            if (this.isToday(checkDate)) {
                dayCell.classList.add('today');
            }

            // Mark occupied dates
            if (this.isDateOccupied(checkDate)) {
                dayCell.classList.add('occupied');
            }

            daysDisplay.appendChild(dayCell);
        }
    }

    isToday(date) {
        const today = new Date();
        return date.getDate() === today.getDate() &&
            date.getMonth() === today.getMonth() &&
            date.getFullYear() === today.getFullYear();
    }

    isDateOccupied(date) {
        return this.occupiedDates.some(occupiedDate =>
            occupiedDate.getTime() === date.getTime()
        );
    }
}

// Initialize the calendar when the page loads
document.addEventListener('DOMContentLoaded', () => {
    new ReservationCalendar();
});










