<font size="10">
    <?php
    $datosAsig=0;
    foreach ($this->datos_asig_vehiculo as $datosAsig) {
        $id_asig_vehiculo = $datosAsig['id_asig_vehiculo'];
        $existe = true;
        $i = 1;
        $numero = 3;
        echo '<h3>'.$datosAsig['placa'].'</h3>';
        echo '<p>Elementos de Seguridad y señalizacion: </p>';
        echo '<table  width="100%" cellpadding="5px"  border="1" >';
        echo '<tr>';
        echo '<th align="center" width="30%">Elemento</th>';
        echo '<th align="center" width="10%">existe</th>';
        echo '<th align="center" width="20%">Estado </th>';
        echo '<th align="center" width="40%">Observaciones</th>';
        echo '</tr>';
        //var_dump('xx',$this->datos_elemento_seg_equipo);exit;
         foreach ($this->datos_elemento_seg_equipo as $datos) {

            if($id_asig_vehiculo == $datos['id_asig_vehiculo']){
                echo '<tr>';
                echo '<td width="30%" >'. $datos['desc_elemento_seg'] .'</td>';
                echo  '<td width="10%" align="center">';
                echo $datos['existe']=='t'?'x':'';
                echo  '</td>';
                if ($datos['existe']=='t'){
                    echo '<td width="20%" >'. $datos['estado_elemento'] .'</td>';
                }else{
                    echo '<td width="20%" > </td>';
                }
                echo '<td width="40%" >'. $datos['observacion'] .'</td>';
                echo '</tr>';

            }
        }//fin 2 for

        echo '</table>';
        echo '<p>Datos del viaje: </p>';
        echo '<table width="100%" cellpadding="5px"  border="1"> 
        <tr>
            <td width="25%">Kilometraje Final:               
            </td>
            <td width="15%" >'.$datosAsig['km_inicio'].'
            </td>
            <td width="60%" rowspan="3" >Observaciones / Novedades de Viaje / Estado de Vehículo:
                '.$datosAsig['observacion_viaje'].'
            </td>
        </tr>
        <tr>
            <td width="25%">Kilometraje Inicial:
            </td>
            <td width="15%">'.$datosAsig['km_final'].'
            </td>
        </tr>
        <tr>
            <td width="25%" >Total Recorrido km:
            </td>
            <td width="15%" >'.$datosAsig['recorrido'].'
            </td>
        </tr>
         <tr>
            <td width="25%" rowspan="3" >Nombre y Firma Chofer:
            </td>
            <td width="75%" height="70px" rowspan="2">
            </td>
          
        </tr>
        <tr>
         
        </tr>
         <tr>
            <td width="75%" align="center">'.ucwords(strtolower($datosAsig['desc_persona'])).'

            </td>
         </tr> 
        
        </table>';

        if(  $datosAsig['incidencia']== 'si'  ) {
            echo '<p>Incidencias:</p>';
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
