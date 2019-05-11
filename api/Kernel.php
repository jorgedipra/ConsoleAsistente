<?php
$_id=false;#para data o id
$_var=false;#especificar
$cont=0;#variable de switch

if($match['target']):
require 'Conexion/conexion.php';##Conexion a base de datos	
require "Entidad/Entidades.php";##entidades get/set
require "Controller/{$match['target']}__Controller.php";##carga Controller
do {
	switch ($match['target']):
      	case 'Landing':
      		$Controller = new  Landing__Controller();
      		${"{$match['target']}_{$match['name']}"} = $Controller->{$match['name']}($_id,$_var);
		    $cont=2;#termina el ciclo
		break;
		default:
			$id=explode("_", $match['name']);
			$match['name']=$id[0];
			$_id=$id[1];#le da id [ordenar,acciones,id]

			##asiganacion de parametros dentro de una pagina
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
}while ($cont<1); 
else:
	$match['target']="error";
	$match['name']="404";
	header("Location: /404");
endif;
##Carga el html del codigo
require  "view/{$match['target']}__{$match['name']}.php";