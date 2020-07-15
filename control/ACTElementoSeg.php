<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTElementoSeg.php
*@author  (egutierrez)
*@date 03-07-2020 15:00:54
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 15:00:54    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTElementoSeg extends ACTbase{    
            
    function listarElementoSeg(){
		$this->objParam->defecto('ordenacion','id_elemento_seg');
        if($this->objParam->getParametro('estado_reg')=='activo'){
            $this->objParam->addFiltro("elemseg.estado_reg = ''".$this->objParam->getParametro('estado_reg')."''");
        }
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODElementoSeg','listarElementoSeg');
        } else{
        	$this->objFunc=$this->create('MODElementoSeg');
            
        	$this->res=$this->objFunc->listarElementoSeg($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarElementoSeg(){
        $this->objFunc=$this->create('MODElementoSeg');    
        if($this->objParam->insertar('id_elemento_seg')){
            $this->res=$this->objFunc->insertarElementoSeg($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarElementoSeg($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarElementoSeg(){
        	$this->objFunc=$this->create('MODElementoSeg');    
        $this->res=$this->objFunc->eliminarElementoSeg($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>