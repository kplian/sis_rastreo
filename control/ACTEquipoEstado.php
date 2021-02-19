<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTEquipoEstado.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:37
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:37    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTEquipoEstado extends ACTbase{    
            
    function listarEquipoEstado(){
		$this->objParam->defecto('ordenacion','id_equipo_estado');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_equipo')!=''){
            $this->objParam->addFiltro("equiesta.id_equipo = ".$this->objParam->getParametro('id_equipo'));
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipoEstado','listarEquipoEstado');
        } else{
        	$this->objFunc=$this->create('MODEquipoEstado');
            
        	$this->res=$this->objFunc->listarEquipoEstado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarEquipoEstado(){
        $this->objFunc=$this->create('MODEquipoEstado');    
        if($this->objParam->insertar('id_equipo_estado')){
            $this->res=$this->objFunc->insertarEquipoEstado($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarEquipoEstado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarEquipoEstado(){
        	$this->objFunc=$this->create('MODEquipoEstado');    
        $this->res=$this->objFunc->eliminarEquipoEstado($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>