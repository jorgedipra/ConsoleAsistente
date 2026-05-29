<?php
/**
 * Kernel - Enrutador principal
 * Mantiene compatibilidad con Controllers legacy (Landing__Controller)
 */
$_id=false;
$_var=false;
$cont=0;

if($match['target']):
    // Cargar dependencias base solo si no existen
    if (!class_exists('Conex')) {
        require 'Conexion/conexion.php';
    }
    if (!class_exists('PtcQueryBuilder')) {
        require "Conexion/PtcQueryBuilder.php";
    }
    if (!class_exists('Controller')) {
        require "Controller/Controller.php";
    }
    require "Entidad/Entidades.php";

    do {
        switch ($match['target']):

            case 'HomeController':
                // Nuevo sistema - usar el nuevo HomeController
                if (!class_exists('HomeController')) {
                    require_once 'app/Http/Controllers/HomeController.php';
                }
                $Controller = new HomeController();

                // Ejecutar método del controller
                if (method_exists($Controller, $match['name'])) {
                    $result = $Controller->{$match['name']}($_id, $_var);
                    // Los métodos que devuelven jsonResponse ya enviaron respuesta y hacen exit()
                    // Solo procesar arrays para vistas
                    if (is_array($result)) {
                        $Landing_home = $result; // Para compatibilidad con vistas
                        extract($result);
                    }
                }
                $cont=2; // termina el ciclo
                break;

            case 'Landing':
                // Sistema legacy - mantener compatibilidad
                if (!class_exists('Landing__Controller')) {
                    require "Controller/{$match['target']}__Controller.php";
                }
                $Controller = new Landing__Controller();
                ${"{$match['target']}_{$match['name']}"} = $Controller->{$match['name']}($_id,$_var);
                $cont=2;
                break;

            default:
                // Otros controllers legacy
                if (!class_exists($match['target'] . '__Controller')) {
                    require "Controller/{$match['target']}__Controller.php";
                }
                $id=explode("_", $match['name']);
                $match['name']=$id[0];
                $_id=$id[1];

                if(isset($match['params']['id'])):
                    $_var=$match['params']['id'];
                elseif(isset($match['params']['ordenar'])):
                    $_var=$match['params']['ordenar'];
                endif;
                if(isset($match['params']['action'])):
                    if(isset($match['params']['id'])):
                        $_id=$match['params']['action'];
                    else:
                        $_var=$match['params']['action'];
                    endif;
                endif;
        endswitch;
    } while ($cont<1);

else:
    $match['target']="Landing";
    $match['name']="_404";
    header("Location: /404");
endif;

// Cargar la vista
if ($match['target'] === 'HomeController') {
    // Determinar qué vista cargar
    if ($match['name'] === 'config') {
        require "view/Landing__config.php";
    } else {
        // Vistas principales
        require "view/Landing__{$match['name']}.php";
    }
} else {
    // Vistas legacy
    require "view/{$match['target']}__{$match['name']}.php";
}
?>