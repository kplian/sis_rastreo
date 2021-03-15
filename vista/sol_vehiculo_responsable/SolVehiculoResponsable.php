<?php
/****************************************************************************************
*@package pXP
*@file gen-SolVehiculoResponsable.php
*@author  (egutierrez)
*@date 12-03-2021 14:10:00
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                12-03-2021 14:10:00    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SolVehiculoResponsable=Ext.extend(Phx.gridInterfaz,{
    nombreVista:'SolVehiculoResponsable',
    estado:'',
    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.SolVehiculoResponsable.superclass.constructor.call(this,config);
        this.init();
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        } else {
            this.bloquearMenus();
        }
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_sol_vehiculo_responsable'
            },
            type:'Field',
            form:true 
        },

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
        {//#GDV-37
            config: {
                name: 'id_responsable',
                fieldLabel: 'Conductor Responsable',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/Responsable/listarResponsable',
                    id: 'id_responsable',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_responsable', 'desc_persona', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'conduc.id_responsable#per.nombre_completo1#conduc.codigo'}
                }),
                valueField: 'id_responsable',
                displayField: 'desc_persona',
                gdisplayField: 'desc_persona',
                hiddenName: 'id_responsable',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_responsable']);
                },
                turl:'../../../sis_rastreo/vista/responsable/Responsable.php',
                ttitle:'Responsable',
                tconfig:{width:600,height:600},
                tdata:{},
                tcls:'Responsable',
                pid:this.idContenedor,
            },
            type: 'TrigguerCombo',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.desc_persona',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'fecha_inicio',
                fieldLabel: 'Fecha Inicio',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
                type:'DateField',
                filters:{pfiltro:'solvere.fecha_inicio',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'fecha_fin',
                fieldLabel: 'Fecha Fin',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                            format: 'd/m/Y', 
                            renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
            },
                type:'DateField',
                filters:{pfiltro:'solvere.fecha_fin',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'solvere.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
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
                filters:{pfiltro:'solvere.fecha_reg',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		},
        {
            config:{
                name: 'id_usuario_ai',
                fieldLabel: 'Fecha creación',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:4
            },
                type:'Field',
                filters:{pfiltro:'solvere.id_usuario_ai',type:'numeric'},
                id_grupo:1,
                grid:false,
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
                filters:{pfiltro:'solvere.usuario_ai',type:'string'},
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
                filters:{pfiltro:'solvere.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Asignación de conductores',
    ActSave:'../../sis_rastreo/control/SolVehiculoResponsable/insertarSolVehiculoResponsable',
    ActDel:'../../sis_rastreo/control/SolVehiculoResponsable/eliminarSolVehiculoResponsable',
    ActList:'../../sis_rastreo/control/SolVehiculoResponsable/listarSolVehiculoResponsable',
    id_store:'id_sol_vehiculo_responsable',
    fields: [
		{name:'id_sol_vehiculo_responsable', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_sol_vehiculo', type: 'numeric'},
		{name:'id_responsable', type: 'numeric'},
		{name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'solicitud', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_responsable', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_sol_vehiculo_responsable',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage: function(m) {
        this.maestro = m;
        this.Atributos[this.getIndAtributo('id_sol_vehiculo')].valorInicial = this.maestro.id_sol_vehiculo;
        this.estado = this.maestro.estado;
        this.store.baseParams = {
            id_sol_vehiculo: this.maestro.id_sol_vehiculo,
            nombreVista:this.nombreVista
        };
        this.load({ params: {start: 0,limit: 50 }});
    },
    onButtonNew:function(){
        //llamamos primero a la funcion new de la clase padre por que reseta el valor los componentes
        Phx.vista.SolVehiculoResponsable.superclass.onButtonNew.call(this);
        this.Cmp.id_responsable.enable();
        this.Cmp.id_responsable.store.baseParams.tipo_responsable = 'conductor';
        this.Cmp.id_responsable.on('expand', function (Combo) {
            this.Cmp.id_responsable.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_responsable.setValue(r[0].data.id_responsable);
                    }else{
                        this.Cmp.id_responsable.reset();
                    }
                }, scope : this
            });        }, this);
    },
    onButtonEdit:function(){
        //llamamos primero a la funcion new de la clase padre por que reseta el valor los componentesSS
        Phx.vista.SolVehiculoResponsable.superclass.onButtonEdit.call(this);
        var data = this.getSelectedData();
        console.log(data.id_responsable);
        if(data.solicitud == 't' ){
            this.Cmp.id_responsable.disable();
            this.Cmp.id_responsable.store.baseParams.tipo_responsable = 'personal_autorizado'
        }else{
            this.Cmp.id_responsable.enable();
            this.Cmp.id_responsable.store.baseParams.tipo_responsable = 'conductor'
        };

        this.Cmp.id_responsable.store.baseParams.query = data.id_responsable;//#GDV-37
        this.Cmp.id_responsable.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {
                    this.Cmp.id_responsable.setValue(data.id_responsable);
                }else{
                    this.Cmp.id_responsable.reset();
                }
            }, scope : this
        });

    },
    preparaMenu:function(n){
        var data = this.getSelectedData();
        var tb =this.tbar;
        console.log('data',data);
        Phx.vista.SolVehiculoResponsable.superclass.preparaMenu.call(this,n);
        if( this.estado == 'vobojefeserv' ){
            this.getBoton('edit').enable();
            if(data.solicitud == 't' ){
                this.getBoton('del').disable();
            }else{
                this.getBoton('del').enable();
            };
        }else{
            this.getBoton('edit').disable();
            this.getBoton('del').disable();
        }

        return tb
    },
    liberaMenu:function(){
        var tb = Phx.vista.SolVehiculoResponsable.superclass.liberaMenu.call(this);
        if(tb){
            if( this.estado == 'vobojefeserv' ){
                this.getBoton('new').enable();
            }else{
                this.getBoton('new').disable();
            }
        }
        return tb
    },

    }
)
</script>
        
        