<?php
/**
*@package pXP
*@file gen-ACTTipoEvento.php
*@author  (admin)
*@date 30-07-2017 15:17:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoEvento extends ACTbase{    
			
	function listarTipoEvento(){
		$this->objParam->defecto('ordenacion','id_tipo_evento');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoEvento','listarTipoEvento');
		} else{
			$this->objFunc=$this->create('MODTipoEvento');
			
			$this->res=$this->objFunc->listarTipoEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoEvento(){
		$this->objFunc=$this->create('MODTipoEvento');	
		if($this->objParam->insertar('id_tipo_evento')){
			$this->res=$this->objFunc->insertarTipoEvento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoEvento(){
			$this->objFunc=$this->create('MODTipoEvento');	
		$this->res=$this->objFunc->eliminarTipoEvento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>