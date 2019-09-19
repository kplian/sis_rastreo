<?php
/**
*@package pXP
*@file gen-Grupo.php
*@author  (admin)
*@date 24-07-2017 08:28:12
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Grupo=Ext.extend(Phx.gridInterfaz,{
	auxColor:'',
	constructor:function(config){
		this.maestro=config.maestro;
        this.initButtons = [this.cmbDepto];
    	//llama al constructor de la clase padre
		Phx.vista.Grupo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
        this.cmbDepto.on('select', this.capturaFiltros, this);
		//Agrega paleta de colores
		this.color = new Ext.ColorPalette({
			fieldLabel: 'Color'
		});
		this.form.add(this.color);
		this.color.on('select',function(cmp,val){
			this.auxColor = val;
		},this);
	},
    capturaFiltros: function (combo, record, index) {
        this.store.baseParams = {id_depto: this.cmbDepto.getValue()};
        this.store.reload();
    },
	Atributos:[
		{
			config:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'id_grupo'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'color',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 23,
				maxLength:15,
				renderer: function(value,p,record){
					return String.format("<span style='background-color: {0}'>&nbsp&nbsp&nbsp&nbsp</span>",record.data['color']);
				}
			},
			type:'TextField',
			filters:{pfiltro:'grupo.color',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'grupo.codigo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'Nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
			type:'TextField',
			filters:{pfiltro:'grupo.nombre',type:'string'},
			id_grupo:1,
			grid:true,
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
			filters:{pfiltro:'grupo.estado_reg',type:'string'},
			id_grupo:1,
			grid:true,
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'Field',
			filters:{pfiltro:'grupo.id_usuario_ai',type:'numeric'},
			id_grupo:1,
			grid:false,
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
			filters:{pfiltro:'grupo.fecha_reg',type:'date'},
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
			filters:{pfiltro:'grupo.usuario_ai',type:'string'},
			id_grupo:1,
			grid:true,
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'Field',
			filters:{pfiltro:'grupo.id_usuario_ai',type:'numeric'},
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
			filters:{pfiltro:'grupo.fecha_mod',type:'date'},
			id_grupo:1,
			grid:true,
			form:false
		},
        {
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_depto'
            },
            type:'Field',
            form:true
        }
	],
	tam_pag:50,	
	title:'Grupo',
	ActSave:'../../sis_rastreo/control/Grupo/insertarGrupo',
	ActDel:'../../sis_rastreo/control/Grupo/eliminarGrupo',
	ActList:'../../sis_rastreo/control/Grupo/listarGrupo',
	id_store:'id_grupo',
	fields: [
		{name:'id_grupo', type: 'numeric'},
		{name:'codigo', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'color', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'usuario_ai', type: 'string'},
        {name:'id_depto', type: 'numeric'}

	],
	sortInfo:{
		field: 'id_grupo',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    cmbDepto : new Ext.form.ComboBox({
        name : 'id_depto',
        fieldLabel : 'Depto',
        typeAhead : false,
        forceSelection : true,
        allowBlank : false,
        disableSearchButton : true,
        emptyText : 'Depto Rastreo',
        store : new Ext.data.JsonStore({
            url : '../../sis_parametros/control/Depto/listarDeptoFiltradoDeptoUsuario',
            id : 'id_depto',
            root : 'datos',
            sortInfo : {
                field : 'deppto.nombre',
                direction : 'ASC'
            },
            totalProperty : 'total',
            fields : ['id_depto', 'nombre', 'codigo'],
            // turn on remote sorting
            remoteSort : true,
            baseParams : {
                par_filtro : 'deppto.nombre#deppto.codigo',
                estado : 'activo',
                codigo_subsistema : 'RAS'
            }
        }),
        valueField : 'id_depto',
        displayField : 'nombre',
        hiddenName : 'id_depto',
        //enableMultiSelect : true,
        triggerAction : 'all',
        lazyRender : true,
        mode : 'remote',
        pageSize : 20,
        queryDelay : 200,
        anchor : '80%',
        listWidth : '200',
        resizable : true,
        minChars : 2
    }),
	agregarArgsExtraSubmit: function(){
		this.argumentExtraSubmit={};
		this.argumentExtraSubmit.color=this.auxColor;
	},
    onButtonNew: function() {

        if(!this.cmbDepto.getValue()){
            alert("Seleccione un Depto");
        }
        else{
            this.window.buttons[0].show();
            this.form.getForm().reset();
            this.loadValoresIniciales();
            this.window.show();
            if(this.getValidComponente(0)){
                this.getValidComponente(0).focus(false,100);
            }
        }
    },
    onButtonEdit: function() {
        if(!this.cmbDepto.getValue()){
            alert("Seleccione un Depto");
        }
        else{
            var sel = this.sm.getSelected();
            Phx.vista.Grupo.superclass.onButtonEdit.call(this);
            this.color.select(sel.data.color);
        }
    },
    loadValoresIniciales: function () {
        Phx.vista.Grupo.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_depto').setValue(this.cmbDepto.getValue());
    }


});
</script>
		
		