@extends('layouts.app')

@section('title', 'Sign Up - Art & Culture Popayán')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <!-- HEADER -->
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join our cultural community in Popayán</p>
            </div>

            <!-- ERROR MESSAGES -->
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}@if(!$loop->last)<br>@endif
                    @endforeach
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <!-- PERSONAL INFORMATION -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimum 8 characters">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat your password">
                </div>

                <!-- ROLE SELECTION -->
                <div class="form-group">
                    <label for="user_type">How do you want to participate?</label>
                    <select id="user_type" name="user_type" required>
                        <option value="">Select your role in the community</option>
                        <option value="artist" {{ old('user_type') == 'artist' ? 'selected' : '' }}>🎨 Artist - Create and share art</option>
                        <option value="cultural_manager" {{ old('user_type') == 'cultural_manager' ? 'selected' : '' }}>🏛️ Cultural Manager - Organize events</option>
                        <option value="visitor" {{ old('user_type') == 'visitor' ? 'selected' : '' }}>👥 Visitor - Explore and participate</option>
                        <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>⚙️ Administrator - Manage platform</option>
                    </select>
                </div>

                <!-- TERMS AND CONDITIONS -->
                <div class="terms-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I accept the <a href="#" class="terms-link">terms and conditions</a> 
                        and the <a href="#" class="terms-link">privacy policy</a>
                    </label>
                </div>

                <!-- REGISTER BUTTON -->
                <button type="submit" class="btn-primary">
                    Create My Account
                </button>
            </form>

            <!-- LOGIN LINK -->
            <div class="auth-footer">
                <a href="{{ route('login') }}">Already have an account? Sign in here</a>
            </div>
        </div>
    </div>
</div>
@endsection