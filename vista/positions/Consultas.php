<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

Ext.define('Phx.vista.carRuta', {
	extend: 'Ext.util.Observable',
	ultimasPosiciones: [],
	estado: 'detenido',
	confirmado: false,
	enProceso: false,
	constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        var aux = [parseFloat(0),parseFloat(0)];
        var point = ol.proj.fromLonLat(aux);
    	//this.featureLine = new ol.Feature(new ol.geom.LineString([point, point]));
    	
    	this.featureLine = new ol.Feature(new ol.geom.LineString());
    	this.featureLine.setId('line');
    	
        var lineStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
              color: 'blue',
              width: 2
            })
         });
                
    	this.featureLine.setStyle([lineStyle]);
    	
        
        
    },
    
    addPos: function(config){
    	
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
        var point = ol.proj.fromLonLat(aux);
    	this.featureLine.getGeometry().appendCoordinate(point);
    	this.ultimasPosiciones.push(point);
    	
    	
    },
    resetPos: function(config){
    	
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
        var point = ol.proj.fromLonLat(aux);
    	this.featureLine.getGeometry().setCoordinates([point, point])
    	this.ultimasPosiciones = [];
    	this.ultimasPosiciones.push(point);
    	
    	
    },
    
    resetLine: function(){
    	//var point = this.getPos();
    	//this.featureLine.getGeometry().setCoordinates([point, point])
    	this.featureLine.getGeometry().setCoordinates()
    },
   
    
    getPos: function(){
    	return this.ultimasPosiciones[this.ultimasPosiciones.length-1];
    },
    
    getImageIcon: function (m) {
	        var image = new ol.style.Icon({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    opacity: 0.75,
                    src: '../../../sis_rastreo/vista/positions/car.svg'
                })
	
	        return image;
   },
   
    
	
	
});

