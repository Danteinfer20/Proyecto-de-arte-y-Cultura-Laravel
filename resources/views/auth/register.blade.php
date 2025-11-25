@extends('layouts.app')

@section('title', 'Registrarse - Arte & Cultura Popayán')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Header Elegante -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-palette"></i>
            </div>
            <h1>Únete a Nuestra Comunidad</h1>
            <p>Comparte, crea y descubre arte y cultura en Popayán</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
            @csrf
            
            <!-- Step 1: Información Personal -->
            <div class="form-step active" id="step1">
                <h3>Información Personal</h3>
                
                <div class="form-group floating-label">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    <label for="name">Nombre Completo</label>
                    <div class="form-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group floating-label">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    <label for="email">Correo Electrónico</label>
                    <div class="form-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary btn-next" data-next="step2">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Seguridad -->
            <div class="form-step" id="step2">
                <h3>Seguridad</h3>
                
                <div class="form-group floating-label">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                    <div class="form-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                        <small class="strength-text" id="strengthText">Seguridad de la contraseña</small>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group floating-label">
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <div class="form-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary btn-back" data-prev="step1">
                        <i class="fas fa-arrow-left"></i> Atrás
                    </button>
                    <button type="button" class="btn btn-primary btn-next" data-next="step3">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Tu Perfil -->
            <div class="form-step" id="step3">
                <h3>Tu Perfil en la Comunidad</h3>
                
                <div class="form-group">
                    <label class="form-label">¿Cuál es tu rol principal?</label>
                    <p class="form-description">Selecciona el perfil que mejor describa tu participación en la cultura</p>
                    
                    <div class="role-cards">
                        <!-- Gestor Cultural -->
                        <div class="role-card" data-role="cultural_manager">
                            <div class="role-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="role-info">
                                <h4>Gestor Cultural</h4>
                                <p>Organizas eventos, exposiciones y actividades culturales</p>
                                <div class="role-badge">Recomendado</div>
                            </div>
                        </div>
                        
                        <!-- Artista -->
                        <div class="role-card" data-role="artist">
                            <div class="role-icon">
                                <i class="fas fa-paint-brush"></i>
                            </div>
                            <div class="role-info">
                                <h4>Artista/Creador</h4>
                                <p>Creas obras artísticas, música, danza o teatro</p>
                            </div>
                        </div>
                        
                        <!-- Visitante -->
                        <div class="role-card" data-role="visitor">
                            <div class="role-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="role-info">
                                <h4>Amante del Arte</h4>
                                <p>Disfrutas, apoyas y participas en eventos culturales</p>
                            </div>
                        </div>
                        
                        <!-- Administrador -->
                        <div class="role-card" data-role="admin">
                            <div class="role-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="role-info">
                                <h4>Administrador</h4>
                                <p>Gestionas y moderas la plataforma cultural</p>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="user_type" name="user_type" value="{{ old('user_type') }}" required>
                    @error('user_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary btn-back" data-prev="step2">
                        <i class="fas fa-arrow-left"></i> Atrás
                    </button>
                    <button type="button" class="btn btn-primary btn-next" data-next="step4">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 4: Términos y Condiciones -->
            <div class="form-step" id="step4">
                <h3>Último Paso: Términos y Condiciones</h3>
                
                <div class="terms-container">
                    <div class="terms-content">
                        <h4>🌻 Bienvenido a Arte & Cultura Popayán</h4>
                        <p>Estás a punto de unirte a nuestra vibrante comunidad cultural. Al crear tu cuenta, aceptas:</p>
                        
                        <div class="terms-list">
                            <div class="term-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Respeto mutuo:</strong> Valorar la diversidad de expresiones culturales</span>
                            </div>
                            <div class="term-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Contenido original:</strong> Compartir solo obras y contenido propios</span>
                            </div>
                            <div class="term-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Propiedad intelectual:</strong> Respetar los derechos de autor</span>
                            </div>
                            <div class="term-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Contribución positiva:</strong> Enriquecer nuestro ecosistema cultural</span>
                            </div>
                            <div class="term-item">
                                <i class="fas fa-check-circle"></i>
                                <span><strong>Confidencialidad:</strong> Protegemos tu privacidad y datos personales</span>
                            </div>
                        </div>
                        
                        <p class="terms-note">📝 <em>Puedes consultar los términos completos en cualquier momento en tu perfil.</em></p>
                    </div>
                </div>

                <div class="checkbox-group terms-acceptance">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        <span class="checkbox-check"></span>
                        He leído y acepto los <a href="{{ url('/terms') }}" target="_blank">términos y condiciones</a> 
                        y la <a href="{{ url('/privacy') }}" target="_blank">política de privacidad</a>
                    </label>
                </div>
                @error('terms')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary btn-back" data-prev="step3">
                        <i class="fas fa-arrow-left"></i> Atrás
                    </button>
                    <button type="submit" class="btn btn-primary btn-complete" id="submitBtn">
                        <i class="fas fa-user-plus"></i> Completar Registro
                    </button>
                </div>
            </div>
        </form>

        <div class="auth-footer">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión aquí</a></p>
        </div>
    </div>
</div>

<script>
// =============================================
// FORM WIZARD SIMPLIFICADO Y 100% FUNCIONAL
// =============================================

class SimpleFormWizard {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.init();
    }

    init() {
        console.log('🚀 Iniciando SimpleFormWizard...');
        this.bindEvents();
        this.updateProgress();
        this.preselectRole();
    }

    bindEvents() {
        console.log('🔗 Configurando eventos...');
        
        // Botones Siguiente
        const nextButtons = document.querySelectorAll('.btn-next');
        console.log('👉 Botones Siguiente encontrados:', nextButtons.length);
        
        nextButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                console.log('🖱️ Click en Siguiente');
                const nextStep = e.target.closest('.btn-next').dataset.next;
                if (this.validateStep(this.currentStep)) {
                    this.goToStep(nextStep);
                }
            });
        });

        // Botones Atrás
        const backButtons = document.querySelectorAll('.btn-back');
        console.log('👈 Botones Atrás encontrados:', backButtons.length);
        
        backButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                console.log('🖱️ Click en Atrás');
                const prevStep = e.target.closest('.btn-back').dataset.prev;
                this.goToStep(prevStep);
            });
        });

        // Selección de Roles
        const roleCards = document.querySelectorAll('.role-card');
        console.log('🎭 Role cards encontrados:', roleCards.length);
        
        roleCards.forEach(card => {
            card.addEventListener('click', () => {
                console.log('🎯 Seleccionando rol');
                this.selectRole(card);
            });
        });

        // Fuerza de Contraseña
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', (e) => {
                this.updatePasswordStrength(e.target.value);
            });
        }

        console.log('✅ Todos los eventos configurados');
    }

    goToStep(stepNumber) {
        console.log('🔄 Cambiando al paso:', stepNumber);
        
        // Ocultar paso actual
        const currentStep = document.getElementById(`step${this.currentStep}`);
        if (currentStep) {
            currentStep.classList.remove('active');
        }
        
        // Mostrar nuevo paso
        const nextStep = document.getElementById(stepNumber);
        if (nextStep) {
            nextStep.classList.add('active');
        }
        
        // Actualizar paso actual
        this.currentStep = parseInt(stepNumber.replace('step', ''));
        
        // Actualizar progreso
        this.updateProgress();
        
        console.log('✅ Paso cambiado a:', this.currentStep);
    }

    updateProgress() {
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            const progress = (this.currentStep / this.totalSteps) * 100;
            progressFill.style.width = `${progress}%`;
            console.log('📊 Progreso actualizado:', progress + '%');
        }
    }

    validateStep(step) {
        console.log('🔍 Validando paso:', step);
        let isValid = true;

        switch(step) {
            case 1:
                isValid = this.validateField(document.getElementById('name')) && 
                         this.validateField(document.getElementById('email'));
                break;
            case 2:
                isValid = this.validateField(document.getElementById('password')) && 
                         this.validateField(document.getElementById('password_confirmation'));
                break;
            case 3:
                const userType = document.getElementById('user_type');
                isValid = userType && userType.value !== '';
                if (!isValid) {
                    alert('Por favor selecciona tu rol principal.');
                }
                break;
            case 4:
                const terms = document.getElementById('terms');
                isValid = terms && terms.checked;
                if (!isValid) {
                    alert('Debes aceptar los términos y condiciones.');
                }
                break;
        }

        console.log('✅ Validación paso', step, ':', isValid);
        return isValid;
    }

    validateField(field) {
        if (!field) return false;

        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        switch(field.id) {
            case 'name':
                if (value.length < 2) {
                    isValid = false;
                    errorMessage = 'El nombre debe tener al menos 2 caracteres.';
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Por favor ingresa un correo electrónico válido.';
                }
                break;
            case 'password':
                if (value.length < 8) {
                    isValid = false;
                    errorMessage = 'La contraseña debe tener al menos 8 caracteres.';
                }
                break;
            case 'password_confirmation':
                const password = document.getElementById('password');
                if (password && value !== password.value) {
                    isValid = false;
                    errorMessage = 'Las contraseñas no coinciden.';
                }
                break;
        }

        this.showFieldError(field, isValid, errorMessage);
        return isValid;
    }

    showFieldError(field, isValid, errorMessage) {
        let errorElement = field.parentNode.querySelector('.error-message');
        
        if (!errorElement && !isValid) {
            errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            field.parentNode.appendChild(errorElement);
        }

        if (errorElement) {
            errorElement.textContent = isValid ? '' : errorMessage;
        }

        if (isValid) {
            field.style.borderColor = '#10B981';
        } else {
            field.style.borderColor = '#EF4444';
        }
    }

    selectRole(card) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        document.getElementById('user_type').value = card.dataset.role;
        console.log('✅ Rol seleccionado:', card.dataset.role);
    }

    preselectRole() {
        const userType = document.getElementById('user_type').value;
        if (userType) {
            const selectedCard = document.querySelector(`.role-card[data-role="${userType}"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }
        }
    }

    updatePasswordStrength(password) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        if (!strengthBar || !strengthText) return;

        let strength = 0;
        let color = '#EF4444';
        let text = 'Seguridad de la contraseña';

        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        if (/[^A-Za-z0-9]/.test(password)) strength += 25;

        if (strength >= 75) {
            color = '#10B981';
            text = 'Muy fuerte 🔒';
        } else if (strength >= 50) {
            color = '#F59E0B';
            text = 'Fuerte 👍';
        } else if (strength >= 25) {
            color = '#FBBF24';
            text = 'Moderada 💪';
        } else if (password.length > 0) {
            color = '#EF4444';
            text = 'Débil 😟';
        }

        strengthBar.style.width = `${strength}%`;
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM completamente cargado');
    new SimpleFormWizard();
});

console.log('📜 Script cargado correctamente');
</script>
@endsection