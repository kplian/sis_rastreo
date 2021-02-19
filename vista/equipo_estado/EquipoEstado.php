<?php
/****************************************************************************************
*@package pXP
*@file gen-EquipoEstado.php
*@author  (egutierrez)
*@date 09-07-2020 13:52:37
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                09-07-2020 13:52:37    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoEstado=Ext.extend(Phx.gridInterfaz,{

    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.EquipoEstado.superclass.constructor.call(this,config);
        this.init();
        //this.load({params:{start:0, limit:this.tam_pag}})
        this.bloquearMenus();
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_equipo_estado'
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
                filters:{pfiltro:'equiesta.fecha_inicio',type:'date'},
                id_grupo:1,
                grid:true,
                form:true
		},
        {
                   config:{
                       name: 'fecha_final',
                       fieldLabel: 'Fecha Final',
                       allowBlank: true,
                       anchor: '80%',
                       gwidth: 100,
                                   format: 'd/m/Y',
                                   renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
                   },
                       type:'DateField',
                       filters:{pfiltro:'equiesta.fecha_inicio',type:'date'},
                       id_grupo:1,
                       grid:true,
                       form:true
       		},
      	{
            config: {
                name: 'estado',
                fieldLabel: 'Estado',
                anchor: '95%',
                tinit: false,
                allowBlank: true,
                origen: 'CATALOGO',
                gdisplayField: 'estado',
                hiddenName: 'estado',
                gwidth: 55,
                baseParams:{
                    cod_subsistema:'RAS',
                    catalogo_tipo:'tequipo_estado'
                },
                anchor: '80%',
                gwidth: 100,
                valueField: 'codigo',
                hidden: false
            },
            type: 'ComboRec',
            id_grupo: 0,
            grid: true,
            form: true
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
                filters:{pfiltro:'equiesta.estado_reg',type:'string'},
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
                filters:{pfiltro:'equiesta.fecha_reg',type:'date'},
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
                filters:{pfiltro:'equiesta.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'equiesta.usuario_ai',type:'string'},
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
                filters:{pfiltro:'equiesta.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Estado de Vehiculo',
    ActSave:'../../sis_rastreo/control/EquipoEstado/insertarEquipoEstado',
    ActDel:'../../sis_rastreo/control/EquipoEstado/eliminarEquipoEstado',
    ActList:'../../sis_rastreo/control/EquipoEstado/listarEquipoEstado',
    id_store:'id_equipo_estado',
    fields: [
		{name:'id_equipo_estado', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_equipo', type: 'numeric'},
		{name:'fecha_inicio', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_final', type: 'date',dateFormat:'Y-m-d'},
		{name:'estado', type: 'string'},
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
        field: 'id_equipo_estado',
        direction: 'ASC'
    },
    bdel:true,
    bsave:false,
    onReloadPage: function(m) {
    		this.maestro = m;
                    this.Atributos[this.getIndAtributo('id_equipo')].valorInicial = this.maestro.id_equipo;
                    this.store.baseParams = {
                        id_equipo: this.maestro.id_equipo,
                    };
                    this.load({ params: {start: 0,limit: 50 }});

    	}
    }
)
</script>
        
        