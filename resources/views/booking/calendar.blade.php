<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Booking Form - DataATE</title>
    <link rel="stylesheet" href="{{ asset('css/booking_calendar.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&family=Geist:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

</head>

<body>
    <div class="booking-container">
        <!-- Back Arrow -->
        <button class="back-btn" onclick="goBack()">
            <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 1L1 7.5L7.5 14" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M1 7.5H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Logo -->
        <img src="{{ asset('image/dataate-logo.png') }}" alt="DataATE" class="header-logo"
            onerror="this.style.display='none'">

        <!-- Form Card -->
        <div class="form-card">
            <!-- Header -->
            <h1 class="form-title">Car Booking Form</h1>

            <!-- Car Selection -->
<div class="form-group">
    <label for="carSelect">Select Car</label>
    <div class="calendar-container"> <!-- Use calendar-container for consistent width -->
        <select id="carSelect" class="custom-select">
            <option value="">-- Select a Car --</option>
            @foreach($cars as $car)
                <option value="{{ $car->plate_no }}">{{ $car->model }} ({{ $car->plate_no }})</option>
            @endforeach
        </select>
    </div>
</div>

            <style>
.custom-select {
    width: 100%; /* full width of parent */
    padding: 12px 40px 12px 12px; 
    border: 1px solid #ccc;
    border-radius: 12px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #f9f9f9 url('data:image/svg+xml;utf8,<svg fill="%23999" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 12px center;
    background-size: 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    cursor: pointer;
}

                /* Optional: nicer focus effect */

.custom-select:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(20, 122, 255, 0.3);
}
            </style>




            <!-- Calendar Section -->
            <div class="form-group">
                <label>Choose your rental date</label>
                <div class="calendar-container">
                    <!-- Calendar Header -->
                    <div class="calendar-header">
                        <button class="nav-btn prev-month" onclick="changeMonth(-1)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M12.5 15L7.5 10L12.5 5" stroke="#1E1E1E" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="month-year-select">
                            <div class="select-field">
                                <select id="monthSelect" onchange="updateCalendar()">
                                    <option value="0">Jan</option>
                                    <option value="1">Feb</option>
                                    <option value="2">Mar</option>
                                    <option value="3">Apr</option>
                                    <option value="4">May</option>
                                    <option value="5">Jun</option>
                                    <option value="6">Jul</option>
                                    <option value="7">Aug</option>
                                    <option value="8">Sep</option>
                                    <option value="9">Oct</option>
                                    <option value="10">Nov</option>
                                    <option value="11">Dec</option>
                                </select>
                            </div>
                            <div class="select-field">
                                <select id="yearSelect" onchange="updateCalendar()">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                        <button class="nav-btn next-month" onclick="changeMonth(1)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7.5 15L12.5 10L7.5 5" stroke="#1E1E1E" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- Calendar Days Header -->
                    <div class="calendar-weekdays">
                        <span>Su</span>
                        <span>Mo</span>
                        <span>Tu</span>
                        <span>We</span>
                        <span>Th</span>
                        <span>Fr</span>
                        <span>Sa</span>
                    </div>

                    <!-- Calendar Days Grid -->
                    <div class="calendar-days" id="calendarDays">
                        <!-- Days will be generated by JavaScript -->
                    </div>

            </div>

            <div id="mapModal" class="time-picker-modal">
                <div class="time-picker-overlay" onclick="closeMapPicker()"></div>
                <div class="time-picker-container" style="width: 90%; max-width: 500px; padding: 0;">
                    <div class="time-picker-header">
                        <span class="time-picker-title">Left-click to choose location</span>
                    </div>
                    <div id="mapCanvas" style="height: 400px; width: 100%;"></div>
                    <div class="time-picker-actions" style="background: white; padding: 10px;">
                        <button class="time-picker-btn cancel" onclick="closeMapPicker()">Cancel</button>
                    </div>
                </div>
            </div>

            <!-- Rental Duration -->
            <div class="form-group">
                <label>Rental duration</label>
                <div class="input-field">
                    <input type="text" id="rentalDuration" placeholder="Select dates on calendar" readonly>
                </div>
                <div class="duration-hours" id="durationHours"></div>
            </div>


<div class="form-group">
    <label>Pick Up Location</label>
    <div class="input-field map-group">
        <input type="text" id="pickupLocation" value="Student Mall" placeholder="Enter pick up location">
        <button type="button" class="map-icon-btn" onclick="openMapPicker('pickupLocation')">📍</button>
    </div>
    <input type="hidden" name="pickup_lat" id="pickup_lat" value="1.558557">
    <input type="hidden" name="pickup_lng" id="pickup_lng" value="103.636647">
</div>

