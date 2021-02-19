<?php
/****************************************************************************************
*@package pXP
*@file gen-MODElementoSeg.php
*@author  (egutierrez)
*@date 03-07-2020 15:00:54
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 15:00:54    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODElementoSeg extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarElementoSeg(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_elemento_seg_sel';
        $this->transaccion='RAS_ELEMSEG_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_elemento_seg','int4');
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
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarElementoSeg(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_ime';
        $this->transaccion='RAS_ELEMSEG_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarElementoSeg(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_ime';
        $this->transaccion='RAS_ELEMSEG_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_elemento_seg','id_elemento_seg','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarElementoSeg(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_ime';
        $this->transaccion='RAS_ELEMSEG_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_elemento_seg','id_elemento_seg','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>