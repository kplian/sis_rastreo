<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Ext.define('Phx.vista.Parametros', {
    extend: 'Ext.util.Observable',
    tipoReporte: 'default',
    title: 'Default',
    pathReporte: '../../../sis_rastreo/vista/_reportes/Reporte.php',
    clsReporte: 'Reporte',
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);
        this.createComponents();
        this.addComponentes();
    },
    createComponents: function(){
    	this.dateFechaIni = new Ext.form.DateField({
            fieldLabel: 'Desde',
            allowBlank: false,
            format: 'd/m/Y'
        });
        this.dateFechaFin = new Ext.form.DateField({
            fieldLabel: 'Hasta',
            allowBlank: false
        });
        this.timeHoraIni = new Ext.form.TimeField({
            fieldLabel: 'Desde',
            allowBlank: false,
            format: 'H:i'
        });
        this.timeHoraFin = new Ext.form.TimeField({
            fieldLabel: 'Hasta',
            allowBlank: false,
            format: 'H:i'
        });

        this.cmpDesde = new Ext.form.CompositeField({
        	fieldLabel: 'Desde',
        	items: [this.dateFechaIni,this.timeHoraIni]
        });

        this.cmpHasta = new Ext.form.CompositeField({
        	fieldLabel: 'Hasta',
        	items: [this.dateFechaFin,this.timeHoraFin]
        });

        this.cmbDispositivo = new Ext.form.AwesomeCombo({
            name: 'ids',
            fieldLabel: 'Vehículos',
            typeAhead: false,
            forceSelection: true,
            allowBlank: false,
            disableSearchButton: true,
            emptyText: 'Seleccione un vehículo ...',
            store: new Ext.data.JsonStore({
                url: '../../sis_rastreo/control/Equipo/listarEquipoRapido',
                id: 'id_equipo',
                root: 'datos',
                sortInfo: {
                    field: 'placa',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_equipo','placa','nro_movil','marca','modelo','tipo_equipo'],
                // turn on remote sorting
                remoteSort: true,
                baseParams: {par_filtro: 'placa#nro_movil#tipo_equipo'}
            }),
            tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{placa}-{tipo_equipo} ({nro_movil})</div> </div></tpl>',
            valueField: 'id_equipo',
            displayField: 'placa',
            hiddenName: 'ids',
            enableMultiSelect: true,
            triggerAction: 'all',
            lazyRender: true,
            mode: 'remote',
            pageSize: 20,
            queryDelay: 200,
            //anchor: '80%',
            listWidth: '280',
            resizable: true,
            minChars: 2
        });

        this.formParam = new Ext.form.FormPanel({
            layout: 'form',
            items: [{
                    xtype: 'fieldset',
                    layout: 'form',
                    border: true,
                    title: 'Parámetros '+this.title,
                    bodyStyle: 'padding:10 20px 10;',
                    columnWidth: '300px',
                    items: [this.cmpDesde,this.cmpHasta,this.cmbDispositivo],
                }],
            tbar: [
                {xtype:'button', text:'<i class="fa fa-print" aria-hidden="true"></i> Generar', tooltip: 'Generar el reporte', handler: this.onSubmit, scope: this},
                {xtype:'button', text:'<i class="fa fa-undo" aria-hidden="true"></i> Reset', tooltipo: 'Resetear los parámetros', handler: this.onReset, scope: this}
            ]
        });

        this.viewPort = new Ext.Container({
            layout: 'border',
            width: '80%',
            items: [{
            	xtype: 'panel',
            	region: 'center',
            	items: this.formParam
            }]
        })

        this.panel.add(this.viewPort);
        this.panel.doLayout();
        this.addEvents('init'); 
    },
    onSubmit: function(){
        if (this.formParam.getForm().isValid()) {
            //Obtener los parámetros para generar los reportes
            var params = this.setBaseParams(),
                paramsExtra = this.setExtraParams();
            Ext.apply(params,paramsExtra);
            console.log('params',params)

            //Abre el reporte
            Phx.CP.loadWindows(this.pathReporte,
                'Reporte de '+this.title, {
                    width : '90%',
                    height : '80%'
                },
                params,
                this.idContenedor, this.clsReporte
            );
        }
    },
    onReset: function(){
        console.log('reset');
    },
    addComponentes: function(){

    },
    setBaseParams: function(){
        var fechaIni = this.dateFechaIni.getValue().format('Y-m-d')+' '+this.timeHoraIni.getValue()+':00',
            fechaFin = this.dateFechaFin.getValue().format('Y-m-d')+' '+this.timeHoraFin.getValue()+':00';

        //Convierte fechas a UTC
        fechaIni = moment(new Date(fechaIni+':00')).utc().format('DD/MM/YYYY HH:mm:00');
        fechaFin = moment(new Date(fechaFin+':00')).utc().format('DD/MM/YYYY HH:mm:00');


        return {
            fecha_ini: fechaIni,
            fecha_fin: fechaFin,
            ids: this.cmbDispositivo.getValue(),
            tipoReporte: this.tipoReporte
        };
    },
    setExtraParams: function(){
        return {};
    }
});
</script>