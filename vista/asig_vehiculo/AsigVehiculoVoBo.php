<?php
/**
*@package pXP
*@file AsigVehiculo.php
*@author  (admin)
*@date 07-03-2019 13:53:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 *  ISSISSUE			FECHA			AUTHOR 					DESCRIPCION
*  #GDV-29              13/01/2021      EGS                     Se habilita para a asignacion de conductor
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.AsigVehiculoVoBo={
	require:'../../../sis_rastreo/vista/asig_vehiculo/AsigVehiculoBase.php',
	requireclase:'Phx.vista.AsigVehiculoBase',
	title:'AsigVehiculoVoBo',
	nombreVista: 'AsigVehiculoVoBo',
	constructor:function(config){
		this.maestro=config.maestro;
		//console.log('maestro',this.maestro.id_funcionario);
		//this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
    	//llama al constructor de la clase padre
		Phx.vista.AsigVehiculoVoBo.superclass.constructor.call(this,config);
		this.init();
        this.bloquearMenus();

		},
	preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
        Phx.vista.AsigVehiculoVoBo.superclass.preparaMenu.call(this,n);
        this.getBoton('btnElementSegu').enable();
        this.getBoton('btnViaje').enable();
        this.getBoton('btnIncidencia').enable();//#.
        if( this.estado == 'vobojefeserv' && this.nombreVistaPadre == 'SolVehiculoVoBo' ){ //GDV-29
            //this.getBoton('edit').enable();
            this.getBoton('edit').disable();

        }else{
            this.getBoton('edit').disable();
        }
        return tb
     }, 
     liberaMenu:function(){
        var tb = Phx.vista.AsigVehiculoVoBo.superclass.liberaMenu.call(this);
        if(tb){
            this.getBoton('btnElementSegu').disable();
            this.getBoton('btnViaje').disable();
            this.getBoton('btnIncidencia').disable();//#.
            if( this.estado == 'vobojefeserv' && this.nombreVistaPadre == 'SolVehiculoVoBo'){ //GDV-29
                //this.getBoton('new').enable();
                this.getBoton('new').disable();

            }else{
                this.getBoton('new').disable();
            }
        }
       return tb
    },
    bnew:true,//GDV-29
    bedit:true,//GDV-29
    bdel:false,
    bsave:false,
    east: {
        url:'../../../sis_rastreo/vista/elemento_seg_equipo/ElementoSegEquipo.php',
        title:'Elem. seguridad y señalizacion',
        width:'50%',
        height:'50%',
        collapsed:true,//#.
        cls:'ElementoSegEquipo'
    },
	}
</script>
		
		