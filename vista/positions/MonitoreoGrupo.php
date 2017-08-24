<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

Ext.define('Phx.vista.car', {
	extend: 'Ext.util.Observable',
	ultimasPosiciones: [],
	estado: 'detenido',
	confirmado: false,
	enProceso: false,
	constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        
        var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
        var point = ol.proj.fromLonLat(aux);
    	this.feature = new ol.Feature({geometry: new ol.geom.Point(point), car: this});    	
    	this.featureLine = new ol.Feature(new ol.geom.LineString([point, point]));
    	this.feature.setId(config.codigo);
    	this.featureLine.setId(config.codigo+'-line');
    	
        var iconStyle = new ol.style.Style({
                image: this.getImageIcon(),
                text: new ol.style.Text({
                    font: '12px Calibri,sans-serif',
                    fill: new ol.style.Fill({ color: '#000' }),
                    stroke: new ol.style.Stroke({
                        color: '#fff', width: 2
                    }),
                    text: config.codigo
                })
            });
            
         var lineStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
              color: 'blue',
              width: 2
            })
         });
                
    	//this.feature.setStyle(iconStyle);
    	
    	this.feature.setStyle([iconStyle]);
    	this.featureLine.setStyle([lineStyle]);
    	this.ultimasPosiciones.push(point);        
       
        
        
    },
    
    setPos: function(config){
    	Ext.apply(this,config);
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
        var point = ol.proj.fromLonLat(aux);
    	
    	
    	this.feature.setGeometry(new ol.geom.Point(point));
    	this.featureLine.getGeometry().appendCoordinate(point);
    	this.ultimasPosiciones.push(point);
    	
    	
    },
    
    resetLine: function(){
    	var point = this.getPos();
    	this.featureLine.getGeometry().setCoordinates([point, point])
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

Ext.define('Phx.vista.MonitoreoGrupo', {
    extend: 'Ext.util.Observable',
    dispositivos : [],
    mostrarRutas: true,
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);
        this.createFormPanel();
        this.showMap();
    },
    
     
    dibujarRutas: function(btn, pressed) {
    	var me = this;
        if(pressed){
            me.mostrarRutas = true;
            me.dispositivos.forEach(function(e){
               if(!me.vectorSource.getFeatureById(e.featureLine.getId())){
    	  	   		 me.vectorSource.addFeature(e.featureLine)
    	  	   }
    	  	  
    	  	   console.log('mostrar la ruta de', e.featureLine.getId())
    	  	});
        }
        else{
            me.mostrarRutas = false;
            me.dispositivos.forEach(function(e){
    	  	   if(me.vectorSource.getFeatureById(e.featureLine.getId())){
    	  	   		me.vectorSource.removeFeature(e.featureLine);
    	  	   }
    	  	   console.log('retira la ruta de', e.feature.getId())
    	  	});
        }

    	
    },
	
	centrarPuntos: function(){
		var extent = this.vectorSource.getExtent();
		try {
        	this.map.getView().fit(extent, this.map.getSize()); 
        }
		catch(err) {
		   console.log('Error al centrar mapa', err)
		}
	},
    
    createFormPanel: function(){
    	var me = this;
    	this.combo_segundos = new Ext.form.ComboBox({
	        store:['detener','5','8','10','15','30','45','60'],
	        typeAhead: true,
	        mode: 'local',
	        triggerAction: 'all',
	        emptyText:'Periodo...',
	        selectOnFocus:true,
	        width:135
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
                    'Grupos', 
                    me.cmbGrupo,
                    '->',
                    {
		              text: '<i class="fa fa-dot-circle-o fa-2x" aria-hidden="true"></i>',
		              handler: me.centrarPuntos,
		              scope: me
		           },
                   {
		              text: '<i class="fa fa-paw fa-2x" aria-hidden="true"></i>',
		              enableToggle: true,
		              pressed: true,
		              toggleHandler: function(btn, pressed){me.dibujarRutas(btn, pressed)},
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
		
		this.cmbGrupo.on('clearcmb', function() {
				this.limpiarTodos();
			}, this);
			
					
		
		this.cmbDispositivo.on('clicksearch', function() {			
				console.log('iniciar monitoreo');
				this.capturarPosicion();
				var extent = this.vectorSource.getExtent();
				try {
                	this.map.getView().fit(extent, this.map.getSize()); 
                }
				catch(err) {
				   console.log('Error al centrar mapa', err)
				}
                
			}, this);
			
		this.cmbGrupo.on('clicksearch', function() {
			
				console.log('iniciar monitoreo');
				this.capturarPosicion();
				var extent = this.vectorSource.getExtent();
				try {
                	this.map.getView().fit(extent, this.map.getSize()); 
                }
				catch(err) {
				   console.log('Error al centrar mapa', err)
				}
                
			}, this);
			
		this.timer_id=Ext.TaskMgr.start({
		    run: this.capturarPosicion,
		    interval:parseInt(5)*1000,
		    scope:this
		});
		
		this.panel.on('resize', function(){
			 this.map.updateSize();
		},this);
		
				
		//this.combo_segundos.on('select',this.evento_combo,this);
    	//this.combo_segundos.setValue('10');	
        
    },
    
     evento_combo: function(){
    		Ext.TaskMgr.stop(this.timer_id);
    		if(this.combo_segundos.getValue()!='detener'){
	    		this.timer_id=Ext.TaskMgr.start({
			    	run: this.capturarPosicion,
			    	interval:parseInt(this.combo_segundos.getValue())*1000,
			    	scope:this
				});
    		}  		
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
			        me.updateResumen(feature.O.car);
			      }
            });
        });
    },
   
   addFeatureClick: function(){
        var feature = new ol.Feature(
                new ol.geom.Point(evt.coordinate)
            );
        feature.setStyle(this.iconStyle);
        this.vectorSource.addFeature(feature);
    },
    contador: 993,
    capturarPosicion: function(){
    	var me = this;
    	if(me.cmbDispositivo.getValue()!=''){
    		if (me.cmbGrupo.getValue()!='') {
    			alert('Solo es posible monitorear eventos por grupo o por auto no por ambos al mismo tiempo, Porfavor borre una de las selecciones');
    			me.cmbGrupo.reset();
    		}
    		this.contador ++;
    		if(!me.enProceso){
    			me.enProceso = true;
	    		Ext.Ajax.request({
	                    url: '../../sis_rastreo/control/Positions/listarUltimaPosicion',
	                    params: {ids: me.cmbDispositivo.getValue(), contador: this.contador},
	                    headers: {'Accept': 'application/json'},
					    failure: me.conexionFailure,
	                    success: me.successCarga,
	                    timeout: me.timeout,
	                    scope: me
	               });
    		}
    		
    	} else if (me.cmbGrupo.getValue()!='') {
    		this.contador ++;
    		if(!me.enProceso){
    			me.enProceso = true;
	    		Ext.Ajax.request({
	                    url: '../../sis_rastreo/control/Positions/listarUltimaPosicion',
	                    params: {ids_grupo: me.cmbGrupo.getValue(), contador: this.contador},
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

        console.log('carga',resp)
    	
    	resp.responseText = resp.responseText.replace('<pre>','').replace('</pre>','')
    	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
    	var me = this;
    	me.enProceso = false;
    	reg.datos.forEach(function(element) {
            //var el = moment(element.servertime).utc().format('DD/MM/YYYY HH:mm:00');
    		me.dibujarPunto({   latitud : element.latitude  ,
	    			            longitud: element.longitude,
	    			            codigo: element.placa ,
	    			            nombre: element.placa,
	    			            attributes: element.attributes,
	    			            speed: element.speed,
	    			            desc_equipo: element.desc_equipo,
	    			            id_equipo: element.id_equipo,
	    			            modelo: element.modelo,
	    			            marca: element.marca,
	    			            estado: element.estado,
	    			            address: element.address,
	    			            altitud: element.altitude });
    	});
    	
    	//elimar los los marcadores que no fueron considerados
    	this.dispositivos.forEach(function(e){
    	  	   if(!e.confirmado){
	    	  	   	console.log('eliminar....', e,  e.feature.getId())
	    	  	   	var index = me.dispositivos.indexOf(e);
	    	  	   	if(me.vectorSource.getFeatureById(e.feature.getId())){
	    	  	   		me.vectorSource.removeFeature(e.feature);
	    	  	   	}
	    	  	   	
	    	  	   	if(me.vectorSource.getFeatureById(e.featureLine.getId())){
	    	  	   		me.vectorSource.removeFeature(e.featureLine);
	    	  	   	}
    	  	   } 
    	  });
    	
    	
    	//resetea los confirmados
    	this.dispositivos.forEach(function(e){
    	  	   e.confirmado = false;
    	  	   
    	  });
    	
    	
        
    },
    
    conexionFailure: function(resp){
    	Phx.CP.conexionFailure(resp)
    },
    
   dibujarPunto:function(data){    	
    	if(this.buscarDispositivos(data.codigo)===true){
    		//actulizar posicion de marcado
    		var car  = this.getDispositivo(data.codigo);
    		car.confirmado = true; 
    		//dibujar un linea conel punto anterio si esta en movimeinto
    		car.setPos(data);
		    if(!this.vectorSource.getFeatureById(car.feature.getId())){
	  	   	   this.vectorSource.addFeature(car.feature)
	  	 	}
	  	 	
	  	 	if(!this.vectorSource.getFeatureById(car.featureLine.getId())){
	  	   	   //car.resetLine();
	  	   	   if(this.mostrarRutas){
	  	   	   	this.vectorSource.addFeature(car.featureLine)
	  	   	   }
	  	 	}
	  	   
    	}
    	else{
    		var car  = new Phx.vista.car (data);
    		this.dispositivos.push(car);
    		car.confirmado = true;
    	    this.vectorSource.addFeature(car.feature);
    	    if(this.mostrarRutas ){
	  	   	   	this.vectorSource.addFeature(car.featureLine)
	  	    }
    	    
    	    console.log('nuevo dispositivo', data.codigo, data.latitud, data.longitud)
    	}
    	
    	
    },
    
    limpiarTodos : function(){
    	var me = this;
    	this.dispositivos.forEach(function(e){
    	  	  
    	  	   console.log('feature id', e.feature.getId())
    	  	   
    	  	   if(me.vectorSource.getFeatureById(e.feature.getId())){
    	  	   	    me.vectorSource.removeFeature(e.feature);
    	  	   }
    	  	   if(me.vectorSource.getFeatureById(e.featureLine.getId())){
    	  	   	    e.resetLine();
    	  	   		me.vectorSource.removeFeature(e.featureLine);
    	  	   }
    	  	   e.confirmado = false;
    	  	   console.log('despues de eliminar feature id', e.feature.getId())
    	  	   
    	  });
    },    
    
    buscarDispositivos: function(id){
    	  var sw = false
    	  this.dispositivos.forEach(function(e){
    	  	   if(e.codigo == id){
    	  	   	   sw =  true
    	  	   }
    	  });    	  
    	return sw
    },
    getDispositivo: function(id){
    	  var dis = undefined;
    	  this.dispositivos.forEach(function(e){
    	  	   if(e.codigo == id){
    	  	   	   dis = e;
    	  	   }
    	  });
    	  
    	return dis;
    },
    
    cmbDispositivo : new Ext.form.AwesomeCombo({
			name : 'id_equipo',
			fieldLabel : 'Dispositivos',
			typeAhead : false,
			forceSelection : true,
			allowBlank : true,
			disableSearchButton : false,
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
			enableMultiSelect : true,
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
		
		cmbGrupo : new Ext.form.AwesomeCombo({
			name : 'id_grupo',
			fieldLabel : 'Grupos',
			typeAhead : false,
			forceSelection : true,
			allowBlank : true,
			disableSearchButton : false,
			emptyText : 'seleccione un grupo ...',
			store : new Ext.data.JsonStore({
				url : '../../sis_rastreo/control/Grupo/listarGrupo',
				id : 'id_grupo',
				root : 'datos',
				sortInfo : {
					field : 'nombre',
					direction : 'ASC'
				},
				totalProperty : 'total',
				fields : ['id_grupo','nombre','codigo'],
				// turn on remote sorting
				remoteSort : true,
				baseParams : {par_filtro : 'nombre#codigo'}
			}),
			tpl: '<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{codigo}-{nombre}</div> </div></tpl>',
			valueField : 'id_grupo',
			displayField : 'nombre',
			hiddenName : 'id_grupo',
			enableMultiSelect : true,
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