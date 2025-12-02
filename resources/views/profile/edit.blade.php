@extends('layouts.app')

@section('title', 'Edit Profile - Art & Culture Popayán')

@section('content')
<div class="profile-edit-container">
    <!-- Header -->
    <div class="edit-header">
        <h1><i class="fas fa-user-edit"></i> Edit My Profile</h1>
        <p>Update your personal and professional information</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> 
            Please correct the errors in the form.
        </div>
    @endif

    <div class="edit-layout">
        <!-- Left Column: Preview -->
        <div class="preview-column">
            <div class="preview-card">
                <h3>Preview</h3>
                
                <!-- Profile Preview -->
                <div class="profile-preview">
                    <!-- Cover Preview -->
                    <div class="cover-preview" id="coverPreview">
                        @if($user->cover_picture)
                            <img src="{{ Storage::url($user->cover_picture) }}" alt="Cover preview">
                        @else
                            <div class="cover-default">
                                <i class="fas fa-mountain"></i>
                                <span>Cover</span>
                            </div>
                        @endif
                    </div>

                    <!-- Avatar Preview -->
                    <div class="avatar-preview-container">
                        <div class="avatar-preview" id="avatarPreview">
                            @if($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Avatar preview">
                            @else
                                <div class="avatar-default">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Info Preview -->
                    <div class="info-preview">
                        <h2 id="previewName">{{ $user->name }}</h2>
                        <p class="preview-username" id="previewUsername">{{ '@' . $user->username }}</p>
                        <p class="preview-bio" id="previewBio">
                            {{ $user->bio ?: 'Your biography will appear here...' }}
                        </p>
                        
                        <div class="preview-stats">
                            <div class="preview-stat">
                                <strong>{{ $user->posts()->count() }}</strong>
                                <span>Posts</span>
                            </div>
                            <div class="preview-stat">
                                <strong>{{ $user->events()->count() }}</strong>
                                <span>Events</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="form-column">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileEditForm">
                @csrf
                @method('PUT')

                <!-- Section: Images -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-images"></i>
                        <h3>Profile Images</h3>
                    </div>

                    <div class="image-upload-grid">
                        <div class="upload-group">
                            <label for="coverInput">Cover Photo</label>
                            <div class="upload-area" id="coverUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="coverText">Click to upload cover</span>
                                <input type="file" id="coverInput" name="cover_picture" accept="image/*" class="file-input">
                            </div>
                            <div id="coverFileName" class="file-name"></div>
                            <p class="upload-hint">Recommended: 1200x400 px (Max. 4MB)</p>
                        </div>

                        <div class="upload-group">
                            <label for="avatarInput">Profile Photo</label>
                            <div class="upload-area" id="avatarUploadArea">
                                <i class="fas fa-user-circle"></i>
                                <span id="avatarText">Click to upload avatar</span>
                                <input type="file" id="avatarInput" name="profile_picture" accept="image/*" class="file-input">
                            </div>
                            <div id="avatarFileName" class="file-name"></div>
                            <p class="upload-hint">Recommended: 400x400 px (Max. 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Basic Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-id-card"></i>
                        <h3>Basic Information</h3>
                    </div>

                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                               class="form-control" required data-preview="name">
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" 
                               class="form-control" required data-preview="username">
                        @error('username')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="form-control" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Section: Biography -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-pen"></i>
                        <h3>Biography</h3>
                    </div>

                    <div class="form-group">
                        <label for="bio">Tell us about yourself</label>
                        <textarea id="bio" name="bio" class="form-control" rows="4" data-preview="bio"
                                  placeholder="Share your passion for art, your experience, projects...">{{ old('bio', $user->bio) }}</textarea>
                        <div class="char-count">
                            <span id="bioCharCount">{{ strlen(old('bio', $user->bio)) }}</span>/500 characters
                        </div>
                        @error('bio')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Section: Contact Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-address-book"></i>
                        <h3>Contact Information</h3>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="form-control">
                            @error('phone')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" 
                                   class="form-control" placeholder="https://...">
                            @error('website')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" 
                                   class="form-control">
                            @error('city')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="neighborhood">Neighborhood/Locality</label>
                            <input type="text" id="neighborhood" name="neighborhood" 
                                   value="{{ old('neighborhood', $user->neighborhood) }}" class="form-control">
                            @error('neighborhood')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    
                    <button type="button" class="btn btn-outline" id="resetBtn">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/modules/profile-edit.js') }}"></script>
@endpush