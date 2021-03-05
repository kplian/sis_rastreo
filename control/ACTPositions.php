<?php
/**
*@package pXP
*@file gen-ACTPositions.php
*@author  (admin)
*@date 15-06-2017 20:34:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

  #RAS-5       04/03/2021        JJA            Agregar tiempo de parqueo en los mapas
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

	function listarUltimaPosicion(){
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPositions','listarUltimaPosicion');
		} else{
			$this->objFunc=$this->create('MODPositions');
			$this->res=$this->objFunc->listarUltimaPosicion($this->objParam);
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

	function listarPosicionesRangoProcesado(){ //#RAS-5
		$this->objParam->defecto('ordenacion','id');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPositions','listarPosicionesRangoProcesado');
		} else{
			$this->objFunc=$this->create('MODPositions');
			$this->res=$this->objFunc->listarPosicionesRangoProcesado($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
}

?>