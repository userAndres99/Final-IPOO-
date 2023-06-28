<?php

class ResponsableV {
    //ATRIBUTOS
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeoperacion;

    //CONSTRUCTOR
    public function __construct()
    {
        $this->rnumeroempleado = '';
        $this->rnumerolicencia = '';
        $this->rnombre = '';
        $this->rapellido = '';
        $this->mensajeoperacion='';
    }

    //========== METODOS GET ==========
    /**
     * para obtener el numero de empleado del responsable
     * @return int
     */
    public function get_rnumeroempleado(){
        return $this->rnumeroempleado;
    }
    /**
     * para obtener el numero de licencia del responsable
     * @return int
     */
    public function get_rnumerolicencia(){
        return $this->rnumerolicencia;
    }
    /**
     * para obtener el nombre del responsable
     * @return string
     */
    public function get_rnombre(){
        return $this->rnombre;
    }
    /**
     * para obtener el apellido del responsable
     * @return string
     */
    public function get_rapellido(){
        return $this->rapellido;
    }
    /**
     * 
     */
    public function get_mensajeoperacion(){
        return $this->mensajeoperacion;
    }

    //========== METODOS SET ==========
    /**
     * para enviar el numero de empleado del responsable
     * @param int
     */
    public function set_rnumeroempleado($rnumeroempleado){
        $this->rnumeroempleado = $rnumeroempleado;
    }
    /**
     * para enviar el numero de licencia del responsable
     * @param int
     */
    public function set_rnumerolicencia($rnumerolicencia){
        $this->rnumerolicencia = $rnumerolicencia;
    }
    /**
     * para enviar el nombre del responsable
     * @param string
     */
    public function set_rnombre($rnombre){
        $this->rnombre = $rnombre;
    }
    /**
     * para enviar el apellido del responsable
     * @param string
     */
    public function set_rapellido($rapellido){
        $this->rapellido = $rapellido;
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
    public function cargar($rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido){
        $this->set_rnumeroempleado($rnumeroempleado);
        $this->set_rnumerolicencia($rnumerolicencia);
        $this->set_rnombre($rnombre);
        $this->set_rapellido($rapellido);
    }
    /**
	 * Recupera los datos de un responsable
	 * @param int 
	 * @return boolean  verdadero si encuentra los datos y false en caso contrario 
	 */		
    public function Buscar($rnumeroempleado){
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable where rnumeroempleado=".$rnumeroempleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($row2=$base->Registro()){					

                    $this->cargar($row2['rnumeroempleado'],$row2['rnumerolicencia'],$row2['rnombre'],$row2['rapellido']);
                     
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
     * recupera una lista de responsable de la base de datos
     * @param string
     * @return array
     */
    public static function listar($condicion=""){
	    $arregloResponsable = null;
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable ";
		if ($condicion!=""){
		    $consultaResponsable=$consultaResponsable.' where '.$condicion;
		}
        $consultaResponsable.=" order by rnombre ";
		//echo $consultaResponsable;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){				
				$arregloResponsable= array();
				while($row2=$base->Registro()){
					
					$rnumeroempleado=$row2['rnumeroempleado'];
					$rnumerolicencia=$row2['rnumerolicencia'];
					$rnombre=$row2['rnombre'];
					$rapellido=$row2['rapellido'];
    
					$responsable=new ResponsableV();
					$responsable->cargar($rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido);

					array_push($arregloResponsable,$responsable);
	
				}
		 	}else{
		 		$this->set_mensajeoperacion($base->getError());
			}
		}else{
		 	$this->set_mensajeoperacion($base->getError());
		}	
		return $arregloResponsable;
	}
    /**
     * Inserta el objeto de responsable actual en la base de datos
     * @return boolean
     */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
			VALUES ('".$this->get_rnumerolicencia()."','".$this->get_rnombre()."','".$this->get_rapellido()."')";
		
		if($base->Iniciar()){

			if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->set_rnumeroempleado($id);
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
     * modifica la información del responsable en la base de datos
     * @return boolean
     */
    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE responsable SET rnumerolicencia='".$this->get_rnumerolicencia()."',rnombre='".$this->get_rnombre()."'
                           ,rapellido='".$this->get_rapellido()."' WHERE rnumeroempleado=". $this->get_rnumeroempleado();
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
     * elimina el registro del responsable de la base de datos
     * @return boolean
     */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->get_rnumeroempleado();
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
        return "EMPLEADO: N°". $this->get_rnumeroempleado()."\n". 
                "NUMERO DE LICENCIA: ". $this->get_rnumerolicencia()."\n". 
                "NOMBRE: ". $this->get_rnombre()."\n".
                "APELLIDO: ". $this->get_rapellido()."\n";
    }
}