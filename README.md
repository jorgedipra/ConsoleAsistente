# ConsoleAsistente 🚀
Asistente de consola conversacional con soporte para comandos de voz y LLMs (Ollama, Claude, OpenAI).
<p align="center">
  <img width="1873" height="956" alt="image" src="https://github.com/user-attachments/assets/14954d64-acf9-4780-a0a2-163fe31ca0aa" />

</p>

## ✨ Características

- 💬 **Chat conversacional** - Interfaz de chat en tiempo real
- 🎤 **Comandos de voz** - Reconocimiento de voz en español
- 🤖 **Integración LLM** - Soporte para Ollama (local), Claude y OpenAI
- 📝 **Respuestas con Markdown** - Código, listas y formato en las respuestas
- 🔧 **Base de datos local** - Respuestas predefinidas para comandos específicos
- 🎨 **Interfaz moderna** - Diseño cyberpunk/retro con CSS personalizado

## 📋 Requisitos

- **PHP** 7.4+ o 8.0+
- **MySQL** 5.7+ o MariaDB 10.3+
- **Node.js** (opcional, para desarrollo)
- **Ollama** (opcional, para LLM local)

### Para usar Ollama (recomendado)

```bash
# Instalar Ollama
# https://ollama.com/download

# Descargar un modelo
ollama pull llama3
# o
ollama pull qwen2.5

# Iniciar Ollama
ollama serve
```

## 🚀 Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/jorgedipra/ConsoleAsistente.git
cd ConsoleAsistente
```

2. **Configurar base de datos**
```sql
-- Crear base de datos
CREATE DATABASE console_asistente CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE console_asistente;

-- Tabla de preguntas/respuestas
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    respuesta TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de vocabulario
CREATE TABLE palabras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    palabra VARCHAR(100) NOT NULL,
    significado TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de configuración LLM
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

-- Tabla de conversación
CREATE TABLE conversacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sesion VARCHAR(100),
    rol VARCHAR(20),
    mensaje TEXT,
    modelo VARCHAR(100),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. **Actualizar configuración de conexión**
Edita `config/conexion.php`:
```php
$servidor = 'localhost';
$usuario = 'tu_usuario';
$clave = 'tu_password';
$baseDatos = 'console_asistente';
```

4. **Iniciar servidor PHP**
```bash
# Opción 1: Servidor PHP built-in (desarrollo)
php -S localhost:8000 router.php

# Opción 2: Apache/Nginx (producción)
# Configurar virtual host apuntando a /public
```

5. **Abrir en navegador**
```
http://localhost:8000
```

## ⚙️ Configuración

### Modal de Configuración

Haz clic en el botón **"Configuración"** en el header para:

- **Proveedor de IA**: Selecciona Ollama, Claude, OpenAI o URL personalizada
- **Modelo**: Elige el modelo a usar
- **Endpoint**: URL del servicio API
- **API Key**: Para servicios que la requieran

### Variables de Entorno

Crea `config/.env` si es necesario:
```env
DB_HOST=localhost
DB_USER=tu_usuario
DB_PASS=tu_password
DB_NAME=console_asistente
```

## 📁 Estructura del Proyecto

```
ConsoleAsistente/
├── app/
│   ├── Http/
│   │   └── Controllers/        # Controladores MVC
│   ├── Repositories/           # Repositorios de datos
│   └── Services/              # Servicios (LLM)
│       └── LlmProviders/      # Proveedores de IA
├── api/
│   ├── Conexion/             # Conexión a BD
│   ├── Controller/            # Controladores legacy
│   └── Console/              # Kernel de consola
├── config/                   # Configuraciones
├── public/
│   ├── css/                  # Estilos
│   ├── js/                   # JavaScript
│   │   ├── app/              # Módulos Vue
│   │   └── home/             # Scripts de home
│   └── files/                # Librerías externas
├── routes/                    # Rutas API y web
├── storage/                   # Archivos subidos
├── view/                     # Vistas PHP
├── router.php                # Router para PHP built-in
└── index.php                 # Punto de entrada
```

## 🔌 API Endpoints

### Chat con LLM
```http
POST /api/llm/chat
Content-Type: application/json

{
  "mensaje": "tu pregunta",
  "historial": []
}
```

### Verificar estado del LLM
```http
GET /api/llm/health
```

### Guardar configuración
```http
POST /api/llm/config
Content-Type: application/json

{
  "provider": "ollama",
  "model": "llama3",
  "endpoint": "http://localhost:11434"
}
```

### Ver comandos disponibles
```http
GET /api/commands
```

## 🎨 Personalización

### Colores
Edita las variables CSS en `public/css/main/main.css`:
```css
:root {
  --color-primary: #3f51b5;
  --color-cyan: #00bebe;
  --color-green: #19d264;
  --color-pink: #f70b75;
}
```

### Agregar comandos
Los comandos se definen en `public/js/home/N.comandos.js`:
```javascript
comandos.command = {
  'HOLA': 'saludar',
  'ADIOS': 'despedirse',
  // ...
};
```

## 🐛 Solución de Problemas

### Ollama no responde
```bash
# Verificar que Ollama está corriendo
curl http://localhost:11434/api/tags

# Reiniciar Ollama
ollama serve
```

### Error de conexión a BD
- Verificar credenciales en `config/conexion.php`
- Confirmar que MySQL está corriendo
- Verificar que la base de datos existe

### CORS errors
Si usas desde otro dominio, configura headers CORS en tu servidor web.

## 📝 Licencia

MIT License - ver archivo [LICENSE](LICENSE) para detalles.

## 👥 Autores

- **Jorge Diaz** - [@jorgedipra](https://github.com/jorgedipra)

## 🙏 Acknowledgments

- [Vue.js](https://vuejs.org/) - Framework JavaScript
- [Annyang](https://github.com/TalAter/annyang) - Reconocimiento de voz
- [AltoRouter](https://altorouter.com/) - Enrutador PHP
- [Marked.js](https://marked.js.org/) - Parser Markdown
