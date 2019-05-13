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
			/*
			SELECT respuesta FROM respuestas WHERE id = (
			SELECT t.respuesta1
			FROM `tipo_respuesta_peso` AS t 
			INNER JOIN respuestas as r
			ON r.id = t.id_pregunta
			WHERE t.id_pregunta = 2)
			*/
			$respuestas=$qb->table( 'tipo_respuesta_peso' )
			->select([
				'tipo_respuesta_peso.respuesta1',
				'tipo_respuesta_peso.respuesta2',
				'tipo_respuesta_peso.respuesta3'
			])
			->join( 'respuestas' , 'respuestas.id' , '=' ,  'tipo_respuesta_peso.id_pregunta' )
			->where('tipo_respuesta_peso.id_pregunta','=',$pregunta[0]['id'] )
			->run( );	
			$respuesta=$qb->table( 'respuestas' )
			->select(["respuesta"])
			->where('id','=',$respuestas[0]['respuesta1'])
			->or_where('id','=',$respuestas[0]['respuesta2'])
			->or_where('id','=',$respuestas[0]['respuesta3'])
			->run();

		endif;
		return $view = [
			'respuesta'   => $respuesta,
			'nose'   => $nose
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