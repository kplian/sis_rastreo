<?php
/****************************************************************************************
*@package pXP
*@file gen-MODAsigVehiculo.php
*@author  (egutierrez)
*@date 03-07-2020 15:02:14
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 15:02:14    egutierrez             Creacion    
  #
*****************************************************************************************/

class MODAsigVehiculo extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarAsigVehiculo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_asig_vehiculo_sel';
        $this->transaccion='RAS_ASIGVEHI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
                
        //Definicion de la lista del resultado del query
		$this->captura('id_asig_vehiculo','int4');
        $this->captura('id_sol_vehiculo','int4');
		$this->captura('id_equipo','int4');
		$this->captura('observaciones','varchar');
		$this->captura('id_responsable','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('placa','varchar');
        $this->captura('desc_marca','varchar');
        $this->captura('desc_modelo','varchar');
        $this->captura('desc_tipo_equipo','varchar');
        $this->captura('desc_persona','varchar');
        $this->captura('km_inicio','numeric');
        $this->captura('km_final','numeric');
        $this->captura('recorrido','numeric');
        $this->captura('observacion_viaje','varchar');
        $this->captura('fecha_salida_ofi','date');
        $this->captura('hora_salida_ofi','time');
        $this->captura('fecha_retorno_ofi','date');
        $this->captura('hora_retorno_ofi','time');
        $this->captura('marca','varchar');
        $this->captura('modelo','varchar');
        $this->captura('id_proveedor','int4');
        $this->captura('id_tipo_equipo','int4');
        $this->captura('incidencia','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarAsigVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_ime';
        $this->transaccion='RAS_ASIGVEHI_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_equipo','id_equipo','int4');
        $this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('placa','placa','varchar');
        //$this->setParametro('marca','marca','varchar');
        $this->setParametro('id_proveedor','id_proveedor','int4');
        $this->setParametro('modelo','modelo','varchar');
        $this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
        $this->setParametro('id_marca','id_marca','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarAsigVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_ime';
        $this->transaccion='RAS_ASIGVEHI_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');
        $this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
		$this->setParametro('id_equipo','id_equipo','int4');
		$this->setParametro('observaciones','observaciones','varchar');
		$this->setParametro('id_responsable','id_responsable','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('placa','placa','varchar');
        //$this->setParametro('marca','marca','varchar');
        $this->setParametro('id_proveedor','id_proveedor','int4');
        $this->setParametro('modelo','modelo','varchar');
        $this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
        $this->setParametro('id_marca','id_marca','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarAsigVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_ime';
        $this->transaccion='RAS_ASIGVEHI_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function EditFormViaje(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_asig_vehiculo_ime';
        $this->transaccion='RAS_EDITFORVI_MOD';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_asig_vehiculo','id_asig_vehiculo','int4');
        $this->setParametro('km_inicio','km_inicio','numeric');
        $this->setParametro('km_final','km_final','numeric');
        $this->setParametro('recorrido','recorrido','numeric');
        $this->setParametro('observacion_viaje','observacion_viaje','varchar');
        $this->setParametro('fecha_retorno_ofi','fecha_retorno_ofi','date');
        $this->setParametro('fecha_salida_ofi','fecha_salida_ofi','date');
        $this->setParametro('hora_retorno_ofi','hora_retorno_ofi','time');
        $this->setParametro('hora_salida_ofi','hora_salida_ofi','time');
        $this->setParametro('incidencia','incidencia','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>