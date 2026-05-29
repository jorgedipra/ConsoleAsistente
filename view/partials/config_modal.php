<!-- Modal de Configuración (se carga desde el footer) -->
<div id="config-modal" class="modal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(3px);">
    <div class="modal-content" style="background: #212121; padding: 0; border: 1px solid #00bebe; border-radius: 8px; box-shadow: 0 0 20px #00dcdc; width: 50%; margin: 10% auto; position: relative;">
        <div class="modal-header">
            <h2>⚙️ Configuración del Asistente</h2>
            <span class="modal-close" onclick="cerrarConfigModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div id="status-container" class="status-box">
                <h3>Estado del Servicio</h3>
                <div id="health-status">
                    <span class="status-loading">Verificando...</span>
                </div>
            </div>

            <div class="form-group">
                <label for="provider-select">Proveedor de IA</label>
                <select id="provider-select" class="form-control">
                    <option value="ollama">🤖 Ollama (Local)</option>
                    <option value="anthropic">🧠 Claude (Anthropic)</option>
                    <option value="openai">💬 OpenAI (GPT)</option>
                    <option value="custom">🔗 URL Personalizada</option>
                </select>
            </div>

            <div class="form-group">
                <label for="model-select">Modelo</label>
                <select id="model-select" class="form-control">
                    <option value="llama3">LLaMA 3</option>
                    <option value="mistral">Mistral</option>
                </select>
            </div>

            <div class="form-group" id="endpoint-group">
                <label for="endpoint-input">
                    Endpoint URL
                    <button type="button" class="btn-refresh" onclick="cargarModelosOllama()" title="Refrescar modelos">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </label>
                <input type="text" id="endpoint-input" class="form-control" value="http://localhost:11434" placeholder="http://localhost:11434">
                <small class="form-text">URL base del servicio API</small>
            </div>

            <div class="form-group api-key-group" id="custom-url-group" style="display: none;">
                <label for="custom-model-input">Modelo para API</label>
                <input type="text" id="custom-model-input" class="form-control" value="modelo" placeholder="Nombre del modelo (ej: llama3, gpt-4)">
                <small class="form-text">Nombre del modelo que usará esta API</small>
            </div>

            <div class="form-group api-key-group" id="apikey-group" style="display: none;">
                <label for="apikey-input">API Key</label>
                <input type="password" id="apikey-input" class="form-control" placeholder="sk-ant-...">
                <small class="form-text">Tu clave API se almacena de forma segura</small>
            </div>

            <div class="config-actions">
                <button id="btn-test" class="btn btn-secondary" onclick="testConnection()">🔍 Probar</button>
                <button id="btn-save" class="btn btn-primary" onclick="saveConfig()">💾 Guardar</button>
            </div>

            <div id="config-result" class="result-box"></div>
        </div>
    </div>
</div>