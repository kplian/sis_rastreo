<font size="10">
   <?php
   $datosAsig=0;
   foreach ($this->datos_asig_vehiculo as $datosAsig) {
       $id_asig_vehiculo = $datosAsig['id_asig_vehiculo'];
       $existe = true;
       $i = 1;
       $numero = 3;
       echo '<h3>'.$datosAsig['placa'].'</h3>';
       echo '<table  width="100%" cellpadding="5px"  border="1" >';
       foreach ($this->datos_elemento_seg_equipo as $datos) {

           if($id_asig_vehiculo == $datos['id_asig_vehiculo'] ){
                   if ($existe == true) {
                       echo '<tr>';
                   }
                   echo '<td width="28%" >' . $datos['desc_elemento_seg'] . '</td>';
                   echo  '<td width="5%" align="center">';
                   echo $datos['existe']=='t'?'x':'';
                   echo  '</td>';

                   if (($i % $numero) == 0) {
                       $existe = true;
                   } else {
                       $existe = false;
                   }
                   if ($existe == true) {
                       echo '</tr>';
                   }

                   $i++;
            }
       }//fin 2 for

       if (($i % $numero) == 0) {
           $existe = false;
       } else {
           $existe = true;
       }
       if ($existe == true) {
           echo '</tr>';
       }
       echo '</table>';
       echo '<table width="100%" cellpadding="5px"  border="1"> 
        <tr>
            <td width="25%">Kilometraje Final               
            </td>
            <td width="25%" >'.$datosAsig['km_inicio'].'
            </td>
            <td width="49.2%" rowspan="2" >Observaciones / Novedades de Viaje / Estado de Vehículo:
                '.$datosAsig['observacion_viaje'].'
            </td>
        </tr>
        <tr>
            <td width="25%">Kilometraje Inicial
            </td>
            <td width="25%">'.$datosAsig['km_final'].'
            </td>
        </tr>
        <tr>
            <td width="25%" rowspan="2" >Total Recorrido km.
            </td>
            <td width="25%" rowspan="2" >'.$datosAsig['recorrido'].'
            </td>
            <td width="25%" rowspan="2" >Nombre y Firma Chofer:
            </td>
            <td width="24.2%">

            </td>
        </tr>
         <tr>
            <td width="24.2%" align="center">'.ucwords(strtolower($datosAsig['desc_persona'])).'

            </td>
        </tr> </table>';

       if(  $datosAsig['incidencia']== 'si'  ) {

           echo '<table border="1">';
           echo '<tr> 
                <td width="30%" align="center">Incidencia</td>
                <td width="69.1%" align="center">Observaciones</td>
            </tr>';
           $agrupador = '';
           foreach ($this->datos_asig_incidencia as $datos) {
               if ($id_asig_vehiculo == $datos['id_asig_vehiculo']) {

                   if ($agrupador != $datos['desc_incidencia_agrupador']) {
                       echo '
                   <tr>
                        <td colspan="2" width="99.1%">' . $datos['desc_incidencia_agrupador'] . ':</td>
                   </tr>
                   ';
                   }

                   echo '<tr>';
                   echo '<td width="30%" >' . $datos['desc_incidencia'] . '</td> ';
                   echo '<td width="69.1%" >' . $datos['observacion'] . '</td>';
                   echo '</tr>';

                   $agrupador = $datos['desc_incidencia_agrupador'];
               }


           }
           echo '</table>';
       }
   }//fin 1 for
   ?>



</font>
