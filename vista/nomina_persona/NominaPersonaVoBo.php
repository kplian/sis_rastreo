<?php
/**
*@package pXP
*@file NominaPersona.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NominaPersonaVoBo={
	require:'../../../sis_rastreo/vista/nomina_persona/NominaPersonaBase.php',
	requireclase:'Phx.vista.NominaPersonaBase',
	title:'NominaPersonaVoBo',
	nombreVista: 'NominaPersonaVoBo',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.NominaPersonaVoBo.superclass.constructor.call(this,config);
		this.init();
        this.bloquearMenus();
		// this.load({params:{start:0,
        //             limit:this.tam_pag ,
        //             nombreVista:this.nombreVista ,
        //             //id_funcionario:this.maestro.id_funcionario
		// }});
		
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.NominaPersonaVoBo.superclass.preparaMenu.call(this,n);

         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.NominaPersonaVoBo.superclass.liberaMenu.call(this);
        if(tb){
		        }
       return tb
    },
    bdel:false,
    bnew:false,
    bedit:false,
    bsave:false
	}
</script>
		
		