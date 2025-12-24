@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataATE - Car Rentals in UTM</title>
    <link rel="stylesheet" href="{{ asset('css/mainpage.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Righteous&family=Suez+One&family=Tilt+Warp&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-gradient"></div>
        
        <!-- Navigation -->
        <nav class="navbar">
            <div class="logo">
                <img src="{{ asset('image/logo.png') }}" alt="DataATE Logo">
            </div>
            <ul class="nav-links">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#car-rental">Car Rental</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}">Notification</a></li>
                    <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                @endauth
            </ul>
            <div class="auth-buttons">
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                @endauth
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="hero-content">
            <div class="hero-text">
                <h1>NO.1 CAR RENTALS<br>IN UTM</h1>
                <p class="tagline">FIND THE PERFECT CAR<br>FOR RENT TODAY!</p>
                <button class="explore-btn" onclick="scrollToCarModels()">EXPLORE NOW</button>
            </div>
            
            <div class="hero-car-section">
                <img src="{{ asset('image/hero-car.svg') }}" alt="Featured Car" class="hero-car-img">
                <div class="car-specs">
                    <span class="color-label">WHITE</span>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Production</span>
                            <span class="spec-value">2020-present</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Max speed</span>
                            <span class="spec-value">37km/h</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Engine</span>
                            <span class="spec-value">4.0 H0000T</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows and Dots -->
        <div class="hero-nav">
            <button class="nav-arrow prev">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
            </button>
            <div class="nav-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            <button class="nav-arrow next">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </button>
        </div>
    </section>

    <!-- Car Models Section -->
    <section class="car-models" id="car-rental">
        <h2 class="section-title">Car Models</h2>
        <div class="cars-grid" id="carsGrid">
            @forelse ($cars as $car)
                @php
                    $modelLower = Str::lower($car->model);
                    $imagePath = 'image/default-avatar.svg';

                    if (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2014')) {
                        $imagePath = 'image/car-axia-2014.png';
                    } elseif (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2015')) {
                        $imagePath = 'image/car-axia-2015.png';
                    } elseif (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2016')) {
                        $imagePath = 'image/car-axia-2016.png';
                    } elseif (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2018')) {
                        $imagePath = 'image/car-axia-2018.png';
                    } elseif (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2024-1')) {
                        $imagePath = 'image/car-axia-2024-1.png';
                    } elseif (Str::contains($modelLower, 'axia') && Str::contains($modelLower, '2024-2')) {
                        $imagePath = 'image/car-axia-2024-2.png';    
                    } elseif (Str::contains($modelLower, 'myvi') && Str::contains($modelLower, '2013')) {
                        $imagePath = 'image/car-myvi-2013.png';
                    } elseif (Str::contains($modelLower, 'myvi') && Str::contains($modelLower, '2016')) {
                        $imagePath = 'image/car-myvi-2016.png';
                    } elseif (Str::contains($modelLower, 'bezza') && Str::contains($modelLower, '2013')) {
                        $imagePath = 'image/car-bezza-2013.png';
                    } elseif (Str::contains($modelLower, 'bezza') && Str::contains($modelLower, '2023-1')) {
                        $imagePath = 'image/car-bezza-2023-1.png';
                    } elseif (Str::contains($modelLower, 'bezza') && Str::contains($modelLower, '2023-2')) {
                        $imagePath = 'image/car-bezza-2023-2.png';
                    }elseif (Str::contains($modelLower, 'beat') && Str::contains($modelLower, '110')) {
                        $imagePath = 'image/car-beat-110.png';
                    }elseif (Str::contains($modelLower, 'dash') && Str::contains($modelLower, '125')) {
                        $imagePath = 'image/car-dash-125.png';
                    }

                    $isAvailable = ($car->availability_status === 'Available');
                @endphp

                <div class="car-card {{ $isAvailable ? '' : 'unavailable' }}" data-car-name="{{ $car->model }}">
                    <div class="car-image">
                        <img src="{{ asset($imagePath) }}" alt="{{ $car->model }}" loading="lazy">
                    </div>
                    <div class="car-info">
                        <h3 class="car-name">{{ $car->model }}</h3>

                        <div class="car-actions">
                            @if ($isAvailable)
                                <button class="btn btn-rent" data-car-name="{{ $car->model }}">Rent</button>
                                <button class="btn btn-details" data-car-name="{{ $car->model }}">Details</button>
                            @else
                                <button class="btn btn-unavailable" disabled>Not Available</button>
                            @endif
                        </div>

                        <div class="car-details" style="display: none;">
                            <p class="car-price">RM {{ number_format($car->price_hour, 2) }} / hour</p>
                            <p class="car-status {{ $isAvailable ? 'status-available' : 'status-unavailable' }}">
                                {{ $car->availability_status }}
                            </p>
                            <p class="car-meta">Mileage: {{ $car->car_mileage }} km</p>
                            <p class="car-meta">Fuel: {{ $car->fuel_level }}%</p>
                        </div>
                    </div>
                </div>
            @empty
                <p style="text-align:center; margin-top: 1rem;">
                    No cars available at the moment.
                </p>
            @endforelse
        </div>
    </section>

    <script src="{{ asset('js/mainpage.js') }}"></script>
</body>
</html>