<?php
/****************************************************************************************
*@package pXP
*@file gen-MODAsigVehiculoIncidencia.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:29
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:29    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODAsigVehiculoIncidencia extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarAsigVehiculoIncidencia(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_asig_vehiculo_incidencia_sel';
        $this->transaccion='RAS_ASINCI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('groupBy','groupBy','varchar');
        $this->setParametro('groupDir','groupDir','varchar');
                
        //Definicion de la lista del resultado del query
		$this->captura('id_asig_vehiculo_incidedencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_asig_vehiculo','int4');
		$this->captura('id_incidencia','int4');
		$this->captura('observacion','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_incidencia','varchar');
        $this->captura('desc_incidencia_agrupador','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarAsigVehiculoIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_incidencia_ime';
        $this->transaccion='RAS_ASINCI_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');
		$this->setParametro('id_incidencia','id_incidencia','int4');
		$this->setParametro('observacion','observacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarAsigVehiculoIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_incidencia_ime';
        $this->transaccion='RAS_ASINCI_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_asig_vehiculo_incidedencia','id_asig_vehiculo_incidedencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');
		$this->setParametro('id_incidencia','id_incidencia','int4');
		$this->setParametro('observacion','observacion','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarAsigVehiculoIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_incidencia_ime';
        $this->transaccion='RAS_ASINCI_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_asig_vehiculo_incidedencia','id_asig_vehiculo_incidedencia','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>