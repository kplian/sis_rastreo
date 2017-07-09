<?php
/**
*@package pXP
*@file EquipoPosicion
*@author  RCM
*@date 06/07/2017
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoPosicion = {    
    bsave:false,    
    require:'../../../sis_rastreo/vista/equipo/Equipo.php',
    requireclase:'Phx.vista.Equipo',
    title:'Equipos',
    nombreVista: 'EquipoPosicion',
    
    constructor: function(config) {
        Phx.vista.EquipoPosicion.superclass.constructor.call(this,config);
        this.init();
        this.load({params:{start:0, limit:this.tam_pag}})
    },  
    
    tabsouth : [{
		url: '../../../sis_rastreo/vista/positions/Positions.php',
		title: 'Posiciones',
		height: '50%',
		cls: 'Positions'
	}, {
        url: '../../../sis_rastreo/vista/events/Events.php',
        title: 'Eventos',
        height: '50%',
        cls: 'Events'
    }],
    bnew: false,
    bedit: false,
    bdel: false
    
};
</script>
