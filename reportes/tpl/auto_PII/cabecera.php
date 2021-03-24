<!--
#ETR-3400  JJA     24/03/2021  Agregar códigos a reportes Gestión vehicular
 -->

    <table   cellpadding="5px"  border="1" >
        <tr>
            <td  style="width: 130px; height: 75px; color: #444444;" >
                <img  style="width: 90px; height: 60px;" src="./../../../lib/<?php echo $_SESSION['_DIR_LOGO'];?>" alt="Logo"> <!-- #ETR-3400-->
            </td>
            <!--<td align="center" style="width: 325px; color: #444444;" >
                <h3> Solicitud de Autorización para uso de Vehículos</h3>
            </td> -->
            <td style="width: 325px;color: #444444; text-align:center; " >
                <div style="margin-top: 10px">
                    <b  style="font-size: 1.4em; display: flex;align-items: center;"> Asignación de Vehículo y Conductor</b>
                </div>
            </td>
            <td style="width: 197px; color: #444444;text-align:center;  " >
                <div style="margin-top: 30px">
                    <b style="display: flex;align-items: center;"> <?php echo $this->datos_sol_vehiculo[0]['nro_tramite'] ;?></b> <!-- #ETR-3400-->
                    <b>Form. 5-R-270</b>
                </div>
            </td>
        </tr>
    </table>
