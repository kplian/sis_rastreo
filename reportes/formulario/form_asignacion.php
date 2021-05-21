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
    Phx.vista.form_asignacion=Ext.extend(Phx.frmInterfaz,{
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

            Phx.vista.form_asignacion.superclass.constructor.call(this,config);
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
                config: {
                    name: 'id_sol_vehiculo_responsable',
                    fieldLabel: 'Conductor',
                    allowBlank: true,
                    emptyText: 'Elija una opción...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_rastreo/control/SolVehiculoResponsable/listarSolVehiculoResponsable',
                        id: 'id_sol_vehiculo_responsable',
                        root: 'datos',
                        sortInfo: {
                            field: 'nombre',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_sol_vehiculo_responsable', 'desc_responsable', 'codigo'],
                        remoteSort: true,
                        baseParams: {par_filtro: 'solvere.id_sol_vehiculo_responsable#per.nombre_completo1'}
                    }),
                    tpl:'<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}"><p><b></b>{desc_responsable}</p></div>\</div></tpl>',
                    valueField: 'id_sol_vehiculo_responsable',
                    displayField: 'desc_responsable',
                    gdisplayField: 'desc_responsable',
                    hiddenName: 'id_sol_vehiculo_responsable',
                    forceSelection: true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 15,
                    queryDelay: 1000,
                    anchor: '80%',
                    gwidth: 150,
                    minChars: 2,
                    enableMultiSelect:true,
                    renderer : function(value, p, record) {
                        return String.format('{0}', record.data['desc_persona']);
                    }
                },
                type: 'AwesomeCombo',
                id_grupo: 0,
                filters: {pfiltro: 'movtip.desc_persona',type: 'string'},
                grid: true,
                form: true
            },
            {
                config:{
                    name: 'desde',
                    fieldLabel: 'Desde',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 160
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            },
            {
                config:{
                    name: 'hasta',
                    fieldLabel: 'Hasta',
                    allowBlank: true,
                    format: 'd/m/Y',
                    width: 160
                },
                type: 'DateField',
                id_grupo: 0,
                form: true
            }

        ],
        labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
        east: {
            url: '../../../sis_rastreo/reportes/Rdetalle_asignacion_vehiculo.php',
            title: 'Detalle Conductores asignados',
            width: '70%',
            cls: 'Rdetalle_asignacion_vehiculo'
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

            Phx.vista.form_asignacion.superclass.loadValoresIniciales.call(this);

        },

    })
</script>