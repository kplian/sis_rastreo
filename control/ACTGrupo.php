<?php
/**
*@package pXP
*@file gen-ACTGrupo.php
*@author  (admin)
*@date 24-07-2017 08:28:12
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTGrupo extends ACTbase{    
			
	function listarGrupo(){
		$this->objParam->defecto('ordenacion','id_grupo');
		$this->objParam->defecto('ordenacion','id_grupo');

        //#6
        if ($this->objParam->getParametro('id_depto') != '') {
            $this->objParam->addFiltro("grupo.id_depto = ".$this->objParam->getParametro('id_depto'));
        } else {
            $this->objParam->addFiltro("grupo.id_depto = 0");
        }
        //#6

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODGrupo','listarGrupo');
		} else{
			$this->objFunc=$this->create('MODGrupo');
			
			$this->res=$this->objFunc->listarGrupo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
    function listarMonitoreoGrupo(){
        $this->objParam->defecto('ordenacion','id_grupo');
        $this->objParam->defecto('ordenacion','id_grupo');
         // inicio #6
        if ($this->objParam->getParametro('id_depto') != '') {
            $this->objParam->addFiltro("grupo.id_depto = ".$this->objParam->getParametro('id_depto'));
        }
        //fin #6
        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODGrupo','listarGrupo');
        } else{
            $this->objFunc=$this->create('MODGrupo');

            $this->res=$this->objFunc->listarGrupo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
				
	function insertarGrupo(){
		$this->objFunc=$this->create('MODGrupo');	
		if($this->objParam->insertar('id_grupo')){
			$this->res=$this->objFunc->insertarGrupo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarGrupo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarGrupo(){
			$this->objFunc=$this->create('MODGrupo');	
		$this->res=$this->objFunc->eliminarGrupo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>