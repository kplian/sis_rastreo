<?php
/**
*@package pXP
*@file gen-ACTEquipo.php
*@author  (admin)
*@date 15-06-2017 17:50:17
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEquipo extends ACTbase{    
			
	function listarEquipo(){
		$this->objParam->defecto('ordenacion','id_equipo');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_localizacion')!=''){
			$this->objParam->addFiltro("equip.id_localizacion = ".$this->objParam->getParametro('id_localizacion'));
		}
        // inicio #6
        if ($this->objParam->getParametro('id_depto') != '') {
            $this->objParam->addFiltro("equip.id_depto = ".$this->objParam->getParametro('id_depto'));
        } else {
            $this->objParam->addFiltro("equip.id_depto = 0");
        }
        //fin #6

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipo');
		} else{
			$this->objFunc=$this->create('MODEquipo');
			
			$this->res=$this->objFunc->listarEquipo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEquipo(){
		$this->objFunc=$this->create('MODEquipo');	
		if($this->objParam->insertar('id_equipo')){
			$this->res=$this->objFunc->insertarEquipo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEquipo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEquipo(){
			$this->objFunc=$this->create('MODEquipo');	
		$this->res=$this->objFunc->eliminarEquipo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarEquipoRapido(){
		$this->objParam->defecto('ordenacion','id_equipo');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipoRapido');
		} else{
			$this->objFunc=$this->create('MODEquipo');
			
			$this->res=$this->objFunc->listarEquipoRapido($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function listarEquipoEstado(){
        $this->objParam->defecto('ordenacion','id_equipo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('id_tipo_equipo')!=''){
            $this->objParam->addFiltro("equip.id_tipo_equipo = ".$this->objParam->getParametro('id_tipo_equipo'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODEquipo','listarEquipoEstado');
        } else{
            $this->objFunc=$this->create('MODEquipo');

            $this->res=$this->objFunc->listarEquipoEstado($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
			
}

?>