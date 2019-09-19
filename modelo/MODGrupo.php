<?php
/**
*@package pXP
*@file gen-MODGrupo.php
*@author  (admin)
*@date 24-07-2017 08:28:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODGrupo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarGrupo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_grupo_sel';
		$this->transaccion='RAS_GRUPO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_grupo','int4');
		$this->captura('codigo','varchar');
		$this->captura('nombre','varchar');
		$this->captura('color','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('usuario_ai','varchar');
        $this->captura('id_depto','int4'); //#6


		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarGrupo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_grupo_ime';
		$this->transaccion='RAS_GRUPO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('color','color','varchar');
        $this->setParametro('id_depto','id_depto','int4'); //#6

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarGrupo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_grupo_ime';
		$this->transaccion='RAS_GRUPO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_grupo','id_grupo','int4');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('color','color','varchar');
        $this->setParametro('id_depto','id_depto','int4'); //#6

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarGrupo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_grupo_ime';
		$this->transaccion='RAS_GRUPO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_grupo','id_grupo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>