<?php
/**
*@package pXP
*@file gen-Localizacion.php
*@author  (admin)
*@date 15-06-2017 17:50:13
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
	Phx.vista.Localizacion = Ext.extend(Phx.arbInterfaz, {
		constructor : function(config) {
			this.maestro = config.maestro;
			Phx.vista.Localizacion.superclass.constructor.call(this, config);
			this.init();
		},
		Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_localizacion'
			},
			type:'Field',
			form:true 
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
				filters:{pfiltro:'local.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:150
			},
				type:'TextField',
				filters:{pfiltro:'local.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'codigo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:30
			},
				type:'TextField',
				filters:{pfiltro:'local.codigo',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'latitud',
				fieldLabel: 'latitud',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'local.latitud',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'longitud',
				fieldLabel: 'longitud',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:8
			},
				type:'TextField',
				filters:{pfiltro:'local.longitud',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'id_localizacion_fk',
				fieldLabel: 'id_localizacion_fk',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_/control/Clase/Metodo',
					id: 'id_',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
				}),
				valueField: 'id_',
				displayField: 'nombre',
				gdisplayField: 'desc_',
				hiddenName: 'id_localizacion_fk',
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
					return String.format('{0}', record.data['desc_']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'movtip.nombre',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'local.fecha_reg',type:'date'},
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
				filters:{pfiltro:'local.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
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
				filters:{pfiltro:'local.usuario_ai',type:'string'},
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
				filters:{pfiltro:'local.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
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
		}
	],
		title:'Areas',
	ActSave:'../../sis_rastreo/control/Localizacion/insertarLocalizacion',
	ActDel:'../../sis_rastreo/control/Localizacion/eliminarLocalizacion',
	ActList:'../../sis_rastreo/control/Localizacion/listarLocalizacion',
	id_store:'id_localizacion',
		textRoot : 'Áreas',
		id_nodo : 'id_localizacion',
		id_nodo_p : 'id_localizacion_fk',
		idNodoDD : 'id_localizacion',
		idOldParentDD : 'id_localizacion_fk',
		idTargetDD : 'id_localizacion',
		enableDD : true,
	fields: [
		{name:'id_localizacion', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'codigo', type: 'string'},
		{name:'latitud', type: 'string'},
		{name:'longitud', type: 'string'},
		{name:'id_localizacion_fk', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
	],
		sortInfo : {
			field : 'id_localizacion',
			direction : 'ASC'
		},
		bdel : true,
		bsave : false,
		bexcel : false,
		rootVisible : true,
		fwidth : 420,
		fheight : 300,
		onNodeDrop : function(o) {
		    this.ddParams = {
		        tipo_nodo : o.dropNode.attributes.tipo_nodo
		    };
		    this.idTargetDD = 'id_localizacion';
		    if (o.dropNode.attributes.tipo_nodo == 'raiz' || o.dropNode.attributes.tipo_nodo == 'hijo') {
		        this.idNodoDD = 'id_localizacion';
		        this.idOldParentDD = 'id_localizacion_fk';
		    } else if(o.dropNode.attributes.tipo_nodo == 'item') {
		        this.idNodoDD = 'id_item';
                this.idOldParentDD = 'id_p';
		    }
		    Phx.vista.Localizacion.superclass.onNodeDrop.call(this, o);
		},
		getNombrePadre : function(n) {
			var direc;
			var padre = n.parentNode;
			if (padre) {
				if (padre.attributes.id != 'id') {
					direc = n.attributes.nombre + ' - ' + this.getNombrePadre(padre);
					return direc;
				} else {
					return n.attributes.nombre;
				}
			} else {
				return undefined;
			}
		},
		successSave : function(resp) {
			Phx.vista.Localizacion.superclass.successSave.call(this, resp);
			var selectedNode = this.sm.getSelectedNode();
			if(selectedNode){
				selectedNode.attributes.estado = 'restringido';	
			}
		},
		successBU : function(resp) {
			Phx.CP.loadingHide();
			var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
			if (!reg.ROOT.error) {
				alert(reg.ROOT.detalle.mensaje)
			} else {
				alert('ocurrio un error durante el proceso')
			}
			resp.argument.node.reload();
		},
		east: {
			url: '../../../sis_kactivos_fijos/vista/equipo/Equipo.php',
			title: 'Vehículos',
			width: '30%',
			cls: 'Equipo'
		}
	}); 
</script>