<?php
$router = new AltoRouter();
$DIR 	= new DIR_();
//si se activa el modo edicion [Se agrega las clases al colocar estado true]
$editar=false;
//[con Console::log imprime las variables con la conla]
$debug=true;
// rura base se deja "" si esta en la raiz
$router->setBasePath('');
//clases que se quieran crear, por cada clase seria un conjunto de funciones diferentes
$Classes=[
			'1'=>'Landing'
		];

#			  @metodo		@ruta  							@target        	  @name		
$router->map('GET|POST',	$DIR->url("/"),   				$Classes['1'],    'home');
$router->map('POST',		$DIR->url("/pregunta"),   		$Classes['1'],    'pregunta');
$router->map('POST',		$DIR->url("/palabras"),   		$Classes['1'],    'palabras');
$router->map('GET',			$DIR->url("/404"), 			  	$Classes['1'],    '_404');

// match current requestc
$match = $router->match();