<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTElementoSegEquipo.php
*@author  (egutierrez)
*@date 03-07-2020 14:59:28
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 14:59:28    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTElementoSegEquipo extends ACTbase{    
            
    function listarElementoSegEquipo(){
		$this->objParam->defecto('ordenacion','id_elemento_seg_equipo');
        if($this->objParam->getParametro('id_asig_vehiculo')!=''){
            $this->objParam->addFiltro("elemav.id_asig_vehiculo = ".$this->objParam->getParametro('id_asig_vehiculo'));
        }
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODElementoSegEquipo','listarElementoSegEquipo');
        } else{
        	$this->objFunc=$this->create('MODElementoSegEquipo');
            
        	$this->res=$this->objFunc->listarElementoSegEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarElementoSegEquipo(){
        $this->objFunc=$this->create('MODElementoSegEquipo');    
        if($this->objParam->insertar('id_elemento_seg_equipo')){
            $this->res=$this->objFunc->insertarElementoSegEquipo($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarElementoSegEquipo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarElementoSegEquipo(){
        	$this->objFunc=$this->create('MODElementoSegEquipo');    
        $this->res=$this->objFunc->eliminarElementoSegEquipo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>