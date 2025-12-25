// Booking Calendar JavaScript

// Current calendar state
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedStartDate = null;
let selectedEndDate = null;
let map;
let geocoder;
let activeMapInputId = null;
let currentMarker = null;
const studentMallJB = { lat: 1.558557, lng: 103.636647 };

// Time state
let startTime = { hour: 7, minute: 0, period: 'AM' };
let endTime = { hour: 7, minute: 0, period: 'PM' };
let currentTimeSelection = 'start';
let timeMode = 'hour';
let tempTime = { hour: 7, minute: 0, period: 'AM' };

// Sample booking data
const bookingData = {
    '2025-12-9': 'whole-day',
    '2025-12-10': 'whole-day',
    '2025-12-11': 'half-day',
    '2025-12-12': 'half-day',
    '2025-12-13': 'half-day',
    '2025-12-16': 'unavailable',
    '2025-12-17': 'few-hours',
    '2025-12-18': 'few-hours',
    '2025-12-19': 'unavailable',
    '2025-12-22': 'few-hours',
};

// Initialize calendar on page load
document.addEventListener('DOMContentLoaded', function () {
    initializeCalendar();
    initializeClockFace();
    loadFromUrlParams();
});

// Initialize calendar
function initializeCalendar() {
    document.getElementById('monthSelect').value = currentMonth;
    document.getElementById('yearSelect').value = currentYear;
    renderCalendar();
}

// Load data from URL parameters
function loadFromUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);

    // 1. Set Car
    if (urlParams.has('car')) {
        const carSelect = document.getElementById('carSelect');
        if (carSelect) {
            // Check if option exists, if not maybe we need to wait or it's invalid
            // For now assuming it matches loop values
            // Check if the value is actually the plate number or if we need to map from request('car') which is plate_no
            carSelect.value = urlParams.get('car');
        }
    }

    // 2. Set Locations
    if (urlParams.has('destination')) document.getElementById('destination').value = urlParams.get('destination');
    if (urlParams.has('Pickup')) document.getElementById('pickupLocation').value = urlParams.get('Pickup');
    if (urlParams.has('Return')) document.getElementById('returnLocation').value = urlParams.get('Return');

    // 3. Set Dates and Times
    if (urlParams.has('start_time') && urlParams.has('end_time')) {
        try {
            const start = new Date(urlParams.get('start_time'));
            const end = new Date(urlParams.get('end_time'));

            if (!isNaN(start) && !isNaN(end)) {
                // Set Global Date Variables
                selectedStartDate = start;
                selectedEndDate = end;

                // Set Month/Year to Start Date
                currentMonth = start.getMonth();
                currentYear = start.getFullYear();
                document.getElementById('monthSelect').value = currentMonth;
                document.getElementById('yearSelect').value = currentYear;

                // Set Global Time Variables
                startTime = extractTimeFromDate(start);
                endTime = extractTimeFromDate(end);

                // Update UI
                renderCalendar();
                updateDurationField();
            }
        } catch (e) {
            console.error("Error parsing dates from URL", e);
        }
    }
}

function extractTimeFromDate(date) {
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const period = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'

    return {
        hour: hours,
        minute: minutes,
        period: period
    };
}

