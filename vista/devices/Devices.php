<?php
/**
*@package pXP
*@file gen-Evices.php
*@author  (admin)
*@date 15-06-2017 20:34:33
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Evices=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Evices.superclass.constructor.call(this,config);
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
				name: 'uniqueid',
				fieldLabel: 'uniqueid',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'disp.uniqueid',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'phone',
				fieldLabel: 'phone',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'disp.phone',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'groupid',
				fieldLabel: 'groupid',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'disp.groupid',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'lastupdate',
				fieldLabel: 'lastupdate',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'disp.lastupdate',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'model',
				fieldLabel: 'model',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'disp.model',type:'string'},
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
				filters:{pfiltro:'disp.attributes',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'contact',
				fieldLabel: 'contact',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:512
			},
				type:'TextField',
				filters:{pfiltro:'disp.contact',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'name',
				fieldLabel: 'name',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'disp.name',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'category',
				fieldLabel: 'category',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'disp.category',type:'string'},
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
				filters:{pfiltro:'disp.positionid',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		}
	],
	tam_pag:50,	
	title:'Dispositivos',
	ActSave:'../../sis_rastreo/control/Evices/insertarEvices',
	ActDel:'../../sis_rastreo/control/Evices/eliminarEvices',
	ActList:'../../sis_rastreo/control/Evices/listarEvices',
	id_store:'id',
	fields: [
		{name:'id', type: 'numeric'},
		{name:'uniqueid', type: 'string'},
		{name:'phone', type: 'string'},
		{name:'groupid', type: 'numeric'},
		{name:'lastupdate', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'model', type: 'string'},
		{name:'attributes', type: 'string'},
		{name:'contact', type: 'string'},
		{name:'name', type: 'string'},
		{name:'category', type: 'string'},
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
		
		