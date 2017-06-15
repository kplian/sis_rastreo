<?php
/**
*@package pXP
*@file gen-ACTEquipoResponsable.php
*@author  (admin)
*@date 15-06-2017 17:50:22
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEquipoResponsable extends ACTbase{    
			
	function listarEquipoResponsable(){
		$this->objParam->defecto('ordenacion','id_equipo_responsable');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEquipoResponsable','listarEquipoResponsable');
		} else{
			$this->objFunc=$this->create('MODEquipoResponsable');
			
			$this->res=$this->objFunc->listarEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEquipoResponsable(){
		$this->objFunc=$this->create('MODEquipoResponsable');	
		if($this->objParam->insertar('id_equipo_responsable')){
			$this->res=$this->objFunc->insertarEquipoResponsable($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEquipoResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEquipoResponsable(){
			$this->objFunc=$this->create('MODEquipoResponsable');	
		$this->res=$this->objFunc->eliminarEquipoResponsable($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>