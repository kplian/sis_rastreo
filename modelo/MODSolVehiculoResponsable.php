<?php
/****************************************************************************************
*@package pXP
*@file gen-MODSolVehiculoResponsable.php
*@author  (egutierrez)
*@date 12-03-2021 14:10:00
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-03-2021 14:10:00    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODSolVehiculoResponsable extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarSolVehiculoResponsable(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_sol_vehiculo_responsable_sel';
        $this->transaccion='RAS_SOLVERE_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_sol_vehiculo_responsable','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_sol_vehiculo','int4');
		$this->captura('id_responsable','int4');
		$this->captura('fecha_inicio','date');
		$this->captura('fecha_fin','date');
		$this->captura('solicitud','bool');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_responsable','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarSolVehiculoResponsable(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_responsable_ime';
        $this->transaccion='RAS_SOLVERE_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarSolVehiculoResponsable(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_responsable_ime';
        $this->transaccion='RAS_SOLVERE_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_sol_vehiculo_responsable','id_sol_vehiculo_responsable','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_fin','fecha_fin','date');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarSolVehiculoResponsable(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_responsable_ime';
        $this->transaccion='RAS_SOLVERE_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_sol_vehiculo_responsable','id_sol_vehiculo_responsable','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>