<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Voucher - DataATE</title>
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Poppins:wght@400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="voucher-container">
        <!-- Header -->
        <header class="voucher-header">
            <a href="{{ route('booking.confirm', $bookingParams) }}" class="back-btn">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 16L7 10.5L13 5" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1 class="header-title">SELECT VOUCHER</h1>
        </header>

        <!-- Coupon Code Input -->
        <!-- Logic for manual input can be added here if needed, consistent with the controller -->
        <div class="coupon-input-section">
            <div class="coupon-input-container">
                <input type="text" class="coupon-input" id="couponCode" placeholder="Enter Voucher Code">
                <button class="apply-btn" id="applyBtn" onclick="applyManualCoupon()">APPLY</button>
            </div>
        </div>

        <!-- Available Vouchers Section -->
        <section class="offers-section">
            <h2 class="section-title">Your Active Vouchers</h2>

            <!-- Vouchers List -->
            <div class="vouchers-list" id="vouchersList">
                @forelse($vouchers as $voucher)
                    <div class="voucher-card">
                        <div class="voucher-left">
                            <span class="voucher-value-text">
                                @if($voucher->discount_percent)
                                    {{ $voucher->discount_percent }}% OFF
                                @elseif($voucher->free_hours)
                                    {{ $voucher->free_hours }}H FREE
                                @endif
                            </span>
                        </div>
                        <div class="voucher-right">
                            <div class="voucher-info">
                                <h3 class="voucher-title">{{ $voucher->voucher_code }}</h3>
                                <div class="voucher-divider"></div>
                                <p class="voucher-desc">
                                    Expires on {{ $voucher->expiry_date->format('d M Y') }}
                                </p>
                            </div>
                            <button class="redeem-btn" onclick="selectVoucher('{{ $voucher->voucher_code }}')">
                                USE
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="no-vouchers">
                        <p>No active vouchers found.</p>
                        <a href="{{ route('loyalty.index') }}">Go to Loyalty Page to redeem rewards!</a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <script>
        function selectVoucher(code) {
            // Construct URL with voucher_code
            let url = new URL("{{ route('booking.confirm') }}");
            
            // Add existing booking params safely
            const bookingParams = @json($bookingParams);
            
            Object.keys(bookingParams).forEach(key => {
                if(bookingParams[key] !== null && bookingParams[key] !== undefined) {
                    url.searchParams.set(key, bookingParams[key]);
                }
            });

            // Set the voucher code
            url.searchParams.set('voucher_code', code);
            
            window.location.href = url.toString();
        }

        function applyManualCoupon() {
            const code = document.getElementById('couponCode').value;
            if(code) {
                selectVoucher(code);
            }
        }
    </script>
</body>
</html>

