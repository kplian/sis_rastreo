<font size="10"><table  width="100%" cellpadding="5px"  border="1" >
		<tr >
            <td rowspan="2" width="20%" ><br>Viaje Solicitado por:
            </td>
            <td width="50%" height="35px">
                <?php  echo '<br>'.ucwords(strtolower($this->datos_sol_vehiculo[0]['desc_funcionario']));?>
            </td>
            <td width="10%" align="center">Día
            </td>
            <td width="10%" align="center">Mes
            </td>
            <td width="10%" align="center">Año
            </td>

		</tr>
        <tr >
            <td width="25%" align="center">Nombre
            </td>
            <td width="25%" align="center">Firma
            </td>
            <td width="10%" align="center"><?php  echo   date("d",strtotime($this->datos_sol_vehiculo[0]['fecha_sol']));?>
            </td>
            <td width="10%" align="center"><?php  echo   date("m",strtotime($this->datos_sol_vehiculo[0]['fecha_sol']));?>
            </td>
            <td width="10%" align="center"><?php  echo   date("Y",strtotime($this->datos_sol_vehiculo[0]['fecha_sol']));?>
            </td>
        </tr>
        <tr >
            <td width="20%" >Destino:
            </td>
            <td width="80%" ><?php  echo  strtolower($this->datos_sol_vehiculo[0]['destino']);?>
            </td>
        </tr>
        <tr >
            <td width="20%" >Motivo Viaje:
            </td>
            <td width="80%" ><?php  echo  strtolower($this->datos_sol_vehiculo[0]['motivo']);?>
            </td>
        </tr>
        <tr >
            <td width="30%" >Tipo de Vehículo Requerido:
            </td>
            <td width="25%" ><?php  echo  strtolower($this->datos_sol_vehiculo[0]['desc_tipo_equipo']);?>
            </td>
            <td width="15%" >CECO/CLCO:
            </td>
            <td width="30%" ><?php  echo  strtolower($this->datos_sol_vehiculo[0]['desc_centro_costo']);?>
            </td>
        </tr>
        <tr >
            <td width="30%" >Nómina de Personas:
            </td>
            <td width="70%" ><?php
                $i = 1;
                foreach ($this->datos_nomina_persona as $datos) {
                    echo  $datos['nombre'].'<br>';
                    $i++;
                }
                ?>
            </td>
        </tr>
        <tr >
            <td width="25%" align="center" ><?php  echo   date("d/m/Y",strtotime($this->datos_sol_vehiculo[0]['fecha_salida']));?>
            </td>
            <td width="25%" align="center"><?php  echo  strtolower($this->datos_sol_vehiculo[0]['hora_salida']);?>
            </td>
            <td width="25%" align="center"><?php  echo   date("d/m/Y",strtotime($this->datos_sol_vehiculo[0]['fecha_retorno']));?>
            </td>
            <td width="25%" align="center"><?php  echo  strtolower($this->datos_sol_vehiculo[0]['hora_retorno']);?>
            </td>
        </tr>
        <tr >
            <td width="50%" align="center" >Fecha y Hora de Salida o Recojo
            </td>
            <td width="50%" align="center" >Fecha y Hora de Retorno
            </td>
        </tr>
        <tr >
            <td width="50%" rowspan="3"  >Observaciones: <?php  echo  strtolower($this->datos_sol_vehiculo[0]['observacion']);?>
            </td>

<!--            <td width="15%" rowspan="2">Nombre y Firma Autorizada:-->
<!--            </td>-->
            <td width="50%" height="60px" >
            </td>
        </tr>
        <tr>
            <td width="50%" align="center" ><?php  echo  ucwords(strtolower($this->datos_sol_vehiculo[0]['desc_jefe_dep']));?>
            </td>
        </tr>
        <tr >
            <td width="50%" align="center" >Nombre y Firma Autorizada
            </td>
        </tr>
        <?php
        if(($this->datos_sol_vehiculo[0]['alquiler']) == 'si') {
            echo '<tr >
            <td width="15%" > Monto: 
            </td>
            <td width="85%" >'.$this->datos_sol_vehiculo[0]['monto'].' BS.
            </td>
        </tr>
        <tr >
            <td width="100%"  align="center" height="70px">
                </td>
        </tr>
        <tr>
             <td width="100%"  align="center">'.ucwords(strtolower($this->datos_sol_vehiculo[0]['desc_gerente'])).'
            </td>
         </tr>
         <tr>
            <td width="100%" align="center">Nombre y Firma Gerente
            </td>
            
        </tr>';
        }
        ?>
</table></font>