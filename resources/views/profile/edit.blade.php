<x-profile-layout>
    <x-slot name="title">Profile</x-slot>

    <div class="profile-container">
        <!-- Page Title -->
        <h1 class="page-title">Profile</h1>

        <!-- Profile Header -->
        <div class="profile-header">
            <!-- Avatar Section -->
            <!-- Avatar Section -->
            <div class="avatar-section">
                <form id="avatar-upload-form" action="{{ route('profile.personal-data.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="avatar-wrapper">
                        <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->customer->username ?? Auth::user()->name) . '&background=3E5789&color=fff' }}" alt="Profile Picture" id="avatarImage" style="border-radius: 50%;">
                    </div>
                    <button type="button" class="avatar-edit-btn" onclick="document.getElementById('avatarInput').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                    </button>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;" onchange="document.getElementById('avatar-upload-form').submit()">
                </form>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-email">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <!-- Profile Menu -->
        <div class="profile-menu">
            <!-- Personal Data -->
            <a href="{{ route('profile.personal-data') }}" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <span class="menu-label">Personal Data</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>

            <!-- Settings -->
            <a href="#settings" class="menu-item" onclick="toggleSection('settings-section')">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </div>
                    <span class="menu-label">Settings</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>

            <!-- Order History -->
            <a href="{{ route('profile.order-history') }}" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <span class="menu-label">Order History</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>

            <!-- Loyalty -->
            <a href="#loyalty" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <span class="menu-label">Loyalty</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>

            <!-- Voucher -->
            <a href="#voucher" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"></path>
                            <path d="M4 8V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2"></path>
                            <path d="M12 4v16"></path>
                            <circle cx="12" cy="8" r="2"></circle>
                        </svg>
                    </div>
                    <span class="menu-label">Voucher</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>

            <!-- Help Center -->
            <a href="#help" class="menu-item">
                <div class="menu-item-left">
                    <div class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <span class="menu-label">Help Center</span>
                </div>
                <div class="menu-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Expandable Sections -->
        <div id="settings-section" class="expandable-section" style="display: none; margin-bottom: 20px; padding: 20px; background: rgba(255,255,255,0.9); border-radius: 12px;">
            @include('profile.partials.update-password-form')
            <hr style="margin: 30px 0; border-color: rgba(0,0,0,0.1);">
            @include('profile.partials.delete-user-form')
        </div>

        <!-- Sign Out Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="signout-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Sign Out</span>
            </button>
        </form>

    <script>
        function toggleSection(sectionId) {
            event.preventDefault();
            const section = document.getElementById(sectionId);
            const allSections = document.querySelectorAll('.expandable-section');
            
            allSections.forEach(s => {
                if (s.id !== sectionId) {
                    s.style.display = 'none';
                }
            });
            
            if (section.style.display === 'none') {
                section.style.display = 'block';
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                section.style.display = 'none';
            }
        }

        // Avatar preview
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarImage').src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</x-profile-layout>
