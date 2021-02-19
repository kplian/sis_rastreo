<?php
/****************************************************************************************
*@package pXP
*@file gen-ACTNominaPersona.php
*@author  (egutierrez)
*@date 03-07-2020 14:58:25
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo

 HISTORIAL DE MODIFICACIONES:
 #ISSUE                FECHA                AUTOR                DESCRIPCION
  #0                03-07-2020 14:58:25    egutierrez             Creacion    
  #
*****************************************************************************************/

class ACTNominaPersona extends ACTbase{    
            
    function listarNominaPersona(){
		$this->objParam->defecto('ordenacion','id_nomina_persona');
        if($this->objParam->getParametro('id_sol_vehiculo')!=''){
            $this->objParam->addFiltro("nomiper.id_sol_vehiculo = ".$this->objParam->getParametro('id_sol_vehiculo'));
        }

        $this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODNominaPersona','listarNominaPersona');
        } else{
        	$this->objFunc=$this->create('MODNominaPersona');
            
        	$this->res=$this->objFunc->listarNominaPersona($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                
    function insertarNominaPersona(){
        $this->objFunc=$this->create('MODNominaPersona');    
        if($this->objParam->insertar('id_nomina_persona')){
            $this->res=$this->objFunc->insertarNominaPersona($this->objParam);            
        } else{            
            $this->res=$this->objFunc->modificarNominaPersona($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
                        
    function eliminarNominaPersona(){
        	$this->objFunc=$this->create('MODNominaPersona');    
        $this->res=$this->objFunc->eliminarNominaPersona($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
            
}

?>