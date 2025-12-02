// Profile Edit Functionality - COMPLETAMENTE FUNCIONAL
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Profile Edit JS loaded');

    // 1. Preview en tiempo real de campos de texto
    initPreviewFields();

    // 2. Contador de caracteres para bio
    initBioCounter();

    // 3. Upload de imágenes FUNCIONAL
    initImageUploads();

    // 4. Botón restablecer
    initResetButton();

    // 5. Manejo del formulario
    initFormHandling();
});

// 1. Preview en tiempo real
function initPreviewFields() {
    const previewFields = document.querySelectorAll('[data-preview]');
    
    previewFields.forEach(field => {
        // Configurar valor inicial
        updatePreview(field.getAttribute('data-preview'), field.value);
        
        // Escuchar cambios
        field.addEventListener('input', function() {
            const fieldType = this.getAttribute('data-preview');
            updatePreview(fieldType, this.value);
        });
    });
}

function updatePreview(field, value) {
    const previewName = document.getElementById('previewName');
    const previewUsername = document.getElementById('previewUsername');
    const previewBio = document.getElementById('previewBio');

    switch(field) {
        case 'name':
            if (previewName) previewName.textContent = value || 'Tu Nombre';
            break;
        case 'username':
            if (previewUsername) previewUsername.textContent = value ? '@' + value : '@username';
            break;
        case 'bio':
            if (previewBio) previewBio.textContent = value || 'Tu biografía aparecerá aquí...';
            break;
    }
}

// 2. Contador de bio
function initBioCounter() {
    const bioTextarea = document.getElementById('bio');
    const charCount = document.getElementById('bioCharCount');
    
    if(bioTextarea && charCount) {
        bioTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
}

// 3. Upload de imágenes - COMPLETAMENTE FUNCIONAL
function initImageUploads() {
    initUploadArea('coverInput', 'coverUploadArea', 'coverText', 'coverFileName', 'coverPreview');
    initUploadArea('avatarInput', 'avatarUploadArea', 'avatarText', 'avatarFileName', 'avatarPreview');
}

function initUploadArea(inputId, areaId, textId, fileNameId, previewId) {
    const fileInput = document.getElementById(inputId);
    const uploadArea = document.getElementById(areaId);
    const textElement = document.getElementById(textId);
    const fileNameElement = document.getElementById(fileNameId);
    const previewElement = document.getElementById(previewId);

    if (!fileInput || !uploadArea) return;

    // Click en el área
    uploadArea.addEventListener('click', function(e) {
        if (e.target !== fileInput) {
            fileInput.click();
        }
    });

    // Drag & Drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function() {
        this.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if(files.length > 0) {
            fileInput.files = files;
            handleFileSelection(fileInput, textElement, fileNameElement, previewElement);
        }
    });

    // Cambio en el input file
    fileInput.addEventListener('change', function() {
        handleFileSelection(this, textElement, fileNameElement, previewElement);
    });
}

