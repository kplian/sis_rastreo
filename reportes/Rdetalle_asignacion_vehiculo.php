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
    Phx.vista.Rdetalle_asignacion_vehiculo=Ext.extend(Phx.gridInterfaz,{

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
                            fieldLabel: 'id_asig_vehiculo',
                            name: 'id_asig_vehiculo'
                        },
                        type:'Field',
                        grid: false,
                        form:true
                    },
                    {
                        config:{
                            name: 'conductor_responsable',
                            fieldLabel: 'Conductor Responsable',
                            allowBlank: true,
                            anchor: '100%',
                            gwidth: 230,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'pe.nombre_completo',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'placa',
                            fieldLabel: 'Placa',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 100,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'eq.placa',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },
                    {
                        config:{
                            name: 'funcionario_solicitante',
                            fieldLabel: 'Funcionario solicitante',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 200,
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
                            name: 'fecha_retorno',
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
                            name: 'nombre_unidad',
                            fieldLabel: 'Nombre unidad',
                            allowBlank: true,
                            anchor: '80%',
                            gwidth: 150,
                            maxLength:10
                        },
                        type:'TextField',
                        filters:{pfiltro:'uo.nombre_unidad',type:'string'},
                        id_grupo:1,
                        grid:true,
                        form:false
                    },


                ];
                Phx.vista.Rdetalle_asignacion_vehiculo.superclass.constructor.call(this,config);

                this.init();
            },

            tam_pag:50,
            title:'Detalle asignacion de vehiculos',
            ActList:'../../sis_rastreo/control/SolVehiculo/ReporteAsignacionVehiculo',
            id_store:'id_asig_vehiculo',
            fields: [
                {name:'id_asig_vehiculo', type: 'numeric'},
                {name:'conductor_responsable', type: 'string'},
                {name:'placa', type: 'string'},
                {name:'funcionario_solicitante', type: 'string'},
                {name:'fecha_retorno', type: 'string'},
                {name:'nombre_unidad', type: 'string'},
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

