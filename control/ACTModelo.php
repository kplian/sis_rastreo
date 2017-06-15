<?php
/**
*@package pXP
*@file gen-ACTModelo.php
*@author  (admin)
*@date 15-06-2017 17:49:58
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTModelo extends ACTbase{    
			
	function listarModelo(){
		$this->objParam->defecto('ordenacion','id_modelo');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_marca')!=''){
			$this->objParam->addFiltro("model.id_marca = ".$this->objParam->getParametro('id_marca'));
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODModelo','listarModelo');
		} else{
			$this->objFunc=$this->create('MODModelo');
			
			$this->res=$this->objFunc->listarModelo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarModelo(){
		$this->objFunc=$this->create('MODModelo');	
		if($this->objParam->insertar('id_modelo')){
			$this->res=$this->objFunc->insertarModelo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarModelo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarModelo(){
			$this->objFunc=$this->create('MODModelo');	
		$this->res=$this->objFunc->eliminarModelo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>