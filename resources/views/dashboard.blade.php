<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'DataATE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* CSS Variables */
        :root {
            --bg-color: #D3DCE3;
            --card-bg: rgba(255, 255, 255, 0.85);
            --text-primary: #000000;
            --text-secondary: rgba(0, 0, 0, 0.6);
            --text-muted: rgba(0, 0, 0, 0.5);
            --accent-blue: #0B1C3F;
            --accent-teal: #113C3C;
            --btn-primary: #14213D;
            --success-green: #14AE5C;
            --warning-orange: #F5A623;
            --white: #FFFFFF;
            --shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Navigation */
        .dashboard-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            background: transparent;
        }

        .nav-logo img {
            height: 32px;
            width: auto;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 40px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--text-secondary);
        }

        .nav-links a.active {
            color: var(--text-muted);
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        .user-name {
            font-weight: 500;
            font-size: 14px;
        }

        /* Main Container */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 40px 60px;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 40px;
        }

        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .stat-icon.blue { background: rgba(11, 28, 63, 0.1); }
        .stat-icon.green { background: rgba(20, 174, 92, 0.1); }
        .stat-icon.orange { background: rgba(245, 166, 35, 0.1); }
        .stat-icon.teal { background: rgba(17, 60, 60, 0.1); }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Quick Actions */
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .action-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 28px 24px;
            text-decoration: none;
            color: var(--text-primary);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.12);
            background: rgba(255, 255, 255, 0.95);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--accent-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .action-icon svg {
            width: 28px;
            height: 28px;
            color: var(--white);
        }

        .action-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .action-desc {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* Recent Activity */
        .activity-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .activity-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: rgba(0, 0, 0, 0.02);
            border-radius: 12px;
        }

        .activity-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .activity-dot.success { background: var(--success-green); }
        .activity-dot.pending { background: var(--warning-orange); }
        .activity-dot.info { background: var(--accent-blue); }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .empty-activity {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }

        .empty-activity svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Responsive - Tablet */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Responsive - Mobile */
        @media (max-width: 768px) {
            .dashboard-nav {
                flex-direction: column;
                gap: 20px;
                padding: 15px 20px;
            }
            
            .nav-links {
                gap: 20px;
            }
            
            .dashboard-container {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 24px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Laptop Layout Enhancements */
        @media (min-width: 1024px) {
            body {
                background: linear-gradient(135deg, #D3DCE3 0%, #C5CED6 100%);
            }
            
            .dashboard-nav {
                padding: 25px 60px;
            }
            
            .nav-logo img {
                height: 36px;
            }
            
            .nav-links {
                gap: 50px;
            }
            
            .nav-links a {
                font-size: 15px;
            }
            
            .dashboard-container {
                padding: 40px 60px 80px;
            }
            
            .welcome-title {
                font-size: 36px;
            }
            
            .stat-card {
                padding: 28px;
            }
            
            .stat-value {
                font-size: 32px;
            }
        }

        @media (min-width: 1440px) {
            .dashboard-container {
                max-width: 1400px;
            }
            
            .stats-grid {
                gap: 30px;
            }
            
            .actions-grid {
                gap: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="dashboard-nav">
        <div class="nav-logo">
            <a href="{{ route('mainpage') }}">
                <img src="{{ asset('image/logo.png') }}" alt="DataATE Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('mainpage') }}">Home</a></li>
            <li><a href="{{ route('mainpage') }}#car-rental">Car Rental</a></li>
            <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
        </ul>
        <div class="nav-user">
            <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <span class="user-name">{{ Auth::user()->name }}</span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="welcome-subtitle">Here's what's happening with your rentals today.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#0B1C3F" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Active Bookings</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#14AE5C" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Completed Rentals</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#F5A623" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Pending Returns</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#113C3C" stroke-width="2">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Vouchers</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h2 class="section-title">Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('mainpage') }}#car-rental" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                </div>
                <span class="action-title">New Booking</span>
                <span class="action-desc">Reserve a car for your next trip</span>
            </a>

            <a href="{{ route('profile.order-history') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <span class="action-title">Order History</span>
                <span class="action-desc">View your past and current bookings</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="action-title">Profile Settings</span>
                <span class="action-desc">Update your personal information</span>
            </a>
        </div>

        <!-- Recent Activity -->
        <h2 class="section-title">Recent Activity</h2>
        <div class="activity-card">
            <div class="activity-list">
                <div class="empty-activity">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <p>No recent activity yet. Start by making your first booking!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