<div id="mapModal" class="time-picker-modal">
    <div class="time-picker-overlay" onclick="closeMapPicker()"></div>
    <div class="time-picker-container" style="width: 90%; max-width: 600px; padding: 20px;">
        <div class="time-picker-header">
            <span class="time-picker-title">Select Location</span>
        </div>
        
        <input id="mapSearchInput" type="text" placeholder="Search for a place..." 
               style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 8px;">
        
        <div id="mapCanvas" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        
        <div class="time-picker-actions" style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="time-picker-btn" style="background: #14213D; color: white; flex: 1;" onclick="setDefaultLocation()">Use Student Mall</button>
            <button type="button" class="time-picker-btn ok" style="flex: 1;" onclick="confirmMapSelection()">Confirm Selection</button>
            <button type="button" class="time-picker-btn cancel" style="flex: 1;" onclick="closeMapPicker()">Cancel</button>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Return Location</label>
    <div class="input-field map-group">
        <input type="text" id="returnLocation" value="Student Mall" placeholder="Enter return location">
        <button type="button" class="map-icon-btn" onclick="openMapPicker('returnLocation')">📍</button>
    </div>
    <input type="hidden" name="return_lat" id="return_lat" value="1.558557">
    <input type="hidden" name="return_lng" id="return_lng" value="103.636647">
</div>

<div id="mapModal" class="time-picker-modal">
    <div class="time-picker-overlay" onclick="closeMapPicker()"></div>
    <div class="time-picker-container" style="width: 90%; max-width: 600px; padding: 20px;">
        <div class="time-picker-header">
            <span class="time-picker-title">Select Location</span>
        </div>
        
        <input id="mapSearchInput" type="text" placeholder="Search for a place..." 
               style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 8px;">
        
        <div id="mapCanvas" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        
        <div class="time-picker-actions" style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="time-picker-btn" style="background: #14213D; color: white; flex: 1;" onclick="setDefaultLocation()">Use Student Mall</button>
            <button class="time-picker-btn ok" style="flex: 1;" onclick="confirmMapSelection()">Confirm Selection</button>
            <button class="time-picker-btn cancel" style="flex: 1;" onclick="closeMapPicker()">Cancel</button>
        </div>
    </div>
</div>
                    <!-- Destination -->
                    <div class="form-group">
                        <label>Destination</label>
                        <div class="input-field map-group">
                            <input type="text" id="destination" name="destination" value="{{ $destination ?? '' }}"
                                placeholder="Enter destination">
                            <button type="button" class="map-icon-btn"
                                onclick="openMapPicker('destination')">📍</button>
                        </div>
                        <input type="hidden" name="destination_lat" id="destination_lat">
                        <input type="hidden" name="destination_lng" id="destination_lng">

                    </div>

                </div>

                <!-- Confirm Button -->
                <button type="button" class="confirm-btn" onclick="confirmBooking()">
                    Confirm
                </button>

                <!-- Time Picker Modal -->
                <div class="time-picker-modal" id="timePickerModal">
                    <div class="time-picker-overlay" onclick="closeTimePicker()"></div>
                    <div class="time-picker-container">
                        <div class="time-picker-header">
                            <span class="time-picker-title" id="timePickerTitle">Select time</span>
                        </div>

                        <div class="time-picker-content">
                            <!-- Time Input Display -->
                            <div class="time-input-display">
                                <div class="time-input-group">
                                    <div class="time-input-box active" id="hourInput" onclick="setTimeMode('hour')">
                                        <span id="selectedHour">07</span>
                                    </div>
                                    <span class="time-separator">:</span>
                                    <div class="time-input-box" id="minuteInput" onclick="setTimeMode('minute')">
                                        <span id="selectedMinute">00</span>
                                    </div>
                                </div>
                                <div class="period-selector">
                                    <button class="period-btn active" id="amBtn" onclick="setPeriod('AM')">AM</button>
                                    <button class="period-btn" id="pmBtn" onclick="setPeriod('PM')">PM</button>
                                </div>
                            </div>

                            <!-- Clock Face -->
                            <div class="clock-face" id="clockFace">
                                <div class="clock-center"></div>
                                <div class="clock-hand" id="clockHand"></div>
                                <!-- Hour numbers will be generated by JS -->
                            </div>
                        </div>

                        <div class="time-picker-actions">
                            <button class="time-picker-btn cancel" onclick="closeTimePicker()">Cancel</button>
                            <button class="time-picker-btn ok" onclick="confirmTime()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6G0oqiCvdkEPLPmtqJcTHjxsZCPF8aOM&libraries=places"></script>
            <script src="{{ asset('js/booking_calendar.js') }}"></script>

            <!-- Map Modal -->
            <div id="mapModal" class="map-modal">
                <div class="map-overlay" onclick="closeMapPicker()"></div>
                <div class="map-container">
                    <div id="mapCanvas" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                    <div style="margin-top:10px; text-align: right;">
                        <button class="time-picker-btn ok" onclick="confirmMapSelection()">Confirm Location</button>
                        <button class="time-picker-btn cancel" onclick="closeMapPicker()">Cancel</button>
                        <!-- New button for default location -->
                        <button class="time-picker-btn" style="background: #14213D; color: white;"
                            onclick="setDefaultLocation()">Use Student Mall</button>
                    </div>
                </div>
            </div>


</body>

</html>