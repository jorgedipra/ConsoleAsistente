<?php 
class Landing__Entidades{
	private $ID;

	public function getID(){
		return $this->ID;
	} 
	public function setID($ID){
		$this->ID = $ID;
	}


	public function Name2($accion,$name,$valor = 0){
        if($accion == "Get")
                return $this->$name;
        if($accion == "Set")
                $this->$name = $valor;
	}



	public function Get($name){
        return $this->$name;
	}

	public function Set($name,$valor = 0){
                $this->$name = $valor;
	}
	

}