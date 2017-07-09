<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Ext.define('Phx.vista.Parametros', {
    extend: 'Ext.util.Observable',
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);
        this.createComponents();
    },
    createComponents: function(){
    	this.fechaIni = new Ext.form.DateField({
            fieldLabel: 'Desde'
        });
        this.fechaFin = new Ext.form.DateField({
            fieldLabel: 'Hasta'
        });
        this.horaIni = new Ext.form.TimeField({
            fieldLabel: 'Desde'
        });
        this.horaFin = new Ext.form.TimeField({
            fieldLabel: 'Hasta'
        });

        this.desde = new Ext.form.CompositeField({
        	fieldLabel: 'Desde',
        	items: [this.fechaIni,this.horaIni]
        });

        this.hasta = new Ext.form.CompositeField({
        	fieldLabel: 'Hasta',
        	items: [this.fechaFin,this.horaFin]
        });

        this.viewPort = new Ext.Container({
            layout: 'border',
            items: [{
            	xtype: 'panel',
            	region: 'center',
            	items: [{
            		xtype: 'fieldset',
            		layout : 'form',
					border : true,
					title : 'Fechas',
					bodyStyle : 'padding:0 10px 0;',
					columnWidth : '300px',
					items : [this.desde,this.hasta,{xtype:'button', text:'Generar'}],
            	}
            	]
            }]
        })

        this.panel.add(this.viewPort);


        this.panel.doLayout();
        this.addEvents('init'); 
    }
});
</script>