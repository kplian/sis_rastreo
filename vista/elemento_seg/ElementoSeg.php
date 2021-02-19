<?php
/****************************************************************************************
*@package pXP
*@file gen-ElementoSeg.php
*@author  (egutierrez)
*@date 03-07-2020 15:00:54
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 15:00:54    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ElementoSeg=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.ElementoSeg.superclass.constructor.call(this,config);
        this.init();
        this.load({params:{start:0, limit:this.tam_pag}})
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_elemento_seg'
            },
            type:'Field',
            form:true 
        },

        {
            config:{
                name: 'nombre',
                fieldLabel: 'Elemento',
                allowBlank: false,
                anchor: '80%',
                gwidth: 400,
            	maxLength:400
            },
                type:'TextField',
                filters:{pfiltro:'elemseg.nombre',type:'string'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
            config:{
                name:'estado_reg',
                fieldLabel:'Estado',
                allowBlank:false,
                emptyText:'...',
                typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                mode: 'local',
                gwidth: 100,
                store:new Ext.data.ArrayStore({
                    fields: ['ID', 'valor'],
                    data :    [['activo','activo'],
                        ['inactivo','inactivo']]

                }),
                valueField:'ID',
                displayField:'valor',
                //renderer:function (value, p, record){if (value == 1) {return 'si'} else {return 'no'}}
            },
            type:'ComboBox',
            valorInicial: 'activo',
            id_grupo:0,
            grid:true,
            form:true
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
                filters:{pfiltro:'elemseg.fecha_reg',type:'date'},
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
                filters:{pfiltro:'elemseg.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'elemseg.usuario_ai',type:'string'},
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
                filters:{pfiltro:'elemseg.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Elementos de SEguridad y Señalizacion',
    ActSave:'../../sis_rastreo/control/ElementoSeg/insertarElementoSeg',
    ActDel:'../../sis_rastreo/control/ElementoSeg/eliminarElementoSeg',
    ActList:'../../sis_rastreo/control/ElementoSeg/listarElementoSeg',
    id_store:'id_elemento_seg',
    fields: [
		{name:'id_elemento_seg', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_elemento_seg',
        direction: 'ASC'
    },
    bdel:true,
    bsave:false
    }
)
</script>
        
        