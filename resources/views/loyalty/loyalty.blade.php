<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/personal-data.css') }}">
    <style>
        /* Override body background if personal-data.css doesn't cover it fully or to match standalone look */
        body {
             /* Ensure gradient is applied if personal-data.css has it, otherwise fallback */
             background: linear-gradient(135deg, #D3DCE3 0%, #C5CED6 100%);
             min-height: 100vh;
        }

        .loyalty-card {
            background-color: #55585d;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
        }

        .loyalty-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .stamps-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            justify-items: center;
        }

        .stamp-slot {
            width: 50px;
            height: 50px;
            background-color: #d1d5db; /* Gray-300 */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stamp-slot.active {
            background-color: transparent;
            border: 2px solid white;
        }
        
        .stamp-slot.filled {
             background-color: white; 
             position: relative;
        }
        
        .history-card {
            background-color: #9ca3af; /* Gray-400 */
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 80px; /* Space for fixed bottom buttons */
            min-height: 300px;
            color: #1f2937; /* Gray-800 */
        }
        
        .history-title {
            text-align: center; 
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 24px;
            color: white;
        }

        .history-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            font-weight: 600;
        }
        
        .history-icon {
            width: 45px;
            height: 45px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            border: 2px solid #374151;
        }

        .history-text {
            flex-grow: 1;
            font-size: 14px;
        }
        
        .history-date {
            font-size: 12px;
            color: #4b5563; /* Gray-600 */
            font-weight: 700;
        }
        
        .bottom-buttons {
            position: fixed;
            bottom: 30px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 16px;
            padding: 0 20px;
        }
        
        .btn-redeem {
            background-color: #dc2626; /* Red-600 */
            color: white;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-size: 16px;
            min-width: 120px;
        }

        .btn-redeem:disabled {
            background-color: #ef4444;
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Star SVG Icon */
        .star-icon {
            color: #374151; 
        }

    </style>
</head>

<body>
    <div class="personal-container">
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('profile.edit') }}" style="color: black; text-decoration: none; font-size: 24px; margin-right: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1 style="color: black; font-size: 20px; margin: 0; font-weight: 600;">My Loyalty</h1>
        </div>
    
        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif
    
        <div class="loyalty-card">
            <div class="loyalty-title">Loyalty Card</div>
            <div class="stamps-grid">
                @for ($i = 1; $i <= 15; $i++)
                    @if ($i <= $rentalCounter)
                        <div class="stamp-slot active">
                             <!-- Star Icon -->
                             <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    @else
                        <div class="stamp-slot"></div>
                    @endif
                @endfor
            </div>
        </div>
    
        <div class="history-card">
            <div class="history-title">History</div>
            
            @foreach($history as $item)
            <div class="history-item">
                <div class="history-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
                <div class="history-text">
                    {{ $item->description }}
                </div>
                <div class="history-date">
                    {{ $item->created_at->format('d M Y') }}
                </div>
            </div>
            @endforeach
            
            @if($history->isEmpty())
                <div style="text-align: center; color: #4b5563;">No history yet.</div>
            @endif
        </div>
    
        <div class="bottom-buttons">           
            <!-- Redeem Form -->
            <form action="{{ route('loyalty.redeem') }}" method="POST">
                @csrf
                <button type="submit" class="btn-redeem" {{ $rentalCounter < 3 ? 'disabled' : '' }}>REDEEM</button>
            </form>
        </div>
    </div>
</body>
</html>
