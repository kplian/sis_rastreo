<?php
/**
 *@package pXP
 *@file gen-DetalleTipoCentroCosto.php
 *@author  (gvelasquez)
 *@date 03-10-2016 15:47:23
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
ISSUE            FECHA:          AUTOR       DESCRIPCION
#RAS-8           21/05/2021      JJA          Reporte de conductores asignados
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Rdetalle_solicitud_vehiculo=Ext.extend(Phx.gridInterfaz,{

            constructor:function(config){
                var me = this;
                console.log('?',me);
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                this.Atributos=[
                    {
                        //configuracion del componente
                        config:{
                            labelSeparator:'',
                            inputType:'hidden',
                            fieldLabel: 'id_sol_vehiculo',
                            name: 'id_sol_vehiculo'
                        },
                        type:'Field',
                        grid: false,
                        form:true
                    },
                    {
                        config:{
                            name: 'solicitante',
                            fieldLabel: 'Solicitante',
                            allowBlank: true,
                            anchor: '100%',
                            gwidth: 230,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'ceco',
                            fieldLabel: 'Ceco',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 250,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'tcc.codigo',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'inicio',
                            fieldLabel: 'Fecha salida',
                            allowBlank: true,
                            //format: 'd/m/Y',
                            width: 160
                        },
                        type: 'string',
                        id_grupo: 0,
                        grid:true,
                        form: false
                    },
                    {
                        config:{
                            name: 'finalizacion',
                            fieldLabel: 'Fecha retorno',
                            allowBlank: true,
                            //format: 'd/m/Y',
                            width: 160
                        },
                        type: 'string',
                        id_grupo: 0,
                        grid:true,
                        form: false
                    },
                    {
                        config:{
                            name: 'destino',
                            fieldLabel: 'Destino',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 150,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'sol.destino',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'alquiler',
                            fieldLabel: 'Alquiler',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 70,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'sol.nombre_unidad',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'depto',
                            fieldLabel: 'Depto',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 140,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'uo.nombre_unidad',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'gerencia',
                            fieldLabel: 'Gerencia',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 150,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'g.nombre_unidad',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'nro_tramite',
                            fieldLabel: 'Nro Tramite',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 70,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'sol.nro_tramite',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },


                ];
                Phx.vista.Rdetalle_solicitud_vehiculo.superclass.constructor.call(this,config);

                this.init();
            },

            tam_pag:50,
            title:'Detalle solicitud de vehiculos',
            ActList:'../../sis_rastreo/control/SolVehiculo/ReporteConsultaSolcitud',
            id_store:'id_sol_vehiculo',
            fields: [
                {name:'id_sol_vehiculo', type: 'numeric'},
                {name:'solicitante', type: 'string'},
                {name:'ceco', type: 'string'},
                {name:'inicio', type: 'string'},
                {name:'finalizacion', type: 'string'},
                {name:'destino', type: 'string'},
                {name:'depto', type: 'string'},
                {name:'gerencia', type: 'string'},
                {name:'alquiler', type: 'string'},
                {name:'nro_tramite', type: 'string'},
            ],

            sortInfo:{
                field: 'order',
                direction: 'asc'
            },

            loadValoresIniciales:function(){
                Phx.vista.Rdetalle_asignacion_vehiculo.superclass.loadValoresIniciales.call(this);
            },
            onReloadPage:function(param){
                var me = this; console.log("var log ",param);
                this.initFiltro(param);
            },

            initFiltro: function(param){
                this.store.baseParams=param;
                this.load( { params: { start:0, limit: this.tam_pag } });
            },

            bdel:false,
            bsave:false,
            bedit:false,
            bnew:false
        }
    )
</script>

