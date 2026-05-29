<?php
/**
 * BaseController - Clase base para todos los controllers
 */

// Cargar dependencias solo si no existen
if (!class_exists('Conex')) {
    require_once __DIR__ . '/../../../api/Conexion/conexion.php';
}
if (!class_exists('PtcQueryBuilder')) {
    require_once __DIR__ . '/../../../api/Conexion/PtcQueryBuilder.php';
}

class BaseController
{
    /** @var Conex */
    protected $Connection;

    /**
     * Constructor - conecta a la base de datos
     */
    public function __construct()
    {
        $this->Connection = new Conex();
        $this->Connection->conectar();
    }

    /**
     * Obtiene conexión PDO
     * @return PDO
     */
    protected function getPdo()
    {
        $BaseDatos = $this->Connection->BaseDatos;
        $Servidor = $this->Connection->Servidor;
        $Usuario = $this->Connection->Usuario;
        $Clave = $this->Connection->Clave;
        $pdo_connection = 'mysql:host=' . $Servidor . ';dbname=' . $BaseDatos . ';charset=utf8;';
        return new PDO($pdo_connection, $Usuario, $Clave);
    }

    /**
     * Respuesta JSON estandarizada
     * @param mixed $data Datos a enviar
     * @param int $status HTTP status code
     */
    protected function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Respuesta de éxito
     * @param mixed $data
     * @param string $message
     */
    protected function success($data = null, $message = 'OK')
    {
        $this->jsonResponse([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Respuesta de error
     * @param string $message
     * @param int $status
     */
    protected function error($message = 'Error', $status = 400)
    {
        $this->jsonResponse([
            'status' => 'error',
            'message' => $message
        ], $status);
    }

    /**
     * Captura input JSON
     * @return array
     */
    protected function getJsonInput()
    {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    /**
     * Obtiene último ID insertado
     * @return int
     */
    protected function getLastId()
    {
        return mysqli_insert_id($this->Connection->Conexion_ID);
    }
}