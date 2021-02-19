<?php
/**
*@package pXP
*@file gen-MODPositions.php
*@author  (admin)
*@date 15-06-2017 20:34:23
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPositions extends MODbase{

	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPositions(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_positions_sel';
		$this->transaccion='PB_POSIC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id','int4');
		$this->captura('address','varchar');
		$this->captura('devicetime','timestamp');
		$this->captura('accuracy','float8');
		$this->captura('course','float8');
		$this->captura('altitude','float8');
		$this->captura('protocol','varchar');
		$this->captura('speed','float8');
		$this->captura('network','varchar');
		$this->captura('servertime','timestamp');
		$this->captura('longitude','float8');
		$this->captura('valid','bool');
		$this->captura('deviceid','int4');
		$this->captura('attributes','varchar');
		$this->captura('latitude','float8');
		$this->captura('fixtime','timestamp');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPositions(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_positions_ime';
		$this->transaccion='PB_POSIC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('address','address','varchar');
		$this->setParametro('devicetime','devicetime','timestamp');
		$this->setParametro('accuracy','accuracy','float8');
		$this->setParametro('course','course','float8');
		$this->setParametro('altitude','altitude','float8');
		$this->setParametro('protocol','protocol','varchar');
		$this->setParametro('speed','speed','float8');
		$this->setParametro('network','network','varchar');
		$this->setParametro('servertime','servertime','timestamp');
		$this->setParametro('longitude','longitude','float8');
		$this->setParametro('valid','valid','bool');
		$this->setParametro('deviceid','deviceid','int4');
		$this->setParametro('attributes','attributes','varchar');
		$this->setParametro('latitude','latitude','float8');
		$this->setParametro('fixtime','fixtime','timestamp');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPositions(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_positions_ime';
		$this->transaccion='PB_POSIC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id','id','int4');
		$this->setParametro('address','address','varchar');
		$this->setParametro('devicetime','devicetime','timestamp');
		$this->setParametro('accuracy','accuracy','float8');
		$this->setParametro('course','course','float8');
		$this->setParametro('altitude','altitude','float8');
		$this->setParametro('protocol','protocol','varchar');
		$this->setParametro('speed','speed','float8');
		$this->setParametro('network','network','varchar');
		$this->setParametro('servertime','servertime','timestamp');
		$this->setParametro('longitude','longitude','float8');
		$this->setParametro('valid','valid','bool');
		$this->setParametro('deviceid','deviceid','int4');
		$this->setParametro('attributes','attributes','varchar');
		$this->setParametro('latitude','latitude','float8');
		$this->setParametro('fixtime','fixtime','timestamp');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPositions(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_positions_ime';
		$this->transaccion='PB_POSIC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id','id','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarUltimaPosicion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_positions_sel';
		$this->transaccion='PB_POSIC_ULT';
		$this->setCount(false);
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Define los parametros para la funcion
		$this->setParametro('ids','ids','varchar');
		$this->setParametro('contador','contador','integer');
		$this->setParametro('ids_grupo','ids_grupo','varchar');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo','integer');
		$this->captura('uniqueid','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('placa','varchar');
		//$this->captura('responsable','text');
		//$this->captura('ci','varchar');
		//$this->captura('celular1','varchar');
		//$this->captura('correo','varchar');
		$this->captura('latitude','float8');
		$this->captura('longitude','float8');
		$this->captura('altitude','float8');
		$this->captura('speed','float8');
		$this->captura('course','float8');
		$this->captura('address','varchar');
		$this->captura('attributes','varchar');
		$this->captura('accuracy','float8');
		$this->captura('desc_equipo','text');
		$this->captura('eventid','integer');
		$this->captura('type','varchar');
		$this->captura('attributes_event','varchar');
		$this->captura('desc_type','varchar');
		$this->captura('devicetime','timestamp');
		$this->captura('nro_movil','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPosicionesRango(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_positions_sel';
		$this->transaccion='PB_POSRAN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Define los parametros para la funcion
		$this->setParametro('ids','ids','varchar');
		$this->setParametro('fecha_ini','fecha_ini','varchar');
		$this->setParametro('fecha_fin','fecha_fin','varchar');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo','integer');
		$this->captura('uniqueid','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('placa','varchar');
		/*$this->captura('responsable','text');
		$this->captura('ci','varchar');
		$this->captura('celular1','varchar');
		$this->captura('correo','varchar');*/
		$this->captura('latitude','float8');
		$this->captura('longitude','float8');
		$this->captura('altitude','float8');
		$this->captura('speed','float8');
		$this->captura('course','float8');
		$this->captura('address','varchar');
		$this->captura('attributes','varchar');
		$this->captura('accuracy','float8');
		$this->captura('desc_equipo','text');
		$this->captura('eventid','integer');
		$this->captura('type','varchar');
		$this->captura('attributes_event','varchar');
		$this->captura('desc_type','varchar');
		$this->captura('distance','text');
		$this->captura('device','timestamp');
		$this->captura('desc_tipo_equipo','varchar');
		$this->captura('nro_movil','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPosicionesRangoProcesado(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_positions_sel';
		$this->transaccion='PB_PORAPRO_SEL';
		$this->setCount(false);
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Define los parametros para la funcion
		$this->setParametro('ids','ids','varchar');
		$this->setParametro('fecha_ini','fecha_ini','varchar');
		$this->setParametro('fecha_fin','fecha_fin','varchar');
				
		//Definicion de la lista del resultado del query
		$this->captura('id','integer');
		$this->captura('id_equipo','integer');
		$this->captura('uniqueid','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('placa','varchar');
		/*$this->captura('responsable','text');
		$this->captura('ci','varchar');
		$this->captura('celular1','varchar');
		$this->captura('correo','varchar');*/
		$this->captura('latitude','float8');
		$this->captura('longitude','float8');
		$this->captura('altitude','float8');
		$this->captura('speed','float8');
		$this->captura('course','float8');
		$this->captura('address','varchar');
		$this->captura('attributes','varchar');
		$this->captura('accuracy','float8');
		$this->captura('desc_equipo','text');
		$this->captura('eventid','integer');
		$this->captura('type','varchar');
		$this->captura('attributes_event','varchar');
		$this->captura('desc_type','varchar');
		$this->captura('send','boolean');
		$this->captura('distance','numeric');
		$this->captura('devicetime','timestamp');
		$this->captura('nro_movil','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarVelocidadesRango(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_positions_sel';
		$this->transaccion='PB_POSVEL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion

		//Define los parametros para la funcion
		$this->setParametro('ids','ids','varchar');
		$this->setParametro('fecha_ini','fecha_ini','varchar');
		$this->setParametro('fecha_fin','fecha_fin','varchar');
		$this->setParametro('velocidad_ini','velocidad_ini','integer');
		$this->setParametro('velocidad_fin','velocidad_fin','integer');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo','integer');
		$this->captura('uniqueid','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('placa','varchar');
		$this->captura('latitude','float8');
		$this->captura('longitude','float8');
		$this->captura('altitude','float8');
		$this->captura('speed','numeric');
		$this->captura('course','float8');
		$this->captura('address','varchar');
		$this->captura('attributes','varchar');
		$this->captura('accuracy','float8');
		$this->captura('desc_equipo','text');
		$this->captura('eventid','integer');
		$this->captura('type','varchar');
		$this->captura('attributes_event','varchar');
		$this->captura('desc_type','varchar');
		$this->captura('devicetime','timestamp');
		$this->captura('tipo_equipo','varchar');
		$this->captura('nro_movil','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}


    function listarDireccionesFaltantes(){

        $this->procedimiento='ras.ft_positions_sel';
        $this->transaccion='RAS_DIRFAL_SEL';
        $this->tipo_conexion='seguridad';
        $this->tipo_procedimiento='SEL';
        $this->count=false;

        $this->arreglo=array("id_usuario" =>1,"tipo"=>'TODOS');
        //Define los parametros para ejecucion de la funcion
        $this->setParametro('id_usuario','id_usuario','integer');
        $this->setParametro('tipo','tipo','varchar');


        $this->captura('id','integer');
        $this->captura('address','varchar');
        $this->captura('latitude','numeric');
        $this->captura('longitude','numeric');

        $this->armarConsulta();
        $this->ejecutarConsulta();

        return $this->respuesta;
    }
    function InsertarDireccionesFaltantes(){

        $this->procedimiento='ras.ft_positions_ime';
        $this->transaccion='RAS_INSDIR_INS';
        $this->tipo_conexion='seguridad';
        $this->tipo_procedimiento='IME';
        $this->count=false;

        $this->setParametro('id_position','id_position','int4');
        $this->setParametro('ubicacion','ubicacion','varchar');
        $this->arreglo=array("id_usuario" =>1,"tipo"=>'TODOS');
        //Define los parametros para ejecucion de la funcion
        $this->setParametro('id_usuario','id_usuario','int4');
        $this->setParametro('tipo','tipo','varchar');


        //$this->objParam->getParametro('ubicacion');
        $this->armarConsulta();
        $this->ejecutarConsulta();
       // var_dump($this->objParam->getParametro);
        return $this->respuesta;
    }
}
?>