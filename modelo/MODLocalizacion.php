<?php
/**
*@package pXP
*@file gen-MODLocalizacion.php
*@author  (admin)
*@date 15-06-2017 17:50:13
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODLocalizacion extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarLocalizacion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_localizacion_sel';
		$this->transaccion='RAS_LOCAL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_localizacion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre','varchar');
		$this->captura('codigo','varchar');
		$this->captura('latitud','float8');
		$this->captura('longitud','float8');
		$this->captura('id_localizacion_fk','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarLocalizacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_localizacion_ime';
		$this->transaccion='RAS_LOCAL_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('latitud','latitud','float8');
		$this->setParametro('longitud','longitud','float8');
		$this->setParametro('id_localizacion_fk','id_localizacion_fk','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarLocalizacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_localizacion_ime';
		$this->transaccion='RAS_LOCAL_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_localizacion','id_localizacion','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('latitud','latitud','float8');
		$this->setParametro('longitud','longitud','float8');
		$this->setParametro('id_localizacion_fk','id_localizacion_fk','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarLocalizacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_localizacion_ime';
		$this->transaccion='RAS_LOCAL_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_localizacion','id_localizacion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarLocalizacionArb(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_localizacion_sel';
		$this->setCount(false);
		$this->transaccion='RAS_LOCARB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_localizacion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre','varchar');
		$this->captura('codigo','varchar');
		$this->captura('latitud','float8');
		$this->captura('longitud','float8');
		$this->captura('id_localizacion_fk','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo_nodo','varchar');
		$this->captura('checked','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta;exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>