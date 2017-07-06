<?php
/**
*@package pXP
*@file gen-ACTLocalizacion.php
*@author  (admin)
*@date 15-06-2017 17:50:13
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTLocalizacion extends ACTbase{    
			
	function listarLocalizacion(){
		$this->objParam->defecto('ordenacion','id_localizacion');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODLocalizacion','listarLocalizacion');
		} else{
			$this->objFunc=$this->create('MODLocalizacion');
			
			$this->res=$this->objFunc->listarLocalizacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarLocalizacion(){
		$this->objFunc=$this->create('MODLocalizacion');	
		if($this->objParam->insertar('id_localizacion')){
			$this->res=$this->objFunc->insertarLocalizacion($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarLocalizacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarLocalizacion(){
			$this->objFunc=$this->create('MODLocalizacion');	
		$this->res=$this->objFunc->eliminarLocalizacion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarLocalizacionArb(){
		$this->objParam->defecto('ordenacion','id_localizacion');
		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_localizacion')!=''){
			if($this->objParam->getParametro('id_localizacion')=='null'){
				$this->objParam->addFiltro("local.id_localizacion_fk is null ");
			} else {
				$this->objParam->addFiltro("local.id_localizacion_fk = ".$this->objParam->getParametro('id_localizacion'));	
			}
		} else {
			$this->objParam->addFiltro("local.id_localizacion_fk is null ");
		}
		$this->objFunc=$this->create('MODLocalizacion');
		$this->res=$this->objFunc->listarLocalizacionArb($this->objParam);
		$this->res->setTipoRespuestaArbol();
		$arreglo=array();
		$arreglo_valores=array();
		//para cambiar un valor por otro en una variable
		/*array_push($arreglo_valores,array('variable'=>'checked','val_ant'=>'true','val_nue'=>true));
		array_push($arreglo_valores,array('variable'=>'checked','val_ant'=>'false','val_nue'=>false));
		$this->res->setValores($arreglo_valores);*/
		array_push($arreglo, array('nombre' => 'id', 'valor' => 'id_localizacion'));
        array_push($arreglo, array('nombre' => 'id_p', 'valor' => 'id_localizacion_fk'));
        array_push($arreglo, array('nombre' => 'text', 'valores' => '[#codigo#]-#nombre#'));
        array_push($arreglo, array('nombre' => 'cls', 'valor' => 'nombre'));
        array_push($arreglo, array('nombre' => 'qtip', 'valores' => '<b>#codigo#</b><br/>#nombre#'));
	
        /*Estas funciones definen reglas para los nodos en funcion a los tipo de nodos que contenga cada uno*/
        $this->res->addNivelArbol('tipo_nodo', 'raiz', array('leaf' => false, 'draggable' => true, 'allowDelete' => true, 'allowEdit' => true, 'cls' => 'folder', 'tipo_nodo' => 'raiz', 'icon' => '../../../lib/imagenes/a_form_edit.png'), $arreglo,$arreglo_valores);
        $this->res->addNivelArbol('tipo_nodo', 'hijo', array('leaf' => false, 'draggable' => true, 'allowDelete' => true, 'allowEdit' => true, 'tipo_nodo' => 'hijo', 'icon' => '../../../lib/imagenes/a_form_edit.png'), $arreglo,$arreglo_valores);
        
        echo $this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>