function handleFileSelection(fileInput, textElement, fileNameElement, previewElement) {
    const file = fileInput.files[0];
    if (!file) return;

    // Validaciones
    if (!file.type.startsWith('image/')) {
        showNotification('❌ Por favor, selecciona solo archivos de imagen.', 'error');
        return;
    }

    // Tamaños máximos diferentes para cover y avatar
    const maxSize = fileInput.id === 'coverInput' ? 4 * 1024 * 1024 : 2 * 1024 * 1024;
    if (file.size > maxSize) {
        const maxMB = maxSize / (1024 * 1024);
        showNotification(`❌ La imagen es demasiado grande. Máximo ${maxMB}MB.`, 'error');
        return;
    }

    // Actualizar interfaz
    if (textElement) {
        textElement.textContent = 'Imagen seleccionada';
    }
    
    if (fileNameElement) {
        fileNameElement.textContent = `📁 ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
    }

    // Mostrar preview
    showImagePreview(file, previewElement);
    showNotification('✅ Imagen cargada correctamente', 'success');
}

function showImagePreview(file, previewElement) {
    if (!previewElement) return;

    const reader = new FileReader();
    
    reader.onload = function(e) {
        // Crear o actualizar imagen
        let img = previewElement.querySelector('img');
        
        if (!img) {
            // Si es un placeholder, reemplazarlo
            if (previewElement.querySelector('.cover-default') || previewElement.querySelector('.avatar-default')) {
                img = document.createElement('img');
                previewElement.innerHTML = '';
                previewElement.appendChild(img);
            } else {
                img = previewElement.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    previewElement.appendChild(img);
                }
            }
        }
        
        img.src = e.target.result;
        img.alt = 'Preview';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
    };

    reader.onerror = function() {
        showNotification('❌ Error al cargar la imagen', 'error');
    };

    reader.readAsDataURL(file);
}

// 4. Botón restablecer
function initResetButton() {
    const resetBtn = document.getElementById('resetBtn');
    if(resetBtn) {
        resetBtn.addEventListener('click', function() {
            if(confirm('¿Estás seguro de que quieres restablecer todos los cambios?')) {
                resetForm();
            }
        });
    }
}

function resetForm() {
    const form = document.getElementById('profileEditForm');
    if (!form) return;

    form.reset();
    
    // Restaurar previews desde los valores por defecto
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const bioInput = document.getElementById('bio');
    
    if (nameInput) updatePreview('name', nameInput.defaultValue || '');
    if (usernameInput) updatePreview('username', usernameInput.defaultValue || '');
    if (bioInput) updatePreview('bio', bioInput.defaultValue || '');
    
    // Restaurar contador de bio
    const charCount = document.getElementById('bioCharCount');
    if(charCount && bioInput) {
        charCount.textContent = (bioInput.defaultValue || '').length;
    }
    
    // Limpiar previews de imágenes
    resetImagePreviews();
    
    showNotification('🔄 Formulario restablecido', 'info');
}

function resetImagePreviews() {
    // Restaurar cover preview
    const coverPreview = document.getElementById('coverPreview');
    const coverText = document.getElementById('coverText');
    const coverFileName = document.getElementById('coverFileName');
    
    if (coverPreview && !coverPreview.querySelector('img')) {
        coverPreview.innerHTML = `
            <div class="cover-default">
                <i class="fas fa-mountain"></i>
                <span>Portada</span>
            </div>
        `;
    }
    
    if (coverText) coverText.textContent = 'Haz clic para subir portada';
    if (coverFileName) coverFileName.textContent = '';
    
    // Restaurar avatar preview  
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarText = document.getElementById('avatarText');
    const avatarFileName = document.getElementById('avatarFileName');
    const userInitial = document.getElementById('name') ? document.getElementById('name').defaultValue.charAt(0).toUpperCase() : 'U';
    
    if (avatarPreview && !avatarPreview.querySelector('img')) {
        avatarPreview.innerHTML = `
            <div class="avatar-default">${userInitial}</div>
        `;
    }
    
    if (avatarText) avatarText.textContent = 'Haz clic para subir avatar';
    if (avatarFileName) avatarFileName.textContent = '';
}

// 5. Manejo del formulario
function initFormHandling() {
    const form = document.getElementById('profileEditForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        });
    }
}

// Sistema de notificaciones
function showNotification(message, type = 'success') {
    // Remover notificaciones existentes
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    });

    // Crear nueva notificación
    const notification = document.createElement('div');
    notification.className = `custom-notification notification-${type}`;
    
    // Estilos
    const backgroundColor = type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db';
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: notificationSlideIn 0.3s ease;
        background: ${backgroundColor};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        min-width: 300px;
    `;
    
    notification.innerHTML = message;
    document.body.appendChild(notification);
    
    // Remover después de 4 segundos
    setTimeout(() => {
        notification.style.animation = 'notificationSlideOut 0.3s ease';
        setTimeout(() => {
            if(notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Añadir estilos de animación para notificaciones
if (!document.querySelector('#notification-styles')) {
    const style = document.createElement('style');
    style.id = 'notification-styles';
    style.textContent = `
        @keyframes notificationSlideIn {
            from { 
                transform: translateX(100%); 
                opacity: 0; 
            }
            to { 
                transform: translateX(0); 
                opacity: 1; 
            }
        }
        
        @keyframes notificationSlideOut {
            from { 
                transform: translateX(0); 
                opacity: 1; 
            }
            to { 
                transform: translateX(100%); 
                opacity: 0; 
            }
        }
    `;
    document.head.appendChild(style);
}