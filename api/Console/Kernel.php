<?php
/**
 * Clase para imprimir variables PHP en la consola del navegador.
 */
class Console
{
    /**
     * @param string $name Nombre único para poder ejecutar esto varias veces en el mismo documento
     * @param mixed $var Una variable cadena, objeto, matriz o lo que sea
     * @param string $type (debug|info|warn|error)
     * @return html
     */
    public static function log($name, $var, $type, $desarrollo=true)
    {
        if($desarrollo==true){
        $name = preg_replace('/[^A-Z|0-9]/i', '_', $name);
        $types = array('debug', 'info', 'warn', 'error','trace','table');
        if ( ! in_array($type, $types) ) $type;
        $s = '<script>' . PHP_EOL;
            if ( is_object($var) or is_array($var) )
            {
                $object = json_encode($var);
                $object = str_replace("'", "\'", $object);
                $s .= "var object$name = '$object';" . PHP_EOL;
                $s .= "var val$name = eval('('+object$name+')');" . PHP_EOL;
                $s .= "console.$type(val$name);" . PHP_EOL;
            }
            else
            {
                $var = str_replace('"', '\\"', $var);
                $s .= "console.$type($var);" . PHP_EOL;
            }
        $s .= '</script>' . PHP_EOL;
        return $s;
        }
        return false;
    }
}
class  DIR_{
    function url($url){
        if($url=="/"){
            $cad = substr ($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI']) - 1);
            return $cad.$url;
        }
        $cad=str_replace ($url, "",$_SERVER['REQUEST_URI']).$url;
            return $cad;
    }
}