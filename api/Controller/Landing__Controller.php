<?php 
//http://phptoolcase.com/api/0.9.2/query_builder.html

class  Landing__Controller extends Controller{

	function home($id='',$var=''){

	$qb = new PtcQueryBuilder( $this->pdo() );
		

	$perfil=$qb->table( 'perfil' )
	->select( array( 'Nombre' , 'Apellido' ) )
	->run( );
	
		return $view = [
			'perfil'   => $perfil
		];
	}##->END function home
	

	function _404($id='',$var=''){
		if($id==true):
			echo "id [".$id."]";
			echo "var [".$var."]";
		endif;

	}//::END->_404

}##->END class landing__Controller