// Render calendar
function renderCalendar() {
    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';

    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const startingDay = firstDay.getDay();
    const totalDays = lastDay.getDate();

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    for (let i = 0; i < startingDay; i++) {
        const emptyDay = document.createElement('button');
        emptyDay.className = 'calendar-day hidden';
        emptyDay.disabled = true;
        calendarDays.appendChild(emptyDay);
    }

    for (let day = 1; day <= totalDays; day++) {
        const dayButton = document.createElement('button');
        dayButton.className = 'calendar-day';
        dayButton.textContent = day;

        const dateObj = new Date(currentYear, currentMonth, day);
        const dateKey = `${currentYear}-${currentMonth + 1}-${day}`;

        if (dateObj < today) {
            dayButton.classList.add('disabled');
            dayButton.disabled = true;
        } else {
            const status = bookingData[dateKey];
            if (status) {
                switch (status) {
                    case 'whole-day':
                        dayButton.classList.add('whole-day-booked');
                        dayButton.disabled = true;
                        dayButton.title = 'Fully booked for the whole day';
                        break;
                    case 'half-day':
                        dayButton.classList.add('half-day-booked');
                        dayButton.title = 'Half-day booked - limited availability';
                        break;
                    case 'few-hours':
                        dayButton.classList.add('few-hours-booked');
                        dayButton.title = 'Few hours booked - mostly available';
                        break;
                    case 'unavailable':
                        dayButton.classList.add('unavailable');
                        dayButton.disabled = true;
                        dayButton.title = 'Not available';
                        break;
                }
            }

            if (dateObj.getTime() === today.getTime()) {
                dayButton.classList.add('today');
            }

            if (selectedStartDate && dateObj.getTime() === selectedStartDate.getTime()) {
                dayButton.classList.add('selected-start');
            }
            if (selectedEndDate && dateObj.getTime() === selectedEndDate.getTime()) {
                dayButton.classList.add('selected-end');
            }
            if (selectedStartDate && selectedEndDate &&
                dateObj > selectedStartDate && dateObj < selectedEndDate) {
                dayButton.classList.add('selected-range');
            }

            if (!dayButton.disabled) {
                dayButton.addEventListener('click', () => selectDate(dateObj, day));
            }
        }

        calendarDays.appendChild(dayButton);
    }

    const remainingCells = 7 - ((startingDay + totalDays) % 7);
    if (remainingCells < 7) {
        for (let i = 0; i < remainingCells; i++) {
            const emptyDay = document.createElement('button');
            emptyDay.className = 'calendar-day disabled';
            emptyDay.textContent = i + 1;
            emptyDay.disabled = true;
            calendarDays.appendChild(emptyDay);
        }
    }
}

function getAddress(latLng) {
    geocoder.geocode({ location: latLng }, function (results, status) {
        if (status === "OK") {
            if (results[0]) {
                document.getElementById(activeMapInputId).value = results[0].formatted_address;
            } else {
                document.getElementById(activeMapInputId).value = latLng.lat() + ", " + latLng.lng();
            }
        } else {
            alert("Geocoder failed: " + status);
        }
    });
}

function placeMarker(location) {
    if (currentMarker) {
        currentMarker.setPosition(location);
    } else {
        currentMarker = new google.maps.Marker({
            position: location,
            map: map,
        });
    }
}

function openMapPicker(inputId) {
    activeMapInputId = inputId;
    const modal = document.getElementById('mapModal');
    modal.classList.add('active');

    if (!map) {
        map = new google.maps.Map(document.getElementById("mapCanvas"), {
            center: studentMallJB,
            zoom: 16,
        });

        geocoder = new google.maps.Geocoder();

        currentMarker = new google.maps.Marker({
            position: studentMallJB,
            map: map,
        });

        map.addListener("click", function (event) {
            placeMarker(event.latLng);
            getAddress(event.latLng);
        });
    } else {
        google.maps.event.trigger(map, "resize");
        map.setCenter(studentMallJB);
        if (currentMarker) currentMarker.setPosition(studentMallJB);
        else {
            currentMarker = new google.maps.Marker({
                position: studentMallJB,
                map: map,
            });
        }
    }
}

function closeMapPicker() {
    document.getElementById('mapModal').classList.remove('active');
}

function confirmMapSelection() {
    if (!currentMarker) {
        alert("Please click on the map to select a location.");
        return;
    }
    const position = currentMarker.getPosition();
    getAddress(position);
    closeMapPicker();
}

function selectDate(date, day) {
    if (!selectedStartDate || (selectedStartDate && selectedEndDate)) {
        selectedStartDate = date;
        selectedEndDate = null;
        currentTimeSelection = 'start';
        tempTime = { ...startTime };
        showTimePicker('Select start time');
    } else if (date >= selectedStartDate) {
        selectedEndDate = date;
        currentTimeSelection = 'end';
        tempTime = { ...endTime };
        showTimePicker('Select end time');
    } else {
        selectedStartDate = date;
        selectedEndDate = null;
        currentTimeSelection = 'start';
        tempTime = { ...startTime };
        showTimePicker('Select start time');
    }

    renderCalendar();
}

function initializeClockFace() {
    const clockFace = document.getElementById('clockFace');
    const radius = 85;
    const centerX = 128;
    const centerY = 128;

    clockFace.querySelectorAll('.clock-number').forEach(n => n.remove());

    for (let i = 1; i <= 12; i++) {
        const angle = (i * 30 - 90) * (Math.PI / 180);
        const x = centerX + radius * Math.cos(angle);
        const y = centerY + radius * Math.sin(angle);

        const numberEl = document.createElement('div');
        numberEl.className = 'clock-number';
        numberEl.dataset.value = i;
        numberEl.style.left = `${x}px`;
        numberEl.style.top = `${y}px`;
        numberEl.style.transform = 'translate(-50%, -50%)';

        numberEl.onclick = () => selectClockNumber(i);
        clockFace.appendChild(numberEl);
    }
}

