<?php
/****************************************************************************************
*@package pXP
*@file gen-AsigVehiculoBase.php
*@author  (egutierrez)
*@date 03-07-2020 15:02:14
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 15:02:14    egutierrez            Creacion    
#GDV-29               13/01/2021            EGS                 Se habilita la asignacion de vehiculos a jefe de servicio
GDV-32                18/02/2021            EGS                 Se habilita que se pueda cambiar de tipo de equipo en la asignacion
*******************************************************************************************/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AsigVehiculoBase=Ext.extend(Phx.gridInterfaz,{
    alquiler:'',
    existe_conductor:'',
    id_tipo_equipo:'',
    estado:'',//GDV-29
    nombreVistaPadre:'',
    id_sol_vehiculo:'', //#GDV-37
    constructor:function(config){
        this.maestro=config.maestro;

        //llama al constructor de la clase padre
        Phx.vista.AsigVehiculoBase.superclass.constructor.call(this,config);
        this.init();
        this.addButton('btnElementSegu', {
            text : 'Elem. Seguridad y Señalizacion',
            iconCls : 'bexecdb',
            disabled : true,
            handler : this.openElementSegu,
            tooltip : '<b>Lista de elemntos de seguridad y señalizacion del vehiculo en la solicitud</b>'
        });
        this.addButton('btnViaje', {
            text : 'Viaje',
            iconCls : 'bexecdb',
            disabled : true,
            handler : this.openViaje,
            tooltip : '<b>Datos despues del viaje</b>'
        });
        this.addButton('btnIncidencia', {
            text : 'Incidencias Viaje',
            iconCls : 'bexecdb',
            disabled : true,
            handler : this.openIncidencia,
            tooltip : '<b>Datos despues del viaje</b>'
        });
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
                    name: 'id_asig_vehiculo'
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
        {
            config: {
                name: 'id_tipo_equipo',
                fieldLabel: 'Tipo Vehiculo',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/TipoEquipo/listarTipoEquipo',
                    id: 'id_tipo_equipo',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_equipo', 'nombre', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'tipveh.id_tipo_equipo#tipveh.nombre#tipveh.codigo',start: 0,limit: 50}
                }),
                valueField: 'id_tipo_equipo',
                displayField: 'nombre',
                gdisplayField: 'desc_tipo_equipo',
                hiddenName: 'id_tipo_equipo',
                forceSelection: true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'remote',
                pageSize: 15,
                queryDelay: 1000,
                anchor: '80%',
                gwidth: 100,
                minChars: 2,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_tipo_equipo']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.nombre',type: 'string'},
            grid: true,
            form: true
        },
        {
            config: {
                name: 'id_equipo',
                fieldLabel: 'Vehiculo',
                allowBlank: false,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/Equipo/listarEquipoEstado',
                    id: 'id_equipo',
                    root: 'datos',
                    sortInfo: {
                        field: 'id_equipo',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_equipo', 'placa','tipo_equipo','marca','modelo','id_tipo_equipo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'equip.placa',nombreVista:'AsigVehiculo',start:0, limit:15}

                }),
                tpl:'<tpl for=".">\ <div class="x-combo-list-item"><p><b>Placa: </b>{placa}</p>\
                                <p><b>Tipo: </b>{tipo_equipo}</p>\
                               <p><b>Marca: </b>{marca}</p>\
                               <p><b>Modelo </b>{modelo}</p>\
                               </div></tpl>',
                valueField: 'id_equipo',
                displayField: 'placa',
                gdisplayField: 'placa',
                hiddenName: 'id_equipo',
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
                    return '<tpl for="."><div class="x-combo-list-item">\
                                <p><b>Placa: </b>'+record.data['placa']+'</p>\
								<p><b>Tipo: </b>'+record.data['desc_tipo_equipo']+'</p>\
								<p><b>Marca: </b>'+record.data['desc_marca']+'</p>\
								<p><b>Modelo: </b>'+record.data['desc_modelo']+'</p>\
							</p></div></tpl>';
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'equip.placa',type: 'string'},
            grid: true,
            form: true
        },

        {
            config: {
                name: 'id_sol_vehiculo_responsable',
                fieldLabel: 'Conductor',
                allowBlank: true,
                emptyText: 'Elija una opción...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/SolVehiculoResponsable/listarSolVehiculoResponsable',
                    id: 'id_sol_vehiculo_responsable',
                    root: 'datos',
                    sortInfo: {
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_sol_vehiculo_responsable', 'desc_responsable', 'codigo'],
                    remoteSort: true,
                    baseParams: {par_filtro: 'solvere.id_sol_vehiculo_responsable#per.nombre_completo1'}
                }),
                tpl:'<tpl for="."><div class="x-combo-list-item" ><div class="awesomecombo-item {checked}"><p><b></b>{desc_responsable}</p></div>\</div></tpl>',
                valueField: 'id_sol_vehiculo_responsable',
                displayField: 'desc_responsable',
                gdisplayField: 'desc_responsable',
                hiddenName: 'id_sol_vehiculo_responsable',
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
                enableMultiSelect:true,
                renderer : function(value, p, record) {
                    return String.format('{0}', record.data['desc_persona']);
                }
            },
            type: 'AwesomeCombo',
            id_grupo: 0,
            filters: {pfiltro: 'movtip.desc_persona',type: 'string'},
            grid: true,
            form: true
        },
        {
            config:{
                name: 'observaciones',
                fieldLabel: 'observaciones',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:500
            },
            type:'TextArea',
            filters:{pfiltro:'asigvehi.observaciones',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'placa',
                fieldLabel: 'Placa',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:300
            },
            type:'TextField',
            id_grupo:1,
            grid:false,
            form:true
        },
        {
            config:{
                name:'id_marca',
                fieldLabel:'Marca',
                allowBlank:true,
                store: new Ext.data.JsonStore({
                    url: '../../sis_rastreo/control/Marca/listarMarca',
                    id: 'id_marca',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_marca','procedencia','nombre'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'id_marca#procedencia#nombre',start:0,limit:99999}
                }),
                valueField: 'id_marca',
                displayField: 'nombre',
                gdisplayField:'nombre',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{nombre}</b></p></div></tpl>',
                hiddenName: 'id_marca',
                forceSelection : false,
                typeAhead : false,
                hideTrigger : true,
                lazyRender:true,
                mode:'remote',
                pageSize:0,
                queryDelay:1000,
                listWidth:600,
                resizable:true,
                anchor:'80%',
                gwidth: 150,
                minChars : 1,
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_marca']);}
            },
            type:'ComboBox',
            id_grupo:1,
            grid:true,
            form:true
        },
        // {
        //     config:{
        //         name: 'marca',
        //         fieldLabel: 'marca',
        //         allowBlank: true,
        //         anchor: '80%',
        //         gwidth: 100,
        //         maxLength:300
        //     },
        //     type:'TextField',
        //     id_grupo:1,
        //     grid:false,
        //     form:true
        // },
        {
            config:{
                name: 'modelo',
                fieldLabel: 'Modelo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:300
            },
            type:'TextField',
            id_grupo:1,
            grid:false,
            form:true
        },
        {
            config:{
                name:'id_proveedor',
                hiddenName: 'id_proveedor',
                origen:'PROVEEDOR',
                fieldLabel:'Proveedor',
                allowBlank:true,

                tinit:false,
                width: '80%',
                valueField: 'id_proveedor',
                baseParams:{par_filtro:'id_proveedor#desc_proveedor#codigo#nit#rotulo_comercial',start:0,limit:99999}

            },
            type:'ComboRec',//ComboRec
            id_grupo: 0,
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
            filters:{pfiltro:'asigvehi.estado_reg',type:'string'},
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
            filters:{pfiltro:'asigvehi.id_usuario_ai',type:'numeric'},
            id_grupo:1,
            grid:false,
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
            filters:{pfiltro:'asigvehi.fecha_reg',type:'date'},
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
            filters:{pfiltro:'asigvehi.usuario_ai',type:'string'},
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
                name: 'fecha_mod',
                fieldLabel: 'Fecha Modif.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                format: 'd/m/Y',
                renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
            },
            type:'DateField',
            filters:{pfiltro:'asigvehi.fecha_mod',type:'date'},
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

    ],
    tam_pag:50,    
    title:'Asignacion de Vehiculos',
    ActSave:'../../sis_rastreo/control/AsigVehiculo/insertarAsigVehiculo',
    ActDel:'../../sis_rastreo/control/AsigVehiculo/eliminarAsigVehiculo',
    ActList:'../../sis_rastreo/control/AsigVehiculo/listarAsigVehiculo',
    id_store:'id_asig_vehiculo',
    fields: [
		{name:'id_asig_vehiculo', type: 'numeric'},
        {name:'id_sol_vehiculo', type: 'numeric'},
		{name:'id_equipo', type: 'numeric'},
		{name:'observaciones', type: 'string'},
		{name:'id_sol_vehiculo_responsable', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
        {name:'placa', type: 'string'},
        {name:'desc_tipo_equipo', type: 'string'},
        {name:'desc_marca', type: 'string'},
        {name:'desc_modelo', type: 'string'},
        {name:'desc_persona', type: 'string'},
        {name:'km_inicio', type: 'numeric'},
        {name:'km_final', type: 'numeric'},
        {name:'recorrido', type: 'numeric'},
        {name:'observacion_viaje', type: 'string'},
        {name:'fecha_salida_ofi', type: 'date',dateFormat:'Y-m-d'},
        {name:'hora_salida_ofi', type: 'string'},
        {name:'fecha_retorno_ofi', type: 'date',dateFormat:'Y-m-d'},
        {name:'hora_retorno_ofi', type: 'string'},
        {name:'modelo', type: 'string'},
        //{name:'marca', type: 'string'},
        {name:'id_tipo_equipo', type: 'numeric'},
        {name:'id_marca', type: 'string'},
        {name:'incidencia', type: 'string'},
        {name:'id_proveedor', type: 'numeric'},
        
    ],
    sortInfo:{
        field: 'id_asig_vehiculo',
        direction: 'ASC'
    },
    bdel:true,
    bsave:false,
    onReloadPage: function(m) {
        this.maestro = m;
        console.log('this.maestro',this.maestro);
        this.obtenerNombreVistaPadre();

        this.Atributos[this.getIndAtributo('id_sol_vehiculo')].valorInicial = this.maestro.id_sol_vehiculo;

        this.alquiler = this.maestro.alquiler;
        this.estado = this.maestro.estado;//GDV-29
        this.existe_conductor = this.maestro.existe_conductor;
        this.id_tipo_equipo = this.maestro.id_tipo_equipo;
        this.id_sol_vehiculo = this.maestro.id_sol_vehiculo; //#GDV-37
        //es para saber la fecha de salida de la solicitud
        this.Cmp.id_equipo.store.baseParams.id_sol_vehiculo = this.maestro.id_sol_vehiculo;
        this.store.baseParams = {
            id_sol_vehiculo: this.maestro.id_sol_vehiculo,
            nombreVista:this.nombreVista ,
        };
        this.load({ params: {start: 0,limit: 50 }});
    },
    openElementSegu: function(){
        var data = this.getSelectedData();
        var win = Phx.CP.loadWindows(
            '../../../sis_rastreo/vista/elemento_seg_equipo/ElementoSegEquipo.php',
            'Elementos de seguridad y señalizacion', {
                width: '95%',
                height: '90%'
            },
            {maestro:data},
            this.idContenedor,
            'ElementoSegEquipo'
        );
    },
    openViaje: function(){
        var data = this.getSelectedData();
        var win = Phx.CP.loadWindows(
            '../../../sis_rastreo/vista/asig_vehiculo/FormViaje.php',
            'Datos del Viaje', {
                width: '80%',
                height: '80%'
            },
            {maestro:data},
            this.idContenedor,
            'FormViaje'
        );
    },
    openIncidencia: function(){
        var data = this.getSelectedData();
        var win = Phx.CP.loadWindows(
            '../../../sis_rastreo/vista/asig_vehiculo_incidencia/AsigVehiculoIncidencia.php',
            'Incidencias de Viaje', {
                width: '80%',
                height: '80%'
            },
            {maestro:data},
            this.idContenedor,
            'AsigVehiculoIncidencia'
        );
    },
    onButtonNew:function(){
        //llamamos primero a la funcion new de la clase padre por que reseta el valor los componentes
        Phx.vista.AsigVehiculoBase.superclass.onButtonNew.call(this);

        this.Cmp.id_sol_vehiculo_responsable.store.baseParams.id_sol_vehiculo =  this.id_sol_vehiculo; //#GDV-37
        console.log('alquiler',this.id_sol_vehiculo);
        //seteamos un valor fijo que vienen de la vista maestro para id_gui
        if (this.alquiler == 'si') {
            this.mostrarComponente(this.Cmp.placa);
            this.mostrarComponente(this.Cmp.modelo);
            //this.mostrarComponente(this.Cmp.marca);
            //this.mostrarComponente(this.Cmp.id_tipo_equipo);
            this.mostrarComponente(this.Cmp.id_proveedor);
            this.mostrarComponente(this.Cmp.id_marca);

            this.ocultarComponente(this.Cmp.id_equipo);

        }
        else{
            this.ocultarComponente(this.Cmp.placa);
            this.ocultarComponente(this.Cmp.modelo);
            //this.ocultarComponente(this.Cmp.marca);
           // this.ocultarComponente(this.Cmp.id_tipo_equipo);
            this.ocultarComponente(this.Cmp.id_proveedor);
            this.ocultarComponente(this.Cmp.id_marca);


            this.mostrarComponente(this.Cmp.id_equipo);

        }
        // if (this.existe_conductor == 'si') {
        //     this.mostrarComponente(this.Cmp.id_sol_vehiculo_responsable);
        // }else{
        //     this.ocultarComponente(this.Cmp.id_sol_vehiculo_responsable);
        // }

        this.Cmp.id_tipo_equipo.store.baseParams.query = this.id_tipo_equipo;
        this.Cmp.id_tipo_equipo.store.load({params:{start:0,limit:this.tam_pag},
            callback : function (r) {
                if (r.length > 0 ) {
                    this.Cmp.id_tipo_equipo.setValue(r[0].data.id_tipo_equipo);
                }else{
                    this.Cmp.id_tipo_equipo.reset();
                }
            }, scope : this
        });

        this.Cmp.id_tipo_equipo.on('select',function(combo,record,index){//GDV-32

            this.Cmp.id_equipo.store.baseParams.id_tipo_equipo = record.data.id_tipo_equipo;
            this.Cmp.id_equipo.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        // this.Cmp.id_equipo.setValue(r[0].data.id_equipo);
                        this.Cmp.id_equipo.reset();
                    }else{
                        this.Cmp.id_equipo.reset();
                    }
                }, scope : this
            });
        },this)


        this.Cmp.id_equipo.on('expand', function (Combo) {
            this.Cmp.id_equipo.store.baseParams.id_tipo_equipo =this.Cmp.id_tipo_equipo.getValue();
            this.Cmp.id_equipo.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_equipo.setValue(r[0].data.id_equipo);
                    }else{
                        this.Cmp.id_equipo.reset();
                    }
                }, scope : this
            });
        }, this);

        // if( this.estado == 'vobojefeserv' && this.nombreVistaPadre == 'SolVehiculoVoBo' ){ //GDV-32
        //     this.ocultarComponente(this.Cmp.id_tipo_equipo);
        //     this.ocultarComponente(this.Cmp.id_equipo);
        //     this.ocultarComponente(this.Cmp.observaciones);
        //
        // }else{
        //     this.mostrarComponente(this.Cmp.id_tipo_equipo);
        //     this.mostrarComponente(this.Cmp.id_equipo);
        //     this.mostrarComponente(this.Cmp.observaciones);
        // }




    },
    onButtonEdit:function(){
        var data = this.getSelectedData();
        console.log('data',data)
        //llamamos primero a la funcion new de la clase padre por que reseta el valor los componentesSS
        Phx.vista.AsigVehiculoBase.superclass.onButtonEdit.call(this);
        if (this.alquiler == 'si') {
            this.mostrarComponente(this.Cmp.placa);
            this.mostrarComponente(this.Cmp.modelo);
            //this.mostrarComponente(this.Cmp.marca);
            //this.mostrarComponente(this.Cmp.id_tipo_equipo);
            this.mostrarComponente(this.Cmp.id_proveedor);
            this.mostrarComponente(this.Cmp.id_marca);



            this.ocultarComponente(this.Cmp.id_equipo);

            this.Cmp.id_tipo_equipo.store.baseParams.query = data.id_tipo_equipo;
            this.Cmp.id_tipo_equipo.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_tipo_equipo.setValue(r[0].data.id_tipo_equipo);
                    }else{
                        this.Cmp.id_tipo_equipo.reset();
                    }
                }, scope : this
            });

            this.Cmp.id_marca.store.baseParams.query = data.id_marca;
            this.Cmp.id_marca.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_marca.setValue(r[0].data.id_marca);
                    }else{
                        this.Cmp.id_marca.reset();
                    }
                }, scope : this
            });
            this.Cmp.id_proveedor.store.baseParams.query = data.id_proveedor;
            this.Cmp.id_proveedor.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_proveedor.setValue(data.id_proveedor);
                    }else{
                        this.Cmp.id_proveedor.reset();
                    }
                }, scope : this
            });



        }
        else{
            this.ocultarComponente(this.Cmp.placa);
            this.ocultarComponente(this.Cmp.modelo);
            //this.ocultarComponente(this.Cmp.marca);
            //this.ocultarComponente(this.Cmp.id_tipo_equipo);
            this.ocultarComponente(this.Cmp.id_proveedor);
            this.ocultarComponente(this.Cmp.id_marca);


            this.mostrarComponente(this.Cmp.id_equipo);
            this.Cmp.id_tipo_equipo.store.baseParams.query = data.id_tipo_equipo;
            this.Cmp.id_tipo_equipo.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                        this.Cmp.id_tipo_equipo.setValue(data.id_tipo_equipo);
                    }else{
                        this.Cmp.id_tipo_equipo.reset();
                    }
                }, scope : this
            });

        }
        this.Cmp.id_equipo.on('expand', function (Combo) {
            this.Cmp.id_equipo.store.baseParams.id_tipo_equipo =this.Cmp.id_tipo_equipo.getValue();
            this.Cmp.id_equipo.store.reload(true);
        }, this);
        this.Cmp.id_tipo_equipo.on('expand', function (Combo) {
            this.Cmp.id_tipo_equipo.store.baseParams.query = '';
            this.Cmp.id_tipo_equipo.store.load();
        }, this);

        // if (this.existe_conductor == 'si') {
        //     this.mostrarComponente(this.Cmp.id_sol_vehiculo_responsable); //#GDV-37
        // }else{
        //     this.ocultarComponente(this.Cmp.id_sol_vehiculo_responsable); //#GDV-37
        // }

        this.Cmp.id_tipo_equipo.on('select',function(combo,record,index){//GDV-32
            console.log('record',record.data.id_tipo_equipo);
            this.Cmp.id_equipo.store.baseParams.id_tipo_equipo = record.data.id_tipo_equipo;
            this.Cmp.id_equipo.store.load({params:{start:0,limit:this.tam_pag},
                callback : function (r) {
                    if (r.length > 0 ) {
                       // this.Cmp.id_equipo.setValue(r[0].data.id_equipo);
                        this.Cmp.id_equipo.reset();
                    }else{
                        this.Cmp.id_equipo.reset();
                    }
                }, scope : this
            });
        },this)

        // if( this.estado == 'vobojefeserv' && this.nombreVistaPadre == 'SolVehiculoVoBo' ){ //GDV-32
        //     this.ocultarComponente(this.Cmp.id_tipo_equipo);
        //     this.ocultarComponente(this.Cmp.id_equipo);
        //     this.ocultarComponente(this.Cmp.observaciones);
        //
        // }else{
        //     this.mostrarComponente(this.Cmp.id_tipo_equipo);
        //     this.mostrarComponente(this.Cmp.id_equipo);
        //     this.mostrarComponente(this.Cmp.observaciones);
        // }

        this.Cmp.id_sol_vehiculo_responsable.store.baseParams.id_sol_vehiculo =  this.id_sol_vehiculo; //#GDV-37



    },
    obtenerNombreVistaPadre:function(){
        this.nombreVistaPadre =  Phx.CP.getPagina(this.idContenedorPadre).obtenerNombreVista();
    },
    }
)
</script>
        
        