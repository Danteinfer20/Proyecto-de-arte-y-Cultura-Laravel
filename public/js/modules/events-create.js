// resources/js/pages/events-create.js
document.addEventListener('DOMContentLoaded', function() {
    // ========== VALIDACIÓN DE FECHAS ==========
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (startDate && endDate) {
        // Establecer fecha mínima como hoy
        const today = new Date().toISOString().split('T')[0];
        startDate.min = today + 'T00:00';
        
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
            
            // Si la fecha fin es anterior a la inicio, actualizarla
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        });
    }
    
    // ========== MANEJO DE PRECIO SEGÚN TIPO DE EVENTO ==========
    const eventType = document.getElementById('event_type');
    const priceField = document.getElementById('price');
    const priceGroup = priceField ? priceField.parentElement : null;
    
    function togglePriceField() {
        if (eventType && priceField && priceGroup) {
            if (eventType.value === 'free') {
                priceField.disabled = true;
                priceField.value = '0';
                priceGroup.style.opacity = '0.6';
                priceGroup.style.pointerEvents = 'none';
            } else {
                priceField.disabled = false;
                priceField.value = priceField.value === '0' ? '' : priceField.value;
                priceGroup.style.opacity = '1';
                priceGroup.style.pointerEvents = 'all';
            }
        }
    }
    
    if (eventType) {
        eventType.addEventListener('change', togglePriceField);
        togglePriceField(); // Ejecutar al cargar
    }
    
    // ========== MANEJO DE SUBIDA DE IMAGEN ==========
    const imageInput = document.getElementById('event_image');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        // Click en el preview abre el file input
        imagePreview.addEventListener('click', function() {
            imageInput.click();
        });
        
        // Mostrar preview de imagen seleccionada
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validar tamaño (5MB máximo)
                if (file.size > 5 * 1024 * 1024) {
                    showMessage('El archivo es demasiado grande. Máximo 5MB.', 'error');
                    this.value = '';
                    return;
                }
                
                // Validar tipo
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showMessage('Formato no válido. Use JPG, PNG o GIF.', 'error');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    imagePreview.innerHTML = `
                        <img src="${this.result}" alt="Preview de imagen del evento">
                        <div class="image-actions">
                            <button type="button" class="btn-change-image" onclick="changeImage()">
                                <i class="fas fa-sync-alt"></i> Cambiar
                            </button>
                            <button type="button" class="btn-remove-image" onclick="removeImage()">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    `;
                    imagePreview.classList.add('has-image');
                    showMessage('Imagen cargada correctamente', 'success');
                });
                
                reader.addEventListener('error', function() {
                    showMessage('Error al cargar la imagen', 'error');
                });
                
                reader.readAsDataURL(file);
            }
        });
        
        // Drag and drop
        imagePreview.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        imagePreview.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });
        
        imagePreview.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                imageInput.dispatchEvent(new Event('change'));
            }
        });
    }
    
    // ========== VALIDACIÓN EN TIEMPO REAL ==========
    const form = document.querySelector('.event-form');
    if (form) {
        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                validateField(this);
            });
            
            field.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('invalid');
                    this.classList.add('valid');
                }
            });
        });
        
        // Validar envío del formulario
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showMessage('Por favor, complete todos los campos requeridos correctamente.', 'error');
                return;
            }
            
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando Evento...';
            
            // Mostrar progreso
            showMessage('Creando evento, por favor espere...', 'info');
        });
    }
    
    // ========== EFECTOS VISUALES EN CAMPOS ==========
    const formControls = document.querySelectorAll('.form-control, .form-select');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // ========== MANEJO DE CAMPOS DE ARTES ESCÉNICAS ==========
    const artTypeField = document.getElementById('art_type');
    const performingArtsSection = document.querySelector('.form-section');
    
    if (artTypeField && performingArtsSection) {
        artTypeField.addEventListener('change', function() {
            if (this.value) {
                performingArtsSection.style.display = 'block';
                // Animación de entrada
                performingArtsSection.style.opacity = '0';
                performingArtsSection.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    performingArtsSection.style.opacity = '1';
                    performingArtsSection.style.transform = 'translateY(0)';
                    performingArtsSection.style.transition = 'all 0.3s ease';
                }, 10);
            } else {
                performingArtsSection.style.opacity = '0';
                performingArtsSection.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    performingArtsSection.style.display = 'none';
                }, 300);
            }
        });
        
        // Ocultar sección inicialmente si no hay tipo seleccionado
        if (!artTypeField.value) {
            performingArtsSection.style.display = 'none';
        }
    }
    
    // ========== CONTADOR DE CARACTERES ==========
    const contentField = document.getElementById('content');
    if (contentField) {
        const charCount = document.createElement('div');
        charCount.className = 'char-count';
        charCount.style.cssText = `
            text-align: right;
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-top: 5px;
        `;
        contentField.parentElement.appendChild(charCount);
        
        function updateCharCount() {
            const count = contentField.value.length;
            charCount.textContent = `${count} caracteres`;
            
            if (count < 50) {
                charCount.style.color = '#e74c3c';
            } else if (count < 100) {
                charCount.style.color = '#f39c12';
            } else {
                charCount.style.color = '#27ae60';
            }
        }
        
        contentField.addEventListener('input', updateCharCount);
        updateCharCount(); // Inicial
    }
    
    // ========== AUTO-GUARDADO (OPCIONAL) ==========
    let autoSaveTimer;
    const formData = {};
    
    formControls.forEach(control => {
        control.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft();
            }, 2000);
        });
    });
    
    function saveDraft() {
        // Guardar borrador en localStorage
        formControls.forEach(control => {
            if (control.name) {
                formData[control.name] = control.value;
            }
        });
        localStorage.setItem('eventDraft', JSON.stringify(formData));
        console.log('Borrador guardado automáticamente');
    }
    
    // Cargar borrador si existe
    const savedDraft = localStorage.getItem('eventDraft');
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        formControls.forEach(control => {
            if (control.name && draft[control.name]) {
                control.value = draft[control.name];
                
                // Disparar eventos para campos que dependen de otros
                if (control.name === 'event_type') {
                    togglePriceField();
                }
                if (control.name === 'art_type') {
                    artTypeField.dispatchEvent(new Event('change'));
                }
            }
        });
        
        // Mostrar notificación de borrador cargado
        showMessage('Borrador anterior cargado', 'info');
    }
    
    // Limpiar borrador al enviar el formulario
    if (form) {
        form.addEventListener('submit', function() {
            localStorage.removeItem('eventDraft');
        });
    }
});

