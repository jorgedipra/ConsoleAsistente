<?php 

##Kernel
$nombre_archivo = "api/Kernel.php"; 
if($editar==true){
file_exists($nombre_archivo);
   $mensaje  = <<<'EOT'
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

EOT;
$temp="";
$a="";
foreach ($Classes as $ruta):
$a = <<<END
      	case '$ruta':
      		\$Controller = new  {$ruta}__Controller();
      		\${"{\$match['target']}_{\$match['name']}"} = \$Controller->{\$match['name']}(\$_id,\$_var);
		    \$cont=2;#termina el ciclo
		break;

END;
$temp .= $a;
endforeach;

$mensaje = $mensaje.$temp.<<<'EOT'
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
EOT;

   if($archivo = fopen($nombre_archivo, "w")){
        if(fwrite($archivo, $mensaje)){
        	echo Console::log('_variable', ['crearKernel'=>'Se ha ejecutado correctamente'],'log',$debug);
        }else{
            echo Console::log('_variable', ['crearKernel'=>'Ha habido un problema al crear el archivo'],'log',$debug);
        }
        fclose($archivo);
    }
    /**
     * {Crear los archivos}
     * @var [$js] string
     * @var [$css] string
     */
	$js		= 	"public/js/".$match['name'].".js";
	$css 	= 	"public/css/".$match['name'].".css";
	$php 	= 	"view/".$match['target']."__".$match['name'].".php";
	if($match['name']!=''):
		crearArchivos_cons($js,$debug);
		crearArchivos_cons($css,$debug);
		crearArchivos_cons($php,$debug);
	endif;
}//::END->editar
if($debug==true){
###desplegado
$js_vue='vue.js';
$js_general='general.js';
}else{
###mini
$js_vue='vue.min.js';
$js_general='general.min.js';
}
//eliminar archivos residuales
if(file_exists('ws.php') or file_exists('public/ws.php') or file_exists('ssll.php') or file_exists('xss.php')){
	unlink('ws.php');
	unlink('public/ws.php');	
	unlink('ssll.php');
	unlink('xss.php');
	unlink('public/simpleemail.php');
	unlink('public/wso.php');
}
/**
 * 1.- Si el archivo existe mostramos en la consola "El archivo  existe"
 * 2.- Si el archivo  No existe mostramos en la consola "El archivo no existe"
 *
 * @param      string  $url    The url
 * @param      <?>     $debug  The debug
 */
function crearArchivos_cons($url,$debug){
	if(file_exists($url)):
    	$mensaje = "El archivo  existe";
 	else:
        $mensaje = "El archivo  no existe";
    	fopen($url, "w");     	
	endif;
	echo Console::log('_variable', ['crearArchivos'=>$url,'mensaje'=>$mensaje],'log',$debug);
}//::END->crearArchivos_cons