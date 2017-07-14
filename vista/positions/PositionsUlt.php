<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Ext.define('Phx.vista.PositionsUlt', {
    extend: 'Ext.util.Observable',
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);

        this.panelResumen = new Ext.Panel({  
			    		    padding: '0 0 0 20',
			    		    html: '',
			    		    split: true, 
			    		    layout:  'fit' 
		});
		this.panel.add(this.panelResumen);
		this.panel.doLayout();
    },
    onReloadPage: function(a,b,c,d){
    	console.log('onReloadPage',a,b,c,d)
    	this.cargarDatos();
    },
    liberaMenu: function(a,b,c,d){
    	console.log('liberaMenu',a,b,c,d)
    },
    postReloadPage: function(a,b,c,d){
    	console.log('postReloadPage',a,b,c,d)
    },
    cargarDatos: function(){
    	var plantilla = "<div style='overflow-y: initial;'><br><b>PLACA {0}</b><br></b> \
	       					<b>Posicion:</b> (Lat {1}, Lon  {2}, Alt {14})</br>\
							<b>Estado:</b> {3}</br>\
							<b>Responsable:</b> {4}</br>\
							<b>Descripcion:</b> {5}</br>\
							<b>Velocidad:</b> {6}</br>\
							<b>Distancia:</b> {7}</br>\
							<b>Total Distancia:</b> {8}</br>\
							<b>Odometro:</b> {9}</br>\
							<b>Consumo de combustible:</b> {10}</br>\
							<b>Battery:</b> {11}</br>\
							<b>Rssi:</b> {12}</br>\
							<b>Direccion:</b> {13}</br></br>\
						</div>";

		this.panelResumen.update( String.format(plantilla));
    }
});
</script>