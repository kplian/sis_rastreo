<?php
/**
*@package pXP
*@file EquipoLoc
*@author  RCM
*@date 06/07/2017
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EquipoLoc = {    
    bsave:false,    
    require:'../../../sis_rastreo/vista/equipo/Equipo.php',
    requireclase:'Phx.vista.Equipo',
    title:'Equipos',
    
    constructor: function(config) {
        //Phx.vista.EquipoLoc.superclass.constructor.call(this,config);
        Phx.vista.Equipo.superclass.constructor.call(this,config);
        this.bloquearMenus();
        this.init();
        if(Phx.CP.getPagina(this.idContenedorPadre)){
         var dataMaestro=Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
         if(dataMaestro){ 
            this.onEnablePanel(this,dataMaestro)
         }
        }
    },
    loadValoresIniciales: function() {
        Phx.vista.EquipoLoc.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_localizacion').setValue(this.maestro.id_localizacion);
    },
    onReloadPage: function(m) {
        this.maestro=m; 
        var IdLoc=-1;
        if(this.maestro.id!='id'){
            IdLoc = this.maestro.id_localizacion;
        }

        this.store.baseParams={id_localizacion: IdLoc};
        this.load({params:{start:0, limit:this.tam_pag}});
    },
    postReloadPage: function(m){
        if(m.id=='id'){
            this.bloquearMenus();
        }
    }
    
};
</script>
