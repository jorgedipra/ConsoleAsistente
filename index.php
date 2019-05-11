<?php 
/**
 * Jorgedipra - landingpage hecha en php
 *
 * @package  Jorgedipra
 * @author   Jorge diaz <jorgedipra@gmail.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Este archivo nos permite emular la funcionalidad 'mod_rewrite' de Apache desde
// servidor web PHP incorporado. Esto proporciona una forma conveniente de probar
// sin haber instalado un software de servidor web 'real' aquí.
// lo mas recomendable es tenerlo en la raiz y no en un public.
// en caso de trabajar en local, configurar un host virtual
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/config/app.php';
?>