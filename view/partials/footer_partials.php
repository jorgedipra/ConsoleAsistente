<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.1/annyang.min.js"></script>
<script src="public/files/vue/<?=$js_vue?>"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="public/js/<?=$js_general?>"></script>
<script src="public/js/<?=$match["name"]?>.js?v=<?=date('d-m-Y-H-i')?>"></script>
<script src="public/js/<?=$match["name"]?>/inputs.js"></script>
<script src="public/js/<?=$match["name"]?>/output.js"></script>

<!-- Modal de Configuración -->
<?php include 'config_modal.php'; ?>

<!-- Modal Config Scripts -->
<script>
const providersModels = {
    ollama: ['llama3', 'llama3.2', 'mistral', 'codellama', 'phi3', 'qwen2.5'],
    anthropic: ['claude-3-haiku-20240307', 'claude-3-sonnet-20240229', 'claude-3-opus-20240229', 'claude-3.5-sonnet-20241022'],
    openai: ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo'],
    custom: []
};

// Abrir modal
function abrirConfigModal() {
    console.log('abrirConfigModal llamado');
    const modal = document.getElementById('config-modal');
    if (modal) {
        console.log('Modal encontrado, mostrándolo');
        modal.style.display = 'block';
        loadConfig();
        checkHealth();

        // Si ya está seleccionado Ollama, cargar sus modelos
        setTimeout(() => {
            const provider = document.getElementById('provider-select')?.value;
            if (provider === 'ollama') {
                cargarModelosOllama();
            }
        }, 100);
    } else {
        console.error('Modal #config-modal NO encontrado en el DOM');
    }
}

// Cerrar modal
function cerrarConfigModal() {
    const modal = document.getElementById('config-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('config-modal');
    if (modal && event.target === modal) {
        cerrarConfigModal();
    }
}

// Actualizar modelos según provider
document.addEventListener('DOMContentLoaded', function() {
    const providerSelect = document.getElementById('provider-select');
    if (providerSelect) {
        providerSelect.addEventListener('change', function() {
            const provider = this.value;
            const modelSelect = document.getElementById('model-select');
            const models = providersModels[provider] || [];

            modelSelect.innerHTML = '';

            if (provider === 'custom') {
                // Para URL personalizada, dejar input de texto
                modelSelect.innerHTML = '<option value="custom">Personalizado</option>';
                document.getElementById('custom-url-group').style.display = 'block';
                document.getElementById('endpoint-input').value = '';
            } else {
                document.getElementById('custom-url-group').style.display = 'none';
            }

            // Mostrar/ocultar campos según provider
            if (provider === 'ollama') {
                document.getElementById('endpoint-group').style.display = 'block';
                document.getElementById('endpoint-input').value = 'http://localhost:11434';
                document.getElementById('apikey-group').style.display = 'none';
                // Cargar modelos de Ollama
                cargarModelosOllama();
            } else if (provider === 'custom') {
                document.getElementById('endpoint-group').style.display = 'block';
                document.getElementById('apikey-group').style.display = 'none';
            } else if (provider === 'anthropic' || provider === 'openai') {
                document.getElementById('endpoint-group').style.display = 'block';
                document.getElementById('apikey-group').style.display = 'block';
                // Cargar modelos predefinidos
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
        });
    }
});

// Cargar modelos disponibles de Ollama
function cargarModelosOllama() {
    const endpoint = document.getElementById('endpoint-input')?.value || 'http://localhost:11434';
    const modelSelect = document.getElementById('model-select');

    modelSelect.innerHTML = '<option value="">Cargando modelos...</option>';

    axios.get(endpoint + '/api/tags')
        .then(response => {
            const models = response.data.models || [];
            modelSelect.innerHTML = '';

            if (models.length === 0) {
                modelSelect.innerHTML = '<option value="llama3">LLaMA 3 (predeterminado)</option>';
                return;
            }

            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model.name;
                option.textContent = model.name;
                modelSelect.appendChild(option);
            });
        })
        .catch(err => {
            modelSelect.innerHTML = '<option value="llama3">LLaMA 3 (error al cargar)</option>';
            console.log('Error cargando modelos de Ollama:', err);
        });
}

