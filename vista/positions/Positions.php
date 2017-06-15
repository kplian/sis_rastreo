<?php
/**
*@package pXP
*@file gen-Positions.php
*@author  (admin)
*@date 15-06-2017 20:34:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Positions=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Positions.superclass.constructor.call(this,config);
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
				name: 'address',
				fieldLabel: 'address',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:512
			},
				type:'TextField',
				filters:{pfiltro:'posic.address',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'devicetime',
				fieldLabel: 'devicetime',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'posic.devicetime',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'accuracy',
				fieldLabel: 'accuracy',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.accuracy',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'course',
				fieldLabel: 'course',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.course',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'altitude',
				fieldLabel: 'altitude',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.altitude',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'protocol',
				fieldLabel: 'protocol',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'posic.protocol',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'speed',
				fieldLabel: 'speed',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.speed',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'network',
				fieldLabel: 'network',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4000
			},
				type:'TextField',
				filters:{pfiltro:'posic.network',type:'string'},
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
				filters:{pfiltro:'posic.servertime',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'longitude',
				fieldLabel: 'longitude',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.longitude',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'valid',
				fieldLabel: 'valid',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100
			},
				type:'Checkbox',
				filters:{pfiltro:'posic.valid',type:'boolean'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'deviceid',
				fieldLabel: 'deviceid',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'posic.deviceid',type:'numeric'},
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
				filters:{pfiltro:'posic.attributes',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'latitude',
				fieldLabel: 'latitude',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'posic.latitude',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fixtime',
				fieldLabel: 'fixtime',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'posic.fixtime',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		}
	],
	tam_pag:50,	
	title:'Posiciones',
	ActSave:'../../sis_rastreo/control/Positions/insertarPositions',
	ActDel:'../../sis_rastreo/control/Positions/eliminarPositions',
	ActList:'../../sis_rastreo/control/Positions/listarPositions',
	id_store:'id',
	fields: [
		{name:'id', type: 'numeric'},
		{name:'address', type: 'string'},
		{name:'devicetime', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'accuracy', type: 'string'},
		{name:'course', type: 'string'},
		{name:'altitude', type: 'string'},
		{name:'protocol', type: 'string'},
		{name:'speed', type: 'string'},
		{name:'network', type: 'string'},
		{name:'servertime', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'longitude', type: 'string'},
		{name:'valid', type: 'boolean'},
		{name:'deviceid', type: 'numeric'},
		{name:'attributes', type: 'string'},
		{name:'latitude', type: 'string'},
		{name:'fixtime', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
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
		
		