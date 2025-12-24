<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Personal Data - {{ config('app.name', 'DataATE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/personal-data.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="personal-nav">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('image/logo.png') }}" alt="DataATE Logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/#car-rental') }}">Car Rental</a></li>
            <li><a href="#">Notification</a></li>
            <li><a href="{{ route('profile.edit') }}" class="active">Profile</a></li>
        </ul>
    </nav>

    <div class="personal-container">
        <!-- Back Button -->
        <a href="{{ route('profile.edit') }}" class="back-button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15,18 9,12 15,6"></polyline>
            </svg>
            Back to Profile
        </a>

        <!-- Page Title -->
        <h1 class="page-title">Personal Data</h1>

        @php
            $activeTab = old('tab', 'personal');
        @endphp

        @if ($errors->any())
            <div class="error-message" style="margin-bottom: 16px; text-align: left;">
                <ul style="margin-left: 20px; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('status') === 'personal-data-updated')
            <div class="success-message show">
                Your personal data has been updated successfully!
            </div>
        @endif

        <!-- Main Form -->
        <form method="POST" action="{{ route('profile.personal-data.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            
            <div class="personal-layout">
                <!-- Left Sidebar Tabs -->
                <div class="sidebar-tabs">
                    <button type="button" class="side-tab {{ $activeTab === 'personal' ? 'active' : '' }}" onclick="showTab('personal')">
                        Personal Information
                    </button>
                    <button type="button" class="side-tab {{ $activeTab === 'emergency' ? 'active' : '' }}" onclick="showTab('emergency')">
                        Emergency Contact
                    </button>
                    <button type="button" class="side-tab {{ $activeTab === 'documents' ? 'active' : '' }}" onclick="showTab('documents')">
                        Documents
                    </button>
                </div>

                <!-- Right Content Area -->
                <div class="content-area">

        <!-- Personal Information Tab -->
        <div id="personal-tab" class="tab-content {{ $activeTab === 'personal' ? 'active' : '' }}">
            <!-- Form content directly -->

                <div class="form-fields">
                    <!-- Username with Avatar -->
                    <div class="field-card with-avatar">
                        <div class="field-left">
                            <div class="field-avatar" style="overflow: visible !important;">
                                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->username ?? $user->name) . '&background=3E5789&color=fff' }}" alt="Profile" id="avatarPreview" style="border-radius: 50%;">
                                <div class="avatar-edit" onclick="document.getElementById('avatarInput').click()">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                        <circle cx="12" cy="13" r="4"></circle>
                                    </svg>
                                </div>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                            </div>
                            <div class="field-info">
                                <span class="field-label">Username</span>
                                <input type="text" name="username" class="field-input" value="{{ old('username', $customer->username ?? $user->name) }}" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Full Name -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Full Name</span>
                            <input type="text" name="name" class="field-input" value="{{ old('name', $user->name) }}" placeholder="Enter full name">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Gender -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Gender</span>
                            <select name="gender" class="field-input field-select">
                            <option value="" disabled {{ empty($gender) ? 'selected' : '' }}>
                                Select Gender
                            </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>

                        </div>

                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    @error('gender')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <!-- Nationality -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Nationality</span>
                            <input type="text" name="nationality" class="field-input" value="{{ old('nationality', $customer->nationality ?? 'Malaysia') }}" placeholder="Enter nationality">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('nationality')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Matric Number -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Matric / Staff Number</span>
                            <input type="text" name="matric_staff_no" class="field-input" value="{{ old('matric_staff_no', $customer->matric_staff_no ?? '') }}" placeholder="e.g. A24CS1234">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('matric_staff_no')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Faculty -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Faculty</span>

                            @php
                                $faculty = old('faculty', $customer->faculty ?? '');
                            @endphp

                            <select name="faculty" class="field-input field-select">
                                <option value="" disabled {{ empty($faculty) ? 'selected' : '' }}>
                                    Select Faculty
                                </option>

                                <option value="Azman Hashim International Business School (AHIBS)"
                                    {{ $faculty === 'Azman Hashim International Business School (AHIBS)' ? 'selected' : '' }}>
                                    Azman Hashim International Business School (AHIBS)
                                </option>

                                <option value="Faculty of Artificial Intelligence (FAI)"
                                    {{ $faculty === 'Faculty of Artificial Intelligence (FAI)' ? 'selected' : '' }}>
                                    Faculty of Artificial Intelligence (FAI)
                                </option>

                                <option value="Faculty of Built Environment and Surveying"
                                    {{ $faculty === 'Faculty of Built Environment and Surveying' ? 'selected' : '' }}>
                                    Faculty of Built Environment and Surveying
                                </option>

                                <option value="Faculty of Chemical & Energy Engineering"
                                    {{ $faculty === 'Faculty of Chemical & Energy Engineering' ? 'selected' : '' }}>
                                    Faculty of Chemical &amp; Energy Engineering
                                </option>

                                <option value="Faculty of Computing"
                                    {{ $faculty === 'Faculty of Computing' ? 'selected' : '' }}>
                                    Faculty of Computing
                                </option>

                                <option value="Faculty of Educational Sciences and Technology (FEST)"
                                    {{ $faculty === 'Faculty of Educational Sciences and Technology (FEST)' ? 'selected' : '' }}>
                                    Faculty of Educational Sciences and Technology (FEST)
                                </option>

                                <option value="Faculty of Electrical Engineering"
                                    {{ $faculty === 'Faculty of Electrical Engineering' ? 'selected' : '' }}>
                                    Faculty of Electrical Engineering
                                </option>

                                <option value="Faculty of Management"
                                    {{ $faculty === 'Faculty of Management' ? 'selected' : '' }}>
                                    Faculty of Management
                                </option>

                                <option value="Faculty of Mechanical Engineering"
                                    {{ $faculty === 'Faculty of Mechanical Engineering' ? 'selected' : '' }}>
                                    Faculty of Mechanical Engineering
                                </option>

                                <option value="Faculty of Science"
                                    {{ $faculty === 'Faculty of Science' ? 'selected' : '' }}>
                                    Faculty of Science
                                </option>

                                <option value="Faculty of Social Sciences and Humanities"
                                    {{ $faculty === 'Faculty of Social Sciences and Humanities' ? 'selected' : '' }}>
                                    Faculty of Social Sciences and Humanities
                                </option>

                                <option value="Malaysia-Japan International Institute of Technology (MJIIT)"
                                    {{ $faculty === 'Malaysia-Japan International Institute of Technology (MJIIT)' ? 'selected' : '' }}>
                                    Malaysia-Japan International Institute of Technology (MJIIT)
                                </option>
                            </select>
                        </div>

                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    @error('faculty')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Kolej -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Kolej</span>

                            @php
                                $kolej = old('residential_college', $customer->residential_college ?? '');
                            @endphp

                            <select name="residential_college" class="field-input field-select">
                                <option value="" disabled {{ empty($kolej) ? 'selected' : '' }}>
                                    Select Kolej
                                </option>

                                <option value="Kolej Tun Dr Ismail" {{ $kolej === 'Kolej Tun Dr Ismail' ? 'selected' : '' }}>
                                    Kolej Tun Dr Ismail
                                </option>
                                <option value="Kolej Rahman Putra" {{ $kolej === 'Kolej Rahman Putra' ? 'selected' : '' }}>
                                    Kolej Rahman Putra
                                </option>
                                <option value="Kolej Tun Fatimah" {{ $kolej === 'Kolej Tun Fatimah' ? 'selected' : '' }}>
                                    Kolej Tun Fatimah
                                </option>
                                <option value="Kolej Tun Razak" {{ $kolej === 'Kolej Tun Razak' ? 'selected' : '' }}>
                                    Kolej Tun Razak
                                </option>
                                <option value="Kolej Tun Hussein Onn" {{ $kolej === 'Kolej Tun Hussein Onn' ? 'selected' : '' }}>
                                    Kolej Tun Hussein Onn
                                </option>
                                <option value="Kolej Tuanku Canselor" {{ $kolej === 'Kolej Tuanku Canselor' ? 'selected' : '' }}>
                                    Kolej Tuanku Canselor
                                </option>
                                <option value="Kolej Perdana" {{ $kolej === 'Kolej Perdana' ? 'selected' : '' }}>
                                    Kolej Perdana
                                </option>
                                <option value="Kolej 9 & 10" {{ $kolej === 'Kolej 9 & 10' ? 'selected' : '' }}>
                                    Kolej 9 &amp; 10
                                </option>
                                <option value="Kolej Datin Seri Endon" {{ $kolej === 'Kolej Datin Seri Endon' ? 'selected' : '' }}>
                                    Kolej Datin Seri Endon
                                </option>
                                <option value="Kolej Dato Onn Jaafar" {{ $kolej === 'Kolej Dato Onn Jaafar' ? 'selected' : '' }}>
                                    Kolej Dato Onn Jaafar
                                </option>
                            </select>
                        </div>

                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    @error('residential_college')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Residential Address -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Residential Address</span>
                            <input type="text" name="address" class="field-input" value="{{ old('address', $customer->address ?? '') }}" placeholder="Enter your address">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Phone Number -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Phone Number</span>
                            <input type="tel" name="phone" class="field-input" value="{{ old('phone', $customer->phone ?? '') }}" placeholder="e.g. +(60)12-3456789">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

            <!-- End of Personal Tab Content -->
        </div>

        <!-- Emergency Contact Tab -->
        <div id="emergency-tab" class="tab-content {{ $activeTab === 'emergency' ? 'active' : '' }}">
            <!-- Form content directly -->

                <div class="form-fields">
                    <!-- Emergency Contact Name -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Emergency Contact Name</span>
                            <input type="text" name="emergency_contact_name" class="field-input" value="{{ old('emergency_contact_name', $customer->emergency_contact_name ?? '') }}" placeholder="Enter contact name">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('emergency_contact_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Emergency Contact Relationship -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Relationship</span>
                            <input type="text" name="relationship" class="field-input" value="{{ old('relationship', $customer->relationship ?? '') }}" placeholder="e.g. Parent, Sibling">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('relationship')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Emergency Contact Phone -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Emergency Contact Phone</span>
                            <input type="tel" name="emergency_phone" class="field-input" value="{{ old('emergency_phone', $customer->emergency_phone ?? '') }}" placeholder="e.g. +(60)12-3456789">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('emergency_phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

            <!-- End of Emergency Tab Content -->
        </div>

        <!-- Documents Tab -->
        <div id="documents-tab" class="tab-content {{ $activeTab === 'documents' ? 'active' : '' }}">
            <!-- Form content directly -->

                <div class="form-fields">
                    <!-- IC/Passport -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">IC / Passport Number</span>
                            <input type="text" name="ic_passport" class="field-input" value="{{ old('ic_passport', $customer->ic_passport ?? '') }}" placeholder="Enter IC or Passport number">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('ic_passport')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- IC/passport image -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Identity Card/Passport</span>
                            <input type="file" name="identity_card_image" class="field-input" accept="image/*">
                            @if(isset($customer->identity_card_image) && $customer->identity_card_image)
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-600">Current file: </span>
                                        <a href="{{ asset($customer->identity_card_image) }}" target="_blank" 
                                        class="text-blue-600 hover:underline">View uploaded IC/Passport</a>
                                    </div>
                            @endif
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('identity_card_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Driving License -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Driving License Number</span>
                            <input type="text" name="license_no" class="field-input" value="{{ old('license_no', $customer->license_no ?? '') }}" >
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('license_no')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- Driving License image -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Driving License Image</span>
                            <input type="file" name="license_image" class="field-input" accept="image/*">
                                @if(isset($customer->license_image) && $customer->license_image)
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-600">Current file: </span>
                                        <a href="{{ asset($customer->license_image) }}" target="_blank" 
                                        class="text-blue-600 hover:underline">View uploaded license</a>
                                    </div>
                                @endif
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('license_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <!-- License Expiry Date -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">License Expiry Date</span>
                            <input type="date" name="license_expiry" class="field-input" value="{{ old('license_expiry', $customer->license_expiry ?? '') }}" style="width: fit-content; align-self: flex-start;">
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('license_expiry')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                <!-- Student/Staff card -->
                    <div class="field-card">
                        <div class="field-info">
                            <span class="field-label">Student/Staff Card</span>
                            <input type="file" name="matric_staff_image" class="field-input" accept="image/*">
                            @if(isset($customer->matric_staff_image) && $customer->matric_staff_image)
                                    <div class="mt-2">
                                        <span class="text-sm text-gray-600">Current file: </span>
                                        <a href="{{ asset($customer->matric_staff_image) }}" target="_blank" 
                                        class="text-blue-600 hover:underline">View uploaded Student/Staff Card</a>
                                    </div>
                            @endif
                        </div>
                        <div class="field-edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('matric_staff_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
        </div>
        
        <div class="submit-section">
            <button type="submit" class="submit-btn" style="width: 100%; margin-top: 20px;">Submit All Changes</button>
        </div>
        </form>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.side-tab').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('semi-active');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // Avatar preview
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Auto-hide success message after 3 seconds
        setTimeout(() => {
            const successMsg = document.querySelector('.success-message');
            if (successMsg) {
                successMsg.classList.remove('show');
            }
        }, 3000);
    </script>
</body>
</html>

