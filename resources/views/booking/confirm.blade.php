<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking - DataATE</title>
    <link rel="stylesheet" href="{{ asset('css/booking_confirm.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Poppins:wght@400;500;600;900&family=Sen:wght@400;500;600;700&family=Shippori+Antique&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="confirm-container">
        <!-- Header -->
        <header class="confirm-header">
            <button class="back-btn" onclick="goBack()">
                <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.5 17L8.5 11.5L14.5 6" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <h1 class="header-title">Confirm Booking</h1>
        </header>

        <!-- Car Info -->
        <section class="car-section">
            <h2 class="car-name" id="carName">Perodua Bezza 2023</h2>
            <div class="car-image">
                <img src="{{ asset('image/car-bezza-2023-1.png') }}" alt="Car" id="carImage"
                    onerror="this.src='https://via.placeholder.com/236x158?text=Car+Image'">
            </div>
        </section>

        <!-- Booking Details Card -->
        <section class="details-card booking-details">
            <h3 class="card-title">Booking Details</h3>

            <!-- Pick Up Location Display -->
            <div class="detail-row">
                <span class="detail-label">Pick Up Location:</span>
                <span class="detail-value">{{ $bookingDetails['pickup_location'] }}</span>
            </div>

            <!-- Return Location Display -->
            <div class="detail-row">
                <span class="detail-label">Return Location:</span>
                <span class="detail-value">{{ $bookingDetails['return_location'] }}</span>
            </div>

            <!-- Destination Display -->
            <div class="detail-row">
                <span class="detail-label">Destination:</span>
                <span class="detail-value">{{ $bookingDetails['destination'] }}</span>
            </div>

            <!-- Start Time Display -->
            <div class="detail-row">
                <span class="detail-label">Start Time:</span>
                <span
                    class="detail-value">{{ \Carbon\Carbon::parse($bookingDetails['start_time'])->format('d/m/Y h:i A') }}</span>
            </div>

            <!-- End Time Display -->
            <div class="detail-row">
                <span class="price-value">End Time:</span>
                <span
                    class="price-amount">{{ \Carbon\Carbon::parse($bookingDetails['end_time'])->format('d/m/Y h:i A') }}</span>
            </div>
            <!-- Booking Hours Display -->
            <div class="detail-row">
                <span class="detail-label">Booking Hours:</span>
                <span class="detail-value" id="bookingHours">{{ $bookingDetails['booking_hours'] }} hour(s)</span>
            </div>
        </section>

        <section class="details-card booking-details">
            <h3 class="card-title">Price Details</h3>


<div class="detail-row">
    <span class="detail-label">Booking Price:</span>
    <span class="detail-value" id="bookingPrice" data-value="{{ $bookingDetails['price'] }}">
        RM{{ number_format($bookingDetails['price'], 2) }}
    </span>
</div>

<div class="detail-row">
    <span class="detail-label">Deposit:</span>
    <span class="detail-value" id="depositAmount" data-value="{{ $bookingDetails['deposit'] }}">
        RM{{ number_format($bookingDetails['deposit'], 2) }}
    </span>
</div>

<div class="detail-row">
    <span class="detail-label">Add-ons:</span>
    <span class="detail-value" id="addonsAmount">RM0.00</span>
</div>

<div class="price-divider"></div>

<div class="detail-row total-row">
    <span class="detail-label">Total:</span>
    <span class="detail-value" id="totalAmount">RM{{ number_format($bookingDetails['total'], 2) }}</span>
