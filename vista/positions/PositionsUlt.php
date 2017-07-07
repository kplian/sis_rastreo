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
		this.cargarDatos();
    },
    onReloadPage: function(record){
    	console.log('onReloadPage',record)
    	this.cargarDatos(record);
    },
    liberaMenu: function(){
    	console.log('liberaMenu')
    },
    postReloadPage: function(record){
    	console.log('postReloadPage',record)
    },
    cargarDatos: function(data){
    	
    	var plantilla = "<div style='overflow-y: initial;'><br><b>PLACA {0}</b><br></b> \
	       					<b>Posicion:</b> (Lat {1}, Lon  {2}, Alt {14})</br>\
							<b>Estado:</b> {3}</br>\
							<b>Responsable:</b> {4}</br>\
							<b>Descripcion:</b> {5}</br>\
							<b>Velocidad (km/h):</b> {6}</br>\
							<b>Distancia:</b> {7}</br>\
							<b>Total Distancia:</b> {8}</br>\
							<b>Odometro:</b> {9}</br>\
							<b>Consumo de combustible:</b> {10}</br>\
							<b>Battery:</b> {11}</br>\
							<b>Rssi:</b> {12}</br>\
							<b>Direccion:</b> {13}</br></br>\
						</div>";
		if(data){
			var  reg = Ext.util.JSON.decode(Ext.util.Format.trim(data.attributes));
			this.panelResumen.update( String.format(plantilla,data.placa, 
				                                           data.longitude,
				                                           data.latitude,
				                                           data.desc_type||'desconocido',
				                                           data.responsable||'no designado',
				                                           data.desc_equipo||'sin descripcion',
				                                           data.speed||0,
				                                           reg.distance||0,
				                                           reg.totalDistance||0,
				                                           reg.odometer||0,
				                                           reg.fuelConsumption||0,			                                           
				                                           reg.battery||0,
				                                           reg.rssi||0,
				                                           data.address||'',
				                                           data.altitud||0));

		} else {
			this.panelResumen.update(String.format(plantilla));
		}
    }
});
</script>