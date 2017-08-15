<?php
/**
*@package pXP
*@file gen-MODEquipo.php
*@author  (admin)
*@date 15-06-2017 17:50:17
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEquipo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEquipo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_equipo_sel';
		$this->transaccion='RAS_EQUIP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo','int4');
		$this->captura('id_tipo_equipo','int4');
		$this->captura('id_modelo','int4');
		$this->captura('id_localizacion','int4');
		$this->captura('nro_motor','varchar');
		$this->captura('placa','varchar');
		$this->captura('estado','varchar');
		$this->captura('nro_movil','varchar');
		$this->captura('fecha_alta','date');
		$this->captura('cabina','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('propiedad','varchar');
		$this->captura('nro_chasis','varchar');
		$this->captura('cilindrada','numeric');
		$this->captura('color','varchar');
		$this->captura('pta','varchar');
		$this->captura('traccion','varchar');
		$this->captura('gestion','int4');
		$this->captura('fecha_baja','date');
		$this->captura('monto','numeric');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_tipo_equipo','varchar');
		$this->captura('desc_modelo','varchar');
		$this->captura('desc_marca','varchar');
		$this->captura('uniqueid','varchar');
		$this->captura('deviceid','integer');
		$this->captura('ultimo_envio','interval');
		$this->captura('latitude','float8');
		$this->captura('longitude','float8');
		$this->captura('speed','float8');
		$this->captura('attributes','varchar');
		$this->captura('address','varchar');
		//$this->captura('desc_type','varchar');
		$this->captura('desc_equipo','text');
		//$this->captura('responsable','text');
		//$this->captura('type','varchar');
		$this->captura('id_grupo','integer');
		$this->captura('desc_grupo','varchar');
		$this->captura('color_grupo','varchar');
		$this->captura('nro_celular','varchar');


		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarEquipo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_ime';
		$this->transaccion='RAS_EQUIP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
		$this->setParametro('id_modelo','id_modelo','int4');
		$this->setParametro('id_localizacion','id_localizacion','int4');
		$this->setParametro('nro_motor','nro_motor','varchar');
		$this->setParametro('placa','placa','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('nro_movil','nro_movil','varchar');
		$this->setParametro('fecha_alta','fecha_alta','date');
		$this->setParametro('cabina','cabina','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('propiedad','propiedad','varchar');
		$this->setParametro('nro_chasis','nro_chasis','varchar');
		$this->setParametro('cilindrada','cilindrada','numeric');
		$this->setParametro('color','color','varchar');
		$this->setParametro('pta','pta','varchar');
		$this->setParametro('traccion','traccion','varchar');
		$this->setParametro('gestion','gestion','int4');
		$this->setParametro('fecha_baja','fecha_baja','date');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('uniqueid','uniqueid','varchar');
		$this->setParametro('id_grupo','id_grupo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEquipo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_ime';
		$this->transaccion='RAS_EQUIP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
		$this->setParametro('id_modelo','id_modelo','int4');
		$this->setParametro('id_localizacion','id_localizacion','int4');
		$this->setParametro('nro_motor','nro_motor','varchar');
		$this->setParametro('placa','placa','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('nro_movil','nro_movil','varchar');
		$this->setParametro('fecha_alta','fecha_alta','date');
		$this->setParametro('cabina','cabina','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('propiedad','propiedad','varchar');
		$this->setParametro('nro_chasis','nro_chasis','varchar');
		$this->setParametro('cilindrada','cilindrada','numeric');
		$this->setParametro('color','color','varchar');
		$this->setParametro('pta','pta','varchar');
		$this->setParametro('traccion','traccion','varchar');
		$this->setParametro('gestion','gestion','int4');
		$this->setParametro('fecha_baja','fecha_baja','date');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('uniqueid','uniqueid','varchar');
		$this->setParametro('id_grupo','id_grupo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEquipo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ras.ft_equipo_ime';
		$this->transaccion='RAS_EQUIP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_equipo','id_equipo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarEquipoRapido(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ras.ft_equipo_sel';
		$this->transaccion='RAS_EQURAP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_equipo','int4');
		$this->captura('placa','varchar');
		$this->captura('nro_movil','varchar');
		$this->captura('marca','varchar');
		$this->captura('modelo','varchar');
		$this->captura('tipo_equipo','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>