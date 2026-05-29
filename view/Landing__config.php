<?php
#@header
define("Titulo", "Configurar LLM - Console Assistant");
include 'partials/header_partials.php';
#@END::header

$debug = true;
echo Console::log('config', ['page' => 'Config LLM'], 'info', $debug);
?>

<section id="app-config" class="config-container">
    <div class="config-header">
        <h1 class="title">⚙️ Configuración del Asistente</h1>
        <p class="subtitle">Selecciona el proveedor de IA y modelo que deseas usar</p>
    </div>

    <div class="config-content">
        <!-- Estado del servicio -->
        <div id="status-container" class="status-box">
            <h3>Estado del Servicio</h3>
            <div id="health-status">
                <span class="status-loading">Verificando...</span>
            </div>
        </div>

        <!-- Selector de Provider -->
        <div class="form-group">
            <label for="provider-select">Proveedor de IA</label>
            <select id="provider-select" class="form-control">
                <option value="ollama">🤖 Ollama (Local) - Sin costo</option>
                <option value="anthropic">🧠 Claude (Anthropic) - API</option>
                <option value="openai">💬 OpenAI (GPT) - API</option>
            </select>
            <small class="form-text">Ollama corre modelos localmente. Claude y OpenAI requieren API keys.</small>
        </div>

        <!-- Selector de Modelo -->
        <div class="form-group">
            <label for="model-select">Modelo</label>
            <select id="model-select" class="form-control">
                <option value="llama3">LLaMA 3</option>
                <option value="llama3.2">LLaMA 3.2</option>
                <option value="mistral">Mistral</option>
                <option value="codellama">CodeLLaMA</option>
                <option value="phi3">Phi-3</option>
            </select>
        </div>

        <!-- Endpoint (para Ollama) -->
        <div class="form-group" id="endpoint-group">
            <label for="endpoint-input">Endpoint</label>
            <input type="text" id="endpoint-input" class="form-control"
                   value="http://localhost:11434"
                   placeholder="http://localhost:11434">
            <small class="form-text">URL del servicio Ollama. Por defecto: http://localhost:11434</small>
        </div>

        <!-- API Key (para Claude/OpenAI) -->
        <div class="form-group api-key-group" id="apikey-group" style="display: none;">
            <label for="apikey-input">API Key</label>
            <input type="password" id="apikey-input" class="form-control"
                   placeholder="sk-ant-...">
            <small class="form-text">Tu clave API se almacena de forma segura</small>
        </div>

        <!-- Configuración avanzada -->
        <details class="advanced-config">
            <summary>⚡ Configuración Avanzada</summary>
            <div class="advanced-content">
                <div class="form-group">
                    <label for="temperature">Temperature: <span id="temp-value">0.7</span></label>
                    <input type="range" id="temperature" min="0" max="2" step="0.1" value="0.7"
                           class="slider">
                    <small>Controla la creatividad (0 = preciso, 2 = creativo)</small>
                </div>
                <div class="form-group">
                    <label for="max-tokens">Max Tokens: <span id="tokens-value">500</span></label>
                    <input type="range" id="max-tokens" min="50" max="4000" step="50" value="500"
                           class="slider">
                    <small>Longitud máxima de respuesta</small>
                </div>
            </div>
        </details>

        <!-- Botones -->
        <div class="config-actions">
            <button id="btn-test" class="btn btn-secondary" onclick="testConnection()">
                🔍 Probar Conexión
            </button>
            <button id="btn-save" class="btn btn-primary" onclick="saveConfig()">
                💾 Guardar Configuración
            </button>
        </div>

        <!-- Resultado de acciones -->
        <div id="config-result" class="result-box"></div>
    </div>

    <div class="config-footer">
        <a href="/" class="btn btn-back">← Volver al Asistente</a>
    </div>
</section>

<style>
.config-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.config-header {
    text-align: center;
    margin-bottom: 30px;
}

.config-header h1 {
    font-family: var(--font-title);
    color: var(--color-cyan);
}

.subtitle {
    color: var(--color-text);
}

.status-box {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: 15px;
    margin-bottom: 20px;
}

.status-box h3 {
    margin-top: 0;
    font-family: var(--font-title);
}

.status-ok {
    color: var(--color-green);
}

.status-error {
    color: var(--color-pink);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--color-text-light);
}

.form-control {
    width: 100%;
    padding: 10px;
    background: var(--color-bg-input);
    border: 1px solid var(--color-border);
    color: var(--color-text-light);
    border-radius: var(--radius-sm);
}

.form-control:focus {
    border-color: var(--color-cyan);
    outline: none;
}

.form-text {
    color: var(--color-text-muted);
    font-size: 12px;
}

.advanced-config {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: 10px;
    margin: 20px 0;
}

.advanced-config summary {
    cursor: pointer;
    font-weight: bold;
    color: var(--color-cyan);
}

.advanced-content {
    padding: 15px;
}

.slider {
    width: 100%;
    accent-color: var(--color-cyan);
}

.config-actions {
    display: flex;
    gap: 10px;
    margin: 20px 0;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-family: var(--font-body);
    transition: all 0.3s;
}

.btn-primary {
    background: var(--color-cyan);
    color: var(--color-bg);
}

.btn-primary:hover {
    background: var(--color-cyan-light);
}

.btn-secondary {
    background: var(--color-bg-card);
    color: var(--color-text-light);
    border: 1px solid var(--color-border);
}

.btn-secondary:hover {
    border-color: var(--color-cyan);
}

