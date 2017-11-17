<?php
/**
*@package pXP
*@file gen-ACTPositions.php
*@author  (admin)
*@date 15-06-2017 20:34:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTReporte extends ACTbase{    
			
	function listarEventosRango(){
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEvents','listarEventosRango');
		} else{
			$this->objFunc=$this->create('MODEvents');
			$this->res=$this->objFunc->listarEventosRango($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarVelocidadesRango(){
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPositions','listarVelocidadesRango');
		} else{
			$this->objFunc=$this->create('MODPositions');
			$this->res=$this->objFunc->listarVelocidadesRango($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function listarPosicionesRango(){
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPositions','listarPosicionesRango');
		} else{
			$this->objFunc=$this->create('MODPositions');
			$this->res=$this->objFunc->listarPosicionesRango($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

}