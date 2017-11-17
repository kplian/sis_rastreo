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
Phx.vista.EquipoResp = {    
    bsave:false,    
    require:'../../../sis_rastreo/vista/equipo/Equipo.php',
    requireclase:'Phx.vista.Equipo',
    title:'Equipos',
    
    constructor: function(config) {
        Phx.vista.EquipoResp.superclass.constructor.call(this,config);
        this.init;
    },
    tabeast: [{
        url: '../../../sis_rastreo/vista/positions/PositionsUlt.php',
        title: 'Ultima informacion',
        width: '40%',
        cls: 'PositionsUlt'
    }, {
        url: '../../../sis_rastreo/vista/equipo_responsable/EquipoResponsable.php',
        title: 'Conductores',
        width: '40%',
        cls: 'EquipoResponsable'
    }]
    
};
</script>
