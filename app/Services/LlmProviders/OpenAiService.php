<?php
/**
 * OpenAiService - Implementación para OpenAI (GPT)
 */
require_once __DIR__ . '/LlmProviderInterface.php';

class OpenAiService implements LlmProviderInterface
{
    private $model;
    private $apiKey;
    private $config;
    private $baseUrl = 'https://api.openai.com/v1';

    public function __construct($model = 'gpt-4o-mini', $apiKey = '', $config = [])
    {
        $this->model = $model;
        $this->apiKey = $apiKey;
        $this->config = $config;
    }

    /**
     * Envía mensaje a OpenAI
     */
    public function chat($mensaje, $historial = [])
    {
        if (empty($this->apiKey)) {
            return "Error: API Key de OpenAI no configurada";
        }

        // Construir messages para contexto
        $messages = [];

        foreach ($historial as $msg) {
            $messages[] = [
                'role' => $msg['rol'],
                'content' => $msg['mensaje']
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $mensaje
        ];

        $temperature = $this->config['temperature'] ?? 0.7;
        $maxTokens = $this->config['max_tokens'] ?? 500;

        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens
        ];

        $ch = curl_init($this->baseUrl . '/chat/completions');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Error de conexión: " . $error;
        }

        if ($httpCode !== 200) {
            return "Error HTTP: " . $httpCode . " - " . $response;
        }

        $result = json_decode($response, true);

        if (isset($result['choices'][0]['message']['content'])) {
            return trim($result['choices'][0]['message']['content']);
        }

        return "Error: Respuesta inesperada de OpenAI";
    }

    /**
     * Verifica disponibilidad de OpenAI API
     */
    public function healthCheck()
    {
        if (empty($this->apiKey)) {
            return [
                'disponible' => false,
                'mensaje' => 'API Key no configurada'
            ];
        }

        return [
            'disponible' => true,
            'mensaje' => 'OpenAI API configurada con modelo: ' . $this->model,
            'modelos' => ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo']
        ];
    }

    /**
     * Lista modelos disponibles
     */
    public function listModels()
    {
        return [
            'gpt-4o',
            'gpt-4o-mini',
            'gpt-4-turbo',
            'gpt-3.5-turbo'
        ];
    }
}