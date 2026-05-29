# Arquitectura de ConsoleAsistente

## Visión General

ConsoleAsistente es una aplicación web MVC que combina:
- Base de datos local para respuestas predefinidas
- Integración con LLMs (Ollama, Claude, OpenAI)
- Procesamiento de lenguaje natural en JavaScript
- Reconocimiento de voz con Web Speech API

## Flujo de Datos

```
Usuario → Input → Vue.js → JavaScript (NLP)
                                  ↓
                    ┌─────────────────────────────┐
                    ↓                             ↓
            Base de datos local          LLM (Ollama/API)
                    ↓                             ↓
                    └─────────────────────────────┘
                                  ↓
                            Respuesta IA
                                  ↓
                            Vue.js → Chat UI
```

## Estructura de Archivos

### Punto de Entrada
- `index.php` - Entrada principal de la aplicación

### Ruteo
- `router.php` - Router para servidor PHP built-in
- `routes/web.php` - Rutas web principales
- `routes/api.php` - Rutas de API REST
- `routes/constructor.php` - Generador de kernels dinámicos

### Controladores
- `api/Controller/Controller.php` - Controlador base legacy
- `api/Controller/Landing__Controller.php` - Controlador de landing
- `app/Http/Controllers/HomeController.php` - Controlador de home
- `app/Http/Controllers/ApiController.php` - Controlador de API LLM

### Servicios
- `app/Services/LlmService.php` - Servicio principal de LLM
- `app/Services/LlmProviders/` - Implementaciones específicas:
  - `OllamaService.php` - Ollama local
  - `ClaudeService.php` - Anthropic Claude
  - `OpenAiService.php` - OpenAI GPT
  - `CustomService.php` - API personalizada

### Frontend JavaScript

#### Núcleo Vue
- `public/js/app/core/App.js` - Núcleo de la aplicación Vue
- `public/js/app/modules/` - Módulos Vue:
  - `NlpProcessor.js` - Procesamiento de lenguaje natural
  - `ResponseFinder.js` - Buscador de respuestas en BD
  - `UnknownWordHandler.js` - Manejo de palabras desconocidas

#### Scripts de Home
- `public/js/home.js` - Instancia Vue principal
- `public/js/home/output.js` - Manejo de salida de mensajes
- `public/js/home/inputs.js` - Manejo de inputs y voz
- `public/js/home/N.duda.js` - Flujo de aprendizaje de palabras
- `public/js/home/N.respuestas.js` - Búsqueda de respuestas
- `public/js/home/N.comandos.js` - Comandos disponibles
- `public/js/home/N.funcionesComandos.js` - Funciones de comandos
- `public/js/home/N.memoria.js` - Memoria de palabras
- `public/js/home/N.clasificar.js` - Clasificación de entrada

### Vistas
- `view/Landing__home.php` - Vista principal
- `view/Landing__config.php` - Página de configuración
- `view/partials/` - Componentes parciales:
  - `header_partials.php` - Header HTML
  - `footer_partials.php` - Footer + scripts
  - `config_modal.php` - Modal de configuración

## Flujo de Procesamiento de Mensaje

### 1. Usuario escribe mensaje
```javascript
// home.js - actualizarChat()
const cadena = this.actividad;
const data = {
  user: User,
  message: cadena,
  rol: "User"
};
```

### 2. Procesamiento de Lenguaje Natural
```javascript
// N.memoria.js - Memoria.buscar()
// Procesa cada palabra y verifica si existe en vocabulario
```

### 3. Verificación de Palabras Desconocidas
```javascript
// N.duda.js - duda.palabras()
// Si encuentra palabras desconocidas, activa modo aprendizaje
```

### 4. Búsqueda de Respuesta
```javascript
// N.respuestas.js - respuestas.opciones()
// 1. Busca en comandos predefinidos
// 2. Busca en base de datos
// 3. Si no encuentra, consulta al LLM
```

### 5. Consulta al LLM
```javascript
// N.duda.js - palabraDesconocida()
// Llama a /api/llm/chat
fetch('/api/llm/chat', {
  method: 'POST',
  body: JSON.stringify({ mensaje: duda.original })
})
```

### 6. Mostrar Respuesta
```javascript
// output.js - messageIA()
// Renderiza Markdown y muestra en el chat
```

## Modelo de Datos

### Tabla: preguntas
```sql
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    respuesta TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabla: palabras
```sql
CREATE TABLE palabras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    palabra VARCHAR(100) NOT NULL,
    significado TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabla: config_llm
```sql
CREATE TABLE config_llm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider VARCHAR(50) NOT NULL,
    model VARCHAR(100) NOT NULL,
    api_key TEXT,
    endpoint VARCHAR(255),
    activo TINYINT(1) DEFAULT 0,
    config_json TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabla: conversacion
```sql
CREATE TABLE conversacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sesion VARCHAR(100),
    rol VARCHAR(20),
    mensaje TEXT,
    modelo VARCHAR(100),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Servicios LLM

### OllamaService
```php
class OllamaService implements LlmProviderInterface {
    public function chat($mensaje, $historial) { }
    public function healthCheck() { }
    public function listModels() { }
}
```

Usa la API REST de Ollama:
- Chat: `POST /api/chat`
- Modelos: `GET /api/tags`

### Configuración de LLM

El servicio carga la configuración desde `config_llm`:
```php
private function cargarConfiguracion() {
    $sql = "SELECT * FROM config_llm WHERE activo = 1 LIMIT 1";
    // ...
}
```

## Rutas API

### GET /api/llm/health
Verifica disponibilidad del LLM.

### POST /api/llm/chat
Envía mensaje y obtiene respuesta.

### GET/POST /api/llm/config
Gestiona configuración del LLM.

### GET /api/commands
Lista comandos disponibles.

## Variables de Estado Vue

```javascript
data: {
  mensaje: [],        // Mensajes de estado
  actividad: '',      // Input actual
  actividades: [],     // Historial de chat
  estado: '',          // Estado del asistente
  classMicro: '',     // Clase CSS del micrófono
  classEnviar: '',    // Clase CSS del botón enviar
  hora: '',           // Hora actual
  fecha: ''           // Fecha actual
}
```

## Hooks y Callbacks

### Vue Mounted
```javascript
mounted() {
  this.mensaje.push({ consola: ':: Asistente ::' });
  this.montajeInicial();
}
```

### Vue Updated
```javascript
updated() {
  this.scrollToBottom();
}
```

## Dependencias Externas

### JavaScript
- Vue.js 2.x
- Axios
- Annyang (reconocimiento de voz)
- Marked.js (Markdown)
- FontAwesome (iconos)

### PHP
- AltoRouter
- MySQLi

## Consideraciones de Seguridad

1. **SQL Injection**: Usar `mysqli_real_escape_string()`
2. **XSS**: Sanitizar HTML en output
3. **CSRF**: Token en formularios
4. **API Keys**: Almacenar en variables de entorno

## Optimizaciones

1. **Caché de respuestas**: Implementar caché Redis/Memcached
2. **Lazy loading**: Cargar módulos JS bajo demanda
3. **Compresión**: Habilitar gzip en servidor
4. **CDN**: Servir archivos estáticos desde CDN
