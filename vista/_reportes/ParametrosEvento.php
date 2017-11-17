<?php
/**
*@package pXP
*@file ParametrosEvento
*@author  RCM
*@date 13/07/20147
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ParametrosEvento = {   
    bsave: false,    
    require: '../../../sis_rastreo/vista/_reportes/Parametros.php',
    requireclase: 'Phx.vista.Parametros',
    title: 'Eventos',
    tipoReporte: 'events',
    pathReporte: '../../../sis_rastreo/vista/_reportes/Reporte.php',
    clsReporte: 'Reporte',
    constructor: function(config) {
        Phx.vista.ParametrosEvento.superclass.constructor.call(this,config)
        this.init;
    },
    addComponentes: function(){
        this.cmbEvents = new Ext.form.AwesomeCombo({
            name: 'events',
            fieldLabel: 'Eventos',
            typeAhead: false,
            forceSelection: true,
            allowBlank: false,
            disableSearchButton: true,
            emptyText: 'Seleccione uno o varios ...',
            store: new Ext.data.JsonStore({
                url: '../../sis_rastreo/control/TipoEvento/listarTipoEvento',
                id: 'id_tipo_equipo',
                root: 'datos',
                sortInfo: {
                    field: 'codigo',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_tipo_evento','codigo','nombre'],
                // turn on remote sorting
                remoteSort: true,
                baseParams: {par_filtro: 'codigo#nombre'}
            }),
            tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{codigo}-{nombre}</div> </div></tpl>',
            valueField: 'codigo',
            displayField: 'codigo',
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
        this.formParam.getComponent(0).add(this.cmbEvents);
        this.formParam.doLayout();
    },
    setExtraParams: function(){
        return {
            events: this.cmbEvents.getValue()
        };
    }
};
</script>
