<?php
/**
*@package pXP
*@file gen-ACTEvents.php
*@author  (admin)
*@date 15-06-2017 20:34:28
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEvents extends ACTbase{    
			
	function listarEvents(){
		$this->objParam->defecto('ordenacion','servertime');
		$this->objParam->defecto('dir_ordenacion','desc');

		if($this->objParam->getParametro('deviceid')!=''){
			$this->objParam->addFiltro("event.deviceid = ".$this->objParam->getParametro('deviceid'));
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEvents','listarEvents');
		} else{
			$this->objFunc=$this->create('MODEvents');
			
			$this->res=$this->objFunc->listarEvents($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEvents(){
		$this->objFunc=$this->create('MODEvents');	
		if($this->objParam->insertar('id')){
			$this->res=$this->objFunc->insertarEvents($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEvents($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEvents(){
			$this->objFunc=$this->create('MODEvents');	
		$this->res=$this->objFunc->eliminarEvents($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>