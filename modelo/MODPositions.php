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
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
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
			
}
?>