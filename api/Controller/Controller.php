<?php
class Controller
{
    /////////////////////////[Conexion a BD]///////////////////////////////
    public $Connection;

    ##[__construct constructor]
    public function __construct()
    {
        $this->Connection = new Conex;
        $this->Connection->conectar();
    } //::END->__construct

    # [getLastId  Devuelve el id autogenerado que se utilizó en la última consulta]
    # @return [int/String] [El valor de el campo AUTO_INCREMENT que fué actualizado por la consulta anterior. Devuelve #cero si no hubo una consulta previa en la conexión o si la consulta no actualiza un valor AUTO_INCREMENT.]
    public function getLastId()
    {
        return mysqli_insert_id($this->Connection->Conexion_ID);
    } //END->getLastId

    ##Envia la consulta a la base de datos y retorna los datos
    public function Consulta($sql = '')
    {
        $this->Connection->consulta($sql);
        $this->Connection->leerVarios();
        $numregistros = $this->Connection->numregistros();
        return $numregistros;
    } //::END->Consulta

    public function pdo()
    {
        $BaseDatos = $this->Connection->BaseDatos;
        $Servidor = $this->Connection->Servidor;
        $Usuario = $this->Connection->Usuario;
        $Clave = $this->Connection->Clave;
        $pdo_connection = 'mysql:host=' . $Servidor . ';dbname=' . $BaseDatos . ';charset:uft8;';
        $pdo = new PDO($pdo_connection, $Usuario, $Clave);
        
        return $pdo;
    }
    /////////////////////////////////////////////////////////////////////
    public function post($var = "")
    {
        /**
         * [Bucle para recibir todas las variables por POST]
         * @var [$_POST]->metodo post
         */
        foreach ($_POST as $nombre_campo => $valor):
            $valor = htmlspecialchars($valor);
            $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
            eval($asignacion);
        endforeach;
        eval("\$var = \$" . $var . ";");

        return $var;
    } //::END-> post

    /////////////////////////////////////////////////////////////////////
    public function get($var = "")
    {
        /**
         * [Bucle para recibir todas las variables por POST]
         * @var [$_GET]->metodo post
         */
        foreach ($_GET as $nombre_campo => $valor):
            $valor = htmlspecialchars($valor);
            $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
            eval($asignacion);
        endforeach;
        eval("\$var = \$" . $var . ";");

        return $var;
    } //::END-> post

    public function session($var = "", $data = "")
    {
        if ($data != '') {
            $_SESSION[$var] = $data;
        }

        $var = $_SESSION[$var];
        return $var;
    } //::END->sesion
}
//funciones huerfanas
function url($url)
{
    return $_SERVER['REQUEST_URI'] . $url;
}
