<?php
/**
 * ApiController - Controlador para endpoints de API LLM
 */
require_once __DIR__ . '/../../../api/Conexion/conexion.php';

class ApiController
{
    private $Conexion_ID;

    public function __construct()
    {
        $conex = new Conex();
        $this->Conexion_ID = $conex->conectar();
    }

    /**
     * Crea respuesta JSON
     */
    private function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Obtiene ID de sesión
     */
    private function getSessionId()
    {
        if (!isset($_SESSION['sesion_id'])) {
            $_SESSION['sesion_id'] = session_id();
        }
        return $_SESSION['sesion_id'];
    }

    /**
     * POST /api/llm/chat - Envía mensaje y obtiene respuesta
     */
    public function chat()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['mensaje']) || empty(trim($data['mensaje']))) {
            return $this->json(['error' => 'Mensaje requerido'], 400);
        }

        $mensaje = trim($data['mensaje']);
        $historial = $data['historial'] ?? [];

        // Cargar servicio LLM
        require_once __DIR__ . '/../../Services/LlmService.php';
        $llm = new LlmService();

        // Obtener respuesta
        $respuesta = $llm->ask($mensaje, $historial);

        // Guardar en historial
        $sesionId = $this->getSessionId();
        $config = $llm->getConfig();

        // Guardar mensaje del usuario
        $this->guardarMensaje($sesionId, 'user', $mensaje, $config['model'] ?? '');

        // Guardar respuesta del asistente
        $this->guardarMensaje($sesionId, 'assistant', $respuesta, $config['model'] ?? '');

        return $this->json([
            'respuesta' => $respuesta,
            'modelo' => $config['model'] ?? 'unknown'
        ]);
    }

    /**
     * GET /api/llm/history - Obtiene historial de conversación
     */
    public function history()
    {
        $sesionId = $this->getSessionId();
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

        $sql = "SELECT rol, mensaje, modelo, fecha
                FROM conversacion
                WHERE sesion = '$sesionId'
                ORDER BY fecha ASC
                LIMIT $limit";

        $result = mysqli_query($this->Conexion_ID, $sql);

        $historial = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $historial[] = $row;
        }

        return $this->json([
            'historial' => $historial,
            'total' => count($historial)
        ]);
    }

    /**
     * POST /api/llm/config - Guarda configuración del LLM
     */
    public function saveConfig()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $provider = $data['provider'] ?? 'ollama';
        $model = $data['model'] ?? 'llama3';
        $apiKey = $data['api_key'] ?? '';
        $endpoint = $data['endpoint'] ?? 'http://localhost:11434';
        $configJson = $data['config_json'] ?? '{"temperature": 0.7, "max_tokens": 500}';

        // Desactivar todas las configuraciones
        mysqli_query($this->Conexion_ID, "UPDATE config_llm SET activo = 0");

        // Insertar nueva configuración
        $sql = "INSERT INTO config_llm (provider, model, api_key, endpoint, activo, config_json)
                VALUES ('$provider', '$model', '$apiKey', '$endpoint', 1, '$configJson')";

        if (mysqli_query($this->Conexion_ID, $sql)) {
            return $this->json([
                'success' => true,
                'message' => 'Configuración guardada'
            ]);
        }

        return $this->json(['error' => 'Error al guardar configuración'], 500);
    }

    /**
     * GET /api/llm/config - Obtiene configuración actual
     */
    public function getConfig()
    {
        $sql = "SELECT * FROM config_llm WHERE activo = 1 LIMIT 1";
        $result = mysqli_query($this->Conexion_ID, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $config = mysqli_fetch_assoc($result);
            // No devolver api_key completa
            if (!empty($config['api_key'])) {
                $config['api_key'] = '***' . substr($config['api_key'], -4);
            }
            return $this->json(['config' => $config]);
        }

        return $this->json(['config' => null], 404);
    }

    /**
     * GET /api/llm/providers - Lista providers disponibles
     */
    public function providers()
    {
        require_once __DIR__ . '/../../Services/LlmService.php';
        $llm = new LlmService();

        return $this->json([
            'providers' => $llm->getProviders()
        ]);
    }

    /**
     * GET /api/llm/health - Verifica estado del LLM
     */
    public function health()
    {
        require_once __DIR__ . '/../../Services/LlmService.php';
        $llm = new LlmService();

        return $this->json($llm->verificarDisponibilidad());
    }

    /**
     * DELETE /api/llm/history - Limpia historial de conversación
     */
    public function clearHistory()
    {
        $sesionId = $this->getSessionId();

        $sql = "DELETE FROM conversacion WHERE sesion = '$sesionId'";
        mysqli_query($this->Conexion_ID, $sql);

        return $this->json([
            'success' => true,
            'message' => 'Historial eliminado'
        ]);
    }

    /**
     * Guarda un mensaje en la base de datos
     */
    private function guardarMensaje($sesion, $rol, $mensaje, $modelo)
    {
        $mensaje = mysqli_real_escape_string($this->Conexion_ID, $mensaje);
        $modelo = mysqli_real_escape_string($this->Conexion_ID, $modelo);

        $sql = "INSERT INTO conversacion (sesion, rol, mensaje, modelo)
                VALUES ('$sesion', '$rol', '$mensaje', '$modelo')";

        mysqli_query($this->Conexion_ID, $sql);
    }
}