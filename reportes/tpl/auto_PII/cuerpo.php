<p>Parte II. Llenado por el Responsable de Transportes</p><?php
$i = 1;
foreach ($this->datos_asig_vehiculo as $datos) {?><font size="10"><table  width="100%" cellpadding="5px"  border="1" >
        <tr >
            <td width="25%"  >Vehículo Asignado:
            </td>
            <td width="75%" >
                <table>
                    <tr><td width="50%"><?php echo  'Placa:'.$datos['placa']; ?>  </td>
                        <td width="50%"><?php  echo  'Modelo :'.$datos['desc_modelo'];?> </td>
                    </tr>
                    <tr><td><?php echo  'Marca:'.$datos['desc_marca']; ?>  </td>
                        <td><?php echo  'Tipo:'.$datos['desc_tipo_equipo']; ?> </td>
                    </tr>
                </table>
            </td>

        </tr>
        <tr >
            <td width="25%" >Nombre del Chofer:
            </td>
            <td width="75%" > <?php echo  ucwords(strtolower($datos['desc_persona']));    ?>
            </td>

        </tr>
        <tr >
            <td width="25%"  >Observaciones:
            </td>
            <td width="75%"  ><?php echo  $datos['observaciones'];    ?>
            </td>
        </tr>

    </table></font>
<?php
    $i++;
}
?><table width="100%" cellpadding="5px"  border="1">
    <tr>
        <td width="100%" height="50px" > </td>
    </tr>
    <tr>
        <td width="100%" align="center" ><?php  echo  ucwords(strtolower($this->datos_sol_vehiculo[0]['desc_jefe_serv']));?> </td>
    </tr>
    <tr>
        <td width="100%" align="center"  >Firma Jefe Division Servicios:</td>
    </tr>
</table>