Ext.define('Phx.vista.Consultas', {
    extend: 'Ext.util.Observable',
    dispositivos : [],
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);
        this.createFormPanel();
        this.showMap();
        this.car  = new Phx.vista.carRuta();
    },
    
     
    
    
    createFormPanel: function(){
    	var me = this;
    	this.combo_segundos = new Ext.form.ComboBox({
	        store:['detener','5','8','10','15','30','45','60'],
	        typeAhead: true,
	        mode: 'local',
	        //triggerAction: 'all',
	        emptyText:'Periodo...',
	        selectOnFocus:true,
	        width:135
	    });
	    
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
            width:70,
            format: 'H:i'
        });
        this.timeHoraFin = new Ext.form.TimeField({
            fieldLabel: 'Hasta',
            allowBlank: false,
            width:70,
            format: 'H:i'
        });
        
    	 this.tbar = new Ext.Toolbar({
        	enableOverflow: true,
        	defaults: {
               scale: 'large',
               iconAlign:'top',
               minWidth: 50,
               boxMinWidth: 50
            },
           // items: ['Vehiculos', this.cmbDispositivo, this.combo_segundos]
            items: ['Vehiculos', 
                    me.cmbDispositivo,
                    '-',
                    'Desde: ',
                    this.dateFechaIni,
                    this.timeHoraIni,
                    'Hasta: ',
                    this.dateFechaFin,
                    this.timeHoraFin,
                    '->',
                    {
		              text: '<i class="fa fa-paw   fa-2x" aria-hidden="true"></i>',
		              handler: me.mostrarRutas,
		              scope: me
		           }]
        });
        
        //Mapas
        this.panelMapa = new Ext.Panel({  
            padding: '0 0 0 0',
            tbar: this.tbar,
            html:'<div id="map-'+this.idContenedor +'" style="width: 100%;height: 100%;"></div>',
            region:'center',
            split: true, 
            layout:  'fit' })

        //Creación del panel de parámetros
        this.viewPort = new Ext.Container({
            layout: 'border',
            items: [this.panelMapa]
        });

        this.panel.add(this.viewPort);
        this.panel.doLayout();
        //this.addEvents('init'); 
        
        this.cmbDispositivo.on('clearcmb', function() {
				this.limpiarTodos();
			}, this);
			
		this.panel.on('resize', function(){
			 this.map.updateSize();
		},this);
		
				
			
        
    },
    
     
    
    
    winInfo: undefined,
    panelResumen: undefined,
    showMap: function(){
    	var me = this;
        this.vectorSource = new ol.source.Vector();
        this.vectorLayer = new ol.layer.Vector({source: this.vectorSource});
        
        this.layer = new ol.layer.Tile({
                    style: 'Aerial',
                    source: new ol.source.OSM()
                });
        
        this.olview = new ol.View({
            center: [0, 0],
            zoom: 2,
            minZoom: 2,
            maxZoom: 20
        }),
        
        this.map = new ol.Map({
            target: document.getElementById('map-'+this.idContenedor),
            view: this.olview,
            layers: [this.layer,this.vectorLayer]
        });
        
        
    },
   
   
    mostrarRutas: function(btn, pressed) {
    	var me = this;
    	
    	if( this.cmbDispositivo.isValid()&&
	        this.dateFechaIni.isValid()&&
	        this.timeHoraIni.isValid()&&
	        this.dateFechaFin.isValid()&&
	        this.timeHoraFin.isValid()){
	        	
	        	
        	if(me.cmbDispositivo.getValue()!=''){
	    		    var fecha_ini  =  this.dateFechaIni.getValue().dateFormat('d-m-Y') + ' ' +this.timeHoraIni.getValue( ) ;
	    		    var fecha_fin  =  this.dateFechaFin.getValue().dateFormat('d-m-Y')+  ' '+this.timeHoraFin.getValue( );
                    //Convierte fechas a UTC
                    fecha_ini = moment(fecha_ini).utc().format('DD/MM/YYYY HH:mm:00');
                    fecha_fin = moment(fecha_fin).utc().format('DD/MM/YYYY HH:mm:00');

		    		Phx.CP.loadingShow();
		    		Ext.Ajax.request({
		                    url: '../../sis_rastreo/control/Positions/listarPosicionesRangoProcesado',
		                    params: { 
		                    	       ids: me.cmbDispositivo.getValue(),
		                    	       fecha_ini: fecha_ini,
		                    	       fecha_fin: fecha_fin
		                    	     },
		                    headers: {'Accept': 'application/json'},
						    failure: me.conexionFailure,
		                    success: me.successCarga,
		                    timeout: me.timeout,
		                    scope: me
		               });
	    	}
        }
        else{
	    	this.limpiarTodos();
	    }
    },
    successCarga: function(resp, a, b, c, d) {
    	Phx.CP.loadingHide();
    	resp.responseText =resp.responseText.replace('<pre>','').replace('</pre>','')
    	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
    	var me = this;
    	me.enProceso = false;
    	if(me.vectorSource.getFeatureById(me.car.featureLine.getId())){
    	     me.vectorSource.removeFeature(me.car.featureLine);
    	}
    	console.log(reg.datos);
    	var sw = true;
    	var latitud_tmp = 0, 
    	    longitud_tmp = 0;
    	if(reg.datos.length > 0){
                /*reg.datos.forEach(function(element) {
                    var el = moment(element.servertime).utc().format('DD/MM/YYYY HH:mm:00');
                    reg.datos.servertime = el;
                });*/

		    	reg.datos.forEach(function(element) {
		    		var data = { latitud : element.latitude, longitud: element.longitude};
		    		if(sw){
			    			me.car.resetPos(data);
			    			sw = false;
			    	}				
		    		if( latitud_tmp != element.latitude ||
		    			longitud_tmp != element.longitude){
			    		
			    		me.car.addPos(data);
			    		console.log(element.latitude, element.longitude, element )
			    		latitud_tmp = element.latitude;
			    		longitud_tmp = element.longitude;
			    		
		    		}				
		    		
		    						
		    	});
		    	
		    	
		    	
		    	me.vectorSource.addFeature(me.car.featureLine)
		    	var extent = this.vectorSource.getExtent();
				try {
		        	this.map.getView().fit(extent, this.map.getSize()); 
		        }
				catch(err) {
				   console.log('Error al centrar mapa', err)
				}	
    	}
    	
    	
    	
    	
        
    },
    
    conexionFailure: function(resp){
    	Phx.CP.conexionFailure(resp)
    },
    
  
    
    limpiarTodos : function(){
    	var me = this;
    	if(me.vectorSource.getFeatureById(me.car.featureLine.getId())){
    	  	me.car.resetLine();
    	  	me.vectorSource.removeFeature(me.car.featureLine);
    	 }
    },
    
    
    
    
    cmbDispositivo : new Ext.form.AwesomeCombo({
			name : 'id_equipo',
			fieldLabel : 'Dispositivos',
			typeAhead : false,
			forceSelection : true,
			allowBlank : false,
			disableSearchButton : true,
			emptyText : 'seleccione un dispositivo ...',
			store : new Ext.data.JsonStore({
				url : '../../sis_rastreo/control/Equipo/listarEquipo',
				id : 'id_equipo',
				root : 'datos',
				sortInfo : {
					field : 'placa',
					direction : 'ASC'
				},
				totalProperty : 'total',
				fields : ['id_equipo','id_tipo_equipo','id_modelo', 'id_localizacion', 'nro_motor', 'placa', 'estado', 
				'nro_movil','fecha_alta','cabina','propiedad', 'nro_chasis', 'cilindrada', 'color', 'pta', 'traccion', 'gestion',
				'desc_tipo_equipo','id_marca','desc_modelo','desc_marca','uniqueid','deviceid'],
				// turn on remote sorting
				remoteSort : true,
				baseParams : {par_filtro : 'placa#nro_movil#desc_tipo_equipo'}
			}),
			tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{placa}-{desc_tipo_equipo}</div> </div></tpl>',
			valueField : 'id_equipo',
			displayField : 'placa',
			hiddenName : 'id_equipo',
			enableMultiSelect : false,
			triggerAction : 'all',
			lazyRender : true,
			mode : 'remote',
			pageSize : 20,
			queryDelay : 200,
			anchor : '80%',
			listWidth : '280',
			resizable : true,
			minChars : 2
		}),
		
	updateResumen:function(datos){
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
								<b>Direccion:</b> {13}</br></br></div>";
								
								
		var  reg   = Ext.util.JSON.decode(Ext.util.Format.trim(datos.attributes));						
		       
		     
		this.panelResumen.update( String.format(plantilla,
			                                           datos.codigo, 
			                                           datos.longitud,
			                                           datos.latitud,
			                                           datos.estado||'desconocido',
			                                           datos.responsable||'no designado',
			                                           datos.desc_equipo||'sin descripcion',
			                                           datos.speed||0,
			                                           reg.distance||0,
			                                           reg.totalDistance||0,
			                                           reg.odometer||0,
			                                           reg.fuelConsumption||0,			                                           
			                                           reg.battery||0,
			                                           reg.rssi||0,
			                                           datos.address||'',
			                                           datos.altitud||0
			                                           
			                                           ));
			                                           
			                                           
			                                         
		
	}	
       
		
    
});
</script>