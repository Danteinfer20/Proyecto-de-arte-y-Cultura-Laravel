@extends('layouts.app')

@section('title', 'Editar Perfil - Arte & Cultura Popayán')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Mi Perfil</h1>
        <p>Actualiza tu información personal</p>
    </div>

    <div class="profile-content">
        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="profile-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Sección de Imágenes -->
            <div class="form-section">
                <h3>Imágenes de Perfil</h3>
                
                <div class="image-upload-grid">
                    <!-- Imagen de Cover -->
                    <div class="image-upload-group">
                        <label>Imagen de Portada</label>
                        <div class="image-preview" id="coverPreview">
                            @if($user->cover_picture)
                                <img src="{{ Storage::url($user->cover_picture) }}" alt="Cover">
                            @else
                                <div class="image-placeholder">
                                    @include('icons.image')
                                    <span>Sin imagen de portada</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="cover_picture" name="cover_picture" accept="image/*" class="image-input">
                        <label for="cover_picture" class="btn btn-secondary btn-small">Cambiar Portada</label>
                    </div>

                    <!-- Imagen de Perfil -->
                    <div class="image-upload-group">
                        <label>Foto de Perfil</label>
                        <div class="image-preview profile-preview" id="profilePreview">
                            @if($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile">
                            @else
                                <div class="image-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="image-input">
                        <label for="profile_picture" class="btn btn-secondary btn-small">Cambiar Foto</label>
                    </div>
                </div>
            </div>

            <!-- Información Básica -->
            <div class="form-section">
                <h3>Información Básica</h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nombre Completo *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="form-section">
                <h3>Información Adicional</h3>
                
                <div class="form-group">
                    <label for="bio">Biografía</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Cuéntanos sobre ti...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="website">Sitio Web</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" placeholder="https://...">
                        @error('website')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="birth_date">Fecha de Nacimiento</label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                        @error('birth_date')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">Género</label>
                        <select id="gender" name="gender">
                            <option value="">Seleccionar</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Masculino</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Femenino</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('gender')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript para previsualización de imágenes -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Previsualización para imagen de perfil
    const profileInput = document.getElementById('profile_picture');
    const profilePreview = document.getElementById('profilePreview');
    
    profileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    });

    // Previsualización para imagen de cover
    const coverInput = document.getElementById('cover_picture');
    const coverPreview = document.getElementById('coverPreview');
    
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection