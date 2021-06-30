<?php
/**
*@package pXP
*@file SolVehiculo.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 ISSUE			FECHA			AUTHOR 					DESCRIPCION
 #GDV-36        02/03/2021      EGS                     Se agrega tab para filtro de estado
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SolVehiculoAsig={
	require:'../../../sis_rastreo/vista/sol_vehiculo/SolVehiculoBase.php',
	requireclase:'Phx.vista.SolVehiculoBase',
	title:'SolVehiculoAsig',
	nombreVista: 'SolVehiculoAsig',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.SolVehiculoAsig.superclass.constructor.call(this,config);
		this.init();
        this.finCons = true;//#GDV-36
		this.load({params:{start:0,
                    limit:this.tam_pag ,
                    nombreVista:this.nombreVista ,
                    estado:'asigvehiculo' //#GDV-36
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
        this.addButton('dev_borrador', {
            text : 'Dev. al Solicitante',
            iconCls : 'batras',
            disabled : true,
            handler : this.devBorrador,
            tooltip : '<b>Devuelve a Borrador</b>'
        });
	},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.SolVehiculoAsig.superclass.preparaMenu.call(this,n);
        this.getBoton('diagrama_gantt').enable();
		this.getBoton('btnChequeoDocumentosWf').enable();
        this.getBoton('dev_borrador').enable();

         //if (data.estado == 'borrador') {
         	this.getBoton('ant_estado').enable();
    		this.getBoton('sig_estado').enable();	

        // };
         if(data.estado == 'cancelado' ) {
             this.getBoton('sig_estado').disable();
             this.getBoton('dev_borrador').disable();
         }else if(data.estado == 'asignado'){
             this.getBoton('dev_borrador').disable();
         };
         

       	
         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.SolVehiculoAsig.superclass.liberaMenu.call(this);
        if(tb){
			this.getBoton('btnChequeoDocumentosWf').disable();          
            this.getBoton('diagrama_gantt').disable();
            this.getBoton('ant_estado').disable();
    		this.getBoton('sig_estado').disable();
            this.getBoton('dev_borrador').disable();

        }
       return tb
    },
    onButtonNew: function() {
        Phx.vista.SolVehiculoAsig.superclass.onButtonNew.call(this);
        this.Cmp.fecha_sol.setValue(new Date());
        this.Cmp.fecha_sol.disable();
        this.Cmp.id_funcionario.store.baseParams.fecha_sol = this.Cmp.fecha_sol.getValue().dateFormat(this.Cmp.fecha_sol.format);
        this.Cmp.id_funcionario.store.baseParams.query = Phx.CP.config_ini.id_funcionario;
        this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {

                    this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                }

            }, scope : this
        });
        this.Cmp.id_funcionario.enable();
    },
    tabsouth: [{
        url: '../../../sis_rastreo/vista/asig_vehiculo/AsigVehiculo.php',
        title: 'Asignacion de Vehiculos',
        height: '50%',
        cls: 'AsigVehiculo'
    },{
        url: '../../../sis_rastreo/vista/nomina_persona/NominaPersonaVoBo.php',
        title: 'Nomina Personas',
        height: '50%',
        cls: 'NominaPersonaVoBo'
    }],
    bdel:false,
    bnew:false,
    bedit:false,
    bsave:false,
    gruposBarraTareas:[//#GDV-36
        {name:'asigvehiculo',title:'<H1 align="center"><i class="fa fa-eye"></i>Asignación</h1>',grupo:0,height:0},
        {name:'asignado',title:'<H1 align="center"><i class="fa fa-eye"></i>Asignado</h1>',grupo:0,height:0},
        {name:'cancelado',title:'<H1 align="center"><i class="fa fa-eye"></i>Cancelado</h1>',grupo:0,height:0}

    ],
    actualizarSegunTab: function(name, indice){//#GDV-36
        if(this.finCons) {
            //this.store.baseParams.nombre_estado= name;
            this.store.baseParams.estado= name;
            this.store.baseParams.nombreVista = this.nombreVista ;
            this.load({params:{start:0, limit:this.tam_pag}});
        }
    },

	}
</script>
		
		