// ========== FUNCIONES GLOBALES ==========
function changeImage() {
    const imageInput = document.getElementById('event_image');
    if (imageInput) {
        imageInput.click();
    }
}

function removeImage() {
    const imageInput = document.getElementById('event_image');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.value = '';
        imagePreview.innerHTML = `
            <i class="fas fa-camera"></i>
            <span>Haz clic para subir una imagen</span>
        `;
        imagePreview.classList.remove('has-image');
        showMessage('Imagen removida', 'info');
    }
}

function validateField(field) {
    if (field.hasAttribute('required') && !field.value.trim()) {
        field.classList.add('invalid');
        field.classList.remove('valid');
        return false;
    }
    
    // Validaciones específicas por tipo de campo
    if (field.type === 'email' && field.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
            field.classList.add('invalid');
            field.classList.remove('valid');
            return false;
        }
    }
    
    if (field.type === 'number' && field.value) {
        if (field.hasAttribute('min') && parseFloat(field.value) < parseFloat(field.getAttribute('min'))) {
            field.classList.add('invalid');
            field.classList.remove('valid');
            return false;
        }
    }
    
    field.classList.remove('invalid');
    field.classList.add('valid');
    return true;
}

function validateForm() {
    const form = document.querySelector('.event-form');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
            
            // Scroll al primer campo inválido
            if (isValid === false) {
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                field.focus();
                isValid = true; // Para evitar múltiples scrolls
            }
        }
    });
    
    return isValid;
}

function showMessage(message, type = 'info') {
    // Remover mensaje anterior si existe
    const existingMessage = document.querySelector('.form-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `form-message ${type}`;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateX(400px);
        transition: transform 0.3s ease;
    `;
    
    // Colores según tipo
    const colors = {
        success: '#27ae60',
        error: '#e74c3c',
        info: '#3498db',
        warning: '#f39c12'
    };
    
    messageDiv.style.backgroundColor = colors[type] || colors.info;
    messageDiv.innerHTML = `
        <i class="fas fa-${getIcon(type)}"></i>
        ${message}
    `;
    
    document.body.appendChild(messageDiv);
    
    // Animación de entrada
    setTimeout(() => {
        messageDiv.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        messageDiv.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (messageDiv.parentElement) {
                messageDiv.remove();
            }
        }, 300);
    }, 5000);
}

function getIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        info: 'info-circle',
        warning: 'exclamation-triangle'
    };
    return icons[type] || 'info-circle';
}

// ========== MANEJO DE NAVEGACIÓN ==========
window.addEventListener('beforeunload', function(e) {
    const form = document.querySelector('.event-form');
    if (form) {
        const formData = new FormData(form);
        let hasData = false;
        
        for (let [key, value] of formData.entries()) {
            if (value && key !== '_token' && key !== 'event_image') {
                hasData = true;
                break;
            }
        }
        
        if (hasData) {
            e.preventDefault();
            e.returnValue = 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?';
            return e.returnValue;
        }
    }
});