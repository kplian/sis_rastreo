<?php
/**
*@package pXP
*@file gen-Events.php
*@author  (admin)
*@date 15-06-2017 20:34:28
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Events=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Events.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'geofenceid',
				fieldLabel: 'geofenceid',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'event.geofenceid',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'deviceid',
				fieldLabel: 'deviceid',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'event.deviceid',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'servertime',
				fieldLabel: 'servertime',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'event.servertime',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'attributes',
				fieldLabel: 'attributes',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4000
			},
				type:'TextField',
				filters:{pfiltro:'event.attributes',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'type',
				fieldLabel: 'type',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'event.type',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'positionid',
				fieldLabel: 'positionid',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'event.positionid',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		}
	],
	tam_pag:50,	
	title:'Eventos',
	ActSave:'../../sis_rastreo/control/Events/insertarEvents',
	ActDel:'../../sis_rastreo/control/Events/eliminarEvents',
	ActList:'../../sis_rastreo/control/Events/listarEvents',
	id_store:'id',
	fields: [
		{name:'id', type: 'numeric'},
		{name:'geofenceid', type: 'numeric'},
		{name:'deviceid', type: 'numeric'},
		{name:'servertime', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'attributes', type: 'string'},
		{name:'type', type: 'string'},
		{name:'positionid', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>