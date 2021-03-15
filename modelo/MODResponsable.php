<?php
/**
*@package pXP
*@file gen-MODResponsable.php
*@author  (admin)
*@date 15-06-2017 17:50:03
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODResponsable extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarResponsable(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_responsable_sel';
		$this->transaccion='RAS_CONDUC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_responsable','int4');
		$this->captura('id_persona','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_persona','text');
        $this->captura('codigo','varchar');//#GDV-35
        $this->captura('tipo_responsable','varchar');//#GDV-37

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_responsable_ime';
		$this->transaccion='RAS_CONDUC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
        $this->setParametro('tipo_responsable','tipo_responsable','varchar');//#GDV-37

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_responsable_ime';
		$this->transaccion='RAS_CONDUC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
        $this->setParametro('tipo_responsable','tipo_responsable','varchar');//#GDV-37

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarResponsable(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_responsable_ime';
		$this->transaccion='RAS_CONDUC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_responsable','id_responsable','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>