<?php
/****************************************************************************************
*@package pXP
*@file gen-AsigVehiculoIncidencia.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:29
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                09-07-2020 13:52:29    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AsigVehiculoIncidencia=Ext.extend(Phx.gridInterfaz,{
    tam_pag: 50,
    bottom_filter: true,
    egrid: false,
    tipoStore: 'GroupingStore',//GroupingStore o JsonStore
    remoteGroup: true,
    groupField:'desc_incidencia_agrupador',
    viewGrid: new Ext.grid.GroupingView({
        forceFit:false,
        //groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
    }),

    constructor:function(config){
        this.maestro=config.maestro;
        console.log('m',this.maestro);
        this.Atributos[1].valorInicial=this.maestro.id_asig_vehiculo;
        //this.Atributos[this.getIndAtributo('id_asig_vehiculo')].valorInicial = this.maestro.id_asig_vehiculo;
        //llama al constructor de la clase padre
        Phx.vista.AsigVehiculoIncidencia.superclass.constructor.call(this,config);
        this.init();
        this.iniciarEventos();
        this.load({params:{start:0, limit:this.tam_pag, id_asig_vehiculo:this.maestro.id_asig_vehiculo}})
    },
    iniciarEventos:function(){
        this.Cmp.id_asig_vehiculo.setValue(this.maestro.id_asig_vehiculo);

    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_asig_vehiculo_incidedencia'
            },
            type:'Field',
            form:true 
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_asig_vehiculo'
            },
            type:'Field',
            form:true
        },

        {
            config: {
                name: 'id_incidencia',
                fieldLabel: 'Incidencia',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/Incidencia/listarIncidencia',
                    id: 'id_incidencia',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_incidencia', 'nombre','desc_agrupador'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'inciden.nombre',combo:'si'}
                }),
                tpl:'<tpl for=".">\ <div class="x-combo-list-item"><p><b>Desc. Agrupador: </b>{desc_agrupador}</p>\
                               <p><b>Nombre: </b>{nombre}</p>\
                               </div></tpl>',
                valueField: 'id_incidencia',
                displayField: 'nombre',
                gdisplayField: 'desc_incidencia',
                hiddenName: 'id_incidencia',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 300,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_incidencia']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            grid: true,
            form: true
        },
        {
            config:{
                name: 'observacion',
                fieldLabel: 'observacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 300,
            	maxLength:500
            },
                type:'TextArea',
                filters:{pfiltro:'asinci.observacion',type:'string'},
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
            filters:{pfiltro:'asinci.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        {
            config:{
                name: 'desc_incidencia_agrupador',
                fieldLabel: 'Desc Agrupador',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:300
            },
            type:'TextField',
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
                name: 'fecha_reg',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'asinci.fecha_reg',type:'date'},
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
                filters:{pfiltro:'asinci.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
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
                filters:{pfiltro:'asinci.usuario_ai',type:'string'},
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
                filters:{pfiltro:'asinci.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Asignacion de Incidencias',
    ActSave:'../../sis_rastreo/control/AsigVehiculoIncidencia/insertarAsigVehiculoIncidencia',
    ActDel:'../../sis_rastreo/control/AsigVehiculoIncidencia/eliminarAsigVehiculoIncidencia',
    ActList:'../../sis_rastreo/control/AsigVehiculoIncidencia/listarAsigVehiculoIncidencia',
    id_store:'id_asig_vehiculo_incidedencia',
    fields: [
		{name:'id_asig_vehiculo_incidedencia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_asig_vehiculo', type: 'numeric'},
		{name:'id_incidencia', type: 'numeric'},
		{name:'observacion', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_incidencia', type: 'string'},
        {name:'desc_incidencia_agrupador', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_asig_vehiculo_incidedencia',
        direction: 'ASC'
    },
    bdel:true,
    bsave:false
    }
)
</script>
        
        