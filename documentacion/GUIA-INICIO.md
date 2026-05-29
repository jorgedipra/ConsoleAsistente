# Guía de Inicio Rápido

## Instalación en 5 Pasos

### 1. Requisitos Previos

Asegúrate de tener instalado:
- PHP 7.4+ o 8.0+
- MySQL 5.7+
- Composer (para dependencias PHP)
- Git

### 2. Clonar el Proyecto

```bash
git clone https://github.com/jorgedipra/ConsoleAsistente.git
cd ConsoleAsistente
```

### 3. Configurar Base de Datos

3.1. Crear la base de datos:
```sql
CREATE DATABASE console_asistente CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE console_asistente;
```

3.2. Crear las tablas:
```sql
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    respuesta TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE palabras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    palabra VARCHAR(100) NOT NULL,
    significado TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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

CREATE TABLE conversacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sesion VARCHAR(100),
    rol VARCHAR(20),
    mensaje TEXT,
    modelo VARCHAR(100),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3.3. Editar `config/conexion.php` con tus credenciales:
```php
$servidor = 'localhost';
$usuario = 'root';
$clave = 'tu_password';
$baseDatos = 'console_asistente';
```

### 4. Instalar Dependencias

```bash
composer install
```

### 5. Iniciar el Servidor

```bash
# Opción A: Servidor PHP built-in (desarrollo)
php -S localhost:8000 router.php

# Opción B: Apache (producción)
# Configurar DocumentRoot a /public
```

### 6. Abrir en el Navegador

```
http://localhost:8000
```

## Configuración de LLM

### Ollama (Recomendado - Gratuito)

1. Descargar e instalar desde https://ollama.com/download

2. Descargar un modelo:
```bash
ollama pull llama3
# o
ollama pull qwen2.5
```

3. Iniciar Ollama:
```bash
ollama serve
```

4. En la app, clic en **Configuración**:
   - Proveedor: Ollama (Local)
   - Endpoint: http://localhost:11434
   - Modelo: selecciona uno descargado

5. Clic en **Probar** para verificar conexión

### OpenAI (De pago)

1. Obtener API key en https://platform.openai.com

2. En Configuración:
   - Proveedor: OpenAI (GPT)
   - API Key: tu_key

### Claude (De pago)

1. Obtener API key en https://console.anthropic.com

2. En Configuración:
   - Proveedor: Claude (Anthropic)
   - API Key: tu_key

## Agregar Respuestas Predefinidas

### Por Base de Datos

```sql
INSERT INTO preguntas (pregunta, respuesta) VALUES
('HOLA', '¡Hola! ¿En qué puedo ayudarte?'),
('ADIOS', '¡Hasta luego! Que tengas un buen día.');
```

### Por Código

Editar `public/js/home/N.comandos.js`:
```javascript
comandos.command = {
  'HOLA': 'saludar',
  'ADIOS': 'despedirse',
  'VER COMANDOS': 'vercomandos'
};
```

## Comandos de Voz

El asistente soporta comandos de voz en español:

1. Clic en el botón de micrófono
2. Di "Hola" o "Escuchar"
3. El asistente te escuchará

## Solución de Problemas

### Error "Connection refused" con Ollama

```bash
# Verificar que Ollama está corriendo
curl http://localhost:11434/api/tags

# Si no responde, iniciar Ollama
ollama serve
```

### Error de Base de Datos

1. Verificar que MySQL está corriendo
2. Verificar credenciales en `config/conexion.php`
3. Verificar que la base de datos existe

### Página en Blanco

1. Verificar permisos de archivos:
```bash
chmod -R 755 storage
chmod -R 755 public
```

2. Ver logs de PHP:
```bash
php -S localhost:8000 router.php -t .
```

## Próximos Pasos

- [ ] Agregar más comandos predefinidos
- [ ] Entrenar con más preguntas/respuestas
- [ ] Personalizar la interfaz
- [ ] Configurar producción con Nginx/Apache
- [ ] Agregar HTTPS
