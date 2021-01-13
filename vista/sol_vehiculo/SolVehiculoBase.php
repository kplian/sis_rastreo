<?php
/****************************************************************************************
*@package pXP
*@file gen-SolVehiculo.php
*@author  (egutierrez)
*@date 02-07-2020 22:13:48
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                02-07-2020 22:13:48    egutierrez            Creacion    
 #GDV-29              29/12/2020            EGS                 Añadiendo campo deexiste conductores

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SolVehiculoBase=Ext.extend(Phx.gridInterfaz,{
    fheight:'70%',
    fwidth: '70%',

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.SolVehiculoBase.superclass.constructor.call(this,config);
        this.addBotonesGantt();
        this.init();
        this.iniciarEventos();
        this.load({params:{start:0, limit:this.tam_pag}});
        this.addButton('btnChequeoDocumentosWf',
            {
                text: 'Documentos',
                grupo:[0,1,2,3,4],
                iconCls: 'bchecklist',
                disabled: true,
                handler: this.loadCheckDocumentosWf,
                tooltip: '<b>Documentos </b><br/>Permite ver los documentos asociados al NRO de trámite.'
            });
    },
    iniciarEventos:function(){

    },

    loadCheckDocumentosWf:function() {
        var rec=this.sm.getSelected();
        rec.data.nombreVista = this.nombreVista;
        Phx.CP.loadWindows('../../../sis_workflow/vista/documento_wf/DocumentoWf.php',
            'Documentos del Proceso',
            {
                width:'90%',
                height:500
            },
            rec.data,
            this.idContenedor,
            'DocumentoWf'
        )},
    addBotonesGantt: function() {
        this.menuAdqGantt = new Ext.Toolbar.SplitButton({
            id: 'b-diagrama_gantt-' + this.idContenedor,
            text: 'Gantt',
            disabled: true,
            grupo:[0,1,2,3,4],
            iconCls : 'bgantt',
            handler:this.diagramGanttDinamico,
            scope: this,
            menu:{
                items: [{
                    id:'b-gantti-' + this.idContenedor,
                    text: 'Gantt Imagen',
                    tooltip: '<b>Muestra un reporte gantt en formato de imagen</b>',
                    handler:this.diagramGantt,
                    scope: this
                }, {
                    id:'b-ganttd-' + this.idContenedor,
                    text: 'Gantt Dinámico',
                    tooltip: '<b>Muestra el reporte gantt facil de entender</b>',
                    handler:this.diagramGanttDinamico,
                    scope: this
                }]
            }
        });
        this.tbar.add(this.menuAdqGantt);
    },
    diagramGantt: function (){
        var data=this.sm.getSelected().data.id_proceso_wf;

        Phx.CP.loadingShow();
        Ext.Ajax.request({
            url:'../../sis_workflow/control/ProcesoWf/diagramaGanttTramite',
            params:{'id_proceso_wf':data},
            success: this.successExport,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
    },

    diagramGanttDinamico: function (){
        var data=this.sm.getSelected().data.id_proceso_wf;

        window.open('../../../sis_workflow/reportes/gantt/gantt_dinamico.html?id_proceso_wf='+data)
    },


    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_sol_vehiculo'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name: 'fecha_sol',
                fieldLabel: 'Fecha Solicitud',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'solvehi.fecha_sol',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name:'id_funcionario',
                hiddenName: 'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Funcionario Solicitante',
                allowBlank:true,
                anchor: '80%',
                gwidth: 100,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario',
                baseParams: {par_filtro: 'id_funcionario#desc_funcionario1'},
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            bottom_filter:false,
            grid:true,
            form:true,
            bottom_filter:true
        },

        //
        // {
        //     config:{
        //         name: 'ceco_clco',
        //         fieldLabel: 'ceco_clco',
        //         allowBlank: true,
        //         anchor: '80%',
        //         gwidth: 100,
        //     	maxLength:50
        //     },
        //         type:'TextField',
        //         filters:{pfiltro:'solvehi.ceco_clco',type:'string'},
        //         id_grupo:1,
        //         grid:false,
        //         form:false
		// },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'ceco_clco'
            },
            type:'Field',
            form:true
        },
        {
            config:{
                name:'id_centro_costo',
                origen:'CENTROCOSTO',
                fieldLabel: 'Centro de Costos',
                url: '../../sis_parametros/control/CentroCosto/listarCentroCostoCombo',
                emptyText : 'Centro Costo...',
                allowBlank:true,
                gdisplayField:'desc_centro_costo',//mapea al store del grid
                anchor: '80%',
                gwidth: 100,
               // baseParams:{filtrar:'grupo_ep'},
                renderer:function (value, p, record){return String.format('{0}', record.data['desc_centro_costo']);}
            },
            type:'ComboRec',
            id_grupo:0,
            filters:{pfiltro:'cc.codigo_cc',type:'string'},
            grid:true,
            form:true
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_proceso_wf'
            },
            type:'Field',
            form:true,
        },
        {
            config:{
                name: 'fecha_salida',
                fieldLabel: 'Fecha Salida',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'solvehi.fecha_salida',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
         {
            config:{
                name: 'hora_salida',
                fieldLabel: 'Hora Salida',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:8,
                format: 'H:i:s',
                minValue: '5:00',
                maxValue: '21:00',
            },
                type:'TimeField',
                filters:{pfiltro:'solvehi.hora_salida',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},

        {
            config:{
                name: 'nro_tramite',
                fieldLabel: 'Nro Tramite',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:-5
            },
                type:'TextField',
                filters:{pfiltro:'solvehi.nro_tramite',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_estado_wf'
            },
            type:'Field',
            form:true

        },
        {
            config:{
                name: 'fecha_retorno',
                fieldLabel: 'Fecha Retorno',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
            type:'DateField',
            filters:{pfiltro:'solvehi.fecha_retorno',type:'date'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'hora_retorno',
                fieldLabel: 'Hora Retorno',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:8,
                format: 'H:i:s',
                minValue: '5:00',
                maxValue: '21:00',
            },
                type:'TimeField',
                filters:{pfiltro:'solvehi.hora_retorno',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},

        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_funcionario_jefe_depto'
            },
            type:'Field',
            form:true,
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
                filters:{pfiltro:'solvehi.estado_reg',type:'string'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'destino',
                fieldLabel: 'Destino',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:100
            },
                type:'TextField',
                filters:{pfiltro:'solvehi.destino',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},

        {
            config: {
                name: 'id_tipo_equipo',
                fieldLabel: 'Tipo Vehiculo',
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
                anchor: '80%',
                gwidth: 100,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_tipo_equipo']);
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
                name: 'motivo',
                fieldLabel: 'Motivo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:500
            },
            type:'TextArea',
            filters:{pfiltro:'solvehi.motivo',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },


        {
            config:{
                name: 'observacion',
                fieldLabel: 'Observacion',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:500
            },
                type:'TextField',
                filters:{pfiltro:'solvehi.observacion',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name:'alquiler',
                fieldLabel:'Alquiler',
                allowBlank:false,
                emptyText:'...',
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                gwidth: 100,
                store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :    [['si','si'],
                        ['no','no']]

                }),
                valueField:'ID',
                displayField:'valor',
                //renderer:function (value, p, record){if (value == 1) {return 'si'} else {return 'no'}}
            },
            type:'ComboBox',
            valorInicial: 'no',
            filters:{pfiltro:'solvehi.alquiler',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'monto',
                fieldLabel: 'Monto',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,

            },
            type:'NumberField',
            id_grupo:1,
            grid:true,
            form:true
        },
        {//#GDV-29
            config:{
                name:'existe_conductor',
                fieldLabel:'Conductor ?',
                allowBlank:false,
                emptyText:'...',
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                gwidth: 100,
                store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :    [['si','si'],
                        ['no','no']]

                }),
                valueField:'ID',
                displayField:'valor',
                renderer:function (value, p, record){if (value == 'si') {return 'si'} else {return 'no'}}
            },
            type:'ComboBox',
            valorInicial: 'si',
            filters:{pfiltro:'solvehi.existe_conductor',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'estado',
                fieldLabel: 'Estado',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:-5
            },
            type:'TextField',
            filters:{pfiltro:'solvehi.nro_tramite',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },

        {
            config:{
                name: 'id_usuario_ai',
                fieldLabel: '',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'solvehi.id_usuario_ai',type:'numeric'},
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
                name: 'fecha_reg',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
                type:'DateField',
                filters:{pfiltro:'solvehi.fecha_reg',type:'date'},
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
                filters:{pfiltro:'solvehi.usuario_ai',type:'string'},
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
                filters:{pfiltro:'solvehi.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		},
    ],
    tam_pag:50,    
    title:'solvehi',
    ActSave:'../../sis_rastreo/control/SolVehiculo/insertarSolVehiculo',
    ActDel:'../../sis_rastreo/control/SolVehiculo/eliminarSolVehiculo',
    ActList:'../../sis_rastreo/control/SolVehiculo/listarSolVehiculo',
    id_store:'id_sol_vehiculo',
    fields: [
		{name:'id_sol_vehiculo', type: 'numeric'},
		{name:'motivo', type: 'string'},
		{name:'alquiler', type: 'string'},
		{name:'ceco_clco', type: 'string'},
		{name:'id_proceso_wf', type: 'numeric'},
		{name:'hora_salida', type: 'string'},
		{name:'fecha_salida', type: 'date',dateFormat:'Y-m-d'},
		{name:'nro_tramite', type: 'string'},
		{name:'id_estado_wf', type: 'numeric'},
		{name:'hora_retorno', type: 'string'},
		{name:'id_funcionario_jefe_depto', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'destino', type: 'string'},
		{name:'fecha_sol', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_tipo_equipo', type: 'numeric'},
		{name:'fecha_retorno', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'observacion', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_tipo_equipo', type: 'string'},
        {name:'desc_funcionario', type: 'string'},
        {name:'monto', type: 'numeric'},
        {name:'id_centro_costo', type: 'numeric'},
        {name:'desc_centro_costo', type: 'string'},
        {name:'existe_conductor', type: 'string'},//#GDV-29
        
    ],
    sortInfo:{
        field: 'id_sol_vehiculo',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    sigEstado:function(){
        var data = this.getSelectedData();
        this.objWizard = Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/FormEstadoWf.php',
            'Estado de Wf',
            {
                modal:true,
                width:700,
                height:450
            }, {data:{
                    id_sol_vehiculo:data.id_sol_vehiculo,
                    id_estado_wf:data.id_estado_wf,
                    id_proceso_wf:data.id_proceso_wf,

                }}, this.idContenedor,'FormEstadoWf',
            {
                config:[{
                    event:'beforesave',
                    delegate: this.onSaveWizard,

                }],

                scope:this
            });

    },
    onSaveWizard:function(wizard,resp){

        Ext.Ajax.request({
            url:'../../sis_rastreo/control/SolVehiculo/siguienteEstado',
            params:{
                id_sol_vehiculo:      wizard.data.id_sol_vehiculo,
                id_proceso_wf_act:  resp.id_proceso_wf_act,
                id_estado_wf_act:   resp.id_estado_wf_act,
                id_tipo_estado:     resp.id_tipo_estado,
                id_funcionario_wf:  resp.id_funcionario_wf,
                id_depto_wf:        resp.id_depto_wf,
                obs:                resp.obs,
                json_procesos:      Ext.util.JSON.encode(resp.procesos)
            },
            success:this.successWizard,
            failure: this.conexionFailure,
            argument:{wizard:wizard},
            timeout:this.timeout,
            scope:this
        });

    },
    successWizard:function(resp){
        Phx.CP.loadingHide();
        resp.argument.wizard.panel.destroy()
        this.reload();
    },
    antEstado: function(res){
        var data = this.getSelectedData();
        Phx.CP.loadingHide();
        Phx.CP.loadWindows('../../../sis_workflow/vista/estado_wf/AntFormEstadoWf.php',
            'Estado de Wf',
            {   modal: true,
                width: 450,
                height: 250
            },
            {    data: data,
                estado_destino: res.argument.estado
            },
            this.idContenedor,'AntFormEstadoWf',
            {
                config:[{
                    event:'beforesave',
                    delegate: this.onAntEstado,
                }],
                scope:this
            });

    },
    onAntEstado: function(wizard,resp){
        console.log('resp',wizard.data.id_help_desk);
        Phx.CP.loadingShow();
        var operacion = 'cambiar';

        Ext.Ajax.request({
            url:'../../sis_rastreo/control/SolVehiculo/anteriorEstado',
            params:{
                id_sol_vehiculo: wizard.data.id_sol_vehiculo,
                id_proceso_wf: resp.id_proceso_wf,
                id_estado_wf:  resp.id_estado_wf,
                obs: resp.obs,
                operacion: operacion
            },
            argument:{wizard:wizard},
            success: this.successAntEstado,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
        });
    },

    successAntEstado:function(resp){
        Phx.CP.loadingHide();
        resp.argument.wizard.panel.destroy()
        this.reload();

    },
    obtenerNombreVista: function () { //#GDV-29
        return this.nombreVista;
    }

    }
)
</script>
        
        