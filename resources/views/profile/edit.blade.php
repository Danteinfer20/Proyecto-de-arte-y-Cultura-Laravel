@extends('layouts.app')

@section('title', 'Mi Perfil - Arte & Cultura Popayán')

@section('content')
<div class="dashboard-container">
    <!-- Header del Dashboard -->
    <div class="dashboard-header">
        <div class="user-hero">
            <!-- Cover Image -->
            <div class="cover-section">
                <div class="cover-image" id="coverSection">
                    @if($user->cover_picture)
                        <img src="{{ Storage::url($user->cover_picture) }}" alt="Cover" id="coverPreview">
                    @else
                        <div class="cover-placeholder" id="coverPreview">
                            <i class="fas fa-mountain"></i>
                            <span>Imagen de portada</span>
                        </div>
                    @endif
                    <div class="cover-overlay">
                        <label for="cover_picture" class="cover-upload-btn">
                            <i class="fas fa-camera"></i>
                            Cambiar Portada
                        </label>
                        <button class="cover-remove-btn" id="removeCover">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Profile Image -->
                <div class="profile-image-section">
                    <div class="profile-image" id="profileSection">
                        @if($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile" id="profilePreview">
                        @else
                            <div class="avatar-placeholder" id="profilePreview">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="profile-actions">
                            <label for="profile_picture" class="profile-upload-btn">
                                <i class="fas fa-camera"></i>
                            </label>
                            <button class="profile-remove-btn" id="removeProfile">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="profile-status">
                        <div class="status-indicator online"></div>
                        <span>En línea</span>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-main-info">
                    <h1>{{ $user->name }}</h1>
                    <p class="user-username">@{{ $user->username }}</p>
                    <p class="user-role">
                        @switch($user->user_type)
                            @case('cultural_manager')
                                <i class="fas fa-calendar-alt"></i> Gestor Cultural
                                @break
                            @case('artist')
                                <i class="fas fa-paint-brush"></i> Artista/Creador
                                @break
                            @case('visitor')
                                <i class="fas fa-heart"></i> Amante del Arte
                                @break
                            @case('admin')
                                <i class="fas fa-cog"></i> Administrador
                                @break
                        @endswitch
                    </p>
                </div>
                
                <div class="user-details">
                    <p class="user-bio">{{ $user->bio ?: '¡Cuéntanos sobre ti y tu pasión por el arte!' }}</p>
                    
                    <div class="user-meta">
                        @if($user->city)
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $user->city }}{{ $user->neighborhood ? ', ' . $user->neighborhood : '' }}</span>
                        </div>
                        @endif
                        
                        @if($user->website)
                        <div class="meta-item">
                            <i class="fas fa-globe"></i>
                            <a href="{{ $user->website }}" target="_blank">Sitio web</a>
                        </div>
                        @endif
                        
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Se unió {{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="user-stats">
                    <div class="stat">
                        <strong>{{ $user->posts_count ?? $user->posts->count() }}</strong>
                        <span>Publicaciones</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->followers_count ?? 0 }}</strong>
                        <span>Seguidores</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->following_count ?? 0 }}</strong>
                        <span>Siguiendo</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $user->products_count ?? $user->products->count() }}</strong>
                        <span>Productos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="dashboard-tabs">
        <nav class="tabs-navigation">
            <button class="tab-btn active" data-tab="profile">
                <i class="fas fa-user-edit"></i>
                Perfil
            </button>
            <button class="tab-btn" data-tab="security">
                <i class="fas fa-shield-alt"></i>
                Seguridad
            </button>
            <button class="tab-btn" data-tab="social">
                <i class="fas fa-share-alt"></i>
                Redes Sociales
            </button>
            <button class="tab-btn" data-tab="preferences">
                <i class="fas fa-cog"></i>
                Preferencias
            </button>
            <button class="tab-btn" data-tab="notifications">
                <i class="fas fa-bell"></i>
                Notificaciones
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="dashboard-content">
        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> 
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Tab 1: Editar Perfil -->
        <div class="tab-content active" id="profileTab">
            <form method="POST" action="{{ route('profile.update') }}" class="profile-form" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <!-- Hidden file inputs -->
                <input type="file" id="cover_picture" name="cover_picture" accept="image/*" class="hidden-file-input">
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden-file-input">
                <input type="hidden" name="remove_cover" id="removeCoverInput" value="0">
                <input type="hidden" name="remove_profile" id="removeProfileInput" value="0">

                <div class="form-sections">
                    <!-- Información Básica -->
                    <div class="form-section-card">
                        <div class="section-header">
                            <i class="fas fa-id-card"></i>
                            <h3>Información Básica</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group floating-label">
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                <label for="name">Nombre Completo *</label>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group floating-label">
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                <label for="username">Nombre de Usuario *</label>
                                @error('username')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group floating-label">
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                <label for="email">Correo Electrónico *</label>
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group floating-label">
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                <label for="phone">Teléfono</label>
                                @error('phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Información Personal -->
                    <div class="form-section-card">
                        <div class="section-header">
                            <i class="fas fa-user"></i>
                            <h3>Información Personal</h3>
                        </div>
                        
                        <div class="form-group floating-label">
                            <textarea id="bio" name="bio" rows="4" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                            <label for="bio">Biografía (máx. 500 caracteres)</label>
                            <div class="char-counter">
                                <span id="bioCharCount">{{ strlen(old('bio', $user->bio)) }}</span>/500
                            </div>
                            @error('bio')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group floating-label">
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                                <label for="birth_date">Fecha de Nacimiento</label>
                                @error('birth_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender">Género</label>
                                <select id="gender" name="gender" class="modern-select">
                                    <option value="">Seleccionar</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Masculino</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Femenino</option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                                    <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefiero no decir</option>
                                </select>
                                @error('gender')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div class="form-section-card">
                        <div class="section-header">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3>Ubicación</h3>
                        </div>
                        <div class="form-grid">
                            <div class="form-group floating-label">
                                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" required>
                                <label for="city">Ciudad *</label>
                                @error('city')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group floating-label">
                                <input type="text" id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $user->neighborhood) }}">
                                <label for="neighborhood">Barrio/Localidad</label>
                                @error('neighborhood')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Enlaces -->
                    <div class="form-section-card">
                        <div class="section-header">
                            <i class="fas fa-link"></i>
                            <h3>Enlaces</h3>
                        </div>
                        <div class="form-group floating-label">
                            <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" placeholder="https://">
                            <label for="website">Sitio Web Personal</label>
                            @error('website')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('/') }}'">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fas fa-save"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab 2: Seguridad -->
        <div class="tab-content" id="securityTab">
            <div class="security-sections">
                <!-- Cambiar Contraseña -->
                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-lock"></i>
                        <h3>Cambiar Contraseña</h3>
                    </div>
                    <form id="passwordForm">
                        <div class="form-grid">
                            <div class="form-group floating-label">
                                <input type="password" id="current_password" name="current_password" required>
                                <label for="current_password">Contraseña Actual</label>
                            </div>
                            <div class="form-group floating-label">
                                <input type="password" id="new_password" name="new_password" required>
                                <label for="new_password">Nueva Contraseña</label>
                            </div>
                            <div class="form-group floating-label">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                                <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key"></i>
                                Cambiar Contraseña
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sesiones Activas -->
                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-desktop"></i>
                        <h3>Sesiones Activas</h3>
                    </div>
                    <div class="sessions-list">
                        <div class="session-item active">
                            <div class="session-info">
                                <i class="fas fa-desktop"></i>
                                <div>
                                    <strong>Navegador Actual</strong>
                                    <span>{{ request()->userAgent() }}</span>
                                    <small>Última actividad: Ahora</small>
                                </div>
                            </div>
                            <span class="session-badge current">Actual</span>
                        </div>
                        <div class="session-item">
                            <div class="session-info">
                                <i class="fas fa-mobile-alt"></i>
                                <div>
                                    <strong>Dispositivo Móvil</strong>
                                    <span>Chrome en Android</span>
                                    <small>Última actividad: Hace 2 días</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline">Cerrar Sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Redes Sociales -->
        <div class="tab-content" id="socialTab">
            <div class="social-sections">
                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-share-alt"></i>
                        <h3>Conectar Redes Sociales</h3>
                    </div>
                    <div class="social-connections">
                        <div class="social-connection">
                            <div class="social-info">
                                <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                <div>
                                    <strong>Facebook</strong>
                                    <span>Conecta tu cuenta de Facebook</span>
                                </div>
                            </div>
                            <button class="btn btn-outline">Conectar</button>
                        </div>
                        <div class="social-connection">
                            <div class="social-info">
                                <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                <div>
                                    <strong>Instagram</strong>
                                    <span>Conecta tu cuenta de Instagram</span>
                                </div>
                            </div>
                            <button class="btn btn-outline">Conectar</button>
                        </div>
                        <div class="social-connection">
                            <div class="social-info">
                                <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                                <div>
                                    <strong>Twitter</strong>
                                    <span>Conecta tu cuenta de Twitter</span>
                                </div>
                            </div>
                            <button class="btn btn-outline">Conectar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: Preferencias -->
        <div class="tab-content" id="preferencesTab">
            <div class="preferences-sections">
                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-palette"></i>
                        <h3>Apariencia</h3>
                    </div>
                    <div class="preference-group">
                        <label>Tema</label>
                        <div class="theme-options">
                            <label class="theme-option">
                                <input type="radio" name="theme" value="light" checked>
                                <div class="theme-preview light-theme">
                                    <i class="fas fa-sun"></i>
                                    <span>Claro</span>
                                </div>
                            </label>
                            <label class="theme-option">
                                <input type="radio" name="theme" value="dark">
                                <div class="theme-preview dark-theme">
                                    <i class="fas fa-moon"></i>
                                    <span>Oscuro</span>
                                </div>
                            </label>
                            <label class="theme-option">
                                <input type="radio" name="theme" value="auto">
                                <div class="theme-preview auto-theme">
                                    <i class="fas fa-adjust"></i>
                                    <span>Automático</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-language"></i>
                        <h3>Idioma</h3>
                    </div>
                    <div class="form-group">
                        <select class="modern-select">
                            <option value="es" selected>Español</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 5: Notificaciones -->
        <div class="tab-content" id="notificationsTab">
            <div class="notifications-sections">
                <div class="form-section-card">
                    <div class="section-header">
                        <i class="fas fa-bell"></i>
                        <h3>Preferencias de Notificaciones</h3>
                    </div>
                    <div class="notification-settings">
                        <div class="notification-item">
                            <div class="notification-info">
                                <strong>Notificaciones por Email</strong>
                                <span>Recibir notificaciones importantes por correo electrónico</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="notification-item">
                            <div class="notification-info">
                                <strong>Nuevos Seguidores</strong>
                                <span>Notificarme cuando alguien me siga</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="notification-item">
                            <div class="notification-info">
                                <strong>Comentarios en mis Publicaciones</strong>
                                <span>Notificarme cuando comenten mis obras</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="notification-item">
                            <div class="notification-info">
                                <strong>Eventos Cercanos</strong>
                                <span>Notificarme sobre eventos culturales en mi área</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el Dashboard -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sistema de pestañas
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Remover active de todos
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Activar actual
            this.classList.add('active');
            document.getElementById(tabId + 'Tab').classList.add('active');
        });
    });

    // Upload de imágenes con preview
    const coverInput = document.getElementById('cover_picture');
    const profileInput = document.getElementById('profile_picture');
    const coverPreview = document.getElementById('coverPreview');
    const profilePreview = document.getElementById('profilePreview');
    const removeCoverInput = document.getElementById('removeCoverInput');
    const removeProfileInput = document.getElementById('removeProfileInput');

    // Cover image upload
    document.querySelector('.cover-upload-btn').addEventListener('click', function(e) {
        e.preventDefault();
        coverInput.click();
    });

    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen es demasiado grande. Máximo 5MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.innerHTML = `<img src="${e.target.result}" alt="Cover preview">`;
                removeCoverInput.value = '0';
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove cover
    document.getElementById('removeCover').addEventListener('click', function(e) {
        e.preventDefault();
        coverPreview.innerHTML = `
            <div class="cover-placeholder">
                <i class="fas fa-mountain"></i>
                <span>Imagen de portada</span>
            </div>
        `;
        coverInput.value = '';
        removeCoverInput.value = '1';
    });

    // Profile image upload
    document.querySelector('.profile-upload-btn').addEventListener('click', function(e) {
        e.preventDefault();
        profileInput.click();
    });

    profileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen es demasiado grande. Máximo 2MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.innerHTML = `<img src="${e.target.result}" alt="Profile preview">`;
                removeProfileInput.value = '0';
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove profile
    document.getElementById('removeProfile').addEventListener('click', function(e) {
        e.preventDefault();
        profilePreview.innerHTML = `
            <div class="avatar-placeholder">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        `;
        profileInput.value = '';
        removeProfileInput.value = '1';
    });

    // Character counter for bio
    const bioTextarea = document.getElementById('bio');
    const bioCharCount = document.getElementById('bioCharCount');

    bioTextarea.addEventListener('input', function() {
        bioCharCount.textContent = this.value.length;
    });

    // Form validation
    const profileForm = document.getElementById('profileForm');
    const saveBtn = profileForm.querySelector('.btn-save');

    profileForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const username = document.getElementById('username').value.trim();
        
        if (!name || !email || !username) {
            e.preventDefault();
            alert('Por favor completa los campos obligatorios.');
            return;
        }

        // Show loading
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        saveBtn.disabled = true;
    });

    // Floating labels
    document.querySelectorAll('.floating-label input, .floating-label textarea').forEach(input => {
        if (input.value) {
            input.parentElement.classList.add('has-value');
        }

        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value) {
                this.parentElement.classList.add('has-value');
            } else {
                this.parentElement.classList.remove('has-value');
            }
        });
    });

    // Password form
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Funcionalidad de cambio de contraseña en desarrollo.');
    });
});
</script>

<style>
.hidden-file-input {
    display: none;
}
</style>
@endsection