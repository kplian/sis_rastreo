<?php
/**
*@package pXP
*@file gen-MODDevices.php
*@author  (admin)
*@date 15-06-2017 20:34:33
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDevices extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarDevices(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_devices_sel';
		$this->transaccion='PB_DISP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id','int4');
		$this->captura('uniqueid','varchar');
		$this->captura('phone','varchar');
		$this->captura('groupid','int4');
		$this->captura('lastupdate','timestamp');
		$this->captura('model','varchar');
		$this->captura('attributes','varchar');
		$this->captura('contact','varchar');
		$this->captura('name','varchar');
		$this->captura('category','varchar');
		$this->captura('positionid','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDevices(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_devices_ime';
		$this->transaccion='PB_DISP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('uniqueid','uniqueid','varchar');
		$this->setParametro('phone','phone','varchar');
		$this->setParametro('groupid','groupid','int4');
		$this->setParametro('lastupdate','lastupdate','timestamp');
		$this->setParametro('model','model','varchar');
		$this->setParametro('attributes','attributes','varchar');
		$this->setParametro('contact','contact','varchar');
		$this->setParametro('name','name','varchar');
		$this->setParametro('category','category','varchar');
		$this->setParametro('positionid','positionid','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarDevices(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_devices_ime';
		$this->transaccion='PB_DISP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id','id','int4');
		$this->setParametro('uniqueid','uniqueid','varchar');
		$this->setParametro('phone','phone','varchar');
		$this->setParametro('groupid','groupid','int4');
		$this->setParametro('lastupdate','lastupdate','timestamp');
		$this->setParametro('model','model','varchar');
		$this->setParametro('attributes','attributes','varchar');
		$this->setParametro('contact','contact','varchar');
		$this->setParametro('name','name','varchar');
		$this->setParametro('category','category','varchar');
		$this->setParametro('positionid','positionid','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDevices(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_devices_ime';
		$this->transaccion='PB_DISP_ELI';
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