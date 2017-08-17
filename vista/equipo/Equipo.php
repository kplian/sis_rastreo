<?php
/**
*@package pXP
*@file gen-Equipo.php
*@author  (admin)
*@date 15-06-2017 17:50:17
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Equipo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Equipo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});

		//Eventos
		this.Cmp.id_marca.on('select',function(combo,record,index){
			this.Cmp.id_modelo.setValue('');
			this.Cmp.id_modelo.store.baseParams.id_marca = this.Cmp.id_marca.getValue();
            this.Cmp.id_modelo.modificado=true;
		},this);
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'id_equipo'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'id_localizacion'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				fieldLabel: '',
				renderer: function(value, p, record) {
					return String.format("<span style='background-color: {0}'>&nbsp&nbsp&nbsp&nbsp</span>",record.data['color_grupo']);
				},
				gwidth: 23
			},
			type: 'Field',
			grid: true,
			form: false
		},
		{
			config: {
				name: 'id_tipo_equipo',
				fieldLabel: 'Tipo',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_rastreo/control/TipoEquipo/listarTipoEquipo',
					id: 'id_tipo_equipo',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_equipo', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'tipveh.nombre#tipveh.codigo'}
				}),
				valueField: 'id_tipo_equipo',
				displayField: 'nombre',
				gdisplayField: 'desc_tipo_equipo',
				hiddenName: 'id_tipo_equipo',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 130,
				minChars: 2,
				renderer : function(value, p, record) {
					return '<tpl for="."><div class="x-combo-list-item">\
								<p><b>Tipo: </b>'+record.data['desc_tipo_equipo']+'</p>\
								<p><b>Marca: </b>'+record.data['desc_marca']+'</p>\
								<p><b>Modelo: </b>'+record.data['desc_modelo']+'</p>\
								<p><b>Año: </b>'+record.data['gestion']+'\
							</p></div></tpl>';
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'equip.tipo_equipo',type: 'string'},
			grid: true,
			form: true,
			bottom_filter:true
		},
		{
			config:{
				name: 'placa',
				fieldLabel: 'Descripción',
				allowBlank: false,
				anchor: '100%',
				gwidth: 150,
				maxLength:20,
				renderer: function(value,p,record){
					return '<tpl for="."><div class="x-combo-list-item">\
								<p><b>Placa: </b>'+record.data['placa']+'</p>\
								<p><b>PTA: </b>'+record.data['pta']+'</p>\
								<p><b>Nro.Chasis: </b>'+record.data['nro_chasis']+'\
								<p><b>IMEI: </b>'+record.data['uniqueid']+'\
							</p></div></tpl>';
				}
			},
				type:'TextField',
				filters:{pfiltro:'equip.placa',type:'string'},
				id_grupo:1,
				grid:true,
				form:false,
				bottom_filter:true
		},
		{
			config:{
				name: 'ultimo_envio',
				fieldLabel: 'Última Sincronización',
				allowBlank: false,
				anchor: '100%',
				gwidth: 200,
				maxLength:128,
				renderer: function(value,p,record){
					var icon='wifi1.png';
					if(record.data['type']=='deviceOffline'||record.data['type']=='deviceUnknown'){
						icon='nowifi2.png';
					}
					return	'<tpl for=".">\
								<table>\
								  <tr>\
								    <th style="vertical-align:middle;">\
										<img src=\'../../../lib/imagenes/'+icon+'\' width=32 height=32>\
								    </th>\
								    <th>\
								    	<div class="x-combo-list-item" style="font-size: x-small">\
											<p><b>Fecha Ult. Sinc.: </b> '+record.data['ultimo_envio']+'</p>\
										</div>\
								    </th>\
								  </tr>\
								</table>\
							</tpl>';
					/*return	'<tpl for=".">\
								<table>\
								  <tr>\
								    <th style="vertical-align:middle;">\
										<img src=\'../../../lib/imagenes/'+icon+'\' width=32 height=32>\
								    </th>\
								    <th>\
								    	<div class="x-combo-list-item" style="font-size: x-small">\
											<p><b>Fecha Ult. Sinc.: </b> '+record.data['ultimo_envio']+'</p>\
											<p><b>Conductor: </b>'+record.data['responsable']+'</p>\
											<p><b>Evento: </b>'+record.data['desc_type']+'</p>\
										</div>\
								    </th>\
								  </tr>\
								</table>\
							</tpl>';*/
				}
			},
				type:'TextField',
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config: {
				name: 'id_marca',
				fieldLabel: 'Marca',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_rastreo/control/Marca/listarMarca',
					id: 'id_marca',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_marca', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'marca.nombre#marca.codigo'}
				}),
				valueField: 'id_marca',
				displayField: 'nombre',
				gdisplayField: 'desc_marca',
				hiddenName: 'id_marca',
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
					return String.format('{0}', record.data['desc_marca']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'equip.marca',type: 'string'},
			grid: false,
			form: true,
			bottom_filter:true
		},
		{
			config: {
				name: 'id_modelo',
				fieldLabel: 'Modelo',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_rastreo/control/Modelo/listarModelo',
					id: 'id_modelo',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_modelo', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'model.nombre#model.codigo',id_marca:'-1'}
				}),
				valueField: 'id_modelo',
				displayField: 'nombre',
				gdisplayField: 'desc_modelo',
				hiddenName: 'id_modelo',
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
					return String.format('{0}', record.data['desc_modelo']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'equip.modelo',type: 'string'},
			grid: false,
			form: true,
			bottom_filter:true
		},
		{
			config:{
				name: 'gestion',
				fieldLabel: 'Año',
				allowBlank: false,
				anchor: '30%',
				gwidth: 100,
				maxLength:4,
				maxValue: 2050,
				minValue: 1900
			},
				type:'NumberField',
				filters:{pfiltro:'equip.gestion',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:true
		},
		{
			config:{
				name: 'placa',
				fieldLabel: 'Placa',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'equip.placa',type:'string'},
				id_grupo:1,
				grid:false,
				form:true
		},
		{
			config:{
				name: 'uniqueid',
				fieldLabel: 'IMEI',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:128
			},
				type:'TextField',
				filters:{pfiltro:'equip.uniqueid',type:'string'},
				id_grupo:1,
				grid:false,
				form:true,
				bottom_filter:true
		},
		{
			config:{
				name: 'nro_movil',
				fieldLabel: 'Nro.Móvil',
				allowBlank: false,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.nro_movil',type:'string'},
				id_grupo:1,
				grid:true,
				form:true,
				bottom_filter:true
		},
		{
			config:{
				name: 'nro_celular',
				fieldLabel: 'Nro.Celular GPS',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.nro_celular',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'id_grupo',
				fieldLabel: 'Grupo',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_rastreo/control/Grupo/listarGrupo',
					id: 'id_grupo',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_grupo', 'nombre', 'codigo','color'],
					remoteSort: true,
					baseParams: {par_filtro: 'grupo.nombre#grupo.codigo'}
				}),
				valueField: 'id_grupo',
				displayField: 'nombre',
				gdisplayField: 'desc_grupo',
				hiddenName: 'id_grupo',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 130,
				minChars: 2,
				tpl:'<tpl for="."><div class="x-combo-list-item">Código: {codigo}<p>Nombre: <span style="background-color: {color}">&nbsp&nbsp&nbsp&nbsp</span> {nombre}</p> </div></tpl>',
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'equip.desc_grupo',type: 'string'},
			grid: true,
			form: true,
			bottom_filter: true
		},
		{
			config:{
				name: 'monto',
				fieldLabel: 'Monto (Bs.)',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:1179650
			},
				type:'NumberField',
				filters:{pfiltro:'equip.monto',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'pta',
				fieldLabel: 'PTA',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.pta',type:'string'},
				id_grupo:1,
				grid:false,
				form:true
		},
		{
			config:{
				name: 'nro_chasis',
				fieldLabel: 'Nro.Chasis',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.nro_chasis',type:'string'},
				id_grupo:1,
				grid:false,
				form:true
		},
		{
			config:{
				name: 'nro_motor',
				fieldLabel: 'Nro.Motor',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.nro_motor',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cilindrada',
				fieldLabel: 'Cilindrada(cc)',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:1179650
			},
				type:'NumberField',
				filters:{pfiltro:'equip.cilindrada',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'cabina',
				fieldLabel: 'Cabina',
				anchor: '100%',
				tinit: false,
				allowBlank: true,
				origen: 'CATALOGO',
				gdisplayField: 'cabina',
				hiddenName: 'cabina',
				gwidth: 55,
				baseParams:{
					cod_subsistema:'RAS',
					catalogo_tipo:'tequipo__cabina'
				},
				valueField: 'codigo'
			},
			type: 'ComboRec',
			id_grupo: 0,
			filters:{pfiltro:'equip.cabina',type:'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'traccion',
				fieldLabel: 'Tracción',
				anchor: '100%',
				tinit: false,
				allowBlank: true,
				origen: 'CATALOGO',
				gdisplayField: 'traccion',
				hiddenName: 'traccion',
				gwidth: 55,
				baseParams:{
					cod_subsistema:'RAS',
					catalogo_tipo:'tequipo__traccion'
				},
				valueField: 'codigo'
			},
			type: 'ComboRec',
			id_grupo: 0,
			filters:{pfiltro:'equip.traccion',type:'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'color',
				fieldLabel: 'Color',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.color',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'propiedad',
				fieldLabel: 'Propiedad',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'equip.propiedad',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:15
			},
				type:'TextField',
				filters:{pfiltro:'equip.estado',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_alta',
				fieldLabel: 'Fecha Alta',
				allowBlank: true,
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equip.fecha_alta',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_baja',
				fieldLabel: 'Fecha Baja',
				allowBlank: true,
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equip.fecha_baja',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'equip.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'equip.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equip.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '100%',
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'equip.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '100%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'equip.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '100%',
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
	tam_pag:50,	
	title:'Vehiculos',
	ActSave:'../../sis_rastreo/control/Equipo/insertarEquipo',
	ActDel:'../../sis_rastreo/control/Equipo/eliminarEquipo',
	ActList:'../../sis_rastreo/control/Equipo/listarEquipo',
	id_store:'id_equipo',
	fields: [
		{name:'id_equipo', type: 'numeric'},
		{name:'id_tipo_equipo', type: 'numeric'},
		{name:'id_modelo', type: 'numeric'},
		{name:'id_localizacion', type: 'numeric'},
		{name:'nro_motor', type: 'string'},
		{name:'placa', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'nro_movil', type: 'string'},
		{name:'fecha_alta', type: 'date',dateFormat:'Y-m-d'},
		{name:'cabina', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'propiedad', type: 'string'},
		{name:'nro_chasis', type: 'string'},
		{name:'cilindrada', type: 'numeric'},
		{name:'color', type: 'string'},
		{name:'pta', type: 'string'},
		{name:'traccion', type: 'string'},
		{name:'gestion', type: 'numeric'},
		{name:'fecha_baja', type: 'date',dateFormat:'Y-m-d'},
		{name:'monto', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_tipo_equipo','id_marca','desc_modelo','desc_marca','uniqueid','deviceid','ultimo_envio',
		'latitude','longitude','speed','attributes','address','desc_type','desc_equipo','responsable','type','id_grupo','desc_grupo','color_grupo','nro_celular'
		
	],
	sortInfo:{
		field: 'id_equipo',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		