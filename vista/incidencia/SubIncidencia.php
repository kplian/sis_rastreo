<?php
/**
 *@package pXP
 *@file SolVehiculo.php
 *@author  (admin)
 *@date 07-03-2019 13:53:18
 *@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.SubIncidencia={
        require:'../../../sis_rastreo/vista/incidencia/IncidenciaBase.php',
        requireclase:'Phx.vista.IncidenciaBase',
        title:'SubIncidencia',
        nombreVista: 'SubIncidencia',
        constructor:function(config){
            this.maestro=config.maestro;
            //llama al constructor de la clase padre
            Phx.vista.SubIncidencia.superclass.constructor.call(this,config);
            this.init();
           this.bloquearMenus();

        },
        preparaMenu:function(n){
            var data = this.getSelectedData();
            var tb =this.tbar;
            Phx.vista.SubIncidencia.superclass.preparaMenu.call(this,n);
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.SubIncidencia.superclass.liberaMenu.call(this);
            if(tb){
            }
            return tb
        },
        onReloadPage: function(m) {
            this.maestro = m;
            this.Atributos[this.getIndAtributo('id_incidencia_fk')].valorInicial = this.maestro.id_incidencia;
            this.store.baseParams = {
                id_incidencia_fk: this.maestro.id_incidencia,
                nombreVista:this.nombreVista ,
            };
            this.load({ params: {start: 0,limit: 50 }});
        },
    }
</script>

