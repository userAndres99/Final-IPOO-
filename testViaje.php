<?php
include_once("BaseDatos.php");
include_once("Empresa.php");
include_once("ResponsableV.php");
include_once("Viaje.php");
include_once("Pasajero.php");

//=============== FUNCIONES DE AYUDA ===============
/**
 * (Dado dos numero uno el minimo y el otro el maximo le solicita al usuario que ingrese un numero dentro de ese rango)
 * @param int $min
 * @param int $max
 * @return int
 */

 function solicitarNumeroEntre($min, $max){
    //int $numero
    $numero = trim(fgets(STDIN));
    while (!is_int($numero) && !($numero >= $min && $numero <= $max)) {
        echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
    }
    return $numero;
}

/**
 * (Menu Principal)
 * @return int
 */
function menuPrincipal(){
    //int $opcionPrincipal

    echo "\n===== MENU PRINCIPAL ===== \n \n";
    
    echo "1-)ACCEDER A LA BASE DE DATOS \n \n";
    echo "2-)Ver lista de Empresas \n";
    echo "3-)ver detalles de una Empresa \n \n";
    echo "4-)Ver lista de Viajes \n";
    echo "5-)ver detalles de un Viaje \n \n";
    echo "6-)Ver lista de Responsables \n";
    echo "7-)ver detalles de un Responsable \n \n";
    echo "8-)Ver lista de Pasajeros \n";
    echo "9-)ver detalles Pasajero \n \n";
    echo "10-)Salir \n \n";
    echo "=====================================\n";
    
    $opcionPrincipal=solicitarNumeroEntre(1,10);
    return $opcionPrincipal;
}
/**
 * (Menu de la Base de Datos)
 * @return int
 */
function menuBaseDatos(){
    //int $opcion

    echo "\n===== BASE DE DATOS ===== \n \n";
    
   
    echo "1-)Insertar una Empresa \n";
    echo "2-)Modificar una Empresas \n";
    echo "3-)Eliminar una Empresa \n \n";
    
    echo "4-)Insertar un Viaje \n";
    echo "5-)Modificar un Viaje \n";
    echo "6-)Eliminar un Viaje \n \n";
    
    echo "7-)Insertar un Responsable \n";
    echo "8-)Modificar un Responsable \n";
    echo "9-)Eliminar un Responsable \n \n";

    echo "10-)Insertar un Pasajero \n";
    echo "11-)Modificar un Pasajero \n";
    echo "12-)Eliminar un Pasajero \n \n";

    echo "13-)Salir \n \n";
    echo "===============================\n";
    
    $opcion=solicitarNumeroEntre(1,13);
    return $opcion;
}

//==================== INICIO DEL TEST ==============================

/*
    int     $opcion,$cantMaxPasajeros,$rnumempleado,$rnumlicencia,$i,$a,$documento,telefono,$cantidadMaxAsientos,cantPasajeros,$asientosDisponibles
    string  $idempresa,$nombre,$direccion,$condicion,$idviaje,$destino,$apellido
    object  $empresa,$viaje,$responsable,$pasajero
    array   $colecViajes,$colecPasajeros,$colecEmpresas
    float   $importe
*/
$opcion=0;
$idempresa="";
$nombre="";
$direccion="";
$empresa=null;
$colecViajes=[];
$condicion="";
$colecPasajeros=[];
$idviaje="";
$viaje=null;
$destino="";
$cantMaxPasajeros=0;
$rnumempleado=0;
$responsable=null;
$importe=0;
$rnumlicencia=0;
$apellido="";
$pasajero=null;
$documento=0;
$telefono=0;
$i=0;
$a=0;
$cantidadMaxAsientos=0;
$cantPasajeros=0;
$asientosDisponibles=0;
$colecEmpresas=[];

