<?php
/****************************************************************************************
*@package pXP
*@file gen-MODIncidencia.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:42
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:42    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODIncidencia extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarIncidencia(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_incidencia_sel';
        $this->transaccion='RAS_INCIDEN_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_incidencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('id_incidencia_fk','int4');
        $this->captura('desc_agrupador','varchar');

        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_incidencia_ime';
        $this->transaccion='RAS_INCIDEN_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
        $this->setParametro('id_incidencia_fk','id_incidencia_fk','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_incidencia_ime';
        $this->transaccion='RAS_INCIDEN_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_incidencia','id_incidencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
        $this->setParametro('id_incidencia_fk','id_incidencia_fk','int4');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarIncidencia(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_incidencia_ime';
        $this->transaccion='RAS_INCIDEN_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_incidencia','id_incidencia','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>