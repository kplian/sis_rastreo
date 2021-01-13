<?php
/**
*@package pXP
*@file gen-Licencia.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.PersonaConductor={
	require:'../../../sis_seguridad/vista/persona/Persona.php',
	requireclase:'Phx.vista.persona',
	title:'PersonaConductor',
	nombreVista: 'PersonaConductor',
	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.PersonaConductor.superclass.constructor.call(this,config);
		this.init();
		this.camposOcultos();
		this.load({params:{start:0, limit:this.tam_pag }});
    },
    camposOcultos:function(){
	    this.ocultarComponente(this.Cmp.cualidad_1);
        this.ocultarComponente(this.Cmp.cualidad_2);
        this.ocultarComponente(this.Cmp.sobrenombre);
        this.ocultarComponente(this.Cmp.grupo_sanguineo);
        this.ocultarComponente(this.Cmp.historia_clinica);
        this.ocultarComponente(this.Cmp.matricula);
        this.ocultarComponente(this.Cmp.celular2);
        this.ocultarComponente(this.Cmp.telefono2);
        this.ocultarComponente(this.Cmp.abreviatura_titulo);
        this.ocultarComponente(this.Cmp.fecha_nacimiento);

        this.Cmp.fecha_nacimiento.allowBlank=true;
        this.Cmp.cualidad_1.allowBlank=true;
        this.Cmp.cualidad_2.allowBlank=true;


    },
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.PersonaConductor.superclass.preparaMenu.call(this,n);

         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.PersonaConductor.superclass.liberaMenu.call(this);
        if(tb){

        }
       return tb
    },
    bdel:false

	}
</script>
		
		