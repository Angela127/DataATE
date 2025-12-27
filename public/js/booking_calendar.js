// Booking Calendar JavaScript

// Current calendar state
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedStartDate = null;
let selectedEndDate = null;
let leafletMap = null;
let leafletMarker = null;
let activeField = null;
const defaultLocation = { lat: 1.558557, lng: 103.636647 };

// Time state
let startTime = { hour: 7, minute: 0, period: 'AM' };
let endTime = { hour: 7, minute: 0, period: 'PM' };
let currentTimeSelection = 'start';
let timeMode = 'hour';
let tempTime = { hour: 7, minute: 0, period: 'AM' };

// Sample booking data
const bookingData = {
    '2025-12-09': 'whole-day',
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

<<<<<<< Updated upstream
// Load booking data from URL parameters (for edit functionality)
=======
// Initialize calendar on page load
>>>>>>> Stashed changes
function loadBookingDataFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    
    console.log('=== LOADING EDIT DATA FROM URL ===');
    console.log('URL params:', Object.fromEntries(urlParams));
    
<<<<<<< Updated upstream
    if (urlParams.toString() === '') {
        console.log('No URL parameters - fresh load');
=======
    // Check if there are any parameters
    if (urlParams.toString() === '') {
        console.log('No URL parameters found - this is a fresh load');
>>>>>>> Stashed changes
        return;
    }
    
    // Load car selection
    const car = urlParams.get('car');
    if (car) {
        const carSelect = document.getElementById('carSelect');
        if (carSelect) {
            carSelect.value = car;
            console.log('✓ Car loaded:', car);
<<<<<<< Updated upstream
=======
        } else {
            console.error('✗ Car select element not found!');
>>>>>>> Stashed changes
        }
    }
    
    // Load locations
    const pickup = urlParams.get('Pickup');
    const returnLoc = urlParams.get('Return');
    const destination = urlParams.get('destination');
    
    if (pickup) {
<<<<<<< Updated upstream
        const el = document.getElementById('pickupLocation');
        if (el) {
            el.value = pickup;
            console.log('✓ Pickup loaded:', pickup);
=======
        const pickupEl = document.getElementById('pickupLocation');
        if (pickupEl) {
            pickupEl.value = pickup;
            console.log('✓ Pickup location loaded:', pickup);
        } else {
            console.error('✗ Pickup location element not found!');
>>>>>>> Stashed changes
        }
    }
    
    if (returnLoc) {
<<<<<<< Updated upstream
        const el = document.getElementById('returnLocation');
        if (el) {
            el.value = returnLoc;
            console.log('✓ Return loaded:', returnLoc);
=======
        const returnEl = document.getElementById('returnLocation');
        if (returnEl) {
            returnEl.value = returnLoc;
            console.log('✓ Return location loaded:', returnLoc);
        } else {
            console.error('✗ Return location element not found!');
>>>>>>> Stashed changes
        }
    }
    
    if (destination) {
<<<<<<< Updated upstream
        const el = document.getElementById('destination');
        if (el) {
            el.value = destination;
            console.log('✓ Destination loaded:', destination);
        }
    }
    
    // Load coordinates
=======
        const destEl = document.getElementById('destination');
        if (destEl) {
            destEl.value = destination;
            console.log('✓ Destination loaded:', destination);
        } else {
            console.error('✗ Destination element not found!');
        }
    }
    
    // Load coordinates for locations
>>>>>>> Stashed changes
    const pickupLat = urlParams.get('pickup_lat');
    const pickupLng = urlParams.get('pickup_lng');
    const returnLat = urlParams.get('return_lat');
    const returnLng = urlParams.get('return_lng');
    const destLat = urlParams.get('destination_lat');
    const destLng = urlParams.get('destination_lng');
    
    if (pickupLat && pickupLng) {
<<<<<<< Updated upstream
        const lat = document.getElementById('pickup_lat');
        const lng = document.getElementById('pickup_lng');
        if (lat && lng) {
            lat.value = pickupLat;
            lng.value = pickupLng;
            console.log('✓ Pickup coords loaded');
=======
        const latEl = document.getElementById('pickup_lat');
        const lngEl = document.getElementById('pickup_lng');
        if (latEl && lngEl) {
            latEl.value = pickupLat;
            lngEl.value = pickupLng;
            console.log('✓ Pickup coordinates loaded:', pickupLat, pickupLng);
        } else {
            console.error('✗ Pickup coordinate elements not found!', { latEl, lngEl });
>>>>>>> Stashed changes
        }
    }
    
    if (returnLat && returnLng) {
<<<<<<< Updated upstream
        const lat = document.getElementById('return_lat');
        const lng = document.getElementById('return_lng');
        if (lat && lng) {
            lat.value = returnLat;
            lng.value = returnLng;
            console.log('✓ Return coords loaded');
=======
        const latEl = document.getElementById('return_lat');
        const lngEl = document.getElementById('return_lng');
        if (latEl && lngEl) {
            latEl.value = returnLat;
            lngEl.value = returnLng;
            console.log('✓ Return coordinates loaded:', returnLat, returnLng);
        } else {
            console.error('✗ Return coordinate elements not found!', { latEl, lngEl });
>>>>>>> Stashed changes
        }
    }
    
    if (destLat && destLng) {
<<<<<<< Updated upstream
        const lat = document.getElementById('destination_lat');
        const lng = document.getElementById('destination_lng');
        if (lat && lng) {
            lat.value = destLat;
            lng.value = destLng;
            console.log('✓ Destination coords loaded');
        }
    }
    
    // Load dates and times
=======
        const latEl = document.getElementById('destination_lat');
        const lngEl = document.getElementById('destination_lng');
        if (latEl && lngEl) {
            latEl.value = destLat;
            lngEl.value = destLng;
            console.log('✓ Destination coordinates loaded:', destLat, destLng);
        } else {
            console.error('✗ Destination coordinate elements not found!', { latEl, lngEl });
        }
    }
    
    // Load start and end times
>>>>>>> Stashed changes
    const startTimeStr = urlParams.get('start_time');
    const endTimeStr = urlParams.get('end_time');
    
    if (startTimeStr && endTimeStr) {
<<<<<<< Updated upstream
        try {
            const startDateTime = new Date(startTimeStr.replace(' ', 'T'));
            const endDateTime = new Date(endTimeStr.replace(' ', 'T'));
            
            if (isNaN(startDateTime.getTime()) || isNaN(endDateTime.getTime())) {
                console.error('Invalid date format');
                return;
            }
            
            // Set selected dates
            selectedStartDate = new Date(startDateTime.getFullYear(), startDateTime.getMonth(), startDateTime.getDate());
            selectedEndDate = new Date(endDateTime.getFullYear(), endDateTime.getMonth(), endDateTime.getDate());
            
            // Convert start time
=======
        console.log('Loading times:', { start: startTimeStr, end: endTimeStr });
        
        try {
            // Parse the datetime strings (format: YYYY-MM-DD HH:mm:ss)
            const startDateTime = new Date(startTimeStr.replace(' ', 'T'));
            const endDateTime = new Date(endTimeStr.replace(' ', 'T'));
            
            console.log('Parsed dates:', { startDateTime, endDateTime });
            
            // Validate dates
            if (isNaN(startDateTime.getTime()) || isNaN(endDateTime.getTime())) {
                console.error('✗ Invalid date format!');
                return;
            }
            
            // Set the selected dates
            selectedStartDate = new Date(startDateTime.getFullYear(), startDateTime.getMonth(), startDateTime.getDate());
            selectedEndDate = new Date(endDateTime.getFullYear(), endDateTime.getMonth(), endDateTime.getDate());
            
            console.log('✓ Selected dates set:', { selectedStartDate, selectedEndDate });
            
            // Extract time components for start time
>>>>>>> Stashed changes
            let startHour = startDateTime.getHours();
            const startMinute = startDateTime.getMinutes();
            const startPeriod = startHour >= 12 ? 'PM' : 'AM';
            
<<<<<<< Updated upstream
            if (startHour === 0) startHour = 12;
            else if (startHour > 12) startHour -= 12;
            
            startTime = { hour: startHour, minute: startMinute, period: startPeriod };
            
            // Convert end time
=======
            // Convert to 12-hour format
            if (startHour === 0) {
                startHour = 12;
            } else if (startHour > 12) {
                startHour -= 12;
            }
            
            startTime = {
                hour: startHour,
                minute: startMinute,
                period: startPeriod
            };
            
            console.log('✓ Start time set:', startTime);
            
            // Extract time components for end time
>>>>>>> Stashed changes
            let endHour = endDateTime.getHours();
            const endMinute = endDateTime.getMinutes();
            const endPeriod = endHour >= 12 ? 'PM' : 'AM';
            
<<<<<<< Updated upstream
            if (endHour === 0) endHour = 12;
            else if (endHour > 12) endHour -= 12;
            
            endTime = { hour: endHour, minute: endMinute, period: endPeriod };
            
            // Update calendar display
            currentMonth = selectedStartDate.getMonth();
            currentYear = selectedStartDate.getFullYear();
            
            document.getElementById('monthSelect').value = currentMonth;
            document.getElementById('yearSelect').value = currentYear;
            
            // Update UI
            setTimeout(() => {
                updateDurationField();
                renderCalendar();
                console.log('=== EDIT DATA LOADED SUCCESSFULLY ===');
            }, 100);
            
        } catch (error) {
            console.error('Error loading dates:', error);
        }
=======
            // Convert to 12-hour format
            if (endHour === 0) {
                endHour = 12;
            } else if (endHour > 12) {
                endHour -= 12;
            }
            
            endTime = {
                hour: endHour,
                minute: endMinute,
                period: endPeriod
            };
            
            console.log('✓ End time set:', endTime);
            
            // Update the calendar to show the correct month
            currentMonth = selectedStartDate.getMonth();
            currentYear = selectedStartDate.getFullYear();
            
            const monthSelect = document.getElementById('monthSelect');
            const yearSelect = document.getElementById('yearSelect');
            
            if (monthSelect && yearSelect) {
                monthSelect.value = currentMonth;
                yearSelect.value = currentYear;
                console.log('✓ Calendar month/year updated:', { currentMonth, currentYear });
            } else {
                console.error('✗ Month/Year select elements not found!');
            }
            
            // Update the rental duration display
            updateDurationField();
            console.log('✓ Duration field updated');
            
            // Re-render calendar to show selected dates
            renderCalendar();
            console.log('✓ Calendar re-rendered with selected dates');
            
            console.log('=== EDIT DATA LOADED SUCCESSFULLY ===');
        } catch (error) {
            console.error('✗ Error loading date/time data:', error);
        }
    } else {
        console.log('No start/end time in URL parameters');
>>>>>>> Stashed changes
    }
}

// Initialize calendar
function initializeCalendar() {
    document.getElementById('monthSelect').value = currentMonth;
    document.getElementById('yearSelect').value = currentYear;
    renderCalendar();
}

function renderCalendar() {
    const calendarDays = document.getElementById('calendarDays');
    if (!calendarDays) return;
    
    calendarDays.innerHTML = '';
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const startingDay = firstDay.getDay();
    const totalDays = lastDay.getDate();
    
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    // Empty cells
    for (let i = 0; i < startingDay; i++) {
        const emptyDay = document.createElement('button');
        emptyDay.className = 'calendar-day hidden';
        emptyDay.disabled = true;
        emptyDay.style.visibility = 'hidden';
        calendarDays.appendChild(emptyDay);
    }
    
    // Day cells
    for (let day = 1; day <= totalDays; day++) {
        const dayButton = document.createElement('button');
        dayButton.className = 'calendar-day';
        dayButton.textContent = day;
        dayButton.type = 'button';
        
        const dateObj = new Date(currentYear, currentMonth, day);
        dateObj.setHours(0, 0, 0, 0);
<<<<<<< Updated upstream
=======
        const month = String(currentMonth + 1).padStart(2, '0');
const dayStr = String(day).padStart(2, '0');
const dateKey = `${currentYear}-${month}-${dayStr}`;

>>>>>>> Stashed changes
        
        const month = String(currentMonth + 1).padStart(2, '0');
        const dayStr = String(day).padStart(2, '0');
        const dateKey = `${currentYear}-${month}-${dayStr}`;
        
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
                        break;
                    case 'half-day':
                        dayButton.classList.add('half-day-booked');
                        break;
                    case 'few-hours':
                        dayButton.classList.add('few-hours-booked');
                        break;
                    case 'unavailable':
                        dayButton.classList.add('unavailable');
                        dayButton.disabled = true;
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
        dayButton.dataset.date = dateKey;
    }
}

function setDefaultLocation() {
    const studentMall = { lat: 1.492, lng: 103.741 };
    leafletMarker.setLatLng([studentMall.lat, studentMall.lng]);
    leafletMap.setView([studentMall.lat, studentMall.lng], 16);

    if (activeField) {
        document.getElementById(activeField).value = "Student Mall";
        document.getElementById(activeField + '_lat').value = studentMall.lat;
        document.getElementById(activeField + '_lng').value = studentMall.lng;
    }
}

function openMapPicker(fieldId) {
    activeField = fieldId;
    const modal = document.getElementById('mapModal');
    modal.classList.add('active');

    if (!leafletMap) {
        leafletMap = L.map('mapCanvas').setView([defaultLocation.lat, defaultLocation.lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(leafletMap);
        leafletMarker = L.marker([defaultLocation.lat, defaultLocation.lng], { draggable: true }).addTo(leafletMap);

        leafletMap.on('click', function(e) {
            if (!leafletMarker) {
                leafletMarker = L.marker(e.latlng, { draggable: true }).addTo(leafletMap);
            } else {
                leafletMarker.setLatLng(e.latlng);
            }
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });
    }

    const searchInput = document.getElementById('mapSearchInput');
    if (searchInput && typeof google !== 'undefined') {
        const autocomplete = new google.maps.places.Autocomplete(searchInput);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            if (!leafletMarker) {
                leafletMarker = L.marker([lat, lng], { draggable: true }).addTo(leafletMap);
            } else {
                leafletMarker.setLatLng([lat, lng]);
            }

            leafletMap.setView([lat, lng], 16);

            if (activeField) {
                document.getElementById(activeField).value = place.name || place.formatted_address;
                document.getElementById(activeField + '_lat').value = lat.toFixed(6);
                document.getElementById(activeField + '_lng').value = lng.toFixed(6);
            }
        });
    }

    setTimeout(() => leafletMap.invalidateSize(), 200);
}

function reverseGeocode(lat, lng) {
    const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            let name = data.display_name || `Lat: ${lat}, Lng: ${lng}`;
            document.getElementById(activeField).value = name;

            if (activeField === 'pickupLocation') {
                document.getElementById('pickup_lat').value = lat.toFixed(6);
                document.getElementById('pickup_lng').value = lng.toFixed(6);
            } else if (activeField === 'returnLocation') {
                document.getElementById('return_lat').value = lat.toFixed(6);
                document.getElementById('return_lng').value = lng.toFixed(6);
            } else if (activeField === 'destination') {
                document.getElementById('destination_lat').value = lat.toFixed(6);
                document.getElementById('destination_lng').value = lng.toFixed(6);
            }
        })
        .catch(err => console.error('Reverse geocoding failed:', err));
}

function confirmMapSelection() {
    if (!leafletMarker) {
        alert('Please click on the map to select a location.');
        return;
    }

    const lat = leafletMarker.getLatLng().lat.toFixed(6);
    const lng = leafletMarker.getLatLng().lng.toFixed(6);

    document.getElementById(activeField).value = `Lat: ${lat}, Lng: ${lng}`;

    if (activeField === 'pickupLocation') {
        document.getElementById('pickup_lat').value = lat;
        document.getElementById('pickup_lng').value = lng;
    } else if (activeField === 'returnLocation') {
        document.getElementById('return_lat').value = lat;
        document.getElementById('return_lng').value = lng;
    } else if (activeField === 'destination') {
        document.getElementById('destination_lat').value = lat;
        document.getElementById('destination_lng').value = lng;
    }

    closeMapPicker();
}

function closeMapPicker() {
    document.getElementById('mapModal').classList.remove('active');
    activeField = null;
    if (leafletMarker) {
        leafletMap.removeLayer(leafletMarker);
        leafletMarker = null;
    }
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
        setTimeout(() => setTimeMode('minute'), 300);
    } else {
        let mins = value * 5;
        tempTime.minute = mins === 60 ? 0 : mins;
        updateClockSelection();
    }
}