do{
    $opcion=menuPrincipal();
    switch($opcion){
        case 1: //ACCEDER A LA BASE DE DATOS
            do{
                $opcion=menuBaseDatos();
                switch($opcion){
                    case 1: //INSERTAR EMPRESA
                        echo "\n Ingrese el nombre de la empresa: \n";
                        $nombre=trim(fgets(STDIN));

                        echo "\n Ingrese la direccion de la empresa: \n";
                        $direccion=trim(fgets(STDIN));

                        $empresa=new Empresa();
                        $empresa->cargar("",$nombre,$direccion);
                        if($empresa->insertar()){
                            echo "\n LA EMPRESA HA SIDO INSERTADA CON EXITO \n";
                        }else{
                            echo "\n ERROR AL TRATAR DE INSERTAR LA EMPRESA: \n".$empresa->get_mensajeoperacion();
                        }
                        

                    break;

                    case 2: //MODIFICAR EMPRESA
                        $colecEmpresas=Empresa::listar();
                    
                        for($i=0;$i<count($colecEmpresas);$i++){
                            echo "\n ID: ".$colecEmpresas[$i]->get_idempresa()."\n". 
                                " NOMBRE: ".$colecEmpresas[$i]->get_enombre()."\n \n";
                        }
                        echo "\n Ingrese el ID de la empresa que desea modificar \n";
                        $idempresa=trim(fgets(STDIN));

                        if(!is_numeric($idempresa)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $empresa=new Empresa();
                        if($empresa->Buscar($idempresa)){
                            echo "\n Ingrese el nombre nuevo: \n";
                            $nombre=trim(fgets(STDIN));

                            echo "\n Ingrese la direccion nueva: \n";
                            $direccion=trim(fgets(STDIN));

                            $empresa->cargar($idempresa,$nombre,$direccion);
                            if($empresa->modificar()){
                                echo "\n LA EMPRESA SE HA MODIFICADO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE MODIFICAR LA EMPRESA: \n". $empresa->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO LA EMPRESA QUE DESEA MODIFICAR \n";
                        }

                    break;

                    case 3: //ELIMINAR EMPRESA
                        $colecEmpresas=Empresa::listar();
                    
                        for($i=0;$i<count($colecEmpresas);$i++){
                            echo "\n ID: ".$colecEmpresas[$i]->get_idempresa()."\n". 
                                " NOMBRE: ".$colecEmpresas[$i]->get_enombre()."\n \n";
                        }
                        echo "\n (AL ELIMINAR UNA EMPRESA SE ELIMINARAN LOS VIAJES RELACIONADOS Y A SU VEZ TAMBIEN LOS PASAJEROS DE DICHOS VIAJES)\n";
                        echo " Ingrese el ID de la empresa que desea eliminar \n";
                        $idempresa=trim(fgets(STDIN));

                        if(!is_numeric($idempresa)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }
                        
                        $empresa=new Empresa();
                        if($empresa->Buscar($idempresa)){
                            //obtenemos la coleccion de viajes relacionadas con la empresa
                            $colecViajes=Viaje::listar($condicion="idempresa=$idempresa");
                            
                            //recorremos la coleccion de viajes
                            for($i=0;$i<count($colecViajes);$i++){
                                
                                //tomamos el id del viaje
                                $idviaje=$colecViajes[$i]->get_idviaje();
                                //obtenemos la coleccion de pasajeros relacionada con el viaje
                                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");

                                //recorremos la coleccion de pasajeros
                                for($a=0;$a<count($colecPasajeros);$a++){
                                    //eliminamos pasajero por pasajero
                                    $colecPasajeros[$a]->eliminar();
                                }
                                //eliminamos viaje por viaje
                                $colecViajes[$i]->eliminar();
                            }
                            //eliminamos la empresa
                            if($empresa->eliminar()){
                                echo "\n LA EMPRESA FUE ELIMINADA CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE ELIMINAR LA EMPRESA: \n". $empresa->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO LA EMPRESA QUE DESEA ELIMINAR \n";
                        }
                        
                    break;

                    //==================================================

                    case 4: //INSERTAR VIAJE
                        
                        echo "\n Ingrese el destino del viaje: \n";
                        $destino=trim(fgets(STDIN));

                        echo "\n Ingrese la cantidad maxima de pasajeros: \n";
                        $cantMaxPasajeros=trim(fgets(STDIN));

                        $colecEmpresas=Empresa::listar();
                    
                        for($i=0;$i<count($colecEmpresas);$i++){
                            echo "\n ID: ".$colecEmpresas[$i]->get_idempresa()."\n". 
                                " NOMBRE: ".$colecEmpresas[$i]->get_enombre()."\n \n";
                        }
                        echo "\n Ingrese el ID de la empresa: \n";
                        $idempresa=trim(fgets(STDIN));

                        $empresa=new Empresa();
                        if($empresa->Buscar($idempresa)){
                            echo "\n EMPRESA ENCONTRADA \n";
                        }else{
                            echo "\n EMPRESA NO ENCONTRADA \n";
                            break;
                        }

                        $colecResponsable=ResponsableV::listar();
                    
                        for($i=0;$i<count($colecResponsable);$i++){
                            echo "\n NUMERO DE EMPLEADO :".$colecResponsable[$i]->get_rnumeroempleado()."\n". 
                                " NOMBRE :".$colecResponsable[$i]->get_rnombre()."\n \n";
                        }
                        echo "\n Ingrese el numero de empleado del responsable \n";
                        $rnumempleado=trim(fgets(STDIN));

                        $responsable=new ResponsableV();
                        if($responsable->Buscar($rnumempleado)){
                            echo "\n RESPONSABLE ENCONTRADO \n";
                        }else{
                            echo "\n RESPONSABLE NO ENCONTRADO \n";
                            break;
                        }

                        echo "\n Ingrese el importe del viaje \n";
                        $importe=trim(fgets(STDIN));

                        $viaje=new Viaje();
                        $viaje->cargar("",$destino,$cantMaxPasajeros,$empresa,$responsable,$importe);
                        if($viaje->insertar()){
                            echo "\n EL VIAJE HA SIDO INSERTADO CON EXITO \n";
                        }else{
                            echo "\n ERROR AL TRATAR DE INSERTAR EL VIAJE: \n". $viaje->get_mensajeoperacion();
                        }
                        
                        
                    break;
                    
                    case 5: //MODIFICAR VIAJE
                        $colecViajes=Viaje::listar();
                    
                        for($i=0;$i<count($colecViajes);$i++){
                            echo "\n ID :".$colecViajes[$i]->get_idviaje()."\n". 
                                " DESTINO :".$colecViajes[$i]->get_vdestino()."\n \n";
                        }

                        echo "\n Ingrese el ID del viaje que desea modificar \n";
                        $idviaje=trim(fgets(STDIN));

                        if(!is_numeric($idviaje)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $viaje=new Viaje();
                        if($viaje->Buscar($idviaje)){
                            echo "\n Ingrese el nuevo destino \n";
                            $destino=trim(fgets(STDIN));

                            echo "\n Ingrese la nueva cantidad maxima de pasajeros \n";
                            $cantMaxPasajeros=trim(fgets(STDIN));

                            $colecEmpresas=Empresa::listar();
                    
                            for($i=0;$i<count($colecEmpresas);$i++){
                                echo "\n ID: ".$colecEmpresas[$i]->get_idempresa()."\n". 
                                    " NOMBRE: ".$colecEmpresas[$i]->get_enombre()."\n \n";
                            }
                            echo "\n Ingrese el nuevo ID de la empresa \n";
                            $idempresa=trim(fgets(STDIN));

                            $empresa=new Empresa();
                            if($empresa->Buscar($idempresa)){
                                echo "\n EMPRESA ENCONTRADA \n";
                            }else{
                                echo "\n EMPRESA NO ENCONTRADA \n";
                                break;
                            }

                            $colecResponsable=ResponsableV::listar();
                    
                            for($i=0;$i<count($colecResponsable);$i++){
                                echo "\n NUMERO DE EMPLEADO :".$colecResponsable[$i]->get_rnumeroempleado()."\n". 
                                    " NOMBRE :".$colecResponsable[$i]->get_rnombre()."\n \n";
                            }
                            echo "\n Ingrese el nuevo numero de empleado del responsable \n";
                            $rnumempleado=trim(fgets(STDIN));

                            $responsable=new ResponsableV();
                            if($responsable->Buscar($rnumempleado)){
                                echo "\n RESPONSABLE ENCONTRADO \n";
                            }else{
                                echo "\n RESPONSABLE NO ENCONTRADO \n";
                                break;
                            }
                            
                            echo "\n Ingrese el nuevo importe \n";
                            $importe=trim(fgets(STDIN));

                            $viaje->cargar($idviaje,$destino,$cantMaxPasajeros,$empresa,$responsable,$importe);
                            if($viaje->modificar()){
                                echo "\n EL VIAJE SE HA MODIFICADO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE MODFICAR EL VIAJE: \n". $viaje->get_mensajeoperacion();
                            }
                        }else{

                            echo "\n NO SE ENCONTRO EL VIAJE QUE DESEA MODIFICAR \n";
                            
                        }

                    break;

                    case 6: //ELIMINAR VIAJE

                        $colecViajes=Viaje::listar();
                    
                        for($i=0;$i<count($colecViajes);$i++){
                            echo "\n ID :".$colecViajes[$i]->get_idviaje()."\n". 
                                " DESTINO :".$colecViajes[$i]->get_vdestino()."\n \n";
                        }
                        echo "\n AL BORRAR UN VIAJE SE BORRARAN LOS PASAJEROS DE DICHO VIAJE \n";
                        echo " Ingrese el ID del viaje que desea eliminar \n";
                        $idviaje=trim(fgets(STDIN));

                        if(!is_numeric($idviaje)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $viaje=new Viaje();
                        if($viaje->Buscar($idviaje)){
                            
                            $colecPasajeros= Pasajero::listar($condicion="idviaje=$idviaje");
                            //recorre la coleccion de pasajeros relacionada a dicho viaje
                            for($i=0;$i < count($colecPasajeros);$i++){
                                //eliminamos pasajero por pasajero
                                $colecPasajeros[$i]->eliminar();
                            }
                            if($viaje->eliminar()){
                                echo "\n EL VIAJE FUE ELIMINADO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE ELIMINAR EL VIAJE: \n". $viaje->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO EL VIAJE QUE DESEA ELIMINAR \n";
                        }

                    break;

                    //==================================================

                    case 7: //INSERTAR RESPONSABLE
                        
                        echo "\n Ingrese el numero de licencia \n";
                        $rnumlicencia=trim(fgets(STDIN));

                        echo "\n Ingrese el nombre \n";
                        $nombre=trim(fgets(STDIN));

                        echo "\n Ingrese el apellido \n";
                        $apellido=trim(fgets(STDIN));

                        $responsable=new ResponsableV();
                        $responsable->cargar("",$rnumlicencia,$nombre,$apellido);
                        if($responsable->insertar()){
                            echo "\n EL RESPONSABLE SE INSERTO CON EXITO \n";
                        }else{
                            echo "\n ERROR AL TRATAR DE INSERTAR EL RESPONSABLE \n". $responsable->get_mensajeoperacion();
                        }
                        

                    break;

                    case 8: //MODIFICAR RESPONSABLE
                        $colecResponsable=ResponsableV::listar();
                    
                        for($i=0;$i<count($colecResponsable);$i++){
                            echo "\n NUMERO DE EMPLEADO :".$colecResponsable[$i]->get_rnumeroempleado()."\n". 
                                " NOMBRE :".$colecResponsable[$i]->get_rnombre()."\n \n";
                        }
                        echo "\n Ingrese el numero de empleado del responsable que desea modificar \n";
                        $rnumempleado=trim(fgets(STDIN));

                        if(!is_numeric($rnumempleado)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $responsable=new ResponsableV();
                        if($responsable->Buscar($rnumempleado)){
                            echo "\n Ingrese el nuevo numero de licencia \n";
                            $rnumlicencia=trim(fgets(STDIN));

                            echo "\n Ingrese el nuevo nombre \n";
                            $nombre=trim(fgets(STDIN));

                            echo "\n Ingrese el nuevo apellido \n";
                            $apellido=trim(fgets(STDIN));

                            $responsable->cargar($rnumempleado,$rnumlicencia,$nombre,$apellido);
                            if($responsable->modificar()){
                                echo "\n EL RESPONSABLE SE MODIFICO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE MODIFICAR EL RESPONSABLE \n". $responsable->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO AL RESPONSABLE QUE DESEA MODIFICAR \n";
                        }
                        
                    break;

                    case 9: //ELIMINAR RESPONSABLE
                        $colecResponsable=ResponsableV::listar();
                    
                        for($i=0;$i<count($colecResponsable);$i++){
                            echo "\n NUMERO DE EMPLEADO :".$colecResponsable[$i]->get_rnumeroempleado()."\n". 
                                " NOMBRE :".$colecResponsable[$i]->get_rnombre()."\n \n";
                        }
                        echo "\n AL ELIMINAR UN RESPONSABLE SE ELIMINARA EL VIAJE AL QUE ESTABA ASIGNADO AL IGUAL QUE LOS PASAJEROS DE DICHO VIAJE \n";
                        echo " Ingrese el numero de empleado del responsable que desea eliminar \n";
                        $rnumempleado=trim(fgets(STDIN));

                        if(!is_numeric($rnumempleado)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $responsable=new ResponsableV();
                        if($responsable->Buscar($rnumempleado)){
                            
                            //obtenemos la coleccion de viajes relacionada con el responsable
                            $colecViajes=Viaje::listar($condicion="rnumeroempleado=$rnumempleado");

                            //recorremos la coleccion de viajes
                            for($i=0;$i<count($colecViajes);$i++){
                                
                                //tomamos el id del viaje
                                $idviaje=$colecViajes[$i]->get_idviaje();
                                //obtenemos la coleccion de pasajeros relacionada con el viaje
                                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");

                                //recorremos la coleccion de pasajeros
                                for($a=0;$a<count($colecPasajeros);$a++){
                                    //eliminamos pasajero por pasajero
                                    $colecPasajeros[$a]->eliminar();
                                }
                                //eliminamos viaje por viaje
                                $colecViajes[$i]->eliminar();
                            }
                            if($responsable->eliminar()){
                                echo "\n EL RESPONSABLE SE ELIMINO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE ELIMINAR AL RESPONSABLE \n". $responsable->get_mensajeoperacion();
                            }
                    
                        }else{
                            echo "\n NO SE ENCONTRO AL RESPONSABLE QUE DESEA ELIMINAR \n";
                        }
                    break;

                    //==================================================

                    case 10: //INSERTAR PASAJERO
                        echo "\n Ingrese el documento del pasajero \n";
                        $documento=trim(fgets(STDIN));

                        if(!is_numeric($documento)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $pasajero=new Pasajero();
                        if($pasajero->Buscar($documento)){
                            echo "\n EL PASAJERO QUE DESEA INSERTAR YA EXISTE \n";
                        }else{
                            echo "\n Ingrese el nombre del pasajero \n";
                            $nombre=trim(fgets(STDIN));

                            echo "\n Ingrese el apellido del pasajero \n";
                            $apellido=trim(fgets(STDIN));

                            echo "\n Ingrese el telefono del pasajero \n";
                            $telefono=trim(fgets(STDIN));

                            $colecViajes=Viaje::listar();
                    
                            for($i=0;$i<count($colecViajes);$i++){
                                echo "\n ID :".$colecViajes[$i]->get_idviaje()."\n". 
                                    " DESTINO :".$colecViajes[$i]->get_vdestino()."\n \n";
                            }
                            echo "\n Ingrese el ID del viaje \n";
                            $idviaje=trim(fgets(STDIN));

                            $viaje=new Viaje();
                            if($viaje->Buscar($idviaje)){
                                //obtengo la cantidad max de asientos del viaje
                                $cantidadMaxAsientos=$viaje->get_vcantmaxpasajeros();

                                //obtengo a todos los pasajeros del viaje
                                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");
                                $cantPasajeros=count($colecPasajeros);

                                //obtengo la cantidad de asientos disponibles
                                $asientosDisponibles=$cantidadMaxAsientos - $cantPasajeros;

                                if($asientosDisponibles > 0){
                                    echo "\n VIAJE ENCONTRADO \n";
                                    echo " QUEDA UN TOTAL DE ". $asientosDisponibles-1 ." ASIENTO DISPONIBLES \n";
                                }else{
                                    echo "\n NO QUEDAN LUGARES DISPONIBLES \n";
                                    break;
                                }

                            }else{
                                echo "\n VIAJE NO ENCONTRADO \n";
                                break;
                            }

                            $pasajero->cargar($documento,$nombre,$apellido,$telefono,$viaje);
                            if($pasajero->insertar()){
                                echo "\n EL PASAJERO SE INSERTO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE INSERTAR AL PASAJERO \n". $pasajero->get_mensajeoperacion();
                            }
                        }
                    break;

                    case 11: //MODIFICAR PASAJERO
                        $colecPasajeros=Pasajero::listar();
                    
                        for($i=0;$i<count($colecPasajeros);$i++){
                            echo "\n DOCUMENTO :".$colecPasajeros[$i]->get_pdocumento()."\n". 
                            " NOMBRE :".$colecPasajeros[$i]->get_pnombre()."\n \n";
                        }
                        echo "\n Ingrese el documento del pasajero que desea modificar \n";
                        $documento=trim(fgets(STDIN));

                        if(!is_numeric($documento)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $pasajero=new Pasajero();
                        if($pasajero->Buscar($documento)){
                            echo "\n Ingrese el nuevo nombre del pasajero \n";
                            $nombre=trim(fgets(STDIN));

                            echo "\n Ingrese el nuevo apellido del pasajero \n";
                            $apellido=trim(fgets(STDIN));

                            echo "\n Ingrese el nuevo telefono del pasajero \n";
                            $telefono=trim(fgets(STDIN));

                            $colecViajes=Viaje::listar();
                    
                            for($i=0;$i<count($colecViajes);$i++){
                                echo "\n ID :".$colecViajes[$i]->get_idviaje()."\n". 
                                    " DESTINO :".$colecViajes[$i]->get_vdestino()."\n \n";
                            }
                            echo "\n Ingrese el nuevo ID del viaje \n";
                            $idviaje=trim(fgets(STDIN));

                            $viaje=new Viaje();
                            if($viaje->Buscar($idviaje)){
                                $cantidadMaxAsientos=$viaje->get_vcantmaxpasajeros();

                                //obtengo a todos los pasajeros del viaje
                                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");
                                $cantPasajeros=count($colecPasajeros);

                                //obtengo la cantidad de asientos disponibles
                                $asientosDisponibles=$cantidadMaxAsientos - $cantPasajeros;

                                if($asientosDisponibles > 0){
                                    echo "\n VIAJE ENCONTRADO \n";
                                    echo " QUEDA UN TOTAL DE ". $asientosDisponibles-1 ." ASIENTO DISPONIBLES \n";
                                }else{
                                    echo "\n NO QUEDAN LUGARES DISPONIBLES \n";
                                    break;
                                }
                                
                            }else{
                                echo "\n VIAJE NO ENCONTRADO \n";
                                break;
                            }
                            $pasajero->cargar($documento,$nombre,$apellido,$telefono,$viaje);
                            if($pasajero->modificar()){
                                echo "\n EL PASAJERO SE MODIFICO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE MODIFICAR AL PASAJERO \n". $pasajero->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO AL PASAJERO QUE DESEA MODIFICAR \n";
                        }
                    break;

                    case 12: //ELIMINAR PASAJERO
                        $colecPasajeros=Pasajero::listar();
                    
                        for($i=0;$i<count($colecPasajeros);$i++){
                            echo "\n DOCUMENTO :".$colecPasajeros[$i]->get_pdocumento()."\n". 
                                " NOMBRE :".$colecPasajeros[$i]->get_pnombre()."\n \n";
                        }
                        echo "\n Ingrese el numero de documento del pasajero que desea eliminar \n";
                        $documento=trim(fgets(STDIN));

                        if(!is_numeric($documento)){
                            echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                            break;
                        }

                        $pasajero=new Pasajero();
                        if($pasajero->Buscar($documento)){
                            if($pasajero->eliminar()){
                                echo "\n EL PASAJERO SE ELIMINO CON EXITO \n";
                            }else{
                                echo "\n ERROR AL TRATAR DE ELIMINAR AL PASAJERO \n". $pasajero->get_mensajeoperacion();
                            }
                        }else{
                            echo "\n NO SE ENCONTRO AL PASAJERO QUE DESEA ELIMINAR \n";
                        }
                    break;
                }
            }while($opcion != 13);

        break;

        //====================================================================================================

        case 2: // VER LISTA DE EMPRESAS
            //obtengo la coleccion de empresas
            $colecEmpresas=Empresa::listar();

            //recorro la coleccion de empresas
            for($i=0;$i<count($colecEmpresas); $i++){
                //obtengo el id de la empresa
                $idempresa=$colecEmpresas[$i]->get_idempresa();
                
                //obtengo la coleccion de viajes de la empresa
                $colecViajes=Viaje::listar($condicion="idempresa=$idempresa");

                //recorro la coleccion de viajes de la empresa
                for($a=0;$a<count($colecViajes); $a++){
                    //obtengo el id del viaje
                    $idviaje=$colecViajes[$a]->get_idviaje();
                    
                    //obtengo la coleccion de pasajeros del viaje
                    $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");

                    //envio la coleccion de pasajeros al viaje
                    $colecViajes[$a]->set_colecPasajeros($colecPasajeros);
                }
                //envio la coleccion de viajes a la empresa
                $colecEmpresas[$i]->set_colecViajes($colecViajes);

                echo "\n*************** EMPRESA N°". $i+1 ." *************** \n".$colecEmpresas[$i];
            }

        break;
        
        //====================================================================================================

        case 3: // BUSCAR EMPRESA
            $colecEmpresas=Empresa::listar();
                    
            for($i=0;$i<count($colecEmpresas);$i++){
                echo "\n ID :".$colecEmpresas[$i]->get_idempresa()."\n". 
                    " NOMBRE :".$colecEmpresas[$i]->get_enombre()."\n \n";
            }
            echo "\n Ingrese el ID de la empresa \n";
            $idempresa=trim(fgets(STDIN));

            if(!is_numeric($idempresa)){
                echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                break;
            }

            $empresa=new Empresa();
            if($empresa->Buscar($idempresa)){
                $colecViajes=Viaje::listar($condicion="idempresa=$idempresa");
                for($i=0;$i<count($colecViajes);$i++){
                    $idviaje=$colecViajes[$i]->get_idviaje();
                    $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");
                    $colecViajes[$i]->set_colecPasajeros($colecPasajeros);
                }
                $empresa->set_colecViajes($colecViajes);
                echo "********** EMPRESA **********\n".$empresa;
            }else{
                echo "\n EMPRESA NO ENCONTRADA \n";
            }
        break;

        //====================================================================================================

        case 4: //VER LISTA DE VIAJES
            $colecViajes=Viaje::listar();
            for($i=0;$i<count($colecViajes);$i++){
                $idviaje=$colecViajes[$i]->get_idviaje();
                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");
                $colecViajes[$i]->set_colecPasajeros($colecPasajeros);

                echo "\n*************** VIAJE N°". $i+1 ." ***************\n".$colecViajes[$i];
            }

        break;

        //====================================================================================================

        case 5: //BUSCAR VIAJE
            $colecViajes=Viaje::listar();
                    
            for($i=0;$i<count($colecViajes);$i++){
                echo "\n ID :".$colecViajes[$i]->get_idviaje()."\n". 
                    " DESTINO :".$colecViajes[$i]->get_vdestino()."\n \n";
            }
            echo "\n Ingrese el ID del viaje \n";
            $idviaje=trim(fgets(STDIN));

            if(!is_numeric($idviaje)){
                echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                break;
            }

            $viaje=new Viaje();
            if($viaje->Buscar($idviaje)){
                $colecPasajeros=Pasajero::listar($condicion="idviaje=$idviaje");
                $viaje->set_colecPasajeros($colecPasajeros);
                
                echo "********** VIAJE **********\n".$viaje;
            }else{
                echo "\n VIAJE NO ENCONTRADO \n";
            }
        break;

        //====================================================================================================

        case 6: //VER LISTA DE RESPONSABLES
            $colecResponsable=ResponsableV::listar();
            for($i=0;$i<count($colecResponsable);$i++){
                echo "\n*************** RESPONSABLE N°". $i+1 ." ***************\n".$colecResponsable[$i];
            }
        break;

        //====================================================================================================

        case 7: //BUSCAR RESPONSABLE
            $colecResponsable=ResponsableV::listar();
                    
            for($i=0;$i<count($colecResponsable);$i++){
                echo "\n NUMERO DE EMPLEADO :".$colecResponsable[$i]->get_rnumeroempleado()."\n". 
                    " NOMBRE :".$colecResponsable[$i]->get_rnombre()."\n \n";
            }
            echo "\n Ingrese el numero de empleado del responsable \n";
            $rnumempleado=trim(fgets(STDIN));

            if(!is_numeric($rnumempleado)){
                echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                break;
            }

            $responsable=new ResponsableV();
            if($responsable->Buscar($rnumempleado)){
                echo "********** RESPONSABLE **********\n".$responsable;
            }else{
                echo "\n NO SE ENCONTRO EL RESPONSABLE \n";
            }
        break;

        //====================================================================================================

        case 8: //VER LISTA DE PASAJEROS
            $colecPasajeros=Pasajero::listar();
            for($i=0;$i<count($colecPasajeros);$i++){
                echo "\n*************** PASAJERO N°". $i+1 ." ***************\n".$colecPasajeros[$i];
            }
        break;

        //====================================================================================================

        case 9: //BUSCAR PASAJERO
            $colecPasajeros=Pasajero::listar();
                    
            for($i=0;$i<count($colecPasajeros);$i++){
                echo "\n DOCUMENTO :".$colecPasajeros[$i]->get_pdocumento()."\n". 
                    " NOMBRE :".$colecPasajeros[$i]->get_pnombre()."\n \n";
            }
            echo "\n Ingrese el documento del pasajero \n";
            $documento=trim(fgets(STDIN));

            if(!is_numeric($documento)){
                echo "\n DEBE INGRESAR NUMEROS VALIDOS \n";
                break;
            }
            
            $pasajero=new Pasajero();
            if($pasajero->Buscar($documento)){
                echo "********** PASAJERO **********\n".$pasajero;
            }else{
                "\n NO SE ENCONTRO EL PASAJERO \n";
            }
        break;
    }

}while($opcion!= 10);
?>                