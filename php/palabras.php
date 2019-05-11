<?php
https://evilnapsis.com/2018/01/24/llenar-una-tabla-con-datos-json-con-vue-js-php-y-mysql/
/*
* Convertir datos de la tabla contact en JSON
* Powered by @evilnapsis
*/
$con = new mysqli("localhost","root","toor","Consola");
if($con){
	$sql = "select * from contact";
	$query = $con->query($sql);
	$data = array();
	while($r = $query->fetch_assoc()){
		$data[] = $r;
	}
	echo json_encode(array("contactos"=>$data));
}
?>