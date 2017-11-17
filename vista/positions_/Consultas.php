<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Ext.define('Phx.vista.DeviceImages', {
    singleton: true,
    constructor: function(config){
     	Ext.apply(this,config);
        this.callParent(arguments);
        this.deviceStore = new Ext.data.JsonStore({
						        fields: ['key', 'name', 'svg', 'fillId', 'rotateId', 'scaleId']
						    });

        this.deviceStore.loadData(this.genData());
    
    
    },
    
    genData: function () {
        var i, key, data = [];
        
        for (i = 0; i < window.Images.length; i++) {
            key = window.Images[i];
            //console.log('xxxxx', 'category' + key.charAt(0).toUpperCase() + key.slice(1))
            data.push({
                key: key,
                //name: Strings['category' + key.charAt(0).toUpperCase() + key.slice(1)],
                name : 'category' + key.charAt(0).toUpperCase() + key.slice(1),
                svg: document.getElementById(key + 'Svg').contentDocument,
                //svg: document.getElementById(key + 'Svg')['#document'],
                fillId: key === 'arrow' ? 'arrow' : 'background',
                rotateId: key === 'arrow' ? 'arrow' : 'background',
                scaleId: key === 'arrow' ? 'arrow' : 'layer1'
            });
        }
        return data;
    },
        
    getImageSvg: function (color, zoom, angle, category) {
        var i, info, svg, width, height, rotateTransform, scaleTransform, fill;
        info = this.deviceStore.getAt(this.deviceStore.find('key', category || 'default', 0, false, false, true));
        svg = Ext.ux.clone(info.get('svg'));
        if (!svg) {
            svg = this.cloneDocument(info.get('svg'));
        }
        
        width = parseFloat(svg.documentElement.getAttribute('width'));
        height = parseFloat(svg.documentElement.getAttribute('height'));

        fill = info.get('fillId');
        if (!Ext.isArray(fill)) {
            fill = [fill];
        }
        
        for (i = 0; i < fill.length; i++) {
            //svg.getElementById(fill[i]).style.fill = color;
        }

        rotateTransform = 'rotate(' + angle + ' ' + (width / 2) + ' ' + (height / 2) + ')';
        svg.getElementById(info.get('rotateId')).setAttribute('transform', rotateTransform);

        
        width *= 1;
        height *= 1;
        scaleTransform = 'scale(' + 1 + ') ';
       

        if (info.get('scaleId') !== info.get('rotateId')) {
            svg.getElementById(info.get('scaleId')).setAttribute('transform', scaleTransform);
        } else {
            svg.getElementById(info.get('scaleId')).setAttribute('transform', scaleTransform + ' ' + rotateTransform);
        }

        svg.documentElement.setAttribute('width', width);
        svg.documentElement.setAttribute('height', height);
        svg.documentElement.setAttribute('viewBox', '0 0 ' + width + ' ' + height);

        return svg;
    },

    formatSrc: function (svg) {
        return 'data:image/svg+xml;charset=utf-8,' +
                encodeURIComponent(new XMLSerializer().serializeToString(svg.documentElement));
    },

    cloneDocument: function (svgDocument) {
        var newDocument, newNode;
        newDocument = svgDocument.implementation.createDocument(svgDocument.namespaceURI, null, null);
        newNode = newDocument.importNode(svgDocument.documentElement, true);
        newDocument.appendChild(newNode);
        return newDocument;
    },

    getImageIcon: function (color, zoom, angle, category) {
        var image, svg, width, height;

        svg = this.getImageSvg(color, zoom, angle, category);
        width = parseFloat(svg.documentElement.getAttribute('width'));
        height = parseFloat(svg.documentElement.getAttribute('height'));

        image =  new ol.style.Icon({
            imgSize: [width, height],
            src: this.formatSrc(svg)
        });
        image.fill = color;
        image.zoom = zoom;
        image.angle = angle;
        image.category = category;

        return image;
    }
});

