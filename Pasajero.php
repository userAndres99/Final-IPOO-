<?php

class Pasajero {
    //ATRIBUTOS
    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $objidviaje;
    private $mensajeoperacion;

    //CONSTRUCTOR
    public function __construct()
    {
        $this->pdocumento = '';
        $this->pnombre = '';
        $this->papellido = '';
        $this->ptelefono = '';
        $this->objidviaje = '';
        $this->mensajeoperacion = '' ;
    }

    //========== METODOS GET ==========
    /**
     * para obtener el documento del pasajero
     * @return int
     */
    public function get_pdocumento(){
        return $this->pdocumento;
    }
    /**
     * para obtener el nombre del pasajero
     * @return string
     */
    public function get_pnombre(){
        return $this->pnombre;
    }
    /**
     * para obtener el apellido del pasajero
     * @return string
     */
    public function get_papellido(){
        return $this->papellido;
    }
    /**
     * para obtener el numero de telefono del pasajero
     * @return int
     */
    public function get_ptelefono(){
        return $this->ptelefono;
    }
    /**
     * para obtener el viaje del pasajero
     * @return object
     */
    public function get_objidviaje(){
        return $this->objidviaje;
    }
    /**
     * para obtener el mensaje de operacion
     * @return string
     */
    public function get_mensajeoperacion(){
        return $this->mensajeoperacion;
    }

    //========== METODOS SET ==========
    /**
     * para enviar el numero de documento del pasajero
     * @param int
     */
    public function set_pdocumento($pdocumento){
        $this->pdocumento = $pdocumento;
    }
    /**
     * para enviar el nombre del pasajero
     * @param string
     */
    public function set_pnombre($pnombre){
        $this->pnombre = $pnombre;
    }
    /**
     * para enviar el apellido del pasajero
     * @param string
     */
    public function set_papellido($papellido){
        $this->papellido = $papellido;
    }
    /**
     * para enviar el numero de telefono del pasajero
     * @param int
     */
    public function set_ptelefono($ptelefono){
        $this->ptelefono = $ptelefono;
    }
    /**
     * para enviar el viaje del pasajero
     * @param object
     */
    public function set_objidviaje($objidviaje){
        $this->objidviaje = $objidviaje;
    }
    /**
     * para enviar el mensaje de operacion
     * @param string
     */
    public function set_mensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //========== METODOS EXTRA ==========
    /**
     * carga los valores del pasajero
     */
    public function cargar($pdocumento,$pnombre,$papellido,$ptelefono,$objidviaje){
        $this->set_pdocumento($pdocumento);
        $this->set_pnombre($pnombre);
        $this->set_papellido($papellido);
        $this->set_ptelefono($ptelefono);
        $this->set_objidviaje($objidviaje);
    }
    /**
	 * Recupera los datos de un pasajero por documento
	 * @param int 
	 * @return boolean  verdadero si encuentra los datos y false en caso contrario 
	 */		
    public function Buscar($pdocumento){
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero where pdocumento=".$pdocumento;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($row2=$base->Registro()){					
				    
                    $viaje=new viaje();
                    $viaje->Buscar($row2['idviaje']);
                    
                    
                    $this->cargar($row2['pdocumento'],$row2['pnombre'],$row2['papellido'],$row2['ptelefono'],$viaje);
                    
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
     * recupera una lista de pasajeros de la base de datos
     * @param string
     * @return array
     */
    public static function listar($condicion=""){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPasajero=$consultaPasajero.' where '.$condicion;
		}
		$consultaPasajero.=" order by pnombre ";
		//echo $consultaPasajero;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$arregloPasajero= array();
				while($row2=$base->Registro()){
					
					$pdocumento=$row2['pdocumento'];
					$pnombre=$row2['pnombre'];
					$papellido=$row2['papellido'];
					$ptelefono=$row2['ptelefono'];
                    $viaje=new Viaje();
                    $viaje->Buscar($row2['idviaje']);

					$pasajero=new Pasajero();
					$pasajero->cargar($pdocumento,$pnombre,$papellido,$ptelefono,$viaje);
					array_push($arregloPasajero,$pasajero);
	
				}
		 	}else{
		 		$this->set_mensajeoperacion($base->getError());
			}
		}else{
		 	$this->set_mensajeoperacion($base->getError());
		}	
		return $arregloPasajero;
	}
    /**
     * Inserta el objeto de pasajero actual en la base de datos
     * @return boolean
     */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje) 
			VALUES (".$this->get_pdocumento().",'".$this->get_pnombre()."','".$this->get_papellido()."','".$this->get_ptelefono()."','".$this->get_objidviaje()->get_idviaje()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

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
     * modifica la información del pasajero en la base de datos
     * @return boolean
     */
    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE pasajero SET pnombre='".$this->get_pnombre()."',papellido='".$this->get_papellido()."'
                           ,ptelefono='".$this->get_ptelefono()."',idviaje='".$this->get_objidviaje()."' WHERE nrodoc=". $this->get_pdocumento();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
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
     * elimina el registro del pasajero de la base de datos
     * @return boolean
     */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->get_pdocumento();
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

    //========== TOSTRING ==========
    public function __toString()
    {
        return "DNI: ". $this->get_pdocumento()."\n". 
                "NOMBRE: ". $this->get_pnombre()."\n". 
                "APELLIDO: ". $this->get_papellido()."\n". 
                "TELEFONO: ". $this->get_ptelefono()."\n". 
                "ID DEL VIAJE: ". $this->get_objidviaje()->get_idviaje()."\n";
    }
}