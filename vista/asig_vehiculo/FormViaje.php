<?php
/**
 *@package pXP
 *@file    ItemEntRec.php
 *@author
 *  *@date
 *@description Reporte Material Entregado/Recibido
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormViaje = Ext.extend(Phx.frmInterfaz, {
        constructor : function(config) {

            this.maestro=config.maestro;

            console.log('maestro',this.maestro);
            this.Atributos[0].valorInicial=this.maestro.id_asig_vehiculo;
            this.Atributos[1].valorInicial=this.maestro.km_inicio;
            this.Atributos[2].valorInicial=this.maestro.km_final;
            this.Atributos[3].valorInicial=this.maestro.recorrido;
            this.Atributos[4].valorInicial=this.maestro.observacion_viaje;
            this.Atributos[5].valorInicial=this.maestro.fecha_salida_ofi;
            this.Atributos[6].valorInicial=this.maestro.hora_salida_ofi;
            this.Atributos[7].valorInicial=this.maestro.fecha_retorno_ofi;
            this.Atributos[8].valorInicial=this.maestro.hora_retorno_ofi;
            this.Atributos[9].valorInicial=this.maestro.incidencia;
            Phx.vista.FormViaje.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();

           this.Cmp.hora_salida_ofi.value=this.maestro.hora_salida_ofi;
            this.Cmp.hora_salida_ofi.originalValue=this.maestro.hora_salida_ofi;
            console.log('f',this.Cmp.hora_salida_ofi);
        },
        iniciarEventos:function(){
            this.Cmp.km_inicio.setValue(this.maestro.km_inicio);
            this.Cmp.km_final.setValue(this.maestro.km_final);
            this.Cmp.recorrido.setValue(this.maestro.recorrido);
            this.Cmp.observacion_viaje.setValue(this.maestro.observacion_viaje);

        },
        Atributos : [

            {
                //configuracion del componente
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_asig_vehiculo'
                },
                type:'Field',
                form:true
            },
            {
                config:{
                    name: 'km_inicio',
                    fieldLabel: 'Kilometraje Inicial',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:4
                },
                type:'Field',
                id_grupo:1,
                grid:false,
                form:true
            },
            {
                config:{
                    name: 'km_final',
                    fieldLabel: 'Kilometraje Final',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:4
                },
                type:'Field',
                id_grupo:1,
                grid:false,
                form:true
            },
            {
                config:{
                    name: 'recorrido',
                    fieldLabel: 'Recorrido',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:4
                },
                type:'Field',
                id_grupo:1,
                grid:false,
                form:true
            },
            {
                config:{
                    name: 'observacion_viaje',
                    fieldLabel: 'Observaciones Viaje',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:1000
                },
                type:'TextArea',
                id_grupo:1,
                grid:false,
                form:true
            },
            {
                config:{
                    name: 'fecha_salida_ofi',
                    fieldLabel: 'Fecha Salida Oficial',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    format: 'd/m/Y',
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                },
                type:'DateField',
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'hora_salida_ofi',
                    fieldLabel: 'Hora Salida Oficial',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:8,
                    format: 'H:i:s',
                    minValue: '5:00',
                    maxValue: '21:00',
                },
                type:'TimeField',
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'fecha_retorno_ofi',
                    fieldLabel: 'Fecha Retorno Oficial',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    format: 'd/m/Y',
                    renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                },
                type:'DateField',
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'hora_retorno_ofi',
                    fieldLabel: 'Hora Retorno Oficial',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    maxLength:8,
                    format: 'H:i:s',
                    minValue: '5:00',
                    maxValue: '21:00',
                },
                type:'TimeField',
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name:'incidencia',
                    fieldLabel:'Tiene Incidencias',
                    allowBlank:false,
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',
                    gwidth: 100,
                    store:new Ext.data.ArrayStore({
                        fields: ['ID', 'valor'],
                        data :    [['si','si'],
                            ['no','no']]

                    }),
                    valueField:'ID',
                    displayField:'valor',
                    //renderer:function (value, p, record){if (value == 1) {return 'si'} else {return 'no'}}
                },
                type:'ComboBox',
                valorInicial:'no',
                id_grupo:0,
                grid:true,
                form:true
            },
         ],
        title : 'Generar Reporte',
        ActSave : '../../sis_rastreo/control/AsigVehiculo/EditFormViaje',
        topBar : true,
        botones : false,
        tooltipSubmit : '<b>Generar Reporte</b>',
        successSave:function(resp){
            console.log('resp',resp);
            if(this.tipo=='reporte'){
                Phx.CP.loadingHide();
                var objRes = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                var nomRep=objRes.ROOT.detalle.archivo_generado;
                if(Phx.CP.config_ini.x==1){
                    nomRep=Phx.CP.CRIPT.Encriptar(nomRep);
                }
                window.open('../../../lib/lib_control/Intermediario.php?r='+nomRep);
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            } else{
                Phx.CP.loadingHide();
                //Ext.Msg.alert('Información',this.mensajeExito);
                if(this.maestro.incidencia == 'si'){
                    this.openIncidencia();
                }
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            }
        },

        openIncidencia: function(){
            var data = this.getSelectedData();
            var win = Phx.CP.loadWindows(
                '../../../sis_rastreo/vista/asig_vehiculo_incidencia/AsigVehiculoIncidencia.php',
                'Incidencias de Viaje', {
                    width: '80%',
                    height: '80%'
                },
                {maestro:this.maestro},
                this.idContenedor,
                'AsigVehiculoIncidencia'
            );
        },

    })
</script>