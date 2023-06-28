<?php

class Viaje {
    //ATRIBUTOS
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objidempresa;
    private $objrnumeroempleado;
    private $vimporte;
    private $colecPasajeros;
    private $mensajeoperacion;

    //CONSTRUCTOR
    public function __construct() {
        $this->idviaje = '';
        $this->vdestino = '';
        $this->vcantmaxpasajeros = '';
        $this->objidempresa='';
        $this->objrnumeroempleado='';
        $this->vimporte = '';
        $this->colecPasajeros = [];
        $this->mensajeoperacion='';
    }

    //========== METODOS GET ==========
    /**
     * para obtener el id del viaje
     * @return int 
     */
    public function get_idviaje(){
        return $this->idviaje;
    }
    /**
     * para obtener el destino del viaje
     * @return string 
     */
    public function get_vdestino(){
        return $this->vdestino;
    }
    /**
     * para obtener la cantidad maxima de pasajeros del viaje
     * @return int
     */
    public function get_vcantmaxpasajeros(){
        return $this->vcantmaxpasajeros;
    }
    /**
     * para obtener a la empresa del viaje
     * @return object
     */
    public function get_objidempresa(){
        return $this->objidempresa;
    }
    /**
     * para obtener el responsable del viaje
     * @return object
     */
    public function get_objrnumeroempleado(){
        return $this->objrnumeroempleado;
    }
    /**
     * para obtener el importe del viaje
     * @return float
     */
    public function get_vimporte(){
        return $this->vimporte;
    }
    /**
     * para obtener la coleccion de pasajeros del viaje
     * @return array
     */
    public function get_colecPasajeros(){
        return $this->colecPasajeros;
    }
    /**
     * 
     */
    public function get_mensajeoperacion(){
        return $this->mensajeoperacion;
    }

    //========== METODOS SET ==========
    /**
     * para enviar el id del viaje
     * @param int
     */
    public function set_idviaje($idviaje){
        $this->idviaje = $idviaje;
    }
    /**
     * para enviar el destino del viaje
     * @param string
     */
    public function set_vdestino($vdestino){
        $this->vdestino = $vdestino;
    }
    /**
     * para enviar la cantidad maxima de pasajeros del viaje
     * @param int
     */
    public function set_vcantmaxpasajeros($vcantmaxpasajeros){
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }
    /**
     * para enviar la empresa del viaje
     * @param object
     */
    public function set_objidempresa($objidempresa){
        $this->objidempresa = $objidempresa;
    }
    /**
     * para enviar al responsable del viaje
     * @param object
     */
    public function set_objrnumeroempleado($objrnumeroempleado){
        $this->objrnumeroempleado = $objrnumeroempleado;
    }
    /**
     * para enviar el importe del viaje
     * @param float
     */
    public function set_vimporte($vimporte){
        $this->vimporte = $vimporte;
    }
    /**
     * para enviar a los pasajeros del viaje
     * @param array
     */
    public function set_colecPasajeros($colecPasajeros){
        $this->colecPasajeros = $colecPasajeros;
    }
    /**
     * 
     */
    public function set_mensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //========== METODOS EXTRA ==========
    /**
     * 
     */
    public function cargar ($idviaje,$vdestino,$vcantmaxpasajeros,$objidempresa,$objrnumeroempleado,$vimporte){
        $this->set_idviaje($idviaje);
        $this->set_vdestino($vdestino);
        $this->set_vcantmaxpasajeros($vcantmaxpasajeros);
        $this->set_objidempresa($objidempresa);
        $this->set_objrnumeroempleado($objrnumeroempleado);
        $this->set_vimporte($vimporte);
    }
    /**
	 * Recupera los datos de un viaje
	 * @param int 
	 * @return bolean 
	 */		
    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){					
				    
                    $empresa=new empresa();
                    $empresa->Buscar($row2['idempresa']);

                    $responsable=new ResponsableV();
                    $responsable->Buscar($row2['rnumeroempleado']);
                    
                    $this->cargar($row2['idviaje'],$row2['vdestino'],$row2['vcantmaxpasajeros'],$empresa,$responsable,$row2['vimporte']);

					$resp= true;
				}				
			
		 	}	else {
		 			$this->set_mensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->set_mensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}
    /**
     *  
     */
    public static function listar($condicion=""){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
					
					$idviaje=$row2['idviaje'];
					$vdestino=$row2['vdestino'];
					$vcantmaxpasajeros=$row2['vcantmaxpasajeros'];
                    $empresa=new Empresa();
                    $empresa->Buscar($row2['idempresa']);
					$responsable=new ResponsableV();
                    $responsable->Buscar($row2['rnumeroempleado']);
                    $vimporte=$row2['vimporte'];
				
					$viaje=new Viaje();
					$viaje->cargar($idviaje,$vdestino,$vcantmaxpasajeros,$empresa,$responsable,$vimporte);
					array_push($arregloViaje,$viaje);
                    
				}
				
			
		 	}else {
		 		$this->set_mensajeoperacion($base->getError());
		 		
			}
		 }else{
		 	$this->set_mensajeoperacion($base->getError());
		 	
		}	
		return $arregloViaje;
	}
    /**
     * Inserta el objeto de viaje actual en la base de datos
     * @return boolean
     */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
        $idempresa = $this->get_objidempresa()->get_idempresa();
        $rnumeroempleado=$this->get_objrnumeroempleado()->get_rnumeroempleado();
		$consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) 
			VALUES ('".$this->get_vdestino()."','".$this->get_vcantmaxpasajeros()."','".$idempresa."','".$rnumeroempleado."','".$this->get_vimporte()."')";
		
		if($base->Iniciar()){
            
            if($id = $base->devuelveIDInsercion($consultaInsertar)){ 
                $resp=  true;
                $this->set_idviaje($id);
			}else{
				$this->set_mensajeoperacion($base->getError());		
			}
		}else{
			$this->set_mensajeoperacion($base->getError());
		}
		return $resp;
	}
    /**
     * modifica la información del viaje en la base de datos
     * @return boolean
     */
    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->get_vdestino()."',vcantmaxpasajeros='".$this->get_vcantmaxpasajeros()."'
                           ,idempresa='".$this->get_objidempresa()->get_idempresa()."',rnumeroempleado='".$this->get_objrnumeroempleado()->get_rnumeroempleado()."',vimporte='".$this->get_vimporte()."' WHERE idviaje=". $this->get_idviaje();
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
     * elimina el registro del viaje de la base de datos
     * @return boolean
     */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->get_idviaje();
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
     * retorna una coleccion de pasajeros en una cadena
     * @return string
     */
    public function mostrarPasajeros(){
        $pasajeros=$this->get_colecPasajeros();
        $cadena="";
        for($i=0;$i<count($pasajeros);$i++){
            $cadena.="PASAJERO N°". $i+1 ."\n".$pasajeros[$i]."\n";
        }
        return $cadena;
    }
    
    //========== TOSTRING ==========
    public function __toString()
    {
        return "ID: ". $this->get_idviaje()."\n". 
                "DESTINO: ". $this->get_vdestino()."\n". 
                "CANTIDAD MAX PASAJEROS: ". $this->get_vcantmaxpasajeros()."\n". 
                "ID EMPRESA: ". $this->get_objidempresa()->get_idempresa()."\n". 
                "RESPONSABLE: N°". $this->get_objrnumeroempleado()->get_rnumeroempleado()."\n".
                "IMPORTE: ". $this->get_vimporte()."\n". 
                "========== PASAJEROS ==========\n". $this->mostrarPasajeros();
    }
    
}