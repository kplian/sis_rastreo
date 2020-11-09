<?php
/****************************************************************************************
*@package pXP
*@file gen-NominaPersona.php
*@author  (egutierrez)
*@date 03-07-2020 14:58:25
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 14:58:25    egutierrez            Creacion    
 #   

*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.NominaPersonaBase=Ext.extend(Phx.gridInterfaz,{
    fecha:'',
    constructor:function(config){
        this.maestro=config.maestro;
        //llama al constructor de la clase padre
        Phx.vista.NominaPersonaBase.superclass.constructor.call(this,config);
        this.init();
        this.iniciarEventos();
        //this.load({params:{start:0, limit:this.tam_pag}})
        var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
        if(dataPadre){
            this.onEnablePanel(this, dataPadre);
        } else {
            this.bloquearMenus();
        }

    },
    iniciarEventos:function(){
        this.fecha = new Date();
        this.Cmp.id_funcionario.store.baseParams.fecha = this.fecha;
    },
            
    Atributos:[
        {
            //configuracion del componente
            config:{
                    labelSeparator:'',
                    inputType:'hidden',
                    name: 'id_nomina_persona'
            },
            type:'Field',
            form:true 
        },
        {
            config:{
                name : 'funcionario',
                fieldLabel : 'Funcionario ??',
                allowBlank: false,
                items: [
                    {boxLabel: 'No', name: 'funcionario', inputValue: 'no', checked: true},
                    {boxLabel: 'Si', name: 'funcionario', inputValue: 'si'}

                ],
            },
            type : 'RadioGroupField',
            id_grupo : 1,
            form : true,
            grid:false
        },
        {
            config:{
                name:'id_funcionario',
                hiddenName: 'id_funcionario',
                origen:'FUNCIONARIOCAR',
                fieldLabel:'Funcionario Solicitante',
                allowBlank:true,
                gwidth:200,
                valueField: 'id_funcionario',
                gdisplayField: 'desc_funcionario',
                baseParams: {par_filtro: 'id_funcionario#desc_funcionario1'},
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario']);}
            },
            type:'ComboRec',//ComboRec
            id_grupo:0,
            filters:{pfiltro:'fun.desc_funcionario1',type:'string'},
            bottom_filter:false,
            grid:false,
            form:true,
            bottom_filter:true //#20
        },

        {
            config:{
                name: 'nombre',
                fieldLabel: 'nombre',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
            	maxLength:500
            },
                type:'TextField',
                filters:{pfiltro:'nomiper.nombre',type:'string'},
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
            filters:{pfiltro:'nomiper.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
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
                filters:{pfiltro:'nomiper.fecha_reg',type:'date'},
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
                filters:{pfiltro:'nomiper.id_usuario_ai',type:'numeric'},
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
                filters:{pfiltro:'nomiper.usuario_ai',type:'string'},
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
                filters:{pfiltro:'nomiper.fecha_mod',type:'date'},
                id_grupo:1,
                grid:true,
                form:false
		}
    ],
    tam_pag:50,    
    title:'Nomina Personas',
    ActSave:'../../sis_rastreo/control/NominaPersona/insertarNominaPersona',
    ActDel:'../../sis_rastreo/control/NominaPersona/eliminarNominaPersona',
    ActList:'../../sis_rastreo/control/NominaPersona/listarNominaPersona',
    id_store:'id_nomina_persona',
    fields: [
		{name:'id_nomina_persona', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'id_sol_vehiculo', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'id_funcionario', type: 'numeric'},
        {name:'funcionario', type: 'string'},
        
    ],
    sortInfo:{
        field: 'id_nomina_persona',
        direction: 'ASC'
    },
    bdel:true,
    bsave:true,
    onReloadPage: function(m) {
        this.maestro = m;
        this.Atributos[this.getIndAtributo('id_sol_vehiculo')].valorInicial = this.maestro.id_sol_vehiculo;
        this.store.baseParams = {
            id_sol_vehiculo: this.maestro.id_sol_vehiculo,
            nombreVista:this.nombreVista
        };
        this.load({ params: {start: 0,limit: 50 }});
    },
    onButtonNew: function(){
        Phx.vista.NominaPersonaBase.superclass.onButtonNew.call(this);
        this.ocultarComponente(this.Cmp.id_funcionario);
        this.mostrarComponente(this.Cmp.nombre);
        this.Cmp.id_funcionario.reset();
        this.Cmp.funcionario.on('change', function(cmp, check){

            if(check.getRawValue() =='no'){
                this.ocultarComponente(this.Cmp.id_funcionario);
                this.mostrarComponente(this.Cmp.nombre);
                this.Cmp.id_funcionario.reset();

            }
            else{
                this.mostrarComponente(this.Cmp.id_funcionario);
                this.ocultarComponente(this.Cmp.nombre);
                this.Cmp.nombre.reset();
            }
        }, this);

    },
    onButtonEdit: function(){
        var data = this.getSelectedData();
        Phx.vista.NominaPersonaBase.superclass.onButtonEdit.call(this);

        this.Cmp.funcionario.on('change', function(cmp, check){

            if(check.getRawValue() =='no'){
                this.ocultarComponente(this.Cmp.id_funcionario);
                this.mostrarComponente(this.Cmp.nombre);
                this.Cmp.id_funcionario.reset();
            }
            else{
                this.mostrarComponente(this.Cmp.id_funcionario);
                this.ocultarComponente(this.Cmp.nombre);
                this.Cmp.nombre.reset();
            }
        }, this);
        console.log('v',this.Cmp.funcionario);
        if( data.id_funcionario != null ){
            console.log('r',this.Cmp.funcionario);
            this.Cmp.funcionario.setValue('si');
            this.Cmp.id_funcionario.store.baseParams.query =  data.id_funcionario;
            this.Cmp.id_funcionario.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {

                        this.Cmp.id_funcionario.setValue(r[0].data.id_funcionario);
                    }

                }, scope : this
            });
            this.Cmp.id_funcionario.enable();
        }else{
            this.Cmp.funcionario.setValue('no');

        }
    },

    }
)
</script>
        
        