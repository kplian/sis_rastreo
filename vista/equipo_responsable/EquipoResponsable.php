<?php
/**
*@package pXP
*@file gen-EquipoResponsable.php
*@author  (admin)
*@date 15-06-2017 17:50:22
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoResponsable=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.EquipoResponsable.superclass.constructor.call(this,config);
		this.bloquearMenus();
        this.init();
        if(Phx.CP.getPagina(this.idContenedorPadre)){
         	var dataMaestro=Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
         	if(dataMaestro){ 
            	this.onEnablePanel(this,dataMaestro)
         	}
        }
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_equipo_responsable'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_equipo'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_responsable',
				fieldLabel: 'Conductor',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_rastreo/control/Responsable/listarResponsable',
					id: 'id_responsable',
					root: 'datos',
					sortInfo: {
						field: 'id_responsable',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_responsable', 'desc_persona'],
					remoteSort: true
				}),
				valueField: 'id_responsable',
				displayField: 'desc_persona',
				gdisplayField: 'desc_responsable',
				hiddenName: 'id_responsable',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_responsable']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'per.nombre_completo1',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'equcon.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_ini',
				fieldLabel: 'Desde',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equcon.fecha_ini',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_fin',
				fieldLabel: 'Hasta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equcon.fecha_fin',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'equcon.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equcon.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'equcon.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equcon.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Conductores',
	ActSave:'../../sis_rastreo/control/EquipoResponsable/insertarEquipoResponsable',
	ActDel:'../../sis_rastreo/control/EquipoResponsable/eliminarEquipoResponsable',
	ActList:'../../sis_rastreo/control/EquipoResponsable/listarEquipoResponsable',
	id_store:'id_equipo_responsable',
	fields: [
		{name:'id_equipo_responsable', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_responsable', type: 'numeric'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_ini', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_equipo', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_responsable'
		
	],
	sortInfo:{
		field: 'id_equipo_responsable',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	loadValoresIniciales: function() {
		Phx.vista.EquipoResponsable.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_equipo').setValue(this.maestro.id_equipo);
	},
	onReloadPage: function(m) {
		this.maestro=m;	
		this.store.baseParams={id_equipo: this.maestro.id_equipo};
		this.load({params:{start:0, limit:this.tam_pag}});	
	}
})
</script>
		
		