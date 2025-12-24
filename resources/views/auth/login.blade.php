<x-auth-layout>
    <x-slot name="title">Login</x-slot>

    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email -->
        <div class="input-group">
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                placeholder="Email" 
                required 
                autofocus 
                autocomplete="email"
            >
            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <input 
                id="password" 
                type="password" 
                name="password" 
                placeholder="Password" 
                required 
                autocomplete="current-password"
            >
            @error('password')
                <div class="input-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn">Login</button>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <div class="forgot-link">
                <a href="{{ route('password.request') }}">Forgot your password</a>
            </div>
        @endif
    </form>
</x-auth-layout>
