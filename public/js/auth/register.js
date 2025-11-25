// public/js/auth/register.js - VERSIÓN ELEGANTE

class ElegantFormWizard {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.animationDuration = 600;
        this.init();
    }

    init() {
        console.log('🎨 Iniciando formulario elegante...');
        this.bindEvents();
        this.updateProgress();
        this.preselectRole();
        this.setupAnimations();
        this.showWelcomeMessage();
    }

    bindEvents() {
        // Botones Siguiente con efectos
        document.querySelectorAll('.btn-next').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.animateButtonClick(e.target);
                const nextStep = e.target.closest('.btn-next').dataset.next;
                if (this.validateStep(this.currentStep)) {
                    this.goToStep(nextStep);
                }
            });
        });

        // Botones Atrás con efectos
        document.querySelectorAll('.btn-back').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.animateButtonClick(e.target);
                const prevStep = e.target.closest('.btn-back').dataset.prev;
                this.goToStep(prevStep);
            });
        });

        // Selección de Roles con animaciones
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', (e) => {
                this.animateCardSelection(card);
                this.selectRole(card);
            });

            // Efectos hover para cards
            card.addEventListener('mouseenter', () => {
                if (!card.classList.contains('selected')) {
                    card.style.transform = 'translateY(-4px) scale(1.02)';
                }
            });

            card.addEventListener('mouseleave', () => {
                if (!card.classList.contains('selected')) {
                    card.style.transform = '';
                }
            });
        });

        // Fuerza de Contraseña en tiempo real
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', (e) => {
                this.updatePasswordStrength(e.target.value);
            });

            // Efecto focus mejorado
            passwordInput.addEventListener('focus', () => {
                passwordInput.parentElement.classList.add('focused');
            });

            passwordInput.addEventListener('blur', () => {
                passwordInput.parentElement.classList.remove('focused');
            });
        }

        // Validación en tiempo real con debounce
        document.querySelectorAll('input').forEach(input => {
            let timeout;
            input.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.validateField(input);
                }, 500);
            });

            input.addEventListener('blur', () => {
                this.validateField(input);
            });
        });

        // Efecto para el checkbox de términos
        const termsCheckbox = document.getElementById('terms');
        if (termsCheckbox) {
            termsCheckbox.addEventListener('change', (e) => {
                this.animateTermsAcceptance(e.target.checked);
            });
        }
    }

    setupAnimations() {
        // Agregar clases de animación a los elementos
        document.querySelectorAll('.form-step').forEach(step => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(20px)';
        });

        // Mostrar primer paso con animación
        const firstStep = document.getElementById('step1');
        if (firstStep) {
            setTimeout(() => {
                firstStep.style.opacity = '1';
                firstStep.style.transform = 'translateY(0)';
            }, 100);
        }
    }

    showWelcomeMessage() {
        console.log('✨ Bienvenido al formulario de registro elegante');
        console.log('🚀 Características activadas:');
        console.log('   • Navegación fluida entre pasos');
        console.log('   • Animaciones suaves');
        console.log('   • Validación en tiempo real');
        console.log('   • Efectos visuales interactivos');
    }

    goToStep(stepNumber) {
        const currentStepElement = document.getElementById(`step${this.currentStep}`);
        const nextStepElement = document.getElementById(stepNumber);

        if (!currentStepElement || !nextStepElement) return;

        // Animación de salida
        currentStepElement.style.opacity = '0';
        currentStepElement.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            currentStepElement.classList.remove('active');
            
            // Preparar siguiente paso
            nextStepElement.style.opacity = '0';
            nextStepElement.style.transform = 'translateY(20px)';
            nextStepElement.classList.add('active');
            
            // Animación de entrada
            setTimeout(() => {
                nextStepElement.style.opacity = '1';
                nextStepElement.style.transform = 'translateY(0)';
                
                // Actualizar estado
                this.currentStep = parseInt(stepNumber.replace('step', ''));
                this.updateProgress();
                this.animateStepChange();
                
            }, 50);
        }, this.animationDuration / 2);
    }

    animateStepChange() {
        // Efecto de partículas para cambio de paso
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            progressFill.style.transform = 'scale(1.1)';
            setTimeout(() => {
                progressFill.style.transform = 'scale(1)';
            }, 300);
        }

        // Efecto de confeti para último paso
        if (this.currentStep === this.totalSteps) {
            this.createConfettiEffect();
        }
    }

    updateProgress() {
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            const progress = (this.currentStep / this.totalSteps) * 100;
            
            // Animación suave del progreso
            progressFill.style.transition = `all ${this.animationDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
            progressFill.style.width = `${progress}%`;
            
            // Efecto de brillo
            progressFill.style.filter = 'brightness(1.2)';
            setTimeout(() => {
                progressFill.style.filter = 'brightness(1)';
            }, 300);
        }
    }

    validateStep(step) {
        let isValid = true;
        let errorMessage = '';

        switch(step) {
            case 1:
                isValid = this.validateField(document.getElementById('name')) && 
                         this.validateField(document.getElementById('email'));
                if (!isValid) {
                    errorMessage = 'Por favor completa correctamente tu información personal';
                }
                break;
            case 2:
                isValid = this.validateField(document.getElementById('password')) && 
                         this.validateField(document.getElementById('password_confirmation'));
                if (!isValid) {
                    errorMessage = 'Revisa que las contraseñas coincidan y sean seguras';
                }
                break;
            case 3:
                const userType = document.getElementById('user_type');
                isValid = userType && userType.value !== '';
                if (!isValid) {
                    errorMessage = 'Por favor selecciona tu rol en la comunidad';
                    this.animateRoleSelectionError();
                }
                break;
            case 4:
                const terms = document.getElementById('terms');
                isValid = terms && terms.checked;
                if (!isValid) {
                    errorMessage = 'Debes aceptar los términos y condiciones';
                    this.animateTermsError();
                }
                break;
        }

        if (!isValid && errorMessage) {
            this.showElegantError(errorMessage);
        }

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
                    errorMessage = 'El nombre debe tener al menos 2 caracteres';
                } else if (value.length > 50) {
                    isValid = false;
                    errorMessage = 'El nombre es demasiado largo';
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Por favor ingresa un correo electrónico válido';
                }
                break;
            case 'password':
                if (value.length < 8) {
                    isValid = false;
                    errorMessage = 'La contraseña debe tener al menos 8 caracteres';
                } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
                    isValid = false;
                    errorMessage = 'Incluye mayúsculas, minúsculas y números';
                }
                break;
            case 'password_confirmation':
                const password = document.getElementById('password');
                if (password && value !== password.value) {
                    isValid = false;
                    errorMessage = 'Las contraseñas no coinciden';
                }
                break;
        }

        this.showFieldError(field, isValid, errorMessage);
        return isValid;
    }

    showFieldError(field, isValid, errorMessage) {
        let errorElement = field.parentNode.querySelector('.error-message');
        
        // Remover estado anterior
        field.classList.remove('valid', 'error');
        
        if (!isValid) {
            // Estado de error
            if (!errorElement) {
                errorElement = document.createElement('span');
                errorElement.className = 'error-message';
                field.parentNode.appendChild(errorElement);
            }
            errorElement.textContent = errorMessage;
            field.classList.add('error');
            
            // Animación de error
            this.animateFieldError(field);
        } else {
            // Estado válido
            if (errorElement) {
                errorElement.remove();
            }
            if (field.value.trim() !== '') {
                field.classList.add('valid');
            }
        }
    }

    selectRole(card) {
        document.querySelectorAll('.role-card').forEach(c => {
            c.classList.remove('selected');
            c.style.transform = '';
        });
        
        card.classList.add('selected');
        document.getElementById('user_type').value = card.dataset.role;
        
        // Efecto de selección
        this.animateRoleSelection(card);
    }

    preselectRole() {
        const userTypeInput = document.getElementById('user_type');
        if (userTypeInput && userTypeInput.value) {
            const selectedCard = document.querySelector(`.role-card[data-role="${userTypeInput.value}"]`);
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
        let color = 'var(--auth-error)';
        let text = 'Muy débil';
        let width = 0;

        // Criterios de fortaleza
        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        if (/[^A-Za-z0-9]/.test(password)) strength += 25;

        // Asignar colores y textos
        if (strength >= 75) {
            color = 'var(--auth-success)';
            text = 'Muy fuerte 🔒';
            width = 100;
        } else if (strength >= 50) {
            color = 'var(--auth-warning)';
            text = 'Fuerte 👍';
            width = 75;
        } else if (strength >= 25) {
            color = '#FBBF24';
            text = 'Moderada 💪';
            width = 50;
        } else {
            color = 'var(--auth-error)';
            text = 'Débil 😟';
            width = 25;
        }

        // Aplicar animación
        strengthBar.style.width = `${width}%`;
        strengthBar.style.backgroundColor = color;
        strengthBar.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        
        strengthText.textContent = text;
        strengthText.style.color = color;
        strengthText.style.transition = 'all 0.3s ease';
    }

    // ===== ANIMACIONES ELEGANTES =====

    animateButtonClick(button) {
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = '';
        }, 150);
    }

    animateCardSelection(card) {
        card.style.transform = 'scale(1.05) rotate(2deg)';
        setTimeout(() => {
            card.style.transform = 'scale(1) rotate(0deg)';
        }, 300);
    }

    animateFieldError(field) {
        field.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            field.style.animation = '';
        }, 500);
    }

    animateRoleSelection(card) {
        const icon = card.querySelector('.role-icon');
        if (icon) {
            icon.style.transform = 'scale(1.2) rotate(10deg)';
            setTimeout(() => {
                icon.style.transform = 'scale(1.1) rotate(0deg)';
            }, 300);
        }
    }

    animateRoleSelectionError() {
        const roleCards = document.querySelector('.role-cards');
        if (roleCards) {
            roleCards.style.animation = 'pulse 0.5s ease-in-out';
            setTimeout(() => {
                roleCards.style.animation = '';
            }, 500);
        }
    }

    animateTermsAcceptance(checked) {
        const termsLabel = document.querySelector('.terms-acceptance label');
        if (termsLabel && checked) {
            termsLabel.style.transform = 'scale(1.02)';
            termsLabel.style.color = 'var(--auth-success)';
            setTimeout(() => {
                termsLabel.style.transform = '';
                termsLabel.style.color = '';
            }, 300);
        }
    }

    animateTermsError() {
        const termsContainer = document.querySelector('.terms-acceptance');
        if (termsContainer) {
            termsContainer.style.borderColor = 'var(--auth-error)';
            termsContainer.style.animation = 'shake 0.5s ease-in-out';
            setTimeout(() => {
                termsContainer.style.animation = '';
                termsContainer.style.borderColor = '';
            }, 500);
        }
    }

    showElegantError(message) {
        // Crear notificación elegante
        const notification = document.createElement('div');
        notification.className = 'elegant-error';
        notification.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <span>${message}</span>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--auth-error);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 400px;
            animation: slideInRight 0.5s ease, slideOutRight 0.5s ease 3.5s forwards;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 4000);
    }

    createConfettiEffect() {
        // Efecto de confeti simple para último paso
        const confettiContainer = document.createElement('div');
        confettiContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        `;
        
        document.body.appendChild(confettiContainer);
        
        // Crear partículas de confeti
        for (let i = 0; i < 30; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: absolute;
                    width: 10px;
                    height: 10px;
                    background: ${this.getRandomColor()};
                    top: -10px;
                    left: ${Math.random() * 100}%;
                    border-radius: 2px;
                    animation: confettiFall 1s ease-in forwards;
                `;
                
                confettiContainer.appendChild(confetti);
                
                setTimeout(() => confetti.remove(), 1000);
            }, i * 100);
        }
        
        setTimeout(() => confettiContainer.remove(), 2000);
    }

    getRandomColor() {
        const colors = [
            '#8B4513', '#D2691E', '#FFD700', '#10B981', 
            '#3B82F6', '#EF4444', '#8B5CF6', '#06B6D4'
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }
}

// Agregar estilos de animación dinámicos
const dynamicStyles = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}

@keyframes confettiFall {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
}

.valid {
    border-color: var(--auth-success) !important;
    background: rgba(16, 185, 129, 0.05) !important;
}

.error {
    border-color: var(--auth-error) !important;
    background: rgba(239, 68, 68, 0.05) !important;
}

.focused {
    transform: translateY(-2px);
}
`;

// Injectar estilos dinámicos
const styleSheet = document.createElement('style');
styleSheet.textContent = dynamicStyles;
document.head.appendChild(styleSheet);

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new ElegantFormWizard();
    
    // Agregar efecto de carga inicial
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

console.log('🎉 FormWizard Elegante cargado correctamente');