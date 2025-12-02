@extends('layouts.app')

@section('title', 'Login - Art & Culture Popayán')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <!-- IMPROVED HEADER -->
            <div class="auth-header">
                <h2>Login</h2>
                <p>Continue your cultural journey in Popayán</p>
            </div>

            <!-- IMPROVED STATUS MESSAGES -->
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}@if(!$loop->last)<br>@endif
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- IMPROVED LOGIN FORM -->
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- EMAIL WITH NEW STRUCTURE -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               required placeholder="your@email.com" autofocus>
                        <div class="icon-left">
                            @include('components.email')
                        </div>
                    </div>
                </div>

                <!-- PASSWORD WITH NEW STRUCTURE -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <input type="password" id="password" name="password" 
                               required placeholder="Enter your password">
                        <div class="icon-left">
                            @include('components.lock')
                        </div>
                    </div>
                </div>

                <!-- IMPROVED ADDITIONAL OPTIONS -->
                <div class="login-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">
                        @include('components.info')
                        Forgot your password?
                    </a>
                </div>

                <!-- IMPROVED LOGIN BUTTON -->
                <button type="submit" class="btn-primary">
                    @include('components.login')
                    Login
                </button>
            </form>

            <!-- IMPROVED SOCIAL SEPARATOR -->
            <div class="social-login">
                <div class="social-divider">
                    <span>Or sign in with</span>
                </div>
                
                <div class="social-buttons">
                    <button type="button" class="social-btn google-btn">
                        @include('components.google')
                        Google
                    </button>
                    <button type="button" class="social-btn facebook-btn">
                        @include('components.facebook')
                        Facebook
                    </button>
                </div>
            </div>

            <!-- IMPROVED REGISTRATION LINK -->
            <div class="auth-footer">
                <a href="{{ route('register') }}">
                    @include('components.user-plus')
                    Don't have an account? Sign up for free
                </a>
            </div>
        </div>
    </div>
</div>
@endsection