<?php
/**
*@package pXP
*@file ParametrosVelocidad
*@author  RCM
*@date 13/07/20147
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ParametrosVelocidad = {    
    bsave: false,    
    require: '../../../sis_rastreo/vista/_reportes/Parametros.php',
    requireclase: 'Phx.vista.Parametros',
    title: 'Velocidades',
    tipoReporte: 'speed',
    pathReporte: '../../../sis_rastreo/vista/_reportes/ReporteVel.php',
    clsReporte: 'ReporteVel',
    constructor: function(config) {
        Phx.vista.ParametrosVelocidad.superclass.constructor.call(this,config);
        this.init;
    },
    addComponentes: function(){
    	this.numberIni = new Ext.form.NumberField({
            fieldLabel: 'Desde',
            width: 50,
            minValue: 1,
            allowDecimals: false,
            allowBlank: false
        });
        this.numberFin = new Ext.form.NumberField({
            fieldLabel: 'Fin',
            width: 50,
            minValue: 1,
            allowDecimals: false,
            allowBlank: false
        });

    	this.cmpVelocidades = new Ext.form.CompositeField({
        	fieldLabel: 'Velocidades entre',
        	items: [
        		this.numberIni,{
                	xtype: 'displayfield',
                    value: ' y '
                },
                this.numberFin, {
                   xtype: 'displayfield',
                   value: ' km/h '
                }]
        });

        this.formParam.getComponent(0).add(this.cmpVelocidades);
        this.formParam.doLayout();
    },
    setExtraParams: function(){
    	return {
    		velocidad_ini: this.numberIni.getValue(),
    		velocidad_fin: this.numberFin.getValue()
    	}
    }
};
</script>