Ext.define('Phx.vista.carRuta', {
	extend: 'Ext.util.Observable',
	ultimasPosiciones: [],
	estado: 'detenido',
	confirmado: false,
	enProceso: false,
	feature:[],
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
    
    addPos: function(config, vectorSource,color, tipoIcono){
    	
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
        var point = ol.proj.fromLonLat(aux);
    	this.featureLine.getGeometry().appendCoordinate(point);
    	this.ultimasPosiciones.push(point);
    	
    	var feature = new ol.Feature({ geometry: new ol.geom.Point(point), car: this, pointData: config.data})
    	this.feature.push(feature);
    	
    	//return this.getMarkerStyle(false, Traccar.app.getReportColor(deviceId), angle, 'arrow');
    	// getMarkerStyle: function (zoom, color, angle, category) 
    	 
    	 
    	 
    	//var image = Phx.vista.DeviceImages.getImageIcon(color, zoom, angle, category);arrow
    	var image = Phx.vista.DeviceImages.getImageIcon(color, false, config.course, tipoIcono);
        var lbl=config.codigo;

        if(tipoIcono=='car'){
            lbl=config.data.nro_movil;
        }
    	var iconStyle = new ol.style.Style({
                image: image,
                text: new ol.style.Text({
                    font: '12px Calibri,sans-serif',
                    fill: new ol.style.Fill({ color: '#000' }),
                    stroke: new ol.style.Stroke({
                        color: '#fff', width: 2
                    }),
                    text: lbl
                })
            });
            
           
    	feature.setStyle([iconStyle]);
    	vectorSource.addFeature(feature);
    	vectorSource.addFeature(this.featureLine)
    	
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
    }
   
    
	
	
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

        //CreaciÃ³n del panel de parÃ¡metros
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
    url: 'http://192.168.60.20:8080/webmap/elfec/wmts/webmap.cartography/{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png',
    showMap: function(){
    	var me = this;
        this.vectorSource = new ol.source.Vector();
        this.vectorLayer = new ol.layer.Vector({source: this.vectorSource});
       
        
        if(this.servidor){
        	  var projection = ol.proj.get('EPSG:900913');
		      var projectionExtent = projection.getExtent();
		      var size = ol.extent.getWidth(projectionExtent) / 256;
		      var resolutions = new Array(22);
		      var matrixIds = new Array(22);
		      for (var z = 0; z < 22; ++z) {
		        // generate resolutions and matrixIds arrays for this WMTS
		        resolutions[z] = size / Math.pow(2, z);
		        matrixIds[z] = z;
		      };	
		      
		      var tileGrid = new ol.tilegrid.WMTS({
		        origin: ol.extent.getTopLeft(projection.getExtent()),
		        resolutions: resolutions,
		        matrixIds: matrixIds
		    });
		      
		      
		      		
				/*	
		     this.layer = new ol.layer.Tile({
					        source: new ol.source.WMTS({
						          attributions: 'Â© <a>Elfec</a>',
						          crossOrigin: 'anonymous',
						          serverType: 'geoserver',
						          requestEncoding: 'REST',
						           
                                 
						          layer: '1',
	                              matrixSet: 'centrality',
						          format: 'image /png',
						          url: 'http://'+this.servidor+'{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png',
						          projection: projection,
					              tileGrid: new ol.tilegrid.WMTS({
					              origin: ol.extent.getTopLeft(projectionExtent),
					              resolutions: resolutions,
					              matrixIds: matrixIds
				              }),
				              style: 'default',
				              wrapX: true,
            					requestEncoding: 'REST',
				              isBaseLayer: false,
				              opacity: 0.6,
					        })
					      });	*/
					     
					     
					     
							this.layer = new ol.layer.Tile({
						        source: new ol.source.WMTS({
						            attributions: 'Tiles Â© <a href="https://services.arcgisonline.com/arcgis/rest/' +
						            'services/Demographics/USA_Population_Density/MapServer/">ArcGIS</a>',
						            //url: 'http://192.168.60.20:8080/webmap/elfec/wmts/webmap.subtransmission/{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png',
						             url: 'http://'+this.servidor+'{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png',
						            layer: 'webmap.subtransmission',
						            matrixSet: 'centrality',
						            format: 'image/png',
						            tileGrid: tileGrid,
						            style: 'default',
						            wrapX: true,
						            requestEncoding: 'REST'
						        }),
						        opacity: 1
						    });
        }
        else{
	        this.layer = new ol.layer.Tile({
	                    style: 'Aerial',
	                    source: new ol.source.OSM()
	                });	
        }
        
                
         
		 
           
       
        this.olview = new ol.View({
            center: [-7304699.1313268, -1939396.311513],
            zoom: 2,
            minZoom: 2,
            maxZoom: 24
        }),
        
        this.map = new ol.Map({
            target: document.getElementById('map-'+this.idContenedor),
            view: this.olview,
            layers: [this.layer,this.vectorLayer]
            //layers: [this.layer, this.vectorLayer]
        });
        
          
        
        this.map.on('click', function(e){
            me.map.forEachFeatureAtPixel(e.pixel, function(feature, layer) {
               if(feature.O.car){
                	if(!me.winInfo){
                	 	me.panelResumen = new Ext.Panel({  
			    		    padding: '0 0 0 20',
			    		    html: '',
			    		    split: true, 
			    		    layout:  'fit' });
			    		    
			            me.winInfo = new Ext.Window({
			                layout:'fit',
			                width:500,
			                height:300,
			                closeAction:'hide',
			                plain: true,
			                items: me.panelResumen,			
			                buttons: [{
			                    text: 'Close',
			                    handler: function(){
			                        me.winInfo.hide();
			                    }
			                }]
			            });
			        }
			        me.winInfo.show();
			        me.updateResumen(feature.O.pointData);
			      }
            });
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
                    var fecha_ini  =  this.dateFechaIni.getValue().dateFormat('Y-m-d') + ' ' +this.timeHoraIni.getValue( ) ;
                    var fecha_fin  =  this.dateFechaFin.getValue().dateFormat('Y-m-d')+  ' '+this.timeHoraFin.getValue( );

                     //Convierte fechas a UTC
                    fecha_ini = moment(new Date(fecha_ini+':00')).utc().format('DD/MM/YYYY HH:mm:00');
                    fecha_fin = moment(new Date(fecha_fin+':00')).utc().format('DD/MM/YYYY HH:mm:00');

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
    	var sw = true;
    	var latitud_tmp = 0, 
    	    longitud_tmp = 0;
    	
    	me.vectorSource.clear();
    	var contador = 1, tipoIcono = 'arrow', color = '#FA2006';  
    	
    	//console.log(contador,color, tipoIcono)  ;
    	if(reg.datos.length > 0){
                
                 

		    	reg.datos.forEach(function(element) {
		    		var data = { latitud : element.latitude, longitud: element.longitude, course: element.course, data:element };
		    		if(contador == 1){
		    			 color = '#FA2006';
		    		}
		    		else{
		    			if(contador == reg.datos.length){
		    			    color = 'rgba(241, 17, 17, 1.0)';
		    			    tipoIcono = 'car';
		    		    }
		    		    else{
		    		    	color =  'rgb(250, 190, 77)'
		    		    }
		    		}
		    		if(sw){
			    			me.car.resetPos(data, me.vectorSource);
			    			sw = false;
			    			
			    	}				
		    		if( latitud_tmp != element.latitude ||
		    			longitud_tmp != element.longitude){
			    		
			    		me.car.addPos(data, me.vectorSource,color  ,tipoIcono);
			    		//console.log(element.latitude, element.longitude, element )
			    		latitud_tmp = element.latitude;
			    		longitud_tmp = element.longitude;
			    		
		    		}				
		    		//console.log('............',contador,color, tipoIcono, reg.datos.length )  ;
		    		contador = contador+1;				
		    	});
		    	
		    	
		    	
		    	//me.vectorSource.addFeature(me.car.featureLine)
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
    	  	me.vectorSource.clear();
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
			/*store : new Ext.data.JsonStore({
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
			tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{placa}-{desc_tipo_equipo}</div> </div></tpl>',*/
            store : new Ext.data.JsonStore({
                url : '../../sis_rastreo/control/Equipo/listarEquipoRapido',
                id : 'id_equipo',
                root : 'datos',
                sortInfo : {
                    field : 'placa',
                    direction : 'ASC'
                },
                totalProperty : 'total',
                fields: ['id_equipo','placa','nro_movil','marca','modelo','tipo_equipo'],
                // turn on remote sorting
                remoteSort : true,
                baseParams : {par_filtro : 'placa#nro_movil#tipo_equipo'}
            }),
            tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{placa}-{tipo_equipo} ({nro_movil})</div> </div></tpl>',
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
		       					<b>PosiciÃ³n:</b> (Lat {1}, Lon  {2}, Alt {14})</br>\
								<b>Hora del Servidor:</b> {3}</br>\
                                <b>Nro.MÃ³vil:</b> {15}</br>\
                                <b>Responsable:</b> {4}</br>\
                                <b>DescripciÃ³n:</b> {5}</br>\
                                <b>Velocidad:</b> {6}</br>\
                                <b>Distancia:</b> {7}</br>\
                                <b>Total Distancia:</b> {8}</br>\
                                <b>OdÃ³metro:</b> {9}</br>\
                                <b>Consumo de combustible:</b> {10}</br>\
                                <b>Battery:</b> {11}</br>\
                                <b>Rssi:</b> {12}</br>\
                                <b>DirecciÃ³n:</b> {13}</br></br>\
                                </div>";
								
		var  reg = {};
		if(datos.attributes){
			 reg   = Ext.util.JSON.decode(Ext.util.Format.trim(datos.attributes));	
		}	
							
		var hora = new Date(datos.servertime).dateFormat('H:i:s.u  d/m/Y H:i:s.u');					
		       
		     
		this.panelResumen.update( String.format(plantilla,
			                                           datos.placa, 
			                                           datos.longitude,
			                                           datos.latitude,
			                                           hora||'desconocido',
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
			                                           datos.altitude||0,
                                                       datos.nro_movil
			                                           
			                                           ));
			                                           
			                                           
			                                         
		
	}	
       
		
    
});
</script>
