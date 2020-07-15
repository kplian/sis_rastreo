<?php
/**
*@package pXP
*@file EquipoResp
*@author  RCM
*@date 06/07/2017
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoEstado = {
    bsave:false,
    require:'../../../sis_rastreo/vista/equipo/Equipo.php',
    requireclase:'Phx.vista.Equipo',
    title:'Equipos Estado',
    nombreVista:'EquipoEstado',

    constructor: function(config) {
        Phx.vista.EquipoEstado.superclass.constructor.call(this,config);
        this.init;
    },
    tabeast: [{
        url: '../../../sis_rastreo/vista/equipo_estado/EquipoEstado.php',
        title: 'Estado',
        width: '50%',
        cls: 'EquipoEstado'
    }]

};
</script>