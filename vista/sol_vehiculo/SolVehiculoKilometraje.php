<?php
/****************************************************************************************
 *@package pXP
 *@file gen-SolVehiculo.php
 *@author  (egutierrez)
 *@date 02-07-2020 22:13:48
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
#0                02-07-2020 22:13:48    egutierrez            Creacion
#GDV-29              29/12/2020            EGS                 Añadiendo campo deexiste conductores

 *******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.SolVehiculoKilometraje=Ext.extend(Phx.gridInterfaz,{
            fheight:'70%',
            fwidth: '70%',
            nombreVista:'SolVehiculoKilometraje',
            constructor:function(config){
                this.maestro=config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.SolVehiculoKilometraje.superclass.constructor.call(this,config);
                this.init();
                this.iniciarEventos();
                var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
                if(dataPadre){
                    this.onEnablePanel(this, dataPadre);
                } else {
                    this.bloquearMenus();
                }
            },
            iniciarEventos:function(){

            },
            Atributos:[
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
                        name: 'nro_tramite',
                        fieldLabel: 'Nro Tramite',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength:-5
                    },
                    type:'TextField',
                    filters:{pfiltro:'solvehi.nro_tramite',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },

                {
                    config:{
                        name: 'km_inicio',
                        fieldLabel: 'Kilometraje inicial',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,

                    },
                    type:'NumberField',
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'km_final',
                        fieldLabel: 'Kilometraje Final',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,

                    },
                    type:'NumberField',
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'recorrido',
                        fieldLabel: 'Recorrido',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,

                    },
                    type:'NumberField',
                    id_grupo:1,
                    grid:true,
                    form:true
                },
                {
                    config:{
                        name: 'desc_funcionario',
                        fieldLabel: 'Funcionario',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength:-5
                    },
                    type:'TextField',
                    filters:{pfiltro:'solvehi.nro_tramite',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'destino',
                        fieldLabel: 'Destino',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength:-5
                    },
                    type:'TextField',
                    filters:{pfiltro:'solvehi.nro_tramite',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'id_usuario_ai',
                        fieldLabel: '',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'solvehi.id_usuario_ai',type:'numeric'},
                    id_grupo:1,
                    grid:false,
                    form:false
                },
                {
                    config:{
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'usu1.cuenta',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'solvehi.fecha_reg',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:300
                    },
                    type:'TextField',
                    filters:{pfiltro:'solvehi.usuario_ai',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength:4
                    },
                    type:'Field',
                    filters:{pfiltro:'usu2.cuenta',type:'string'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
                {
                    config:{
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
                    },
                    type:'DateField',
                    filters:{pfiltro:'solvehi.fecha_mod',type:'date'},
                    id_grupo:1,
                    grid:true,
                    form:false
                },
            ],
            tam_pag:50,
            title:'solvehi',
            ActList:'../../sis_rastreo/control/SolVehiculo/listarSolVehiculoKilometraje',
            id_store:'id_sol_vehiculo',
            fields: [
                {name:'id_sol_vehiculo', type: 'numeric'},
                {name:'km_final', type: 'string'},
                {name:'nro_tramite', type: 'string'},
                {name:'km_inicio', type: 'string'},
                {name:'recorrido', type: 'numeric'},
                {name:'desc_funcionario', type: 'string'},
                {name:'destino', type: 'string'},


            ],
            sortInfo:{
                field: 'id_sol_vehiculo',
                direction: 'DESC'
            },
            bdel:false,
            bsave:false,
            bedit:false,
            bnew: false,
            onReloadPage: function(m) {
                this.maestro = m;
                this.store.baseParams = {
                    id_equipo: this.maestro.id_equipo,
                    nombreVista:this.nombreVista
                };
                this.load({ params: {start: 0,limit: 50 }});
            },

        }
    )
</script>