.btn-back {
    background: transparent;
    color: var(--color-cyan);
    text-decoration: none;
}

.result-box {
    padding: 15px;
    border-radius: var(--radius-sm);
    margin-top: 15px;
    display: none;
}

.result-success {
    background: rgba(25, 210, 100, 0.2);
    border: 1px solid var(--color-green);
    color: var(--color-green);
}

.result-error {
    background: rgba(247, 11, 117, 0.2);
    border: 1px solid var(--color-pink);
    color: var(--color-pink);
}
</style>

<script>
const providersModels = {
    ollama: ['llama3', 'llama3.2', 'mistral', 'codellama', 'phi3', 'qwen2.5'],
    anthropic: ['claude-3-haiku-20240307', 'claude-3-sonnet-20240229', 'claude-3-opus-20240229', 'claude-3.5-sonnet-20241022'],
    openai: ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo']
};

// Al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    loadConfig();
    checkHealth();

    // Event listeners
    document.getElementById('provider-select').addEventListener('change', updateModels);
    document.getElementById('temperature').addEventListener('input', updateTempValue);
    document.getElementById('max-tokens').addEventListener('input', updateTokensValue);
});

function updateModels() {
    const provider = document.getElementById('provider-select').value;
    const modelSelect = document.getElementById('model-select');
    const models = providersModels[provider] || [];

    modelSelect.innerHTML = '';
    models.forEach(model => {
        const option = document.createElement('option');
        option.value = model;
        option.textContent = model;
        modelSelect.appendChild(option);
    });

    // Mostrar/ocultar campos según provider
    document.getElementById('endpoint-group').style.display = provider === 'ollama' ? 'block' : 'none';
    document.getElementById('apikey-group').style.display = provider === 'ollama' ? 'none' : 'block';
}

function updateTempValue() {
    document.getElementById('temp-value').textContent = document.getElementById('temperature').value;
}

function updateTokensValue() {
    document.getElementById('tokens-value').textContent = document.getElementById('max-tokens').value;
}

function loadConfig() {
    axios.get('/api/llm/config')
        .then(response => {
            if (response.data.config) {
                const cfg = response.data.config;
                document.getElementById('provider-select').value = cfg.provider;
                updateModels();
                document.getElementById('model-select').value = cfg.model;
                document.getElementById('endpoint-input').value = cfg.endpoint;

                if (cfg.config_json) {
                    const config = JSON.parse(cfg.config_json);
                    document.getElementById('temperature').value = config.temperature || 0.7;
                    document.getElementById('max-tokens').value = config.max_tokens || 500;
                    updateTempValue();
                    updateTokensValue();
                }
            }
        })
        .catch(err => console.log('Sin configuración guardada'));
}

function checkHealth() {
    const statusEl = document.getElementById('health-status');
    statusEl.innerHTML = '<span class="status-loading">Verificando...</span>';

    axios.get('/api/llm/health')
        .then(response => {
            const data = response.data;
            if (data.disponible) {
                statusEl.innerHTML = '<span class="status-ok">✅ ' + data.mensaje + '</span>';
            } else {
                statusEl.innerHTML = '<span class="status-error">❌ ' + data.mensaje + '</span>';
            }
        })
        .catch(err => {
            statusEl.innerHTML = '<span class="status-error">❌ Error al verificar</span>';
        });
}

function testConnection() {
    const resultEl = document.getElementById('config-result');
    resultEl.style.display = 'block';
    resultEl.className = 'result-box';
    resultEl.innerHTML = '⏳ Probando conexión...';

    const provider = document.getElementById('provider-select').value;
    const endpoint = document.getElementById('endpoint-input').value;
    const apiKey = document.getElementById('apikey-input').value;

    // Guardar configuración temporal y probar
    axios.post('/api/llm/config', {
        provider: provider,
        model: document.getElementById('model-select').value,
        endpoint: endpoint,
        api_key: apiKey,
        config_json: JSON.stringify({
            temperature: parseFloat(document.getElementById('temperature').value),
            max_tokens: parseInt(document.getElementById('max-tokens').value)
        })
    })
    .then(() => checkHealth())
    .catch(err => {
        resultEl.className = 'result-box result-error';
        resultEl.innerHTML = '❌ Error al guardar configuración';
    });
}

function saveConfig() {
    const resultEl = document.getElementById('config-result');
    resultEl.style.display = 'block';
    resultEl.className = 'result-box';
    resultEl.innerHTML = '⏳ Guardando...';

    const provider = document.getElementById('provider-select').value;
    const endpoint = document.getElementById('endpoint-input').value;
    const apiKey = document.getElementById('apikey-input').value;

    axios.post('/api/llm/config', {
        provider: provider,
        model: document.getElementById('model-select').value,
        endpoint: endpoint,
        api_key: apiKey,
        config_json: JSON.stringify({
            temperature: parseFloat(document.getElementById('temperature').value),
            max_tokens: parseInt(document.getElementById('max-tokens').value)
        })
    })
    .then(response => {
        resultEl.className = 'result-box result-success';
        resultEl.innerHTML = '✅ ' + response.data.message;
        setTimeout(() => {
            window.location.href = '/';
        }, 1500);
    })
    .catch(err => {
        resultEl.className = 'result-box result-error';
        resultEl.innerHTML = '❌ ' + (err.response?.data?.error || 'Error al guardar');
    });
}
</script>

<?php
#@footer
include 'partials/footer_partials.php';
#@END::footer
?>