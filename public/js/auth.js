// Navegación por pasos del formulario de registro
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.step');
    let currentStep = 1;

    // Mostrar paso actual
    function showStep(stepNumber) {
        steps.forEach(step => step.classList.remove('active'));
        progressSteps.forEach(step => step.classList.remove('active'));
        
        document.getElementById(`step${stepNumber}`).classList.add('active');
        document.querySelector(`.step[data-step="${stepNumber}"]`).classList.add('active');
        currentStep = stepNumber;
    }

    // Validar paso actual antes de avanzar
    function validateStep(stepNumber) {
        const currentStepElement = document.getElementById(`step${stepNumber}`);
        const inputs = currentStepElement.querySelectorAll('input[required]');
        
        for (let input of inputs) {
            if (!input.value.trim()) {
                input.focus();
                showError(input, 'Este campo es obligatorio');
                return false;
            }
            
            if (input.type === 'email' && !isValidEmail(input.value)) {
                input.focus();
                showError(input, 'Ingresa un email válido');
                return false;
            }
            
            if (input.type === 'password' && input.id === 'password_confirmation') {
                const password = document.getElementById('password').value;
                if (input.value !== password) {
                    input.focus();
                    showError(input, 'Las contraseñas no coinciden');
                    return false;
                }
            }
        }
        
        return true;
    }

    // Validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Mostrar error
    function showError(input, message) {
        // Remover error anterior
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Crear nuevo error
        const error = document.createElement('span');
        error.className = 'error-message';
        error.textContent = message;
        error.style.color = '#d32f2f';
        error.style.fontSize = '0.85rem';
        error.style.marginTop = '5px';
        error.style.display = 'block';
        
        input.parentNode.appendChild(error);
        
        // Resaltar input
        input.style.borderColor = '#d32f2f';
        
        // Remover error después de 3 segundos
        setTimeout(() => {
            error.remove();
            input.style.borderColor = '';
        }, 3000);
    }

    // Botones Siguiente
    document.querySelectorAll('.btn-next').forEach(button => {
        button.addEventListener('click', function() {
            const nextStep = parseInt(this.getAttribute('data-next'));
            
            if (validateStep(currentStep)) {
                showStep(nextStep);
                
                // Scroll to top del formulario
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Botones Anterior
    document.querySelectorAll('.btn-prev').forEach(button => {
        button.addEventListener('click', function() {
            const prevStep = parseInt(this.getAttribute('data-prev'));
            showStep(prevStep);
            
            // Scroll to top del formulario
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Validación en tiempo real para email
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (this.value && !isValidEmail(this.value)) {
                showError(this, 'Ingresa un email válido');
            }
        });
    }

    // Validación en tiempo real para confirmación de contraseña
    const passwordConfirm = document.getElementById('password_confirmation');
    if (passwordConfirm) {
        passwordConfirm.addEventListener('blur', function() {
            const password = document.getElementById('password').value;
            if (this.value && password !== this.value) {
                showError(this, 'Las contraseñas no coinciden');
            }
        });
    }

    // Efectos visuales para los roles
    document.querySelectorAll('.role-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Remover todas las selecciones visuales
            document.querySelectorAll('.role-option label').forEach(label => {
                label.style.borderColor = '#e0e0e0';
                label.style.background = 'white';
                label.style.boxShadow = 'none';
            });
            
            // Aplicar estilo al seleccionado
            if (this.checked) {
                const label = this.nextElementSibling;
                label.style.borderColor = '#2c5530';
                label.style.background = 'rgba(44, 85, 48, 0.05)';
                label.style.boxShadow = '0 4px 15px rgba(44, 85, 48, 0.1)';
            }
        });
    });

    // Inicializar el primer paso
    showStep(1);
});