function selectClockNumber(value) {
    if (timeMode === 'hour') {
        tempTime.hour = value;
        updateClockSelection();
        setTimeout(() => {
            setTimeMode('minute');
        }, 300);
    } else {
        let mins = value * 5;
        tempTime.minute = mins === 60 ? 0 : mins;
        updateClockSelection();
    }
}

function updateClockSelection() {
    document.getElementById('selectedHour').textContent =
        tempTime.hour.toString().padStart(2, '0');
    document.getElementById('selectedMinute').textContent =
        tempTime.minute.toString().padStart(2, '0');

    const clockNumbers = document.querySelectorAll('.clock-number');
    let handAngle = 0;

    clockNumbers.forEach(el => {
        const val = parseInt(el.dataset.value);
        let isSelected = false;

        if (timeMode === 'hour') {
            isSelected = val === tempTime.hour;
            el.textContent = val;
            if (isSelected) handAngle = val * 30;
        } else {
            let minuteVal = (val * 5) % 60;
            isSelected = minuteVal === tempTime.minute;
            el.textContent = minuteVal.toString().padStart(2, '0');
            if (isSelected) handAngle = val * 30;
        }

        el.classList.toggle('selected', isSelected);
    });

    const hand = document.getElementById('clockHand');
    hand.style.transform = `translateX(-50%) rotate(${handAngle}deg)`;

    document.getElementById('amBtn').classList.toggle('active', tempTime.period === 'AM');
    document.getElementById('pmBtn').classList.toggle('active', tempTime.period === 'PM');
}

function setTimeMode(mode) {
    timeMode = mode;
    document.getElementById('hourInput').classList.toggle('active', mode === 'hour');
    document.getElementById('minuteInput').classList.toggle('active', mode === 'minute');
    updateClockSelection();
}

function setPeriod(period) {
    tempTime.period = period;
    updateClockSelection();
}

function showTimePicker(title) {
    const modal = document.getElementById('timePickerModal');
    document.getElementById('timePickerTitle').textContent = title;

    timeMode = 'hour';
    document.getElementById('hourInput').classList.add('active');
    document.getElementById('minuteInput').classList.remove('active');

    updateClockSelection();
    modal.classList.add('active');
}

function closeTimePicker() {
    const modal = document.getElementById('timePickerModal');
    modal.classList.remove('active');
}

function confirmTime() {
    if (currentTimeSelection === 'start') {
        startTime = { ...tempTime };
        closeTimePicker();
        if (selectedEndDate) {
            updateDurationField();
        }
    } else {
        endTime = { ...tempTime };
        closeTimePicker();
        updateDurationField();
    }
}

function updateDurationField() {
    const durationInput = document.getElementById('rentalDuration');
    const durationHours = document.getElementById('durationHours');

    if (selectedStartDate && selectedEndDate) {
        const startStr = formatDateTime(selectedStartDate, startTime);
        const endStr = formatDateTime(selectedEndDate, endTime);
        durationInput.value = `${startStr} - ${endStr}`;

        const totalHours = calculateHours();
        if (totalHours > 0) {
            durationHours.textContent = `Total: ${totalHours} hour${totalHours !== 1 ? 's' : ''}`;
        } else {
            durationHours.textContent = 'End time must be after start time';
        }
    } else if (selectedStartDate) {
        const startStr = formatDateTime(selectedStartDate, startTime);
        durationInput.value = `${startStr} - Select end date/time`;
        durationHours.textContent = '';
    } else {
        durationInput.value = '';
        durationHours.textContent = '';
    }
}

function calculateHours() {
    if (!selectedStartDate || !selectedEndDate) return 0;

    let startHour24 = startTime.hour;
    if (startTime.period === 'PM' && startTime.hour !== 12) startHour24 += 12;
    if (startTime.period === 'AM' && startTime.hour === 12) startHour24 = 0;

    let endHour24 = endTime.hour;
    if (endTime.period === 'PM' && endTime.hour !== 12) endHour24 += 12;
    if (endTime.period === 'AM' && endTime.hour === 12) endHour24 = 0;

    const startDateTime = new Date(selectedStartDate);
    startDateTime.setHours(startHour24, startTime.minute, 0, 0);

    const endDateTime = new Date(selectedEndDate);
    endDateTime.setHours(endHour24, endTime.minute, 0, 0);

    const diffMs = endDateTime - startDateTime;
    const diffHours = Math.round(diffMs / (1000 * 60 * 60) * 10) / 10;

    return Math.max(0, diffHours);
}

