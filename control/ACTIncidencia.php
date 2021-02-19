<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTIncidencia.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:42
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:42    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTIncidencia extends ACTbase{    
            
    function listarIncidencia(){
		$this->objParam->defecto('ordenacion','id_incidencia');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('nombreVista')=='Incidencia'){
            $this->objParam->addFiltro("inciden.id_incidencia_fk is null ");
        }

        if($this->objParam->getParametro('combo')=='si'){
            $this->objParam->addFiltro("inciden.id_incidencia_fk is not null");
        }

        if($this->objParam->getParametro('id_incidencia_fk')!=''){
            $this->objParam->addFiltro("inciden.id_incidencia_fk = ".$this->objParam->getParametro('id_incidencia_fk'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODIncidencia','listarIncidencia');
        } else{
        	$this->objFunc=$this->create('MODIncidencia');
            
        	$this->res=$this->objFunc->listarIncidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarIncidencia(){
        $this->objFunc=$this->create('MODIncidencia');    
        if($this->objParam->insertar('id_incidencia')){
            $this->res=$this->objFunc->insertarIncidencia($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarIncidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarIncidencia(){
        	$this->objFunc=$this->create('MODIncidencia');    
        $this->res=$this->objFunc->eliminarIncidencia($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>