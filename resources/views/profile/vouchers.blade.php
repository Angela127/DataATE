<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Vouchers - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Poppins:wght@400;500;600;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
</head>
<body>
    <div class="voucher-container">
        <!-- Header -->
        <div class="voucher-header">
            <a href="{{ route('profile.edit') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 19L5 12L12 5" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1 class="header-title">My Vouchers</h1>
        </div>

        <!-- Coupon Input (Optional Placeholders) -->
        <div class="coupon-input-section">
            <div class="coupon-input-container">
                <input type="text" class="coupon-input" placeholder="Have a promo code?">
                <button class="apply-btn">Apply</button>
            </div>
        </div>

        <!-- Active Vouchers -->
        <div class="offers-section">
            <h2 class="section-title">Active Vouchers</h2>
            
            <div class="vouchers-list">
                @if($activeVouchers->isEmpty())
                    <p style="text-align: center; color: var(--text-secondary); font-size: 14px;">No active vouchers.</p>
                @else
                    @foreach($activeVouchers as $voucher)
                    <div class="voucher-card">
                        <div class="voucher-left">
                            <span class="voucher-value-text">
                                @if($voucher->discount_percent)
                                    {{ $voucher->discount_percent }}% OFF
                                @else
                                    FREE
                                @endif
                            </span>
                        </div>
                        <div class="voucher-right">
                            <div class="voucher-info">
                                <div class="voucher-title">
                                    @if($voucher->discount_percent)
                                        Discount Voucher
                                    @else
                                        12 Hours Free
                                    @endif
                                </div>
                                <div style="font-size: 11px; color: #666; margin-bottom: 6px;">{{ $voucher->description ?? 'Special reward for you!' }}</div>
                                <div class="voucher-divider"></div>
                                <div class="voucher-desc">
                                    Code: <strong>{{ $voucher->voucher_code }}</strong><br>
                                    Expires: {{ $voucher->expiry_date->format('d M Y') }}
                                </div>
                            </div>
                            <button class="redeem-btn active">Use</button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Past Vouchers -->
        @if($pastVouchers->isNotEmpty())
        <div class="offers-section" style="padding-top: 0;">
            <h2 class="section-title">Past Vouchers</h2>
            <div class="vouchers-list">
                @foreach($pastVouchers as $voucher)
                <div class="voucher-card" style="opacity: 0.7;">
                    <div class="voucher-left" style="background: #e5e5e5;">
                        <span class="voucher-value-text" style="color: #888;">
                            @if($voucher->discount_percent)
                                {{ $voucher->discount_percent }}%
                            @else
                                FREE
                            @endif
                        </span>
                    </div>
                    <div class="voucher-right">
                        <div class="voucher-info">
                            <div class="voucher-title" style="color: #666;">
                                @if($voucher->discount_percent)
                                    Discount Voucher
                                @else
                                    12 Hours Free
                                @endif
                            </div>
                            <div style="font-size: 11px; color: #888; margin-bottom: 6px;">{{ $voucher->description ?? 'Special reward.' }}</div>
                            <div class="voucher-divider"></div>
                            <div class="voucher-desc">
                                Code: {{ $voucher->voucher_code }}<br>
                                @if($voucher->status === 'used')
                                    Used on {{ $voucher->updated_at->format('d M Y') }}
                                @else
                                    Expired on {{ $voucher->expiry_date->format('d M Y') }}
                                @endif
                            </div>
                        </div>
                        <button class="redeem-btn disabled" disabled>
                            @if($voucher->status === 'used')
                                USED
                            @else
                                EXPIRED
                            @endif
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</body>
</html>
