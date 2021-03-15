<?php
/****************************************************************************************
*@package pXP
*@file gen-MODSolVehiculo.php
*@author  (egutierrez)
*@date 02-07-2020 22:13:48
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                02-07-2020 22:13:48    egutierrez             Creacion    
#GDV-29              29/12/2020            EGS                 Añadiendo campo deexiste conductores
 *****************************************************************************************/

class MODSolVehiculo extends MODbase{
    
    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }
            
    function listarSolVehiculo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_sol_vehiculo_sel';
        $this->transaccion='RAS_SOLVEHI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('estado','estado','varchar');
        $this->setParametro('nombreVista','nombreVista','varchar');
        $this->setParametro('tipo_reporte','tipo_reporte','varchar');

        //Definicion de la lista del resultado del query
		$this->captura('id_sol_vehiculo','int4');
		$this->captura('motivo','varchar');
		$this->captura('alquiler','varchar');
		$this->captura('ceco_clco','varchar');
		$this->captura('id_proceso_wf','int4');
		$this->captura('hora_salida','time');
		$this->captura('fecha_salida','date');
		$this->captura('nro_tramite','varchar');
		$this->captura('id_estado_wf','int4');
		$this->captura('hora_retorno','time');
		$this->captura('id_funcionario_jefe_depto','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('destino','varchar');
		$this->captura('fecha_sol','date');
		$this->captura('id_tipo_equipo','int4');
		$this->captura('fecha_retorno','date');
		$this->captura('id_funcionario','int4');
		$this->captura('observacion','varchar');
		$this->captura('estado','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
        $this->captura('usr_mod','varchar');
        $this->captura('desc_tipo_equipo','varchar');
        $this->captura('desc_funcionario','varchar');
        $this->captura('monto','numeric');
        $this->captura('id_centro_costo','int4');
        $this->captura('desc_centro_costo','varchar');
        $this->captura('existe_conductor','varchar');//#GDV-29
        $this->captura('telefono_contacto','varchar');//#GDV-37
        $this->captura('id_responsable','int4');//#GDV-37
        $this->captura('desc_reponsable','varchar');//#GDV-37

        if($this->objParam->getParametro('tipo_reporte')=='auto_PI' || $this->objParam->getParametro('tipo_reporte')=='auto_PII'){
            $this->captura('desc_jefe_dep','varchar');
            $this->captura('desc_gerente','varchar');
            $this->captura('desc_jefe_serv','varchar');
        }
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function insertarSolVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_ime';
        $this->transaccion='RAS_SOLVEHI_INS';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('motivo','motivo','varchar');
		$this->setParametro('alquiler','alquiler','varchar');
		$this->setParametro('ceco_clco','ceco_clco','varchar');
		$this->setParametro('id_proceso_wf','id_proceso_wf','int4');
		$this->setParametro('hora_salida','hora_salida','time');
		$this->setParametro('fecha_salida','fecha_salida','date');
		$this->setParametro('nro_tramite','nro_tramite','varchar');
		$this->setParametro('id_estado_wf','id_estado_wf','int4');
		$this->setParametro('hora_retorno','hora_retorno','time');
		$this->setParametro('id_funcionario_jefe_depto','id_funcionario_jefe_depto','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('destino','destino','varchar');
		$this->setParametro('fecha_sol','fecha_sol','date');
		$this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
		$this->setParametro('fecha_retorno','fecha_retorno','date');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('observacion','observacion','varchar');
		$this->setParametro('estado','estado','varchar');
        $this->setParametro('monto','monto','numeric');
        $this->setParametro('id_centro_costo','id_centro_costo','int4');
        $this->setParametro('existe_conductor','existe_conductor','varchar');//#GDV-29
        $this->setParametro('telefono_contacto','telefono_contacto','varchar');//#GDV-37
        $this->setParametro('id_responsable','id_responsable','int4');//#GDV-37

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function modificarSolVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_ime';
        $this->transaccion='RAS_SOLVEHI_MOD';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
		$this->setParametro('motivo','motivo','varchar');
		$this->setParametro('alquiler','alquiler','varchar');
		$this->setParametro('ceco_clco','ceco_clco','varchar');
		$this->setParametro('id_proceso_wf','id_proceso_wf','int4');
		$this->setParametro('hora_salida','hora_salida','time');
		$this->setParametro('fecha_salida','fecha_salida','date');
		$this->setParametro('nro_tramite','nro_tramite','varchar');
		$this->setParametro('id_estado_wf','id_estado_wf','int4');
		$this->setParametro('hora_retorno','hora_retorno','time');
		$this->setParametro('id_funcionario_jefe_depto','id_funcionario_jefe_depto','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('destino','destino','varchar');
		$this->setParametro('fecha_sol','fecha_sol','date');
		$this->setParametro('id_tipo_equipo','id_tipo_equipo','int4');
		$this->setParametro('fecha_retorno','fecha_retorno','date');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('observacion','observacion','varchar');
		$this->setParametro('estado','estado','varchar');
        $this->setParametro('monto','monto','numeric');
        $this->setParametro('id_centro_costo','id_centro_costo','int4');
        $this->setParametro('existe_conductor','existe_conductor','varchar');//#GDV-29
        $this->setParametro('telefono_contacto','telefono_contacto','varchar');//#GDV-37
        $this->setParametro('id_responsable','id_responsable','int4');//#GDV-37


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
    function eliminarSolVehiculo(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_ime';
        $this->transaccion='RAS_SOLVEHI_ELI';
        $this->tipo_procedimiento='IME';
                
        //Define los parametros para la funcion
		$this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function siguienteEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'ras.ft_sol_vehiculo_ime';
        $this->transaccion = 'RAS_SIGESOLVEH_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
        $this->setParametro('id_proceso_wf_act','id_proceso_wf_act','int4');
        $this->setParametro('id_estado_wf_act','id_estado_wf_act','int4');
        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');
        $this->setParametro('id_tipo_estado','id_tipo_estado','int4');
        $this->setParametro('id_funcionario_wf','id_funcionario_wf','int4');
        $this->setParametro('id_depto_wf','id_depto_wf','int4');
        $this->setParametro('obs','obs','text');
        $this->setParametro('json_procesos','json_procesos','text');

        $this->setParametro('id_depto_lb','id_depto_lb','int4');
        $this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
    function anteriorEstado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_ime';
        $this->transaccion='RAS_ANSOLVEH_IME';
        $this->tipo_procedimiento='IME';
        //Define los parametros para la funcion
        $this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
        $this->setParametro('id_proceso_wf','id_proceso_wf','int4');
        $this->setParametro('id_estado_wf','id_estado_wf','int4');
        $this->setParametro('obs','obs','varchar');
        $this->setParametro('estado_destino','estado_destino','varchar');
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function listarSolVehiculoKilometraje(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ras.ft_sol_vehiculo_sel';
        $this->transaccion='RAS_SOLVEHIKIL_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_funcionario_usu','id_funcionario_usu','int4');

        //Definicion de la lista del resultado del query
        $this->captura('id_sol_vehiculo','int4');
        $this->captura('nro_tramite','varchar');
        $this->captura('km_inicio','numeric');
        $this->captura('km_final','numeric');
        $this->captura('recorrido','numeric');
        $this->captura('desc_funcionario','varchar');
        $this->captura('destino','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function EditFormAlquilado(){
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='ras.ft_sol_vehiculo_ime';
        $this->transaccion='RAS_EDITFORAL_MOD';
        $this->tipo_procedimiento='IME';

        //Define los parametros para la funcion
        $this->setParametro('id_sol_vehiculo','id_sol_vehiculo','int4');
        $this->setParametro('alquiler','alquiler','varchar');
        $this->setParametro('monto','monto','numeric');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
            
}
?>