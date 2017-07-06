<?php
/**
*@package pXP
*@file gen-ACTPositions.php
*@author  (admin)
*@date 15-06-2017 20:34:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPositions extends ACTbase{    
			
	function listarPositions(){
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('deviceid')!=''){
			$this->objParam->addFiltro("posic.deviceid = ".$this->objParam->getParametro('deviceid'));
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPositions','listarPositions');
		} else{
			$this->objFunc=$this->create('MODPositions');
			
			$this->res=$this->objFunc->listarPositions($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPositions(){
		$this->objFunc=$this->create('MODPositions');	
		if($this->objParam->insertar('id')){
			$this->res=$this->objFunc->insertarPositions($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPositions($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPositions(){
			$this->objFunc=$this->create('MODPositions');	
		$this->res=$this->objFunc->eliminarPositions($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>