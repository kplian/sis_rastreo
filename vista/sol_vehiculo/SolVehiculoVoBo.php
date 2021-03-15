<?php
/**
*@package pXP
*@file SolVehiculo.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SolVehiculoVoBo={
	require:'../../../sis_rastreo/vista/sol_vehiculo/SolVehiculoBase.php',
	requireclase:'Phx.vista.SolVehiculoBase',
	title:'SolVehiculoVoBo',
	nombreVista: 'SolVehiculoVoBo',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.SolVehiculoVoBo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0,
                    limit:this.tam_pag ,
                    nombreVista:this.nombreVista ,
                    //id_funcionario:this.maestro.id_funcionario
		}});
		
		this.addButton('ant_estado',
						{argument: {estado: 'anterior'},
						text:'Anterior',
		                grupo:[0,1,2],
						iconCls: 'batras',
						disabled:false,
						handler:this.antEstado,
						tooltip: '<b>Pasar al Anterior Estado</b>'
						});
		this.addButton('sig_estado',
						{ text:'Siguiente',
						grupo:[0,1,2],
						iconCls: 'badelante', 
						disabled: false,
						handler: this.sigEstado, 
						tooltip: '<b>Pasar al Siguiente Estado</b>'
						});
        this.addButton('btnAlquilado', { //GDV-37
            text : 'Alquiler',
            iconCls : 'bexecdb',
            disabled : true,
            handler : this.openAlquilado,
            tooltip : '<b>Datos de Alquilado</b>'
        });
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.SolVehiculoVoBo.superclass.preparaMenu.call(this,n);
        this.getBoton('diagrama_gantt').enable();
		this.getBoton('btnChequeoDocumentosWf').enable();

         //if (data.estado == 'borrador') {
         	this.getBoton('ant_estado').enable();
    		this.getBoton('sig_estado').enable();	

        // };
         if(data.estado == ('vobo' ||'finalizado' )){
         	this.getBoton('ant_estado').disable();
    		this.getBoton('sig_estado').disable();		
         };

         if(data.estado == 'vobojefeserv' ){
             this.getBoton('btnAlquilado').enable();
         }else{
             this.getBoton('btnAlquilado').disable();
         }

       	
         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.SolVehiculoVoBo.superclass.liberaMenu.call(this);
        if(tb){
			this.getBoton('btnChequeoDocumentosWf').disable();          
            this.getBoton('diagrama_gantt').disable();
            this.getBoton('ant_estado').disable();
    		this.getBoton('sig_estado').disable();  
        }
       return tb
    },
    tabsouth: [{
        url: '../../../sis_rastreo/vista/nomina_persona/NominaPersonaVoBo.php',
        title: 'Nomina Personas',
        height: '40%',
        cls: 'NominaPersonaVoBo'
    },{
        url: '../../../sis_rastreo/vista/sol_vehiculo_responsable/SolVehiculoResponsable.php',
        title: 'Asignacion de Conductores',
        height: '40%',
        cls: 'SolVehiculoResponsable'
    },{
        url: '../../../sis_rastreo/vista/asig_vehiculo/AsigVehiculoVoBo.php',
        title: 'Vehiculos Asignados',
        height: '50%',
        cls: 'AsigVehiculoVoBo'
     }],
    bdel:false,
    bnew:false,
    bedit:false,
    bsave:false,

    openAlquilado: function(){ //#GDV-37
        var data = this.getSelectedData();
        var win = Phx.CP.loadWindows(
            '../../../sis_rastreo/vista/sol_vehiculo/FormAlquilado.php',
            'Alquiler', {
                width: '50%',
                height: '50%'
            },
            {maestro:data},
            this.idContenedor,
            'FormAlquilado'
        );
    },
	}
</script>
		
		