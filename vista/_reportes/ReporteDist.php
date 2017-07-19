<?php
/**
*@package pXP
*@file ReporteDist.php
*@author  RCM
*@date 13/07/2017
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ReporteDist=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config;
        //llama al constructor de la clase padre
        Phx.vista.ReporteDist.superclass.constructor.call(this,config);
        this.init();

        this.store.setBaseParam('start', 0);
        this.store.setBaseParam('limit', this.tam_pag);
        this.store.setBaseParam('fecha_ini', this.maestro.fecha_ini);
        this.store.setBaseParam('fecha_fin',this.maestro.fecha_fin);
        this.store.setBaseParam('ids',this.maestro.ids);


        this.load({
            params:{
                start:0,
                limit:this.tam_pag,
                fecha_ini: this.maestro.fecha_ini,
                fecha_fin: this.maestro.fecha_fin,
                ids: this.maestro.ids
            }
        });
    },
            
    Atributos:[
        {
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_equipo'
            },
            type:'Field',
            form:true 
        }, {
            config:{
                name: 'uniqueid',
                fieldLabel: 'IMEI',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.uniqueid',type:'string'},
            grid:true
        }, {
            config:{
                name: 'servertime',
                fieldLabel: 'Fecha/Hora',
                gwidth: 120,
                format: 'd/m/Y', 
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
            type:'Field',
            filters:{pfiltro:'disp.servertime',type:'string'},
            grid:true
        }, {
            config:{
                name: 'placa',
                fieldLabel: 'Placa',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.placa',type:'string'},
            grid:true
        }, {
            config:{
                name: 'distance',
                fieldLabel: 'Distancia (km.)',
                gwidth: 100
            },
            type:'Field',
            grid:true
        }, {
            config:{
                name: 'desc_type',
                fieldLabel: 'Evento',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.desc_type',type:'string'},
            grid:true
        }, {
            config:{
                name: 'desc_equipo',
                fieldLabel: 'Vehículo',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.desc_equipo',type:'string'},
            grid:true
        }, {
            config:{
                name: 'desc_tipo_equipo',
                fieldLabel: 'Tipo',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.tipo_equipo',type:'string'},
            grid:true
        }, {
            config:{
                name: 'marca',
                fieldLabel: 'Marca',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.marca',type:'string'},
            grid:true
        }, {
            config:{
                name: 'modelo',
                fieldLabel: 'Modelo',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.modelo',type:'string'},
            grid:true
        }, {
            config:{
                name: 'latitude',
                fieldLabel: 'Latitud',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.latitude',type:'string'},
            grid:true
        }, {
            config:{
                name: 'longitude',
                fieldLabel: 'Longitud',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.longitude',type:'string'},
            grid:true
        }, {
            config:{
                name: 'altitude',
                fieldLabel: 'Altitud',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.altitude',type:'string'},
            grid:true
        }, {
            config:{
                name: 'course',
                fieldLabel: 'Rumbo',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.course',type:'string'},
            grid:true
        }, {
            config:{
                name: 'address',
                fieldLabel: 'Dirección',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.address',type:'string'},
            grid:true
        }, {
            config:{
                name: 'attributes',
                fieldLabel: 'Atributos Posicion',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.attributes_pos',type:'string'},
            grid:true
        }, {
            config:{
                name: 'accuracy',
                fieldLabel: 'Precisión',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.accuracy',type:'string'},
            grid:true
        }, {
            config:{
                name: 'attributes_event',
                fieldLabel: 'Atributos Eventos',
                gwidth: 100
            },
            type:'Field',
            filters:{pfiltro:'disp.attributes',type:'string'},
            grid:true
        }
    ],
    tam_pag:50, 
    title:'ReporteDist',
    ActList:'../../sis_rastreo/control/Reporte/listarPosicionesRango',
    fields: [
        {name:'id_equipo', type: 'numeric'},
        {name:'uniqueid', type: 'numeric'},
        {name:'marca', type: 'string'},
        {name:'modelo', type: 'string'},
        {name:'placa', type: 'string'},
        {name:'latitude', type: 'numeric'},
        {name:'longitude', type: 'numeric'},
        {name:'altitude', type: 'numeric'},
        {name:'speed', type: 'numeric'},
        {name:'course', type: 'numeric'},
        {name:'address', type: 'numeric'},
        {name:'attributes', type: 'string'},
        {name:'accuracy', type: 'numeric'},
        {name:'desc_equipo', type: 'string'},
        {name:'eventid', type: 'numeric'},
        {name:'type', type: 'string'},
        {name:'attributes_event', type: 'string'},
        {name:'desc_type', type: 'string'},
        {name:'tipo_equipo', type: 'string'},
        {name:'servertime', type: 'date',dateFormat:'Y-m-d H:i:s.u'},'distance','desc_tipo_equipo'
    ],
    sortInfo:{
        field: 'pos.servertime',
        direction: 'ASC'
    },
    bdel: false,
    bsave: false,
    bnew: false,
    bedit: false
})
</script>
        
        