function updateClockSelection() {
    document.getElementById('selectedHour').textContent = tempTime.hour.toString().padStart(2, '0');
    document.getElementById('selectedMinute').textContent = tempTime.minute.toString().padStart(2, '0');
    
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
    
    document.getElementById('clockHand').style.transform = `translateX(-50%) rotate(${handAngle}deg)`;
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
    document.getElementById('timePickerModal').classList.remove('active');
}

function confirmTime() {
    if (currentTimeSelection === 'start') {
        startTime = { ...tempTime };
        closeTimePicker();
        if (selectedEndDate) updateDurationField();
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
    
    if (!selectedStartDate || !selectedEndDate) {
        showNotification('Please select both start and end dates with times', 'error');
        return;
    }
    
    const totalHours = calculateHours();
    if (totalHours <= 0) {
        showNotification('End time must be after start time', 'error');
        return;
    }
    
    const carSelect = document.getElementById('carSelect');
    const selectedCar = carSelect ? carSelect.value : '';
    
    if (!selectedCar) {
        showNotification('Please select a car', 'error');
        return;
    }
    
    const pickupLocation = document.getElementById('pickupLocation')?.value.trim() || '';
    const returnLocation = document.getElementById('returnLocation')?.value.trim() || '';
    const destination = document.getElementById('destination')?.value.trim() || '';
    
    if (!pickupLocation || !returnLocation) {
        showNotification('Please fill in pickup and return locations', 'error');
        return;
    }
    
<<<<<<< Updated upstream
    const pickupLat = document.getElementById('pickup_lat')?.value || '';
    const pickupLng = document.getElementById('pickup_lng')?.value || '';
    const returnLat = document.getElementById('return_lat')?.value || '';
    const returnLng = document.getElementById('return_lng')?.value || '';
    const destLat = document.getElementById('destination_lat')?.value || '';
    const destLng = document.getElementById('destination_lng')?.value || '';
    
=======
    // Get coordinates from hidden fields
    const pickupLat = document.getElementById('pickup_lat') ? document.getElementById('pickup_lat').value : '';
    const pickupLng = document.getElementById('pickup_lng') ? document.getElementById('pickup_lng').value : '';
    const returnLat = document.getElementById('return_lat') ? document.getElementById('return_lat').value : '';
    const returnLng = document.getElementById('return_lng') ? document.getElementById('return_lng').value : '';
    const destLat = document.getElementById('destination_lat') ? document.getElementById('destination_lat').value : '';
    const destLng = document.getElementById('destination_lng') ? document.getElementById('destination_lng').value : '';
    
    console.log('Coordinates:', {
        pickup: { lat: pickupLat, lng: pickupLng },
        return: { lat: returnLat, lng: returnLng },
        destination: { lat: destLat, lng: destLng }
    });
    
    // Format datetime for Laravel (YYYY-MM-DD HH:mm:ss)
>>>>>>> Stashed changes
    const startDateTime = formatDateTimeForLaravel(selectedStartDate, startTime);
    const endDateTime = formatDateTimeForLaravel(selectedEndDate, endTime);
    
    const bookingData = {
        car: selectedCar,
        destination: destination,
        Pickup: pickupLocation,
        Return: returnLocation,
        start_time: startDateTime,
        end_time: endDateTime,
        hours: totalHours
    };
    
<<<<<<< Updated upstream
=======
    // Add coordinates if they exist
>>>>>>> Stashed changes
    if (pickupLat && pickupLng) {
        bookingData.pickup_lat = pickupLat;
        bookingData.pickup_lng = pickupLng;
    }
    
    if (returnLat && returnLng) {
        bookingData.return_lat = returnLat;
        bookingData.return_lng = returnLng;
    }
    
    if (destLat && destLng) {
        bookingData.destination_lat = destLat;
        bookingData.destination_lng = destLng;
    }
    
<<<<<<< Updated upstream
    console.log('=== BOOKING DATA ===', bookingData);
=======
    console.log('=== FINAL BOOKING DATA ===', bookingData);
>>>>>>> Stashed changes
    
    const params = new URLSearchParams(bookingData);
    window.location.href = `/booking/confirm?${params.toString()}`;
}

function showNotification(message, type = 'info') {
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
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
<<<<<<< Updated upstream

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PAGE LOADED ===');
    initializeCalendar();
    initializeClockFace();
    
    // Load edit data after a brief delay
    setTimeout(() => {
        loadBookingDataFromURL();
    }, 150);
});
=======
document.addEventListener('DOMContentLoaded', () => {
    loadBookingDataFromURL();
    initializeCalendar();
});
>>>>>>> Stashed changes
