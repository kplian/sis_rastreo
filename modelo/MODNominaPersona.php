<?php
/****************************************************************************************
*@package pXP
*@file gen-MODNominaPersona.php
*@author  (egutierrez)
*@date 03-07-2020 14:58:25
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 14:58:25    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODNominaPersona extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarNominaPersona(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_nomina_persona_sel';
        $this->transaccion='RAS_NOMIPER_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_nomina_persona','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre','varchar');
		$this->captura('id_sol_vehiculo','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('id_funcionario','int4');
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarNominaPersona(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_nomina_persona_ime';
        $this->transaccion='RAS_NOMIPER_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarNominaPersona(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_nomina_persona_ime';
        $this->transaccion='RAS_NOMIPER_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_nomina_persona','id_nomina_persona','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarNominaPersona(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_nomina_persona_ime';
        $this->transaccion='RAS_NOMIPER_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_nomina_persona','id_nomina_persona','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>