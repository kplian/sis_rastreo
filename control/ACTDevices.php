<?php
/**
*@package pXP
*@file gen-ACTDevices.php
*@author  (admin)
*@date 15-06-2017 20:34:33
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDevices extends ACTbase{    
			
	function listarDevices(){
		$this->objParam->defecto('ordenacion','id');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDevices','listarDevices');
		} else{
			$this->objFunc=$this->create('MODDevices');
			
			$this->res=$this->objFunc->listarDevices($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDevices(){
		$this->objFunc=$this->create('MODDevices');	
		if($this->objParam->insertar('id')){
			$this->res=$this->objFunc->insertarDevices($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDevices($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDevices(){
			$this->objFunc=$this->create('MODDevices');	
		$this->res=$this->objFunc->eliminarDevices($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>