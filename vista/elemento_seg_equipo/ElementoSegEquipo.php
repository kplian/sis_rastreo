<?php
/****************************************************************************************
*@package pXP
*@file gen-ElementoSegEquipo.php
*@author  (egutierrez)
*@date 03-07-2020 14:59:28
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 14:59:28    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ElementoSegEquipo=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        console.log('m',this.maestro);
        if (this.maestro!=undefined){
            this.Atributos[1].valorInicial=this.maestro.id_equipo;
            this.Atributos[2].valorInicial=this.maestro.id_asig_vehiculo;
        }

        //llama al constructor de la clase padre
        Phx.vista.ElementoSegEquipo.superclass.constructor.call(this,config);
        this.init();
        //this.iniciarEventos();
        if (this.maestro==undefined){
            this.bloquearMenus();
        }else{
            this.load({params:{start:0, limit:this.tam_pag, id_asig_vehiculo: this.maestro.id_asig_vehiculo }});
        }

    },
    iniciarEventos:function(){
        this.Cmp.id_equipo.setValue(this.maestro.id_equipo);
        this.Cmp.id_asig_vehiculo.setValue(this.maestro.id_asig_vehiculo);

    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_elemento_seg_equipo'
            },
            type:'Field',
            form:true 
        },
        {
            //configuracion del componente
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_equipo'
            },
            type:'Field',
            form:true
        },
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
            config: {
                name: 'id_elemento_seg',
                fieldLabel: 'Elemento',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/ElementoSeg/listarElementoSeg',
                    id: 'id_elemento_seg',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_elemento_seg', 'nombre'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'elemseg.nombre',estado_reg:'activo'}
                }),
                valueField: 'id_elemento_seg',
                displayField: 'nombre',
                gdisplayField: 'desc_elemento_seg',
                hiddenName: 'id_elemento_seg',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '100%',
                gwidth: 150,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_elemento_seg']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'elemseg.nombre',type: 'string'},
            grid: true,
            form: true
        },

        {
            config:{
                name: 'existe',
                fieldLabel: 'existe',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                renderer:function (value,p,record){
                    var checked = '';
                    var state = '';
                    // console.log('value',record)
                    if(value === 't'){
                        checked = 'checked';
                    }
                    state ='disabled';
                    return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>',checked, state);
                }
            },
                type:'Checkbox',
                filters:{pfiltro:'elemav.existe',type:'boolean'},
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
            filters:{pfiltro:'elemav.estado_reg',type:'string'},
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
                filters:{pfiltro:'elemav.fecha_reg',type:'date'},
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
                filters:{pfiltro:'elemav.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'elemav.usuario_ai',type:'string'},
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
                filters:{pfiltro:'elemav.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Elemenotos de seguridad asignados a un vehiculo',
    ActSave:'../../sis_rastreo/control/ElementoSegEquipo/insertarElementoSegEquipo',
    ActDel:'../../sis_rastreo/control/ElementoSegEquipo/eliminarElementoSegEquipo',
    ActList:'../../sis_rastreo/control/ElementoSegEquipo/listarElementoSegEquipo',
    id_store:'id_elemento_seg_equipo',
    fields: [
		{name:'id_elemento_seg_equipo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_elemento_seg', type: 'numeric'},
		{name:'id_equipo', type: 'numeric'},
		{name:'existe', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'desc_elemento_seg', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_elemento_seg_equipo',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage: function(m) {
        this.maestro = m;
        console.log('maestro',this.maestro);
        this.Atributos[this.getIndAtributo('id_asig_vehiculo')].valorInicial = this.maestro.id_asig_vehiculo;
        this.Atributos[this.getIndAtributo('id_equipo')].valorInicial = this.maestro.id_equipo;
        this.store.baseParams = {
            id_asig_vehiculo: this.maestro.id_asig_vehiculo
        };
        this.load({ params: {start: 0,limit: 50 }});
    },
    onButtonEdit: function () {
        Phx.vista.ElementoSegEquipo.superclass.onButtonEdit.call(this);
        //console.log("ver editar ",this.Cmp.habilitado);
        //console.log("ver editar2 ",this.sm.selections.items[0].data.habilitado);
        if(this.sm.selections.items[0].data.existe=='t'){
            this.Cmp.existe.setValue(true);
        }
    },

    }
)
</script>
        
        