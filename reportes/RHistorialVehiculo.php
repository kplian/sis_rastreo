<?php
/**
 *@package pXP
 *@author  Juan Jimenez
 *@date    18-02-2021
 *@description Historial de movimiento de vehiculos

HISTORIAL DE MODIFICACIONES:


ISSUE            FECHA:          AUTOR       DESCRIPCION
#RAS-2  ENDETR    18-02-2021       JJA            Historial de movimiento de vehiculos
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.RHistorialVehiculo = Ext.extend(Phx.frmInterfaz, {

        Atributos : [

            {
                config:{
                    name: 'fecha_ini',
                    fieldLabel: 'Fecha Inicio',
                    allowBlank: false,
                    anchor: '100%',
                    gwidth: 100,
                    format: 'd/m/Y',
                    renderer:function (value,p,record)	{
                        return value?value.dateFormat('d/m/Y'):''
                    }
                },
                type:'DateField',
                filters:{pfiltro:'fecha_ini',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'fecha_fin',
                    fieldLabel: 'Fecha Fin',
                    allowBlank: false,
                    anchor: '100%',
                    gwidth: 100,
                    format: 'd/m/Y',
                    renderer:function (value,p,record){
                        return value?value.dateFormat('d/m/Y'):''
                    }
                },
                type:'DateField',
                id_grupo:1,
                form:true
            },
            {
                config:{
                    name:'ids',
                    fieldLabel:'Vehículos',
                    allowBlank:true,
                    emptyText:'Vehículos..',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_rastreo/control/Equipo/listarEquipoRapido',
                        id: 'id_equipo',
                        root: 'datos',
                        sortInfo:{
                            field: 'placa',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_equipo','placa','nro_movil','marca','modelo','tipo_equipo'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro: 'placa#nro_movil#tipo_equipo'}
                    }),
                    valueField: 'id_equipo',
                    displayField: 'placa',
                    //tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{nro_cuenta}</b></p><p>{denominacion}</p></div></tpl>',
                    hiddenName: 'ids',
                    forceSelection:true,
                    typeAhead: false,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode:'remote',
                    pageSize:10,
                    queryDelay:1000,
                    listWidth:600,
                    resizable:true,
                    anchor:'100%'

                },
                type:'ComboBox',
                id_grupo:0,
                filters:{
                    pfiltro:'gestion',
                    type:'string'
                },
                grid:true,
                form:true
            }

        ],

        topBar : true,
        botones : false,
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Historial de vehículos</b>',

        constructor : function(config) {
            Phx.vista.RHistorialVehiculo.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();
        },

        iniciarEventos:function(){
        },

        tipo : 'reporte',
        clsSubmit : 'bprint',

        Grupos : [{
            layout : 'column',
            items : [{
                xtype : 'fieldset',
                layout : 'form',
                border : true,
                title : 'Datos para el reporte',
                bodyStyle : 'padding:0 10px 0;',
                columnWidth : '500px',
                items : [],
                id_grupo : 0,
                collapsible : true
            }]
        }],

        ActSave:'../../sis_rastreo/control/Equipo/ReporteHistorialVehiculo',
        successSave :function(resp){
            Phx.CP.loadingHide();
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            if (reg.ROOT.error) {
                alert('error al procesar');
                return
            }
            var nomRep = reg.ROOT.detalle.archivo_generado;
            if(Phx.CP.config_ini.x==1){
                nomRep = Phx.CP.CRIPT.Encriptar(nomRep);
            }

            window.open('../../../reportes_generados/'+nomRep+'?t='+new Date().toLocaleTimeString())
        },
        agregarArgsExtraSubmit: function() {
            var bandera=0;
            for (var i = 0; i < parseInt(this.Cmp.ids.store.data.items.length); i++) {
                if(this.Cmp.ids.store.data.items[i].data.id_equipo == this.Cmp.ids.value && bandera==0){
                    bandera=1;
                    this.argumentExtraSubmit.vehiculo = this.Cmp.ids.store.data.items[i].data.marca+"  "+this.Cmp.ids.store.data.items[i].data.modelo+"  "+this.Cmp.ids.store.data.items[i].data.placa;

                }
            }

        },
    })
</script>