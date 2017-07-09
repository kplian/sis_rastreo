<?php
header("content-type: text/javascript; charset=UTF-8");
?>
<script>

Ext.define('Phx.vista.car', {
	extend: 'Ext.util.Observable',
	ultimasPosiciones: [],
	estado: 'detenido',
	confirmado: true,
	
	constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        
        var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
    	this.feature = new ol.Feature(
              new ol.geom.Point(ol.proj.fromLonLat(aux))
              //new ol.geom.LineString([ol.proj.fromLonLat(aux)])
            );
        this.feature.setId(config.codigo)
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
                
    	this.feature.setStyle(iconStyle);
    	this.ultimasPosiciones.push(config);        
       
        
        
    },
    
    setPos: function(config){
    	this.ultimasPosiciones.push(config);
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
    	//this.feature.getGeometry().setCoordinates(new ol.geom.Point(ol.proj.fromLonLat(aux)));
    	this.feature.setGeometry(new ol.geom.Point(ol.proj.fromLonLat(aux)));
    },
    appendCoordinate: function(config){
    	this.ultimasPosiciones.push(config);
    	var aux = [parseFloat(config.longitud),parseFloat(config.latitud)];
    	this.feature.getGeometry().appendCoordinate(aux)
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
   }
    
	
	
});

Ext.define('Phx.vista.Monitoreo', {
    extend: 'Ext.util.Observable',
    dispositivos : [],
   
    constructor: function(config){
        Ext.apply(this,config);
        this.callParent(arguments);
        this.panel = Ext.getCmp(this.idContenedor);
        this.createFormPanel();
        //this.setEventos();
        this.showMap();
    },
    
    
    createFormPanel: function(){
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
            items: ['Vehiculos', this.cmbDispositivo, this.combo_segundos]
        });
        
        
       

        //Mapas
        this.panelMapa = new Ext.Panel({  
            padding: '0 0 0 0',
            tbar: this.tbar,
            html:'<div id="map-'+this.idContenedor +'"></div>',
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
			
		
		this.cmbDispositivo.on('clicksearch', function() {
				console.log('iniciar moitoero');
				this.capturarPosicion();
			}, this);
			
		this.timer_id=Ext.TaskMgr.start({
		    run: this.capturarPosicion,
		    interval:parseInt(this.combo_segundos.getValue())*1000,
		    scope:this
		});
				
		this.combo_segundos.on('select',this.evento_combo,this);
    	this.combo_segundos.setValue('10');	
			
        
        
        
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
    
    showMap: function(){
        this.vectorSource = new ol.source.Vector();
        this.vectorLayer = new ol.layer.Vector({
          source: this.vectorSource
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
            layers: [
                new ol.layer.Tile({
                    style: 'Aerial',
                    source: new ol.source.OSM()
                }),
                this.vectorLayer
            ]
        });

        this.map.getView().setZoom(17);
        this.map.getView().setCenter(ol.proj.fromLonLat([-68.131096, -16.514822]));

       /* this.map.on('click', function(e){
            console.log('map click',e)
            this.map.forEachFeatureAtPixel(e.pixel, function(feature, layer) {
                console.log('ffff',feature,layer)
                alert('test test')
            });
        },this);*/
       
       
       

       
       
    },
   
   
    
    addFeatureClick: function(){
        var feature = new ol.Feature(
                new ol.geom.Point(evt.coordinate)
            );
        feature.setStyle(this.iconStyle);
        this.vectorSource.addFeature(feature);
    },
    contador: 275,
    capturarPosicion: function(){
    	var me = this;
    	if(me.cmbDispositivo.getValue()!=''){
    		this.contador ++;
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
    	else{
    		this.limpiarTodos();
    	}
    	
    	
    },
    
    successCarga: function(resp, a, b, c, d) {
    	resp.responseText =resp.responseText.replace('<pre>','').replace('</pre>','')
    	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
    	
    	console.log('posiciones..', reg)
    	var me = this;
    	
    	
    	reg.datos.forEach(function(element) {
    		me.dibujarPunto({latitud : element.latitude  ,
    			            longitud: element.longitude,
    			            codigo: element.placa ,
    			            nombre: element.placa  });
    	});
    	
    	//elimar los los marcadores que no fueron considerados
    	this.dispositivos.forEach(function(e){
    	  	   if(!e.confirmado){
    	  	   	console.log('eliminar....', e)
    	  	   	var index = me.dispositivos.indexOf(e);
    	  	   	//me.dispositivos.splice(index, 1);
    	  	   	console.log('feature id', e.feature.getId());
    	  	   	if(me.vectorSource.getFeatureById(e.feature.getId())){
    	  	   		me.vectorSource.removeFeature(e.feature);
    	  	   		console.log('despeus de eliminar feature id', e.feature.getId());
    	  	   	}
    	  	   	else{
    	  	   		console.log('no esta en el mapa feature id', e.feature.getId());
    	  	   	}
    	  	   	
    	  	   	
    	  	   	//delete e.feature;
    	  	   	//delete e;
    	  	   } 
    	  });
    	
    	
    	//resetea los confirmados
    	this.dispositivos.forEach(function(e){
    	  	   e.confirmado = false;
    	  	   
    	  });
    	
    	
    	
    	var extent = this.vectorSource.getExtent();
        this.map.getView().fit(extent, this.map.getSize()); 
    	
    	//this.map.getView().getGeofencesSource().clear();
        
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
    		console.log('actualizar posicion....',this.getDispositivo(data.codigo));
    		
    		
    		
    		/*
    		if(this.vectorSource.getFeatureById(car.feature.getId())){
    			car.appendCoordinate(data)
    			console.log('actualiza posiciones',data )
    	  	 }
    	  	 else{*/
    	  	 	car.setPos(data);
    	  	 	this.vectorSource.addFeature(car.feature)
    	  	 	console.log('nueva posiciones',data )
    	  	//}
    		
    		
    		
    	}
    	else{
    		var car  = new Phx.vista.car (data);
    		car.confirmado = true;
    	    this.vectorSource.addFeature(car.feature);
    	    this.dispositivos.push(car);
    	    console.log('nuevo dispositivo', data.codigo, data.latitud, data.longitud)
    	}
    	
    	
    },
    
    limpiarTodos : function(){
    	var me = this;
    	this.dispositivos.forEach(function(e){
    	  	  
    	  	   //var index = me.dispositivos.indexOf(e);
    	  	   //me.dispositivos.splice(index, 1);
    	  	   console.log('feature id', e.feature.getId())
    	  	   e.confirmado = false;
    	  	   if(me.vectorSource.getFeatureById(e.feature.getId())){
    	  	   		me.vectorSource.removeFeature(e.feature);
    	  	   		console.log('despeus de eliminar feature id', e.feature.getId());
    	  	   }
    	  	   
    	  	   console.log('despeus de eliminar feature id', e.feature.getId())
    	  	   //delete e.feature;
    	  	   //delete e;
    	  	   
    	  	   
    	  	   
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
			allowBlank : false,
			disableSearchButton : false,
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
		
		
       
		
    
});
</script>