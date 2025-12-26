<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'DataATE') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #F8FAFC;
            --sidebar-width: 260px;
            --sidebar-bg: #FAF9F6;
            --sidebar-active: #EADBC8;
            --accent-orange: #FF7F50; 
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-color); color: var(--text-primary); display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px;
        }

        .logo-container { margin-bottom: 40px; }
        .logo-img { height: 40px; } /* Adjust based on actual logo */
        
        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 8px; flex: 1; }
        
        .nav-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-item a:hover { background-color: rgba(0,0,0,0.03); }
        .nav-item a.active { background-color: #FFEADD; color: #D35400; font-weight: 600; }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #FFE4D6; 
            border-radius: 12px;
            margin-top: auto;
        }
        
        .user-avatar {
            width: 32px; height: 32px;
            background: #D35400;
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 32px 48px;
        }

        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .page-title { font-size: 24px; font-weight: 700; color: var(--text-primary); }

        /* Sub-navigation (Tabs) */
        .sub-nav { display: flex; gap: 8px; background: white; padding: 4px; border-radius: 8px; border: 1px solid var(--border-color); }
        .sub-nav a {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
        }
        .sub-nav a:hover { background: #F1F5F9; }
        .sub-nav a.active { background: #1E293B; color: white; }

        /* Icons */
        .nav-icon { width: 20px; height: 20px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <img src="{{ asset('image/logo.png') }}" alt="HASTA" class="logo-img">
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.document_approvals') }}" class="{{ request()->routeIs('admin.document_approvals') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M9 15l2 2 4-4"></path>
                    </svg>
                    Customers
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('booking.index') }}" class="{{ request()->routeIs('booking.index') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    Booking
                </a>
            </li>
            
            <!-- Fleet Management Section -->
            <li class="nav-item">
                <a href="{{ route('admin.cars.index') }}" class="{{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    Fleet
                </a>
            </li>

            <!-- Loyalty Section -->
            <li class="nav-item">
                <a href="{{ route('admin.vouchers.index') }}" class="{{ request()->routeIs('admin.vouchers.*', 'admin.loyalty.*') ? 'active' : '' }}">
                     <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>  
                    Loyalty
                </a>
            </li>
            
            {{-- Reporting - Manager Only --}}
            @if(optional(Auth::user())->role === 'manager') 
            <li class="nav-item">
                <a href="#">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    Reporting
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="#">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Settings
                </a>
            </li>
        </ul>
        
        <div class="user-profile">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div style="font-size: 14px; font-weight: 600;">{{ Auth::user()->name }}</div>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
