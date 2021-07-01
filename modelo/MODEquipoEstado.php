<?php
/****************************************************************************************
*@package pXP
*@file gen-MODEquipoEstado.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:37
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:37    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODEquipoEstado extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarEquipoEstado(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_equipo_estado_sel';
        $this->transaccion='RAS_EQUIESTA_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_equipo_estado','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_equipo','int4');
		$this->captura('fecha_inicio','date');
		$this->captura('fecha_final','date');
		$this->captura('estado','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('nro_tramite','varchar');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarEquipoEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_equipo_estado_ime';
        $this->transaccion='RAS_EQUIESTA_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_final','fecha_final','date');
		$this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarEquipoEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_equipo_estado_ime';
        $this->transaccion='RAS_EQUIESTA_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo_estado','id_equipo_estado','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('fecha_final','fecha_final','date');
		$this->setParametro('estado','estado','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarEquipoEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_equipo_estado_ime';
        $this->transaccion='RAS_EQUIESTA_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo_estado','id_equipo_estado','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>