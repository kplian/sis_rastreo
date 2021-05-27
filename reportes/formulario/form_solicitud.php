<?php
/**
 *@package pXP
 *@file    FormFiltro.php
 *@author  Grover Velasquez Colque
 *@date    30-10-2016
 *@description permite filtrar varios campos antes de mostrar el contenido de una grilla

ISSUE            FECHA:          AUTOR       DESCRIPCION
#RAS-8           21/05/2021      JJA          Reporte de conductores asignados
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.form_solicitud=Ext.extend(Phx.frmInterfaz,{
        constructor:function(config)
        {
            this.panelResumen = new Ext.Panel({html:''});
            this.Grupos = [{

                xtype: 'fieldset',
                border: false,
                autoScroll: true,
                layout: 'form',
                items: [],
                id_grupo: 0

            },
                this.panelResumen
            ];

            Phx.vista.form_solicitud.superclass.constructor.call(this,config);
            this.init();
            this.iniciarEventos();
            //console.log('-->'+this.Cmp.id_gestion.getValue());
            if(config.detalle){

                //cargar los valores para el filtro
                this.loadForm({data: config.detalle});
                var me = this;
                setTimeout(function(){
                    me.onSubmit()
                }, 1500);

            }
            this.maestro=config;


        },

        Atributos:[
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
            {
                config:{
                    name:'id_tipo_cc',
                    qtip: 'Tipo de centro de costos, cada tipo solo puede tener un centro por gestión',
                    origen:'TIPOCC',
                    fieldLabel:'Proyecto',
                    gdisplayField: 'desc_tipo_cc',
                    url:  '../../sis_parametros/control/TipoCc/listarTipoCcAll',
                    baseParams: {movimiento:''},
                    allowBlank:true,
                    width: 250

                },
                type:'ComboRec',
                id_grupo:0,
                filters:{pfiltro:'vcc.codigo_tcc#vcc.descripcion_tcc',type:'string'},
                grid:true,
                form:true
            },
            {
                config:{
                    name:'id_uo',
                    hiddenName: 'id_uo',
                    origen:'UO',
                    fieldLabel:'Gerencia',
                    gdisplayField:'desc_uo',//mapea al store del grid
                    gwidth:200,
                    emptyText:'Dejar blanco para toda la empresa...',
                    width : 250,
                    baseParams: {gerencia: 'si'},
                    allowBlank:true,
                    tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{codigo}</b> - {nombre_unidad}</p> </div></tpl>',
                    listWidth:'315',
                },
                type:'ComboRec',
                id_grupo:0,
                form:true
            },
            {
                config:{
                    name: 'desde',
                    fieldLabel: 'Retorno Desde',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 250
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config:{
                    name: 'hasta',
                    fieldLabel: 'Retorno Hasta',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 250
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            }

        ],
        labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
        east: {
            url: '../../../sis_rastreo/reportes/Rdetalle_solicitud_vehiculo.php',
            title: 'Detalle Consultas Solicitud',
            width: '70%',
            cls: 'Rdetalle_solicitud_vehiculo'
        },


        title: 'Filtros Para el Reporte de Tipo centro de costo',
        // Funcion guardar del formulario
        onSubmit: function(o) {
            var me = this;
            if (me.form.getForm().isValid()) {
                var parametros = me.getValForm();
                this.onEnablePanel(this.idContenedor + '-east', parametros)
            }
        },
        iniciarEventos:function(){


        },
        //mp filtran el el combo partida de acuerdo a la gestion
        loadValoresIniciales: function () {

            Phx.vista.form_solicitud.superclass.loadValoresIniciales.call(this);

        },

    })
</script>