function formatDateTime(date, time) {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    const hour = time.hour.toString().padStart(2, '0');
    const minute = time.minute.toString().padStart(2, '0');
    return `${day}/${month}/${year} ${hour}:${minute} ${time.period}`;
}

function formatDate(date) {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function formatDateTimeForLaravel(date, time) {
    let hour24 = time.hour;
    if (time.period === 'PM' && time.hour !== 12) hour24 += 12;
    if (time.period === 'AM' && time.hour === 12) hour24 = 0;

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(hour24).padStart(2, '0');
    const minutes = String(time.minute).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:00`;
}

function changeMonth(delta) {
    currentMonth += delta;

    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    } else if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }

    document.getElementById('monthSelect').value = currentMonth;
    document.getElementById('yearSelect').value = currentYear;

    renderCalendar();
}

function updateCalendar() {
    currentMonth = parseInt(document.getElementById('monthSelect').value);
    currentYear = parseInt(document.getElementById('yearSelect').value);
    renderCalendar();
}

function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '/';
    }
}

function confirmBooking() {
    console.log('=== CONFIRM BOOKING CLICKED ===');

    // Validate dates
    if (!selectedStartDate || !selectedEndDate) {
        console.log('ERROR: Missing dates');
        showNotification('Please select both start and end dates with times', 'error');
        return;
    }

    const totalHours = calculateHours();
    console.log('Total hours calculated:', totalHours);

    if (totalHours <= 0) {
        console.log('ERROR: Invalid hours');
        showNotification('End time must be after start time', 'error');
        return;
    }

    // Validate car selection
    const carSelect = document.getElementById('carSelect');
    const selectedCar = carSelect ? carSelect.value : '';
    console.log('Selected car:', selectedCar);

    if (!selectedCar) {
        console.log('ERROR: No car selected');
        showNotification('Please select a car', 'error');
        return;
    }

    // Get locations - with detailed logging
    const pickupElement = document.getElementById('pickupLocation');
    const returnElement = document.getElementById('returnLocation');
    const destinationElement = document.getElementById('destination');

    console.log('Pickup element:', pickupElement);
    console.log('Return element:', returnElement);
    console.log('Destination element:', destinationElement);

    const pickupLocation = pickupElement ? pickupElement.value.trim() : '';
    const returnLocation = returnElement ? returnElement.value.trim() : '';
    const destination = destinationElement ? destinationElement.value.trim() : '';

    console.log('Locations:', {
        pickup: pickupLocation,
        return: returnLocation,
        destination: destination
    });

    if (!pickupLocation || !returnLocation) {
        console.log('ERROR: Missing locations');
        showNotification('Please fill in pickup and return locations', 'error');
        return;
    }

    // Format datetime for Laravel (YYYY-MM-DD HH:mm:ss)
    const startDateTime = formatDateTimeForLaravel(selectedStartDate, startTime);
    const endDateTime = formatDateTimeForLaravel(selectedEndDate, endTime);

    console.log('Formatted times:', {
        start: startDateTime,
        end: endDateTime
    });

    const bookingData = {
        car: selectedCar,
        destination: destination,
        Pickup: pickupLocation,
        Return: returnLocation,
        start_time: startDateTime,
        end_time: endDateTime,
        hours: totalHours
    };

    console.log('=== FINAL BOOKING DATA ===', bookingData);

    // Build URL with all parameters
    const params = new URLSearchParams(bookingData);
    const finalUrl = `/booking/confirm?${params.toString()}`;

    console.log('Redirecting to:', finalUrl);

    // Redirect to confirm page
    window.location.href = finalUrl;
}

function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 12px 24px;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        z-index: 1001;
        animation: slideDown 0.3s ease-out;
        ${type === 'error' ? 'background: #E75B5B; color: white;' :
            type === 'success' ? 'background: #14213D; color: white;' :
                'background: #3F5481; color: white;'}
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translate(-50%, -10px);
        }
    }
`;
document.head.appendChild(style);