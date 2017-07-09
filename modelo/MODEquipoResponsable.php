<?php
/**
*@package pXP
*@file gen-MODEquipoResponsable.php
*@author  (admin)
*@date 15-06-2017 17:50:22
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEquipoResponsable extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_equipo_responsable_sel';
		$this->transaccion='RAS_EQUCON_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo_responsable','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_responsable','int4');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_ini','date');
		$this->captura('id_equipo','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_responsable','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_responsable_ime';
		$this->transaccion='RAS_EQUCON_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_ini','fecha_ini','date');
		$this->setParametro('id_equipo','id_equipo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_responsable_ime';
		$this->transaccion='RAS_EQUCON_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_ini','fecha_ini','date');
		$this->setParametro('id_equipo','id_equipo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEquipoResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_responsable_ime';
		$this->transaccion='RAS_EQUCON_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo_responsable','id_equipo_responsable','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>