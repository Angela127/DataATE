<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verification - HASTA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fef9f3;
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #fff;
            padding: 20px;
            border-right: 1px solid #f0e6d9;
        }

        .logo {
            background-color: #ff6b35;
            color: white;
            padding: 10px 15px;
            font-size: 24px;
            font-weight: 700;
            border-radius: 8px;
            margin-bottom: 40px;
            display: inline-block;
        }

        .logo span {
            color: #fff;
            border: 2px solid white;
            padding: 2px 6px;
            margin: 0 2px;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 15px 10px;
            margin-bottom: 5px;
            border-radius: 8px;
            cursor: pointer;
            color: #333;
            font-weight: 500;
            text-decoration: none;
        }

        .nav-item:hover {
            background-color: #fff5ee;
        }

        .nav-item.active {
            background-color: #fff5ee;
            color: #ff6b35;
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            margin-right: 12px;
        }

        .company-badge {
            position: absolute;
            bottom: 30px;
            left: 20px;
            display: flex;
            align-items: center;
            background-color: #ffe8dc;
            padding: 10px 15px;
            border-radius: 10px;
        }

        .company-badge .icon {
            background-color: #ff6b35;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 10px;
        }

        .company-badge .text {
            font-size: 12px;
            font-weight: 600;
            color: #333;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
        }

        .page-title {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .tab {
            font-size: 16px;
            font-weight: 500;
            color: #888;
            cursor: pointer;
            padding-bottom: 10px;
            border-bottom: 3px solid transparent;
            margin-bottom: -12px;
            text-decoration: none;
        }

        .tab:hover {
            color: #ff6b35;
        }

        .tab.active {
            color: #333;
            border-bottom-color: #ff6b35;
        }

        /* Booking Card */
        .booking-card {
            background-color: #fffaf5;
            border: 1px solid #f5e6d8;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .booking-card:hover {
            border-color: #ff6b35;
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.1);
        }

        .booking-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .car-image {
            width: 150px;
            height: 100px;
            object-fit: contain;
            border-radius: 10px;
        }

        .car-details {
            flex: 1;
        }

        .car-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .car-plate {
            font-size: 14px;
            color: #888;
        }

        .booking-info {
            display: flex;
            gap: 40px;
            margin-top: 15px;
        }

        .info-block {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-label svg {
            width: 16px;
            height: 16px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .info-time {
            font-size: 12px;
            color: #888;
        }

        .price-block {
            text-align: right;
        }

        .price {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .price .currency-icon {
            background-color: #4caf50;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .invoice-info {
            font-size: 11px;
            color: #888;
            margin-top: 5px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 5px 0;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }

        .status-pending { color: #ff9800; }
        .status-verified { color: #4caf50; }
        .status-failed { color: #f44336; }
        .status-declined { color: #f44336; }
        .status-ongoing { color: #ff6b35; }

        /* Receipt Section */
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #ff6b35;
            display: inline-block;
        }

        .receipt-container {
            background-color: #fff;
            border: 1px solid #f0e6d9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .receipt-image {
            max-width: 300px;
            max-height: 400px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .receipt-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ff6b35;
            font-weight: 500;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #fff5ee;
            border-radius: 8px;
        }

        .receipt-link:hover {
            background-color: #ffe8dc;
        }

        /* Verification Section */
        .verification-section {
            background-color: #fff;
            border: 1px solid #f0e6d9;
            border-radius: 10px;
            padding: 20px;
        }

        .current-status {
            margin-bottom: 20px;
        }

        .current-status label {
            font-size: 14px;
            color: #888;
            display: block;
            margin-bottom: 5px;
        }

        .current-status .status-value {
            font-size: 16px;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-accept {
            background-color: #4caf50;
            color: white;
        }

        .btn-accept:hover {
            background-color: #43a047;
        }

        .btn-decline {
            background-color: #f44336;
            color: white;
        }

        .btn-decline:hover {
            background-color: #e53935;
        }

        /* Customer Info */
        .customer-info {
            background-color: #fff;
            border: 1px solid #f0e6d9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .label {
            color: #888;
            font-size: 14px;
        }

        .info-row .value {
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">HA<span>S</span>TA</div>
            
            <ul class="nav-menu">
                <a href="#" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Booking
                </a>
                <a href="#" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Customers
                </a>
                <a href="#" class="nav-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Fleet
                </a>
                <a href="#" class="nav-item">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Reporting
</a>
<a href="{{ url('/payment/verify') }}" class="nav-item active">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Payment Verification
</a>
<a href="#" class="nav-item">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Settings
</a>
            </ul>

            <div class="company-badge">
                <div class="icon">HT</div>
                <div class="text">Hasta Travel & Tours<br>Sdn. Bhd.</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">Payment Verification</div>

            <!-- Tabs -->
            <div class="tabs">
                <a href="{{ url('/payment/verify?tab=all') }}" class="tab {{ ($currentTab ?? '') === 'all' ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ url('/payment/verify?tab=pending') }}" class="tab {{ ($currentTab ?? '') === 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ url('/payment/verify?tab=verified') }}" class="tab {{ ($currentTab ?? '') === 'verified' ? 'active' : '' }}">
                    Verified
                </a>
                <a href="{{ url('/payment/verify?tab=failed') }}" class="tab {{ ($currentTab ?? '') === 'failed' ? 'active' : '' }}">
                    Failed
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- LIST VIEW: Show all rentals -->
            @if(isset($rentals) && $rentals && count($rentals) > 0)
                <div class="pending-list">
                    <h3 style="margin-bottom: 15px; color: #333;">
                        {{ ucfirst($currentTab ?? 'Pending') }} Verifications ({{ count($rentals) }})
                    </h3>
                    
                    @foreach($rentals as $item)
                        <div class="booking-card" style="cursor: pointer;" onclick="window.location='{{ url('/payment/verify/' . $item->id) }}'">
                            <div class="booking-card-header">
                                <img src="{{ isset($item->car) && $item->car->image_path ? asset($item->car->image_path) : asset('image/default-car.png') }}" 
                                     alt="Car" class="car-image">

                                <div class="car-details">
                                    <div class="car-name">
                                        {{ $item->car->model ?? 'N/A' }}
                                    </div>
                                    <div class="car-plate">
                                        {{ $item->plate_no ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="booking-info">
                                    <div class="info-block">
                                        <div class="info-label">Pick Up</div>
                                        <div class="info-value">{{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d M Y') : 'N/A' }}</div>
                                    </div>

                                    <div class="info-block">
                                        <div class="info-label">Return</div>
                                        <div class="info-value">{{ $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d M Y') : 'N/A' }}</div>
                                    </div>
                                </div>

                                    <div class="price-block">
                                    <div class="status-badge status-{{ strtolower($item->payment->verification_status ?? 'pending') }}">
                                        {{ ucfirst($item->payment->verification_status ?? 'Pending') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            <!-- DETAIL VIEW: Show specific rental -->
            @elseif(isset($rental) && $rental)
                <!-- Booking Card -->
                <div class="booking-card">
                    <div class="booking-card-header">
                        <img src="{{ isset($rental->car) && $rental->car->image_path ? asset($rental->car->image_path) : asset('image/default-car.png') }}" 
                             alt="Car" class="car-image">
                        
                        <div class="car-details">
                            <div class="car-name">
                                {{ $rental->car->model ?? 'N/A' }}
                            </div>
                            <div class="car-plate">
                                {{ $rental->plate_no ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="booking-info">
                            <div class="info-block">
                                <div class="info-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    Pick Up
                                </div>
                                <div class="info-value">{{ $rental->start_time ? \Carbon\Carbon::parse($rental->start_time)->format('d M Y') : 'N/A' }}</div>
                                <div class="info-time">{{ $rental->start_time ? \Carbon\Carbon::parse($rental->start_time)->format('h:i A') : 'N/A' }}</div>
                            </div>

                            <div class="info-block">
                                <div class="info-label">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Return
                                </div>
                                <div class="info-value">{{ $rental->end_time ? \Carbon\Carbon::parse($rental->end_time)->format('d M Y') : 'N/A' }}</div>
                                <div class="info-time">{{ $rental->end_time ? \Carbon\Carbon::parse($rental->end_time)->format('h:i A') : 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="price-block">
                            @php
                                    $hours = 0;
                                    $totalPrice = 0;

                                    // Use stored payment amount if available
                                    if(isset($rental->payment) && $rental->payment->amount > 0) {
                                        $totalPrice = $rental->payment->amount;
                                    } else {
                                        // Fallback calculation
                                        if ($rental->start_time && $rental->end_time) {
                                            $start = \Carbon\Carbon::parse($rental->start_time);
                                            $end = \Carbon\Carbon::parse($rental->end_time);
                                            $hours = $start->diffInHours($end);
                                            if ($hours < 1) $hours = 1; 
                                        }
                                        $pricePerHour = $rental->car->price_hour ?? 0;
                                        $totalPrice = $hours * $pricePerHour;
                                    }
                                @endphp
                                <div class="price">
                                    <span class="currency-icon">$</span>
                                    MYR {{ number_format($totalPrice, 2) }}
                                </div>
                            <div class="invoice-info">
                                #{{ $rental->id ?? 'N/A' }}<br>
                                PAY: {{ $rental->payment->payment_id ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="status-badge status-{{ strtolower($rental->payment->verification_status ?? 'pending') }}">
                        Status: {{ ucfirst($rental->payment->verification_status ?? 'Pending') }}
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="section-title">Customer Information</div>
                <div class="customer-info">
                    <div class="info-row">
                        <span class="label">Customer Name</span>
                        <span class="value">{{ $rental->customer->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Email</span>
                        <span class="value">{{ $rental->customer->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Phone</span>
                        <span class="value">{{ $rental->customer->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Pickup Location</span>
                        <span class="value">{{ $rental->pick_up_location ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Return Location</span>
                        <span class="value">{{ $rental->return_location ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Destination</span>
                        <span class="value">{{ $rental->destination ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Payment Status</span>
                        <span class="value">{{ ucfirst($rental->payment_status ?? 'Pending') }}</span>
                    </div>
                </div>

                <!-- Payment Receipt -->
<div class="section-title">Payment Receipt</div>
<div class="receipt-container">

    @if(isset($rental->payment->receipt_path) && $rental->payment->receipt_path)
        @php
            $extension = pathinfo($rental->payment->receipt_path, PATHINFO_EXTENSION);
        @endphp

        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
            <a href="{{ asset('storage/' . $rental->payment->receipt_path) }}" target="_blank">
                <img src="{{ asset('storage/' . $rental->payment->receipt_path) }}" 
                    alt="Payment Receipt" 
                    class="receipt-image"
                    style="cursor: pointer;"
                    title="Click to view full size">
            </a>
        @elseif(strtolower($extension) === 'pdf')
            <a href="{{ asset('storage/' . $rental->payment->receipt_path) }}" 
               target="_blank" 
               class="receipt-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                View / Download Receipt (PDF)
            </a>
        @else
            <a href="{{ asset('storage/' . $rental->payment->receipt_path) }}" 
               target="_blank" 
               class="receipt-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Receipt
            </a>
        @endif
    @else
        <p style="color: #888;">No receipt uploaded yet.</p>
    @endif
</div>

                <!-- Verification Action -->
                <div class="section-title">Verification Action</div>
                <div class="verification-section">
                    <div class="current-status">
                        <label>Current Verification Status:</label>
                        <span class="status-value status-{{ strtolower($rental->payment->verification_status ?? 'pending') }}">
                            {{ ucfirst($rental->payment->verification_status ?? 'Pending') }}
                        </span>
                    </div>

                    <div class="action-buttons">
                        <!-- Accept Form -->
                        <form action="{{ route('payment.verify.accept', $rental->id ?? 1) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-accept">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Accept Payment
                            </button>
                        </form>

                        <!-- Decline Form -->
                        <form action="{{ route('payment.verify.decline', $rental->id ?? 1) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                            @csrf
                            <button type="submit" class="btn btn-decline">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Decline Payment
                            </button>

                            <select name="reason" style="padding: 12px; border: 1px solid #f44336; border-radius: 8px; color: #333; width: 200px;" required>
                                <option value="" disabled selected>Select Rejection Reason</option>
                                <option value="Incorrect Amount">Incorrect Amount</option>
                                <option value="Invalid Account">Invalid Account</option>
                                <option value="Other">Other</option>
                            </select>
                        </form>
                    </div>
                </div>

            <!-- EMPTY STATE: No rentals found -->
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3>No Pending Verifications</h3>
                    <p>All payments have been verified. Check back later!</p>
                </div>
            @endif

        </div>
    </div>
</body>
</html>