<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento - Plataforma Cultural Popayán</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Nuestro CSS personalizado -->
    <link href="{{ asset('css/pages/events-create.css') }}" rel="stylesheet">
</head>
<body class="event-create-body">
    <div class="event-create-container">
        <div class="create-header">
            <h1><i class="fas fa-calendar-plus"></i> Crear Nuevo Evento</h1>
            <p>Comparte tu evento cultural con la comunidad de Popayán</p>
        </div>

        <form action="{{ route('events.store') }}" method="POST" class="event-form" enctype="multipart/form-data">
            @csrf
            
            <!-- Campo para imagen del evento -->
            <div class="form-group">
                <label class="form-label" for="event_image">Imagen del Evento</label>
                <div class="image-upload-container">
                    <div class="image-preview" id="imagePreview">
                        <i class="fas fa-camera"></i>
                        <span>Haz clic para subir una imagen</span>
                    </div>
                    <input type="file" class="form-control image-input" id="event_image" name="event_image" 
                           accept="image/*" style="display: none;">
                    <small class="image-help">Formatos: JPG, PNG, GIF. Tamaño máximo: 5MB</small>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label required-field" for="title">Título del Evento</label>
                <input type="text" class="form-control" id="title" name="title" required 
                       placeholder="Ej: Festival de Danza Folclórica">
            </div>

            <div class="form-group">
                <label class="form-label required-field" for="content">Descripción del Evento</label>
                <textarea class="form-control" id="content" name="content" rows="5" required 
                          placeholder="Describe tu evento..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required-field" for="category_id">Categoría</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="location_id">Ubicación</label>
                    <select class="form-select" id="location_id" name="location_id">
                        <option value="">Selecciona una ubicación</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required-field" for="start_date">Fecha de Inicio</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                </div>

                <div class="form-group">
                    <label class="form-label required-field" for="end_date">Fecha de Fin</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required-field" for="event_type">Tipo de Evento</label>
                    <select class="form-select" id="event_type" name="event_type" required>
                        <option value="free">Gratuito</option>
                        <option value="paid">Pago</option>
                        <option value="donation">Donación</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="price">Precio ($)</label>
                    <input type="number" class="form-control" id="price" name="price" 
                           min="0" step="0.01" placeholder="0.00" value="0">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="max_capacity">Capacidad Máxima</label>
                <input type="number" class="form-control" id="max_capacity" name="max_capacity" 
                       min="1" placeholder="Ej: 100">
            </div>

            <!-- Campos adicionales para artes escénicas -->
            <div class="form-section">
                <h3><i class="fas fa-theater-masks"></i> Información de Artes Escénicas (Opcional)</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="art_type">Tipo de Arte</label>
                        <select class="form-select" id="art_type" name="art_type">
                            <option value="">Selecciona un tipo</option>
                            <option value="circus">Circo</option>
                            <option value="theater">Teatro</option>
                            <option value="dance">Danza</option>
                            <option value="performance">Performance</option>
                            <option value="magic">Magia</option>
                            <option value="music">Música</option>
                            <option value="storytelling">Cuentacuentos</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="duration_minutes">Duración (minutos)</label>
                        <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" 
                               min="1" placeholder="Ej: 90">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="artistic_director">Director Artístico</label>
                        <input type="text" class="form-control" id="artistic_director" name="artistic_director" 
                               placeholder="Nombre del director">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="company">Compañía/Grupo</label>
                        <input type="text" class="form-control" id="company" name="company" 
                               placeholder="Nombre de la compañía">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="technical_requirements">Requerimientos Técnicos</label>
                    <textarea class="form-control" id="technical_requirements" name="technical_requirements" 
                              rows="3" placeholder="Equipamiento técnico necesario..."></textarea>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-calendar-check"></i> Crear Evento
            </button>
        </form>
    </div>

    <!-- Nuestro JavaScript personalizado -->
    <script src="{{ asset('js/modules/events-create.js') }}"></script>
</body>
</html>