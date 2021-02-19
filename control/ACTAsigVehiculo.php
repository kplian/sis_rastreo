<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTAsigVehiculo.php
*@author  (egutierrez)
*@date 03-07-2020 15:02:14
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 15:02:14    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTAsigVehiculo extends ACTbase{    
            
    function listarAsigVehiculo(){
		$this->objParam->defecto('ordenacion','id_asig_vehiculo');
        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("asigvehi.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }
        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAsigVehiculo','listarAsigVehiculo');
        } else{
        	$this->objFunc=$this->create('MODAsigVehiculo');
            
        	$this->res=$this->objFunc->listarAsigVehiculo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarAsigVehiculo(){
        $this->objFunc=$this->create('MODAsigVehiculo');    
        if($this->objParam->insertar('id_asig_vehiculo')){
            $this->res=$this->objFunc->insertarAsigVehiculo($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarAsigVehiculo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarAsigVehiculo(){
        	$this->objFunc=$this->create('MODAsigVehiculo');    
        $this->res=$this->objFunc->eliminarAsigVehiculo($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function EditFormViaje(){
        $this->objFunc=$this->create('MODAsigVehiculo');

        $this->res=$this->objFunc->EditFormViaje($this->objParam);

        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>