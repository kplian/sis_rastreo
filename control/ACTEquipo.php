<?php
/**
 *@package pXP
 *@file gen-ACTEquipo.php
 *@author  (admin)
 *@date 15-06-2017 17:50:17
 *@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 *
 *  #RAS-3          19/02/2021      JJA         Nuevo reporte de historial de movimientos de vehículos
 *  #GDV-33         22/02/2021      EGS         Se agrega kilometraje inicial
 */

require_once(dirname(__FILE__).'/../reportes/RHistorialVehiculoPDF.php');//#RAS-3

class ACTEquipo extends ACTbase{

    function listarEquipo(){
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_localizacion')!=''){
            $this->objParam->addFiltro("equip.id_localizacion = ".$this->objParam->getParametro('id_localizacion'));
        }
        // inicio #6
        if ($this->objParam->getParametro('id_depto') != '') {
            $this->objParam->addFiltro("equip.id_depto = ".$this->objParam->getParametro('id_depto'));
        } else {
            $this->objParam->addFiltro("equip.id_depto = 0");
        }
        //fin #6

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function insertarEquipo(){
        $this->objFunc=$this->create('MODEquipo');
        if($this->objParam->insertar('id_equipo')){
            $this->res=$this->objFunc->insertarEquipo($this->objParam);
        } else{
            $this->res=$this->objFunc->modificarEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarEquipo(){
        $this->objFunc=$this->create('MODEquipo');
        $this->res=$this->objFunc->eliminarEquipo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarEquipoRapido(){
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipoRapido');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipoRapido($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function ReporteHistorialVehiculo(){//#RAS-3

         if($this->objParam->getParametro('fecha_ini')){
             $this->objParam->addFiltro(" (p.devicetime::date  >= ''".$this->objParam->getParametro('fecha_ini')."''::date )");
         }
         if($this->objParam->getParametro('fecha_fin')){
             $this->objParam->addFiltro(" (p.devicetime::date  <= ''".$this->objParam->getParametro('fecha_fin')."''::date ) ");
         }
         $this->objParam->addFiltro(" (eq.id_equipo::integer  = ''".$this->objParam->getParametro('ids')."''::integer ) ");

         $this->objFunc = $this->create('MODEquipo');
         $this->res = $this->objFunc->ReporteHistorialVehiculo($this->objParam);


        $nombreArchivo = uniqid(md5(session_id()).'Historial') . '.pdf';

        $tamano = 'LETTER';
        $orientacion = 'L';
        $titulo = 'Consolidado';

        $this->objParam->addParametro('orientacion',$orientacion);
        $this->objParam->addParametro('tamano',$tamano);
        $this->objParam->addParametro('titulo_archivo',$titulo);
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);

        $reporte = new RHistorialVehiculoPDF($this->objParam);

        $reporte->datosHeader($this->res->getDatos(),$this->objParam);

        $reporte->generarReporte();
        $reporte->output($reporte->url_archivo,'F');

        $this->mensajeExito = new Mensaje();
        $this->mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado','Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }
    function listarEquipoEstado(){
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_tipo_equipo')!=''){
            $this->objParam->addFiltro("equip.id_tipo_equipo = ".$this->objParam->getParametro('id_tipo_equipo'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipoEstado');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipoEstado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarKilometrajeInicialEquipo(){//#GDV-33
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        $this->objFunc=$this->create('MODEquipo');

        $this->res=$this->objFunc->listarKilometrajeInicialEquipo($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarEquipoKilometraje(){//#GDV-34
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if ($this->objParam->getParametro('id_depto') != '') {
            $this->objParam->addFiltro("equip.id_depto = ".$this->objParam->getParametro('id_depto'));
        } else {
            $this->objParam->addFiltro("equip.id_depto = 0");
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipoKilometraje');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipoKilometraje($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

}

?>