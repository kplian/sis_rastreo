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
    Phx.vista.FormSolAuto = Ext.extend(Phx.frmInterfaz, {
        constructor : function(config) {

            this.maestro=config.maestro;

            console.log('maestro',this.maestro);
            this.Atributos[0].valorInicial=this.maestro.id_sol_vehiculo
            Phx.vista.FormSolAuto.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();

        },


        Atributos : [

            {
                //configuracion del componente
                config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_sol_vehiculo'
                },
                type:'Field',
                form:true
            },
            {
                config:{
                    name:'tipo_reporte',
                    fieldLabel:'Reporte de ',
                    allowBlank:false,
                    emptyText:'Reporte de',
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',
                    valueField: 'tipo',
                    anchor: '80%',
                    gwidth: 100,
                    width:150,
                    store:new Ext.data.ArrayStore({
                        fields: ['variable', 'valor'],
                        data : [
                            ['auto_PI','Solicitud de Viaje'],
                            ['auto_PII','Asignacion de Vehiculos'],
                            ['auto_PIII','Reporte de Viaje']
                        ]
                    }),
                    valueField: 'variable',
                    displayField: 'valor',
                    /*
                    listeners: {
                        'afterrender': function(combo){
                            combo.setValue('todo');
                        }
                    }*/
                },
                type:'ComboBox',
                form:true
            },


        ],
        title : 'Generar Reporte',
        ActSave : '../../sis_rastreo/control/SolVehiculo/reporteAutorizacion',
        topBar : true,
        botones : false,
        labelSubmit : 'Imprimir',
        tooltipSubmit : '<b>Generar Reporte</b>',


        tipo : 'reporte',
        clsSubmit : 'bprint',
        successSave:function(resp){
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
                Ext.Msg.alert('Información',this.mensajeExito);
                Phx.CP.getPagina(this.idContenedorPadre).reload();
                this.panel.close();
            }
        },
    })
</script>