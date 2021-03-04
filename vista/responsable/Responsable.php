<?php
/**
*@package pXP
*@file gen-Responsable.php
*@author  (admin)
*@date 15-06-2017 17:50:03
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
  ISSUE			FECHA			AUTHOR 					DESCRIPCION
 *#GDV-35       02/03/2020      EGS                     Se modifica codigo
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Responsable=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Responsable.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_responsable'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'codigo',//#GDV-35
				fieldLabel: 'Código',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'conduc.codigo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},

        {
            config:{
                name:'id_persona',
                fieldLabel:'Nombre completo',
                allowBlank:false,
                emptyText:'Persona...',
                store: new Ext.data.JsonStore({

                    url: '../../sis_seguridad/control/Persona/listarPersona',
                    id: 'id_persona',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre_completo1',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_persona','nombre_completo1','ci'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'p.nombre_completo1#p.ci'}
                }),
                valueField: 'id_persona',
                displayField: 'nombre_completo1',
                gdisplayField:'desc_person',//mapea al store del grid
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombre_completo1}</p><p>CI:{ci}</p> </div></tpl>',
                hiddenName: 'id_persona',
                forceSelection:true,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:10,
                queryDelay:1000,
                width:250,
                gwidth:280,
                minChars:2,
                turl:'../../../sis_rastreo/vista/responsable/PersonaConductor.php',
                ttitle:'Personas',
                // tconfig:{width:1800,height:500},
                tdata:{nombreVista:'Conductores'},
                tcls:'PersonaConductor',
                pid:this.idContenedor,

                renderer:function (value, p, record){return String.format('{0}', record.data['desc_persona']);}
            },
            type:'TrigguerCombo',
            bottom_filter:true,
            id_grupo:0,
            filters:{
                pfiltro:'nombre_completo1',
                type:'string'
            },

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
				filters:{pfiltro:'conduc.estado_reg',type:'string'},
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'conduc.usuario_ai',type:'string'},
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
				filters:{pfiltro:'conduc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'conduc.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'conduc.fecha_mod',type:'date'},
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
	tam_pag:50,	
	title:'Conductores',
	ActSave:'../../sis_rastreo/control/Responsable/insertarResponsable',
	ActDel:'../../sis_rastreo/control/Responsable/eliminarResponsable',
	ActList:'../../sis_rastreo/control/Responsable/listarResponsable',
	id_store:'id_responsable',
	fields: [
		{name:'id_responsable', type: 'numeric'},
		{name:'id_persona', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'codigo', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_persona',
        {name:'cod_funcionario', type: 'string'}
		
	],
	sortInfo:{
		field: 'id_responsable',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	south: {
		url:'../../../sis_rastreo/vista/licencia/Licencia.php',
		title:'Licencias', 
		height:'50%',	//altura de la ventana hijo
		cls:'Licencia'
	}
})
</script>
		
		