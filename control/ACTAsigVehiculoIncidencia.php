<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTAsigVehiculoIncidencia.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:29
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                09-07-2020 13:52:29    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTAsigVehiculoIncidencia extends ACTbase{    
            
    function listarAsigVehiculoIncidencia(){
		$this->objParam->defecto('ordenacion','id_asig_vehiculo_incidedencia');

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('id_asig_vehiculo')!=''){
            $this->objParam->addFiltro("asinci.id_asig_vehiculo = ".$this->objParam->getParametro('id_asig_vehiculo'));
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODAsigVehiculoIncidencia','listarAsigVehiculoIncidencia');
        } else{
        	$this->objFunc=$this->create('MODAsigVehiculoIncidencia');
            
        	$this->res=$this->objFunc->listarAsigVehiculoIncidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarAsigVehiculoIncidencia(){
        $this->objFunc=$this->create('MODAsigVehiculoIncidencia');    
        if($this->objParam->insertar('id_asig_vehiculo_incidedencia')){
            $this->res=$this->objFunc->insertarAsigVehiculoIncidencia($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarAsigVehiculoIncidencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarAsigVehiculoIncidencia(){
        	$this->objFunc=$this->create('MODAsigVehiculoIncidencia');    
        $this->res=$this->objFunc->eliminarAsigVehiculoIncidencia($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>