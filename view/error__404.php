<?php 
#@header
define("Titulo", "404");
include 'partials/header_partials.php'; 
#@END::header

#@header-html
include 'partials/Landing__header_partials.php';
#@END::header
?>
<div class="container text-center" id="error404">
	<p>
		<h2>PÁGINA NO ENCONTRADA</h2>
	</p>
	<img id="error404__img" src="storage/public/404/404_1.gif" alt="404" title="404">
	<p>
		<h2>	
			Vaya, parece que esa página no existe.
		</h2>
	</p>
	<p>
		Parece que lo cables tienen un fantasma que los molesta... <br>
		Tal vez esto te ayude a volver a casa:
	</p>
	<a href="/" title="Home" id="error404___btnHome">	
		<p>
			<i class="fas fa-home"></i>
		</p>
	</a>
	<br>
</div>
<?php 
#@footer-html
include 'partials/Landing__footer_partials.php';
#@END::footer
#
#footer/Scripts
// include 'partials/footer_partials.php'; 
#@END::footer
?>
