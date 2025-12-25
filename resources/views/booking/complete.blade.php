<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Complete - DataATE</title>
    <link rel="stylesheet" href="{{ asset('css/booking_complete.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

@if(isset($car) && isset($bookingDetails))
    <div style="background: #f0f0f0; padding: 20px; margin: 20px; border-radius: 8px; font-family: monospace; font-size: 12px;">
        <h3>Debug Information (Remove in production)</h3>
        <hr>
        <strong>Car:</strong> {{ $car ? $car->model . ' (' . $car->plate_no . ')' : 'No car selected' }}<br>
        <strong>Booking Hours:</strong> {{ $bookingDetails['booking_hours'] }}<br>
        <strong>Pickup Location:</strong> {{ $bookingDetails['pickup_location'] }}<br>
        <strong>Return Location:</strong> {{ $bookingDetails['return_location'] }}<br>
        <strong>Destination:</strong> {{ $bookingDetails['destination'] }}<br>
        <strong>Start Time:</strong> {{ $bookingDetails['start_time'] }}<br>
        <strong>End Time:</strong> {{ $bookingDetails['end_time'] }}<br>
        <strong>Price:</strong> RM{{ number_format($bookingDetails['price'], 2) }}<br>
        <strong>Total:</strong> RM{{ number_format($bookingDetails['total'], 2) }}<br>
        <hr>
        <strong>All Query Parameters:</strong><br>
        @foreach(request()->query() as $key => $value)
            {{ $key }}: {{ $value }}<br>
        @endforeach
    </div>
@endif

<body>
    <div class="complete-container">
        <!-- Header -->
        <header class="complete-header">
            <div class="header-logo">
                <img src="{{ asset('image/logo.png') }}" alt="DataATE" onerror="this.style.display='none'">
            </div>
        </header>

        <!-- Progress Indicator -->
        <div class="progress-section">
            <div class="progress-bar">
                <div class="progress-step completed">
                    <div class="step-icon">
                        <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2H2C1.44772 2 1 2.44772 1 3V15C1 15.5523 1.44772 16 2 16H12C12.5523 16 13 15.5523 13 15V3C13 2.44772 12.5523 2 12 2Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M4 6H10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 10H10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 14H7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
                <div class="progress-line completed"></div>
                <div class="progress-step completed">
                    <div class="step-icon">
                        <svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 8H5C3.89543 8 3 8.89543 3 10V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V10C21 8.89543 20.1046 8 19 8Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M7 8V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V8" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="12" cy="13" r="2" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
                <div class="progress-line completed"></div>
                <div class="progress-step completed">
                    <div class="step-icon">
                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="progress-labels">
                <span class="completed">Booking</span>
                <span class="completed">Pick Up</span>
                <span class="completed">Complete</span>
            </div>
        </div>

        <!-- Success Content -->
        <div class="success-content">
            <!-- Success Icon -->
            <div class="success-icon">
                <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="100" cy="100" r="90" stroke="#14AE5C" stroke-width="20"/>
                    <path d="M60 100L90 130L140 70" stroke="#14AE5C" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <!-- Success Message -->
            <div class="success-message">
                <h1 class="success-title">Form & Feedback Successfully</h1>
                <h2 class="success-subtitle">Submitted</h2>
                <p class="success-desc">
                    Thank you! Your feedback and issue report have been submitted successfully. We'll get back to you if follow-up is needed.
                </p>
            </div>
        </div>

        <!-- Back to Home Button -->
        <a href="{{ route('mainpage') }}" class="home-btn">Back to Home</a>
    </div>
</body>
</html>