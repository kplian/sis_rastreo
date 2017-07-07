<?php
/**
*@package pXP
*@file ParametrosDistancia
*@author  RCM
*@date 13/07/20147
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ParametrosDistancia = {    
    bsave: false,    
    require: '../../../sis_rastreo/vista/_reportes/Parametros.php',
    requireclase: 'Phx.vista.Parametros',
    title: 'Distancia',
    tipoReporte: 'distance',
    pathReporte: '../../../sis_rastreo/vista/_reportes/ReporteDist.php',
    clsReporte: 'ReporteDist',
    constructor: function(config) {
        Phx.vista.ParametrosDistancia.superclass.constructor.call(this,config);
        this.init;
    }
};
</script>
