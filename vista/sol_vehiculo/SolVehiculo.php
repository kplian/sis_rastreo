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
Phx.vista.SolVehiculo={
	require:'../../../sis_rastreo/vista/sol_vehiculo/SolVehiculoBase.php',
	requireclase:'Phx.vista.SolVehiculoBase',
	title:'SolVehiculo',
	nombreVista: 'SolVehiculo',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.SolVehiculo.superclass.constructor.call(this,config);
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
        this.addButton('btnSolAutorizacion', {
            text : 'Sol. Autorizacion ',
            iconCls : 'bexecdb',
            disabled : false,
            handler : this.openSolAuto,
            tooltip : '<b>Autorizacion</b>'
        });
	},
    openSolAuto: function(){
        var data = this.getSelectedData();
        var win = Phx.CP.loadWindows(
            '../../../sis_rastreo/vista/sol_vehiculo/FormSolAuto.php',
            'Autorizacion', {
                width: '50%',
                height: '50%'
            },
            {maestro:data},
            this.idContenedor,
            'FormSolAuto'
        );
    },
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.SolVehiculo.superclass.preparaMenu.call(this,n);
        this.getBoton('diagrama_gantt').enable();
		this.getBoton('btnChequeoDocumentosWf').enable();

         if (data.estado == 'borrador') {
         	this.getBoton('ant_estado').disable();
    		this.getBoton('sig_estado').enable();
         }else {
             if(data.estado == ('autorizado')){
                 this.getBoton('ant_estado').enable();
                 this.getBoton('sig_estado').disable();
             }else{
                 this.getBoton('ant_estado').disable();
                 this.getBoton('sig_estado').disable();
             }
         };
         return tb 
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.SolVehiculo.superclass.liberaMenu.call(this);
        if(tb){
			this.getBoton('btnChequeoDocumentosWf').disable();          
            this.getBoton('diagrama_gantt').disable();
            this.getBoton('ant_estado').disable();
    		this.getBoton('sig_estado').disable();  
        }
       return tb
    },
    onButtonNew: function() {
        Phx.vista.SolVehiculo.superclass.onButtonNew.call(this);
        this.Cmp.fecha_sol.setValue(new Date());
        this.Cmp.fecha_sol.disable();
        this.Cmp.id_funcionario.store.baseParams.fecha = this.Cmp.fecha_sol.getValue().dateFormat(this.Cmp.fecha_sol.format);
        this.Cmp.id_funcionario.store.baseParams.query = Phx.CP.config_ini.id_funcionario;
        this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {

                    this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                }

            }, scope : this
        });
        this.Cmp.id_funcionario.enable();
        this.obtenerGestion(this.Cmp.fecha_sol.getValue());

    },
    onButtonEdit: function() {
        var data = this.getSelectedData();
        console.log('data',data);
        Phx.vista.SolVehiculo.superclass.onButtonEdit.call(this);
        this.Cmp.fecha_sol.setValue(new Date());
        this.Cmp.fecha_sol.disable();
        this.Cmp.id_funcionario.store.baseParams.fecha = this.Cmp.fecha_sol.getValue().dateFormat(this.Cmp.fecha_sol.format);
        this.obtenerGestion(this.Cmp.fecha_sol.getValue());
        this.Cmp.id_centro_costo.store.baseParams.query = data.id_centro_costo;
        this.Cmp.id_centro_costo.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {

                    this.Cmp.id_centro_costo.setValue(r[0].data.id_centro_costo);
                }

            }, scope : this
        });
    },
    tabsouth: [{
        url: '../../../sis_rastreo/vista/nomina_persona/NominaPersona.php',
        title: 'Nomina Personas',
        height: '40%',
        cls: 'NominaPersona'
    },{
        url: '../../../sis_rastreo/vista/asig_vehiculo/AsigVehiculoVoBo.php',
        title: 'Vehiculos Asignados',
        height: '50%',
        cls: 'AsigVehiculoVoBo'
    }],
    bsave:false,
    obtenerGestion: function (fecha) {
        Phx.CP.loadingShow();
        Ext.Ajax.request({
            url: '../../sis_parametros/control/Gestion/obtenerGestionByFecha',
            params: {fecha: fecha},
            success: this.successGestion,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
    },
    successGestion: function (resp) {
        Phx.CP.loadingHide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        if (!reg.ROOT.error) {
            this.Cmp.id_centro_costo.store.baseParams.id_gestion = reg.ROOT.datos.id_gestion;
        } else {
            alert('Lo sentimos, no fue posible completar la obtenci&oacute;n de la gesti&oacute;n')
        }
    },
	}
</script>
		
		