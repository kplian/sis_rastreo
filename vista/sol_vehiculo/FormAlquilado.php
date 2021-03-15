<?php
/**
 *@package pXP
 *@file    ItemEntRec.php
 *@author
 *  *@date
 *@description Reporte Material Entregado/Recibido
 * ISSUE			FECHA			AUTHOR 					DESCRIPCION

 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormAlquilado = Ext.extend(Phx.frmInterfaz, {
        constructor : function(config) {

            this.maestro=config.maestro;

            console.log('maestro',this.maestro);
            this.Atributos[0].valorInicial=this.maestro.id_sol_vehiculo;
            this.Atributos[1].valorInicial=this.maestro.alquiler;
            this.Atributos[2].valorInicial=this.maestro.monto;

            Phx.vista.FormAlquilado.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();


        },
        iniciarEventos:function(){

            if(this.maestro.alquiler == 'si'){
                this.Cmp.monto.enable();
                //this.Cmp.monto.allowBlank = false;
            }else{
                this.Cmp.monto.setValue('');
                this.Cmp.monto.disable();
                //this.Cmp.monto.allowBlank = true;
            }
            this.Cmp.alquiler.on('select',function(combo,record,index){

                if(record.data.valor == 'si'){
                    this.Cmp.monto.enable();
                    //this.Cmp.monto.allowBlank = false;
                }else{
                    this.Cmp.monto.setValue('');
                    this.Cmp.monto.disable();
                    //this.Cmp.monto.allowBlank = true;

                }
            },this)

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
                    name:'alquiler',
                    fieldLabel:'Alquiler',
                    allowBlank:false,
                    emptyText:'...',
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    mode: 'local',
                    anchor: '80%',
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
                valorInicial: 'no',
                filters:{pfiltro:'solvehi.alquiler',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
            },
            {
                config:{
                    name: 'monto',
                    fieldLabel: 'Monto',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,

                },
                type:'NumberField',
                id_grupo:1,
                grid:true,
                form:true
            },

         ],
        title : 'Generar Reporte',
        ActSave : '../../sis_rastreo/control/SolVehiculo/EditFormAlquilado',
        topBar : true,
        botones : false,
        tooltipSubmit : '<b>Generar Reporte</b>',
        successSave: function(resp) {
            this.mensajeExito= 'Datos Guardados'
            Phx.vista.FormAlquilado.superclass.successSave.call(this, resp);
            Phx.CP.getPagina(this.idContenedorPadre).reload();
            this.panel.close();

        }



    })
</script>