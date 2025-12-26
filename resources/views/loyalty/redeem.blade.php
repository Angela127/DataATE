<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Redeem Reward - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&family=Poppins:wght@400;500;600;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
    
    <style>
        /* Extra styles for redeem specific elements if needed */
        .current-stamps-banner {
            background: var(--accent-blue-dark);
            color: white;
            padding: 16px;
            border-radius: 12px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <!-- Header -->
        <div class="voucher-header">
            <a href="{{ route('loyalty.index') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 19L5 12L12 5" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1 class="header-title">Redeem Rewards</h1>
        </div>

        <div class="offers-section" style="margin-top: -60px;">
            <!-- Stamps Counter -->
            <div class="current-stamps-banner">
                Current Stamps: {{ $stamps }}
            </div>

            @if (session('error'))
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-family: 'Poppins', sans-serif; font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('voucher.store') }}" method="POST" id="redeemForm">
                @csrf
                <input type="hidden" name="tier" id="tierInput">
                <div class="vouchers-list">
                    @foreach($tiers as $cost => $rule)
                    <div class="voucher-card">
                        <div class="voucher-left" style="{{ $rule['type'] === 'free_hours' ? 'background: #dbeafe;' : '' }}">
                            <span class="voucher-value-text" style="{{ $rule['type'] === 'free_hours' ? 'color: #1e40af;' : '' }}">
                                {{ $rule['type'] === 'discount' ? $rule['amount'].'%' : 'FREE' }}
                            </span>
                        </div>
                        <div class="voucher-right">
                            <div class="voucher-info">
                                <div class="voucher-title">
                                    {{ $rule['type'] === 'discount' ? $rule['amount'].'% Off' : $rule['amount'].' Hours Free' }}
                                </div>
                                <div class="voucher-divider"></div>
                                <div class="voucher-desc">Cost: <strong>{{ $cost }} Stamps</strong></div>
                            </div>
                            <button type="button" class="redeem-btn {{ $stamps >= $cost ? 'active' : 'disabled' }}" 
                                onclick="{{ $stamps >= $cost ? 'submitRedeem('.$cost.')' : '' }}" 
                                {{ $stamps < $cost ? 'disabled' : '' }}>
                                Redeem
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

    <script>
        function submitRedeem(tier) {
            if(confirm('Are you sure you want to redeem ' + tier + ' stamps? This will consume your stamps.')) {
                document.getElementById('tierInput').value = tier;
                document.getElementById('redeemForm').submit();
            }
        }
    </script>
</body>
</html>