// Cargar config guardada
function loadConfig() {
    axios.get('/api/llm/config')
        .then(response => {
            if (response.data.config) {
                const cfg = response.data.config;
                document.getElementById('provider-select').value = cfg.provider;
                document.getElementById('endpoint-input').value = cfg.endpoint;

                // Cargar modelos según provider
                if (cfg.provider === 'ollama') {
                    cargarModelosOllama();
                    setTimeout(() => {
                        document.getElementById('model-select').value = cfg.model;
                    }, 500);
                } else {
                    updateModelsFromProvider(cfg.provider);
                    setTimeout(() => {
                        document.getElementById('model-select').value = cfg.model;
                    }, 100);
                }

                if (cfg.config_json) {
                    try {
                        const config = JSON.parse(cfg.config_json);
                        document.getElementById('temperature').value = config.temperature || 0.7;
                        document.getElementById('max-tokens').value = config.max_tokens || 500;
                    } catch(e) {}
                }
            }
        })
        .catch(err => console.log('Sin configuración'));
}

function updateModelsFromProvider(provider) {
    const modelSelect = document.getElementById('model-select');
    const models = providersModels[provider] || [];
    modelSelect.innerHTML = '';
    models.forEach(model => {
        const option = document.createElement('option');
        option.value = model;
        option.textContent = model;
        modelSelect.appendChild(option);
    });
}

// Verificar estado del LLM
function checkHealth() {
    const statusEl = document.getElementById('health-status');
    if (!statusEl) return;
    statusEl.innerHTML = '<span class="status-loading">Verificando...</span>';

    axios.get('/api/llm/health')
        .then(response => {
            console.log('Health response:', response);
            const data = response.data;
            if (data.disponible) {
                statusEl.innerHTML = '<span class="status-ok">✅ ' + data.mensaje + '</span>';
            } else {
                statusEl.innerHTML = '<span class="status-error">❌ ' + data.mensaje + '</span>';
            }
        })
        .catch(err => {
            console.error('Health error:', err);
            statusEl.innerHTML = '<span class="status-error">❌ ' + (err.message || 'Error al verificar') + '</span>';
        });
}

// Probar conexión
function testConnection() {
    const resultEl = document.getElementById('config-result');
    if (!resultEl) return;
    resultEl.style.display = 'block';
    resultEl.className = 'result-box';
    resultEl.innerHTML = '⏳ Probando...';

    console.log('Test connection params:', {
        provider: document.getElementById('provider-select').value,
        model: document.getElementById('model-select').value,
        endpoint: document.getElementById('endpoint-input').value
    });

    axios.post('/api/llm/config', {
        provider: document.getElementById('provider-select').value,
        model: document.getElementById('model-select').value,
        endpoint: document.getElementById('endpoint-input').value,
        api_key: document.getElementById('apikey-input').value,
        config_json: JSON.stringify({
            temperature: 0.7,
            max_tokens: 500
        })
    })
    .then(response => {
        console.log('Test response:', response);
        resultEl.className = 'result-box result-success';
        resultEl.innerHTML = '✅ Conexión exitosa';
        checkHealth();
    })
    .catch(err => {
        console.error('Test error:', err);
        resultEl.className = 'result-box result-error';
        resultEl.innerHTML = '❌ Error: ' + (err.response?.data?.error || err.message);
    });
}

// Guardar configuración
function saveConfig() {
    const resultEl = document.getElementById('config-result');
    if (!resultEl) return;
    resultEl.style.display = 'block';
    resultEl.className = 'result-box';
    resultEl.innerHTML = '⏳ Guardando...';

    axios.post('/api/llm/config', {
        provider: document.getElementById('provider-select').value,
        model: document.getElementById('model-select').value,
        endpoint: document.getElementById('endpoint-input').value,
        api_key: document.getElementById('apikey-input').value,
        config_json: JSON.stringify({
            temperature: 0.7,
            max_tokens: 500
        })
    })
    .then(response => {
        resultEl.className = 'result-box result-success';
        resultEl.innerHTML = '✅ Configuración guardada';
        setTimeout(() => {
            cerrarConfigModal();
        }, 1500);
    })
    .catch(err => {
        resultEl.className = 'result-box result-error';
        resultEl.innerHTML = '❌ ' + (err.response?.data?.error || 'Error al guardar');
    });
}
</script>
</body>
</html>