</div>

            <button class="edit-btn" onclick="editBooking()">Edit</button>
            <script>
                function editBooking() {
                    const params = new URLSearchParams({
                        car: '{{ $bookingDetails['car'] ?? request('car') }}',
                        destination: '{{ $bookingDetails['destination'] }}',
                        Pickup: '{{ $bookingDetails['pickup_location'] }}',
                        Return: '{{ $bookingDetails['return_location'] }}',
                        start_time: '{{ $bookingDetails['start_time'] }}',
                        end_time: '{{ $bookingDetails['end_time'] }}'
                    });
                    window.location.href = "{{ route('booking.calendar') }}?" + params.toString();
                }
            </script>
        </section>

        <!-- Voucher Section -->
        <section class="details-card voucher-section">
            <div class="voucher-row">
                <div class="voucher-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 5H3C2.45 5 2 5.45 2 6V10C3.1 10 4 10.9 4 12C4 13.1 3.1 14 2 14V18C2 18.55 2.45 19 3 19H21C21.55 19 22 18.55 22 18V14C20.9 14 20 13.1 20 12C20 10.9 20.9 10 22 10V6C22 5.45 21.55 5 21 5Z"
                            stroke="#52698D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10 5V19" stroke="#52698D" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" stroke-dasharray="4 4" />
                    </svg>
                </div>

                @if(!empty($bookingDetails['voucher_code']))
                    <!-- Applied Voucher State -->
                    <div class="voucher-content">
                        <span class="voucher-label" id="voucherLabel" style="color: #2ECC71;">Voucher Applied</span>
                        <span class="voucher-status" id="voucherStatus"
                            style="color: #333; font-weight: 600;">{{ $bookingDetails['voucher_code'] }}</span>
                    </div>
                    <!-- Remove Button (Link essentially reloading without voucher_code) -->
                    @php
                        $paramsWithoutVoucher = request()->except('voucher_code');
                    @endphp
                    <a href="{{ route('booking.confirm', $paramsWithoutVoucher) }}" class="remove-voucher-btn"
                        title="Remove Voucher">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L13 13M1 13L13 1" stroke="#E75B5B" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </a>
                @else
                    <!-- No Voucher State -->
                    <div class="voucher-content">
                        <span class="voucher-label" id="voucherLabel">Voucher</span>
                        <span class="voucher-status" id="voucherStatus">Select a voucher</span>
                    </div>
                    <a href="{{ route('booking.voucher', request()->all()) }}" class="voucher-select-btn"
                        id="voucherSelectBtn">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="#52698D" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                @endif
            </div>
        </section>

        <!-- Payment Method Card -->
        <section class="details-card payment-section">
            <h3 class="card-title">Payment Method</h3>

            <div class="payment-options">
                <label class="payment-option selected">
                    <input type="radio" name="payment" value="qr" checked>
                    <span class="radio-custom"></span>
                    <span class="payment-name">QR Payment</span>
                </label>

                <label class="payment-option" style="opacity: 0.5; pointer-events: none;">
                    <input type="radio" name="payment" value="card" disabled>
                    <span class="radio-custom"></span>
                    <span class="payment-name">Credit/Debit Card (Unavailable)</span>
                </label>

                <label class="payment-option" style="opacity: 0.5; pointer-events: none;">
                    <input type="radio" name="payment" value="bank" disabled>
                    <span class="radio-custom"></span>
                    <span class="payment-name">Online Banking (Unavailable)</span>
                </label>
            </div>
        </section>

        <!-- Pay Now Form -->
        <form action="{{ route('booking.create_rental') }}" method="POST" id="paymentForm">
            @csrf
            
            @foreach($bookingDetails as $key => $value)
                @if($value !== null)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            
            <button type="submit" class="pay-now-btn">Pay Now</button>
        </form>
    </div>
<script>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    // PICKUP_URL not needed anymore as form submits directly
=======
=======
>>>>>>> Stashed changes
    const PICKUP_URL = "{{ route('booking.pickup') }}";
    
    // This function is now in booking_confirm.js
    // But we keep this inline version as backup with complete data
    function editBooking() {
        const params = new URLSearchParams({
            car: '{{ $bookingDetails['car'] ?? request('car') }}',
            destination: '{{ $bookingDetails['destination'] ?? request('destination') }}',
            Pickup: '{{ $bookingDetails['pickup_location'] ?? request('Pickup') }}',
            Return: '{{ $bookingDetails['return_location'] ?? request('Return') }}',
            start_time: '{{ $bookingDetails['start_time'] ?? request('start_time') }}',
            end_time: '{{ $bookingDetails['end_time'] ?? request('end_time') }}',
            pickup_lat: '{{ $bookingDetails['pickup_lat'] ?? request('pickup_lat') }}',
            pickup_lng: '{{ $bookingDetails['pickup_lng'] ?? request('pickup_lng') }}',
            return_lat: '{{ $bookingDetails['return_lat'] ?? request('return_lat') }}',
            return_lng: '{{ $bookingDetails['return_lng'] ?? request('return_lng') }}',
            destination_lat: '{{ $bookingDetails['destination_lat'] ?? request('destination_lat') }}',
            destination_lng: '{{ $bookingDetails['destination_lng'] ?? request('destination_lng') }}'
        });
        
        // Remove empty parameters
        for (let [key, value] of [...params.entries()]) {
            if (!value || value === '') {
                params.delete(key);
            }
        }
        
        window.location.href = "{{ route('booking.calendar') }}?" + params.toString();
    }
    function applyLocationAddon() {
    const pickup = '{{ strtolower($bookingDetails['pickup_location']) }}'.trim();
    const dropoff = '{{ strtolower($bookingDetails['return_location']) }}'.trim();

    let locationAddon = 0;

    if (pickup !== 'student mall') {
        locationAddon += 10;
    }

    if (dropoff !== 'student mall') {
        locationAddon += 10;
    }

    if (locationAddon === 0) return;

    // Read existing amounts
    const bookingPrice = {{ $bookingDetails['price'] }};
    const deposit = {{ $bookingDetails['deposit'] }};
    const baseAddons = {{ $bookingDetails['addons'] }};
    const discount = {{ $bookingDetails['discount'] ?? 0 }};

    const newAddons = baseAddons + locationAddon;
    const newTotal = bookingPrice + deposit + newAddons - discount;

    // Update UI
    document.getElementById('addonsAmount').textContent = `RM${newAddons.toFixed(2)}`;
    document.getElementById('totalPrice').textContent = `RM${newTotal.toFixed(2)}`;

    console.log('📍 Location Add-on: RM' + locationAddon);
}
document.addEventListener('DOMContentLoaded', function () {
    applyLocationAddon();
});

<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
</script>

</body>

</html>