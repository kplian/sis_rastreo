<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTSolVehiculoResponsable.php
*@author  (egutierrez)
*@date 12-03-2021 14:10:00
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                12-03-2021 14:10:00    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTSolVehiculoResponsable extends ACTbase{    
            
    function listarSolVehiculoResponsable(){
		$this->objParam->defecto('ordenacion','id_sol_vehiculo_responsable');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("solvere.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODSolVehiculoResponsable','listarSolVehiculoResponsable');
        } else{
        	$this->objFunc=$this->create('MODSolVehiculoResponsable');
            
        	$this->res=$this->objFunc->listarSolVehiculoResponsable($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarSolVehiculoResponsable(){
        $this->objFunc=$this->create('MODSolVehiculoResponsable');    
        if($this->objParam->insertar('id_sol_vehiculo_responsable')){
            $this->res=$this->objFunc->insertarSolVehiculoResponsable($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarSolVehiculoResponsable($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarSolVehiculoResponsable(){
        	$this->objFunc=$this->create('MODSolVehiculoResponsable');    
        $this->res=$this->objFunc->eliminarSolVehiculoResponsable($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>