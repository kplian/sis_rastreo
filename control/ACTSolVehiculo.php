<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTSolVehiculo.php
*@author  (egutierrez)
*@date 02-07-2020 22:13:48
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                02-07-2020 22:13:48    egutierrez             Creacion
  #GDV-36        02/03/2021      EGS                     Se agrega tab para filtro de estado
  #RAS-8            21/05/2021             JJA          Reporte de conductores asignados
#
*****************************************************************************************/
require_once(dirname(__FILE__).'/../../pxp/pxpReport/DataSource.php');
require_once dirname(__FILE__).'/../../pxp/lib/lib_reporte/ReportePDFFormulario.php';
require_once(dirname(__FILE__).'/../reportes/RAutoPI.php');
require_once(dirname(__FILE__).'/../reportes/RAutoPII.php');
require_once(dirname(__FILE__).'/../reportes/RAutoPIII.php');
class ACTSolVehiculo extends ACTbase{    
            
    function listarSolVehiculo(){
		$this->objParam->defecto('ordenacion','id_sol_vehiculo');
        $this->objParam->addParametro('id_funcionario_usu',$_SESSION["ss_id_funcionario"]);

        if ($this->objParam->getParametro('nombreVista') == 'SolVehiculoVoBo') {
            $this->objParam->addFiltro("solvehi.estado in (''vobojefedep'',''vobogerente'',''vobojefeserv'')");
        }
        if ($this->objParam->getParametro('nombreVista') == 'SolVehiculoAsig') { //#GDV-36
            $this->objParam->addFiltro("solvehi.estado = ''".$this->objParam->getParametro('estado')."''");
        }
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODSolVehiculo','listarSolVehiculo');
        } else{
        	$this->objFunc=$this->create('MODSolVehiculo');
            
        	$this->res=$this->objFunc->listarSolVehiculo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarSolVehiculo(){
        $this->objFunc=$this->create('MODSolVehiculo');    
        if($this->objParam->insertar('id_sol_vehiculo')){
            $this->res=$this->objFunc->insertarSolVehiculo($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarSolVehiculo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarSolVehiculo(){
        	$this->objFunc=$this->create('MODSolVehiculo');    
        $this->res=$this->objFunc->eliminarSolVehiculo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function siguienteEstado(){
        $this->objFunc=$this->create('MODSolVehiculo');
        $this->res=$this->objFunc->siguienteEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function anteriorEstado(){
        $this->objFunc=$this->create('MODSolVehiculo');
        $this->res=$this->objFunc->anteriorEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteAutorizacion(){
        $this->objParam->defecto('ordenacion','id_sol_vehiculo');

        $this->objParam->defecto('dir_ordenacion','asc');
        $this->objParam->defecto('cantidad',1000000000);
        $this->objParam->defecto('puntero', 0);
        $this->objParam->addParametro('nombreVista','');

        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("solvehi.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }

        $this->objFunc=$this->create('MODSolVehiculo');
        $dataSourceSolVehiculo = $this->objFunc->listarSolVehiculo($this->objParam);

        $this->objParam->parametros_consulta['filtro'] = '0 = 0';

        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("nomiper.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }
        $this->objFunc=$this->create('MODNominaPersona');
        $dataSourceNominaPersona = $this->objFunc->listarNominaPersona($this->objParam);

        $this->objParam->parametros_consulta['filtro'] = '0 = 0';

        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("asigvehi.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }

        $this->objFunc=$this->create('MODAsigVehiculo');
        $dataSourceAsigVehiculo = $this->objFunc->listarAsigVehiculo($this->objParam);

        $this->objParam->parametros_consulta['filtro'] = '0 = 0';

        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("asig.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }

        $this->objFunc=$this->create('MODElementoSegEquipo');
        $dataSourceElementSegEqui = $this->objFunc->listarElementoSegEquipo($this->objParam);
        $this->objParam->addParametro('groupBy','desc_incidencia_agrupador');
        $this->objParam->addParametro('groupDir','asc');
        $this->objFunc=$this->create('MODAsigVehiculoIncidencia');
        $dataSourceAsigIncidencia = $this->objFunc->listarAsigVehiculoIncidencia($this->objParam);


        //var_dump('sol',$dataSourceAsigIncidencia);exit;
        if($this->objParam->getParametro('tipo_reporte')=='auto_PI'){

            $nombreArchivo = uniqid(md5(session_id()).'-SolVehiculo') . '.pdf';
            $tamano = 'LETTER';
            $orientacion = 'P';
            $this->objParam->addParametro('orientacion',$orientacion);
            $this->objParam->addParametro('tamano',$tamano);
            $this->objParam->addParametro('titulo_archivo',$titulo);
            $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
            $this->objParam->addParametro('datos_sol_vehiculo',$dataSourceSolVehiculo->getDatos());
            $this->objParam->addParametro('datos_nomina_persona',$dataSourceNominaPersona->getDatos());
            $this->objParam->addParametro('datos_asig_vehiculo',$dataSourceAsigVehiculo->getDatos());
            $this->objParam->addParametro('datos_elemento_seg_equipo',$dataSourceElementSegEqui->getDatos());

            $reporte = new RAutoPI($this->objParam);

            $reporte->datosHeader($this->objParam);
            $reporte->generarReporte1($this->objParam);
            $reporte->output($reporte->url_archivo,'F');

            $this->mensajeExito=new Mensaje();
            $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
            $this->mensajeExito->setArchivoGenerado($nombreArchivo);
            $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

        }
        if($this->objParam->getParametro('tipo_reporte')=='auto_PII'){

            $nombreArchivo = uniqid(md5(session_id()).'-AsigVehiculo') . '.pdf';
            $tamano = 'LETTER';
            $orientacion = 'P';
            $this->objParam->addParametro('orientacion',$orientacion);
            $this->objParam->addParametro('tamano',$tamano);
            $this->objParam->addParametro('titulo_archivo',$titulo);
            $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
            $this->objParam->addParametro('datos_sol_vehiculo',$dataSourceSolVehiculo->getDatos());
            $this->objParam->addParametro('datos_nomina_persona',$dataSourceNominaPersona->getDatos());
            $this->objParam->addParametro('datos_asig_vehiculo',$dataSourceAsigVehiculo->getDatos());

            $reporte = new RAutoPII($this->objParam);

            $reporte->datosHeader($this->objParam);
            $reporte->generarReporte1($this->objParam);
            $reporte->output($reporte->url_archivo,'F');

            $this->mensajeExito=new Mensaje();
            $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
            $this->mensajeExito->setArchivoGenerado($nombreArchivo);
            $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

        }
        if($this->objParam->getParametro('tipo_reporte')=='auto_PIII'){

            $nombreArchivo = uniqid(md5(session_id()).'-ElementVehiculo') . '.pdf';
            $tamano = 'LETTER';
            $orientacion = 'P';
            $this->objParam->addParametro('orientacion',$orientacion);
            $this->objParam->addParametro('tamano',$tamano);
            $this->objParam->addParametro('titulo_archivo',$titulo);
            $this->objParam->addParametro('nombre_archivo',$nombreArchivo);
            $this->objParam->addParametro('datos_sol_vehiculo',$dataSourceSolVehiculo->getDatos());
            $this->objParam->addParametro('datos_nomina_persona',$dataSourceNominaPersona->getDatos());
            $this->objParam->addParametro('datos_asig_vehiculo',$dataSourceAsigVehiculo->getDatos());
            $this->objParam->addParametro('datos_elemento_seg_equipo',$dataSourceElementSegEqui->getDatos());
            $this->objParam->addParametro('datos_asig_incidencia',$dataSourceAsigIncidencia->getDatos());

            $reporte = new RAutoPIII($this->objParam);

            $reporte->datosHeader($this->objParam);
            $reporte->generarReporte1($this->objParam);
            $reporte->output($reporte->url_archivo,'F');

            $this->mensajeExito=new Mensaje();
            $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
            $this->mensajeExito->setArchivoGenerado($nombreArchivo);
            $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());

        }
    }
        function listarSolVehiculoKilometraje(){
            $this->objParam->defecto('ordenacion','id_sol_vehiculo');
            $this->objParam->defecto('dir_ordenacion','asc');
            $this->objParam->addParametro('id_funcionario_usu',$_SESSION["ss_id_funcionario"]);
            
            if($this->objParam->getParametro('id_equipo')!=''){
                $this->objParam->addFiltro("asi.id_equipo = ".$this->objParam->getParametro('id_equipo'));
            }

            if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
                $this->objReporte = new Reporte($this->objParam,$this);
                $this->res = $this->objReporte->generarReporteListado('MODSolVehiculo','listarSolVehiculoKilometraje');
            } else{
                $this->objFunc=$this->create('MODSolVehiculo');

                $this->res=$this->objFunc->listarSolVehiculoKilometraje($this->objParam);
            }
            $this->res->imprimirRespuesta($this->res->generarJson());


    }
    function EditFormAlquilado(){//#GDV-37
        $this->objFunc=$this->create('MODSolVehiculo');

        $this->res=$this->objFunc->EditFormAlquilado($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function ReporteAsignacionVehiculo(){ //#RAS-8
        $this->objParam->defecto('ordenacion','asig.id_sol_vehiculo');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_funcionario')){
            $this->objParam->addFiltro("fun.id_funcionario = ".$this->objParam->getParametro('id_funcionario'));
        }
        if($this->objParam->getParametro('id_sol_vehiculo_responsable')){
            $this->objParam->addFiltro("r.id_sol_vehiculo_responsable = ".$this->objParam->getParametro('id_sol_vehiculo_responsable'));
        }
        if($this->objParam->getParametro('desde')){
            $this->objParam->addFiltro(" (sol.fecha_retorno::date >= ''".$this->objParam->getParametro('desde')."''::date ) ");
        }
        if($this->objParam->getParametro('hasta')){
            $this->objParam->addFiltro(" (sol.fecha_retorno::date <= ''".$this->objParam->getParametro('hasta')."''::date ) ");
        }


        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODSolVehiculo','ReporteAsignacionVehiculo');
        } else{
            $this->objFunc=$this->create('MODSolVehiculo');

            $this->res=$this->objFunc->ReporteAsignacionVehiculo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function ReporteConsultaSolcitud(){ //#RAS-8
        $this->objParam->defecto('ordenacion','asig.id_sol_vehiculo');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_funcionario')){
            $this->objParam->addFiltro("fun.id_funcionario = ".$this->objParam->getParametro('id_funcionario'));
        }
        if($this->objParam->getParametro('id_uo')){
            $this->objParam->addFiltro("g.id_uo = ".$this->objParam->getParametro('id_uo'));
        }
        if($this->objParam->getParametro('id_tipo_cc')){
            $this->objParam->addFiltro("tcc.id_tipo_cc = ".$this->objParam->getParametro('id_tipo_cc'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODSolVehiculo','ReporteConsultaSolcitud');
        } else{
            $this->objFunc=$this->create('MODSolVehiculo');

            $this->res=$this->objFunc->ReporteConsultaSolcitud($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
}

?>