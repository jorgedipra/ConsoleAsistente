<?php
/**
 * LlmProviderInterface - Interface para proveedores de LLM
 */
interface LlmProviderInterface
{
    /**
     * Envía un mensaje y obtiene respuesta
     * @param string $mensaje
     * @param array $historial
     * @return string
     */
    public function chat($mensaje, $historial = []);

    /**
     * Verifica si el servicio está disponible
     * @return array
     */
    public function healthCheck();

    /**
     * Lista modelos disponibles
     * @return array
     */
    public function listModels();
}