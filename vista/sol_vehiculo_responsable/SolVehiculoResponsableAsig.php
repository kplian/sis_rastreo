<?php
/**
*@package pXP
*@file SolVehiculo.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 * ISSUE        FECHA           AUTOR           DESCRIPCION
 * #GDV-38      02/06/2021      EGS             Se agrega id responsable como obligatorio
 * #ETR-4275    17/06/2021      EGS             Se habilita feha de solicitud al editar y no carga automaticamente este
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SolVehiculoResponsableAsig={
	require:'../../../sis_rastreo/vista/sol_vehiculo_responsable/SolVehiculoResponsable.php',
	requireclase:'Phx.vista.SolVehiculoResponsable',
	title:'SolVehiculoResponsableAsig',
	nombreVista: 'SolVehiculoResponsableAsig',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.SolVehiculoResponsableAsig.superclass.constructor.call(this,config);
		this.init();
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        } else {
            this.bloquearMenus();
        }

	},
    
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.SolVehiculoResponsableAsig.superclass.preparaMenu.call(this,n);

        this.getBoton('edit').disable();
        this.getBoton('del').disable();
          return tb
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.SolVehiculoResponsableAsig.superclass.liberaMenu.call(this);
        if(tb){
        }
       return tb
    },
    bdel:false,
    bnew:false,
    bedit:false,
    bsave:false,
	}
</script>
		
		