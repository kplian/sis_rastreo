<?php
/****************************************************************************************
*@package pXP
*@file gen-MODElementoSegEquipo.php
*@author  (egutierrez)
*@date 03-07-2020 14:59:28
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 14:59:28    egutierrez             Creacion
  #GDV-28              28/08/2020            EGS                 Se Agregan campos de estado y observacion
*****************************************************************************************/

class MODElementoSegEquipo extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarElementoSegEquipo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_elemento_seg_equipo_sel';
        $this->transaccion='RAS_ELEMAV_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_elemento_seg_equipo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_elemento_seg','int4');
		$this->captura('id_equipo','int4');
		$this->captura('existe','bool');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('id_asig_vehiculo','int4');
        $this->captura('desc_elemento_seg','varchar');
        $this->captura('observacion','varchar');//#GDV-28
        $this->captura('estado_elemento','varchar');//#GDV-28
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarElementoSegEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_equipo_ime';
        $this->transaccion='RAS_ELEMAV_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_elemento_seg','id_elemento_seg','int4');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('existe','existe','bool');
        $this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');
        $this->setParametro('observacion','observacion','varchar');//#GDV-28
        $this->setParametro('estado_elemento','estado_elemento','varchar');//#GDV-28

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarElementoSegEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_equipo_ime';
        $this->transaccion='RAS_ELEMAV_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_elemento_seg_equipo','id_elemento_seg_equipo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_elemento_seg','id_elemento_seg','int4');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('existe','existe','bool');
        $this->setParametro('observacion','observacion','varchar');//#GDV-28
        $this->setParametro('estado_elemento','estado_elemento','varchar');//#GDV-28

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarElementoSegEquipo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_elemento_seg_equipo_ime';
        $this->transaccion='RAS_ELEMAV_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_elemento_seg_equipo','id_elemento_seg_equipo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>