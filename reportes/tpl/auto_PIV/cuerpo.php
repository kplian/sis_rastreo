<!--
#ETR-3400  JJA     24/03/2021  Agregar códigos a reportes Gestión vehicular
#ETR-4484  JJA     06/07/2021  Cambio de formato de reporte
 -->
<br><br>
<table border="1" align="center" style="margin-left: -50px;">
    <tr style="background-color: #000080; color:white;height: 30px;">
        <td align="left" >Parte I. Llenado por el solicitante</td>
    </tr>
    <tr  style="height: 50px;" >
        <td align="center" width="146px;" rowspan="2" colspan="2" ><br/><br/><b>Solicitante:</b></td>
        <td align="center" width="146px;" colspan="2" style="background-color: #F2F5A9;"><b>Nombre</b></td>
        <td align="center" width="146px;" colspan="2" style="background-color: #F2F5A9;"><b>Firma</b></td>
        <td align="center" width="73px;" style="background-color: #F2F5A9;"><b>Dia</b></td>
        <td align="center" width="73px;" style="background-color: #F2F5A9;"><b>Mes</b></td>
        <td align="center" width="75px;" style="background-color: #F2F5A9;"><b>Año</b></td>
    </tr>
    <tr style="height: 50px;">
        <td align="center" width="146px;" colspan="2"><?php echo $this->datos_sol_vehiculo[0]["desc_funcionario"]; ?></td>
        <td align="center" width="146px;" colspan="2"></td>
        <td align="center" width="73px;"><br/>
            <?php  echo explode("-", $this->datos_sol_vehiculo[0]["fecha_sol"])[2]; ?>
        </td>
        <td align="center" width="73px;"><br/>
            <?php echo explode("-", $this->datos_sol_vehiculo[0]["fecha_sol"])[1]; ?></td>
        <td align="center" width="75px;"><br/>
            <?php echo explode("-", $this->datos_sol_vehiculo[0]["fecha_sol"])[0]; ?></td>
    </tr>
    <tr style="height: 50px;">
        <td width="146px" height="50px" colspan="2"><br/><br/><b>Lugares visitados:</b></td>
        <td align="center" colspan="7" ><br/><br/><?php echo $this->datos_sol_vehiculo[0]["destino"]; ?></td>
    </tr>
    <tr style="height: 50px;">
        <td align="center" width="146px;" height="50px" colspan="2"><b>Nómina de Personas:</b></td>
        <td align="center" colspan="7" >
            <ol>
                <?php $nomina=0; foreach ($this->datos_nomina_persona as $nomina) { ?>
                <li>
                <?php echo $nomina['nombre']; ?>
                </li>
                <?php } ?>
            </ol>
        </td>
    </tr>
    <tr style="background-color: #F2F5A9;">
        <td align="center" colspan="4"><b>Fecha y Hora de Salida</b> </td>
        <td align="center" colspan="5" ><b>Fecha y Hora de Retorno</b></td>
    </tr>
    <tr>
        <td align="left" colspan="2" ><b>Fecha:</b> <?php echo $this->datos_sol_vehiculo[0]["fecha_salida"]; ?></td>
        <td align="left" colspan="2" ><b>Hora:</b> <?php echo $this->datos_sol_vehiculo[0]["hora_salida"]; ?></td>
        <td align="left" colspan="3" ><b>Fecha:</b> <?php echo $this->datos_sol_vehiculo[0]["fecha_retorno"]; ?></td>
        <td align="left" colspan="2" ><b>Hora:</b> <?php echo $this->datos_sol_vehiculo[0]["hora_retorno"]; ?></td>
    </tr>
    <tr style="height: 50px;">
        <td align="center" width="146px;" height="50px" colspan="2"><br/><b>Vehículo Asignado:</b></td>
        <td align="center" colspan="7" ><br/><br/><?php echo $this->datos_asig_vehiculo[0]["placa"]." - ".$this->datos_asig_vehiculo[0]["desc_marca"]." ".$this->datos_asig_vehiculo[0]["desc_modelo"]; ?></td>
    </tr>
    <tr style="height: 50px;">
        <td align="center" width="146px;" height="50px" colspan="2"><br/><b>Nombre del Chofer:</b></td>
        <td align="center" colspan="3" ><?php echo $this->datos_asig_vehiculo[0]["desc_persona"]; ?></td>
        <td align="center" colspan="2" ><br/><br/><b>Propio/Alquilado:</b></td>
        <td align="center" colspan="2" >
            <br/><br/><?php if($this->datos_sol_vehiculo[0]["alquiler"] =="no"){ echo("Propio");} else{ echo"Alquilado"; } ?>

        </td>
    </tr>
    <!-- #ETR-4484-->
    <tr style="height: 50px;">
        <td align="center" width="146px;" height="50px" colspan="2"><br/><b>Observaciones / Novedades de Viaje / Estado de Vehículo:</b></td>
        <td align="center" colspan="7" ><br/>
            <?php $observ=0; foreach ($this->datos_elemento_seg_equipo as $observ) { ?>
                <?php if($observ==1){ ?>
                    <?php echo $observ['observacion']." "; ?>
                <?php }else{ ?>
                    <br/>
                    <?php echo $observ['observacion']; ?>
                <?php } ?>

            <?php } ?>
        </td>
    </tr>

</table>

