<?php 
//http://phptoolcase.com/api/0.9.2/query_builder.html

class  Landing__Controller extends Controller{

	function home($id='',$var=''){

	$qb = new PtcQueryBuilder( $this->pdo() );
		
	$datos=$qb->table( 'personal' )
	->select(array('dato','valor'))
	->where('id','=',1 )
	->or_where('id','=',2 )
	->run( );
	
		return $view = [
			'datos'   => $datos
		];
	}##->END function home
	
	function pregunta($id='',$var=''){
		$qb 	= new PtcQueryBuilder( $this->pdo() ); 
		$data = json_decode(file_get_contents("php://input"));//captura de datos con Json
		$nose=0;
		$pregunta =$qb->table( 'preguntas' )
		->select(array('id'))
		->where('pregunta','like',$data->pregunta )
		->run( );
		if(!isset($pregunta[0])):
			$respuesta = "{ 'respuesta0': :'no te entiendo' }";
			$nose=1;
		else:	
			
			$respuestas=$qb->table( 'tipo_respuesta_peso' )
			->select(['respuestas.respuesta'])
			->join( 'respuestas' , 'respuestas.id' , '=' ,  'tipo_respuesta_peso.respuesta' )
			->where('tipo_respuesta_peso.id_pregunta','=',$pregunta[0]['id'] )
			->run( );	
			$Nrespuestas=$qb->countRows(  );
		endif;
		return $view = [
			'respuesta'   => $respuestas,
			'nose'   => $nose,
			'Nrespuestas'   => $Nrespuestas
		];
	}##->END funtion pregunta

	function palabras($id='',$var=''){
		$qb 	= new PtcQueryBuilder( $this->pdo() ); 
		$data 	= json_decode(file_get_contents("php://input"));
		
		$palabra= $qb->table( 'palabras' )
			->select(array('id'))
			->where('palabras','=',$data->palabra )
			->run( );
		
		if(!isset($palabra[0])):
			$qb->table( 'palabras' )
				->insert( array( 'palabras' => $data->palabra ) ) 
				->run( );
		endif;
		//echo $data->palabra;	
	}##->END funtion palabras

	function _404($id='',$var=''){
		if($id==true):
			echo "id [".$id."]";
			echo "var [".$var."]";
		endif;

	}//::END->_404

}##->END class landing__Controller