<?php
/**
*@package pXP
*@file gen-ACTResponsable.php
*@author  (admin)
*@date 15-06-2017 17:50:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTResponsable extends ACTbase{    
			
	function listarResponsable(){
		$this->objParam->defecto('ordenacion','id_responsable');

        if($this->objParam->getParametro('tipo_responsable')!=''){
            if($this->objParam->getParametro('tipo_responsable')=='conductor_alquilado'){

                $this->objParam->addFiltro("conduc.tipo_responsable in (''conductor'',''conductor_alquilado'')");
            }else{
                $this->objParam->addFiltro("conduc.tipo_responsable = ''".$this->objParam->getParametro('tipo_responsable')."''");
            }

        }

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODResponsable','listarResponsable');
		} else{
			$this->objFunc=$this->create('MODResponsable');
			
			$this->res=$this->objFunc->listarResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarResponsable(){
		$this->objFunc=$this->create('MODResponsable');	
		if($this->objParam->insertar('id_responsable')){
			$this->res=$this->objFunc->insertarResponsable($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarResponsable($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarResponsable(){
			$this->objFunc=$this->create('MODResponsable');	
		$this->res=$this->objFunc->eliminarResponsable($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>