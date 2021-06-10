<!--
#ETR-3400  JJA     24/03/2021  Agregar códigos a reportes Gestión vehicular
#ETR-3506  JJA     30/03/2021  Cambio de codigo
 -->
<font size="10">
    <table   cellpadding="5px"  border="1" >
        <tr>
            <td  style="width: 130px; height: 75px; color: #444444;" >
                <img  style="width: 90px; height: 60px;" src="./../../../lib/<?php echo $_SESSION['_DIR_LOGO'];?>" alt="Logo">
            </td>
            <!--<td align="center" style="width: 325px; color: #444444;" >
                <h3> Solicitud de Autorización para uso de Vehículos</h3>
            </td> -->
            <td style="width: 325px;color: #444444; text-align:center; " >
                <div style="margin-top: 10px">
                    <b  style="font-size: 1.4em; display: flex;align-items: center;"> Autorización para uso de Vehículos</b> <!-- #ETR-3400-->
                </div>
            </td>
            <td style="width: 197px; color: #444444;text-align:center;  " > <!-- #ETR-3400-->
                <div style="margin-top: 30px">
                    <b style="display: flex;align-items: center;"> <?php echo $this->datos_sol_vehiculo[0]['nro_tramite'] ;?></b>
                    <b>Form. 2-R-2012/1</b> <!-- #ETR-3506-->
                </div>
            </td>
        </tr>
    </table>
</font>