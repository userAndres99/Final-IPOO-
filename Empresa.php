<?php

class Empresa {
    /*ATRIBUTOS*/
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $colecViajes;
    private $mensajeoperacion;

    //CONSTRUCTOR
    public function __construct( )
    {
        $this->idempresa = '';
        $this->enombre = '';
        $this->edireccion = '';
        $this->colecViajes= [];
        $this->mensajeoperacion=''; 
    }

    /**
     * carga los valores de la empresa
     */
    public function cargar($idempresa,$enombre,$edireccion){
        $this->set_idempresa($idempresa);
        $this->set_enombre($enombre);
        $this->set_edireccion($edireccion);
    }

    //========== METODOS GET ==========
    /**
     * para obtener el id de la empresa
     * @return int
     */
    public function get_idempresa(){
        return $this->idempresa;
    }
    /**
     * para obtener el nombre de la empresa
     * @return string
     */
    public function get_enombre(){
        return $this->enombre;
    }
    /**
     * para obtener la direccion de la empresa
     * @return string
     */
    public function get_edireccion(){
        return $this->edireccion;
    }
    /**
     * para obtener la coleccion de viajes de la empresa
     * @return array
     */
    public function get_colecViajes(){
        return $this->colecViajes;
    }
    /**
     * 
     */
    public function get_mensajeoperacion(){
        return $this->mensajeoperacion;
    }

    //========== METODOS SET ==========
    /**
     * para enviar el id de la empresa
     * @param int
     */
    public function set_idempresa($idempresa){
        $this->idempresa = $idempresa;
    }
    /**
     * para enviar el nombre de la empresa
     * @param string
     */
    public function set_enombre($enombre){
        $this->enombre = $enombre ;
    }
    /**
     * para enviar la direccion de la empresa
     * @param string
     */
    public function set_edireccion($edireccion){
        $this->edireccion = $edireccion;
    }
    /**
     * para enviar una coleccion de viajes a la empresa
     * @param array
     */
    public function set_colecViajes($colecViajes){
        $this->colecViajes = $colecViajes;
    }
    /**
     * 
     */
    public function set_mensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //========== METODOS EXTRA ==========
    /**
     * carga los valores de la empresa
     */
    /*public function cargar($idempresa,$enombre,$edireccion){
        $this->set_idempresa($idempresa);
        $this->set_enombre($enombre);
        $this->set_edireccion($edireccion);
    }*/
    /**
	 * Recupera los datos de una empresa 
	 * @param int 
	 * @return boolean  verdadero si encuentra los datos y false en caso contrario 
	 */		
    public function Buscar($idempresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idempresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($row2=$base->Registro()){					
                     
                    $this->cargar($row2['idempresa'], $row2['enombre'], $row2['edireccion']);
                    
					$resp= true;
				}				
			
		 	}else {
		 		$this->set_mensajeoperacion($base->getError());
		 		
			}
		}else{
		 	$this->set_mensajeoperacion($base->getError());
		 	
		}		
		return $resp;
	}
    /**
     * recupera una lista de empresa de la base de datos
     * @param string
     * @return array
     */
    public static function listar($condicion=""){
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by idempresa ";
		//echo $consultaEmpresa;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
					
					$idempresa=$row2['idempresa'];
					$enombre=$row2['enombre'];
					$edireccion=$row2['edireccion'];
					
					$empresa=new Empresa();
					$empresa->cargar($idempresa,$enombre,$edireccion);
					array_push($arregloEmpresa,$empresa);
	
				}
		 	}else{
		 		$this->set_mensajeoperacion($base->getError());
			}
		}else{
		 	$this->set_mensajeoperacion($base->getError());
		}	
		return $arregloEmpresa;
	}
    /**
     * Inserta el objeto de empresa actual en la base de datos
     * @return boolean
     */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa (enombre, edireccion) 
			VALUES ('".$this->get_enombre()."','".$this->get_edireccion()."')";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->set_idempresa($id);
			    $resp=  true;

			}else{
				$this->set_mensajeoperacion($base->getError());		
			}
		}else{
			$this->set_mensajeoperacion($base->getError());
		}
		return $resp;
	}
    /**
     * modifica la información de la empresa en la base de datos
     * @return boolean
     */
    public function modificar(){

    $resp = false;
    $base = new BaseDatos();
    $consultaModifica = "UPDATE empresa SET enombre='" . $this->get_enombre() . "', edireccion='" . $this->get_edireccion() . "' WHERE idempresa=" . $this->get_idempresa();

    if ($base->Iniciar()) {
        if ($base->Ejecutar($consultaModifica)) {
            $resp = true;
        } else {
            $this->set_mensajeoperacion($base->getError());
        }
    } else {
        $this->set_mensajeoperacion($base->getError());
    }
    return $resp;
}
    /**
     * elimina el registro de la empresa de la base de datos
     * @return boolean
     */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->get_idempresa();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->set_mensajeoperacion($base->getError());
					
				}
		}else{
				$this->set_mensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    /**
     * retorna una coleccion de viajes en una cadena
     * @return string
     */
    public function mostrarViajes(){
        $viajes=$this->get_colecViajes();
        $cadena="";
        for($i=0; $i<count($viajes);$i++){
            $cadena.="VIAJE N°". $i+1 ."\n".$viajes[$i]."\n \n";
        }
        return $cadena;
    }

    //========== TOSTRING ==========
    public function __toString()
    {
        return "ID: ".$this->get_idempresa()."\n". 
                "NOMBRE: ". $this->get_enombre()."\n". 
                "DIRECCION: ". $this->get_edireccion()."\n". 
                "========== VIAJES ==========\n ". $this->mostrarViajes();
    }

}