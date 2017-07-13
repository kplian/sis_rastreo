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
            emptyText: 'Seleccione un estado ...',
            store: new Ext.data.ArrayStore({
                id: 'id',
                fields: [
                    'id',
                    'nombre'
                ],
                data: [
                    [1, 'Detenido'], 
                    [2, 'Desconectado'],
                    [3, 'Desconocido'],
                    [4, 'En Movimiento'],
                    [5, 'OnLine'],
                    [6, 'Alarma']
                ]
            }),
            valueField: 'id',
            displayField: 'nombre',
            hiddenName: 'events',
            enableMultiSelect: true,
            triggerAction: 'all',
            lazyRender:true,
            mode: 'local',
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
