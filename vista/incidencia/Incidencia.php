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
    Phx.vista.Incidencia={
        require:'../../../sis_rastreo/vista/incidencia/IncidenciaBase.php',
        requireclase:'Phx.vista.IncidenciaBase',
        title:'Incidencia',
        nombreVista: 'Incidencia',
        constructor:function(config){
            this.maestro=config.maestro;
            //console.log('maestro',this.maestro.id_funcionario);
            //this.Atributos[this.getIndAtributo('id_funcionario')].valorInicial = this.maestro.id_funcionario;
            //llama al constructor de la clase padre
            Phx.vista.Incidencia.superclass.constructor.call(this,config);
            this.init();
            this.load({params:{start:0,
                    limit:this.tam_pag ,
                    nombreVista:this.nombreVista,
                }});

        },
        preparaMenu:function(n){
            var data = this.getSelectedData();
            var tb =this.tbar;
            Phx.vista.Incidencia.superclass.preparaMenu.call(this,n);
            return tb
        },
        liberaMenu:function(){
            var tb = Phx.vista.Incidencia.superclass.liberaMenu.call(this);
            if(tb){
            }
            return tb
        },
        tabsouth: [{
            url: '../../../sis_rastreo/vista/incidencia/SubIncidencia.php',
            title: 'SubIncidencia',
            height: '50%',
            cls: 'SubIncidencia'
        },],
    }
</script>
		
		