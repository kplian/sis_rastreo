/***********************************I-DAT-RCM-RAS-0-05/07/2017****************************************/
insert into segu.tsubsistema(codigo,nombre,prefijo,nombre_carpeta) values
('RAS','Rastreo Satelital','RAS','rastreo');

-------------------------------------
--DEFINICION DE INTERFACES
-------------------------------------

select pxp.f_insert_tgui ('Rastreo Satelital', '', 'RAS', 'si', 1, '', 1, '../../../lib/imagenes/gema32x32.png', '', 'RAS');
select pxp.f_insert_tgui ('Tipos de Vehículos', 'Registro de Tipos de Vehículos', 'RAS.1', 'si', 1, 'sis_rastreo/vista/tipo_equipo/TipoEquipo.php', 2, '', 'TipoEquipo', 'RAS');
select pxp.f_insert_tgui ('Marcas', 'Marcas y modelos', 'RAS.8', 'si', 2, 'sis_rastreo/vista/marca/Marca.php', 3, '', 'Marca', 'RAS');
select pxp.f_insert_tgui ('Condutores', 'Registro Conductores', 'RAS.2', 'si', 3, 'sis_rastreo/vista/responsable/Responsable.php', 2, '', 'Responsable', 'RAS');
select pxp.f_insert_tgui ('Areas', 'Areas', 'RAS.9', 'si', 4, 'sis_rastreo/vista/localizacion/Localizacion.php', 3, '', 'Localizacion', 'RAS');
select pxp.f_insert_tgui ('Vehículos', 'Registro de Vehículos', 'RAS.3', 'si', 5, 'sis_rastreo/vista/equipo/EquipoResp.php', 2, '', 'EquipoResp', 'RAS');
select pxp.f_insert_tgui ('Ubicación de Vehículos', 'Búsqueda de vehículos por diferentes criterios', 'RAS.4', 'si', 6, '', 2, '', '', 'RAS');
select pxp.f_insert_tgui ('Reportes', 'Búsqueda de vehículos por diferentes criterios', 'RAS.7', 'si', 7, '', 2, '', '', 'RAS');
select pxp.f_insert_tgui ('Posiciones capturadas', 'Posiciones capturadas', 'RAS.5', 'si', 1, 'sis_rastreo/vista/equipo/EquipoPosicion.php', 3, '', 'EquipoPosicion', 'RAS');
select pxp.f_insert_tgui ('Monitoreo', 'Monitoreo en tiempo real', 'RAS.12', 'si', 2, 'sis_rastreo/vista/positions/Monitoreo.php', 3, '', 'Monitoreo', 'RAS');
select pxp.f_insert_tgui ('Consultas', 'Consultas', 'RAS.6', 'si', 3, 'sis_rastreo/vista/positions/Consultas.php', 3, '', 'Consultas', 'RAS');

select pxp.f_insert_testructura_gui ('RAS', 'SISTEMA');
select pxp.f_insert_testructura_gui ('RAS.1', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.2', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.3', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.4', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.5', 'RAS.4');
select pxp.f_insert_testructura_gui ('RAS.6', 'RAS.4');
select pxp.f_insert_testructura_gui ('RAS.7', 'RAS');

select pxp.f_insert_testructura_gui ('RAS.8', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.9', 'RAS');

/***********************************F-DAT-RCM-RAS-0-05/07/2017****************************************/

/***********************************I-DAT-RCM-RAS-0-06/07/2017****************************************/
select pxp.f_add_catalog('RAS','tequipo__traccion','2WD','2WD','');
select pxp.f_add_catalog('RAS','tequipo__traccion','4WD','4WD','');

select pxp.f_add_catalog('RAS','tequipo__cabina','Simple','simple','');
select pxp.f_add_catalog('RAS','tequipo__cabina','Doble','doble','');
/***********************************F-DAT-RCM-RAS-0-06/07/2017****************************************/

/***********************************I-DAT-RCM-RAS-0-07/07/2017****************************************/
select pxp.f_insert_tgui ('Eventos', 'Eventos sucedidos', 'RAS.10', 'si', 1, 'sis_rastreo/vista/reportes/EventoReporte.php', 3, '', 'EventoReporte', 'RAS');
select pxp.f_insert_tgui ('Velocidades', 'Velocidades registradas', 'RAS.11', 'si', 2, 'sis_rastreo/vista/reportes/VelocidadReporte.php', 3, '', 'VelocidadReporte', 'RAS');
select pxp.f_insert_tgui ('Distancias', 'Distancias recorridas', 'RAS.12', 'si', 3, 'sis_rastreo/vista/reportes/DistanciaReporte.php', 3, '', 'DistanciaReporte', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.10', 'RAS.7');
select pxp.f_insert_testructura_gui ('RAS.11', 'RAS.7');
select pxp.f_insert_testructura_gui ('RAS.12', 'RAS.7');
/***********************************F-DAT-RCM-RAS-0-07/07/2017****************************************/

/***********************************I-DAT-RCM-RAS-0-13/07/2017****************************************/
select pxp.f_insert_tgui ('Eventos', 'Eventos sucedidos', 'RAS.10', 'si', 1, 'sis_rastreo/vista/_reportes/ParametrosEvento.php', 3, '', 'ParametrosEvento', 'RAS');
select pxp.f_insert_tgui ('Velocidades', 'Velocidades registradas', 'RAS.11', 'si', 2, 'sis_rastreo/vista/_reportes/ParametrosVelocidad.php', 3, '', 'ParametrosVelocidad', 'RAS');
select pxp.f_insert_tgui ('Distancias', 'Distancias recorridas', 'RAS.12', 'si', 3, 'sis_rastreo/vista/_reportes/ParametrosDistancia.php', 3, '', 'ParametrosDistancia', 'RAS');
/***********************************F-DAT-RCM-RAS-0-13/07/2017****************************************/

/***********************************I-DAT-RCM-RAS-0-23/07/2017****************************************/
select pxp.f_insert_tgui ('Grupos', 'Grupos de Vehículos', 'RAS.20', 'si', 8, 'sis_rastreo/vista/grupo/Grupo.php', 2, '', 'Grupo', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.20', 'RAS');
/***********************************F-DAT-RCM-RAS-0-23/07/2017****************************************/

/***********************************I-DAT-RCM-RAS-0-30/07/2017****************************************/
select pxp.f_insert_tgui ('Tipos de Eventos', 'Registro de Tipos de Eventos', 'RAS.21', 'si', 10, 'sis_rastreo/vista/tipo_evento/TipoEvento.php', 2, '', 'TipoEvento', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.21', 'RAS');

INSERT INTO ras.ttipo_evento ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_tipo_evento", "codigo", "nombre")
VALUES 
  (1, NULL, E'2017-07-30 11:29:58.150', NULL, E'activo', NULL, E'NULL', 1, E'4001', E'S/D'),
  (1, NULL, E'2017-07-30 11:30:05.579', NULL, E'activo', NULL, E'NULL', 2, E'4006', E'S/D'),
  (1, NULL, E'2017-07-30 11:30:21.046', NULL, E'activo', NULL, E'NULL', 3, E'6002', E'Alerta de Velocidad máxima Excedida'),
  (1, NULL, E'2017-07-30 11:30:33.777', NULL, E'activo', NULL, E'NULL', 4, E'6006', E'Aceleración Brusca'),
  (1, NULL, E'2017-07-30 11:31:06.978', NULL, E'activo', NULL, E'NULL', 5, E'6007', E'Frenado Brusco'),
  (1, NULL, E'2017-07-30 11:31:17.617', NULL, E'activo', NULL, E'NULL', 6, E'6009', E'GPS Desconectado'),
  (1, NULL, E'2017-07-30 11:31:26.322', NULL, E'activo', NULL, E'NULL', 7, E'6010', E'GPS Conectado'),
  (1, NULL, E'2017-07-30 11:31:42.887', NULL, E'activo', NULL, E'NULL', 8, E'6011', E'Movilidad Encendida'),
  (1, NULL, E'2017-07-30 11:31:55.887', NULL, E'activo', NULL, E'NULL', 9, E'6012', E'Movilidad Apagada'),
  (1, NULL, E'2017-07-30 11:32:12.126', NULL, E'activo', NULL, E'NULL', 10, E'6016', E'Tiempo de estacionamiento máximo Excedido'),
  (1, NULL, E'2017-07-30 11:32:32.798', NULL, E'activo', NULL, E'NULL', 11, E'6017', E'Remolque de movilidad detectado'),
  (1, NULL, E'2017-07-30 11:32:44.142', NULL, E'activo', NULL, E'NULL', 12, E'6018', E'Remolque de movilidad finalizado');
/***********************************F-DAT-RCM-RAS-0-30/07/2017****************************************/

/***********************************I-DAT-RCM-JRR-0-15/08/2017****************************************/
select pxp.f_insert_tgui ('Monitoreo Grupo', 'Monitoreo en tiempo real', 'RAS.12', 'si', 3, 'sis_rastreo/vista/positions/MonitoreoGrupo.php', 3, '', 'MonitoreoGrupo', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.12', 'RAS.7');

/***********************************F-DAT-RCM-JRR-0-15/08/2017****************************************/

/***********************************I-DAT-JJA-JRR-0-08/05/2019****************************************/
select pxp.f_insert_tgui ('Monitoreo', 'Monitoreo', 'MONREO', 'si', 3, 'sis_rastreo/vista/positions/Monitoreo.php', 3, '', 'Monitoreo', 'RAS');
/***********************************F-DAT-JJA-JRR-0-08/05/2019****************************************/

/***********************************I-DAT-JJA-JRR-0-09/05/2019****************************************/
select pxp.f_insert_tgui ('Areas', 'Areas', 'RAS.9', 'no', 4, 'sis_rastreo/vista/localizacion/Localizacion.php', 3, '', 'Localizacion', 'RAS');
/***********************************F-DAT-JJA-JRR-0-09/05/2019****************************************/

/***********************************I-DAT-JJA-JRR-0-14/05/2019****************************************/
select pxp.f_insert_tgui ('RASTREO SATELITAL', '', 'RAS', 'si', 1, '', 1, '../../../lib/imagenes/gema32x32.png', '', 'RAS');
/***********************************F-DAT-JJA-JRR-0-14/05/2019****************************************/
/***********************************I-DAT-EGS-RAS-0-15/07/2020****************************************/
select wf.f_import_tproceso_macro ('insert','SOLVEHICU', 'RAS', 'Solicitud de Vehiculos','si');
select wf.f_import_tcategoria_documento ('insert','legales', 'Legales');
select wf.f_import_tcategoria_documento ('insert','proceso', 'Proceso');
select wf.f_import_ttipo_proceso ('insert','SOLVEH',NULL,NULL,'SOLVEHICU','Solicitud Vehicular','ras.vsol_vehiculo','id_sol_vehiculo','si','','','','SOLVEH',NULL);
select wf.f_import_ttipo_estado ('insert','borrador','SOLVEH','borrador','si','no','no','ninguno','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','borrador','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','vobojefedep','SOLVEH','vobojefedep','no','no','no','funcion_listado','ras.f_lista_funcionario_depto','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'si','vobojefedep','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','vobogerente','SOLVEH','vobogerente','no','no','no','funcion_listado','ras.f_lista_funcionario_gerente_area','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','vobogerente','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','asigvehiculo','SOLVEH','asigvehiculo','no','no','no','listado','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','asigvehiculo','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','vobojefeserv','SOLVEH','vobojefeserv','no','no','no','funcion_listado','ras.f_lista_funcionario_servicio','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','vobojefeserv','','',NULL,'no',NULL,'','');
select wf.f_import_ttipo_estado ('insert','autorizado','SOLVEH','autorizado','no','no','si','anterior','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','autorizado','','',NULL,'no',NULL,'','');
select wf.f_import_testructura_estado ('insert','borrador','vobojefedep','SOLVEH',1,'','no');
select wf.f_import_testructura_estado ('insert','vobojefedep','asigvehiculo','SOLVEH',1,'"{$tabla.alquiler_numero}"=0','no');
select wf.f_import_testructura_estado ('insert','vobojefedep','vobogerente','SOLVEH',1,'"{$tabla.alquiler_numero}"=1','no');
select wf.f_import_testructura_estado ('insert','vobogerente','asigvehiculo','SOLVEH',1,'','no');
select wf.f_import_testructura_estado ('insert','asigvehiculo','vobojefeserv','SOLVEH',1,'','no');
select wf.f_import_testructura_estado ('insert','vobojefeserv','autorizado','SOLVEH',1,'','no');

select pxp.f_insert_tgui ('GESTIÓN VEHICULAR', '', 'RAS', 'si', 1, '', 1, '../../../lib/imagenes/gema32x32.png', '', 'RAS');
select pxp.f_insert_tgui ('Configuraciones', 'Configuraciones', 'CONVEH', 'si', 1, '', 2, '', '', 'RAS');
select pxp.f_insert_tgui ('Solicitud de Vehiculo', 'Solicitan Vehiculos Activos', 'SOLVEHI', 'si', 3, '', 2, '', '', 'RAS');
select pxp.f_insert_tgui ('Solicitud', 'Registro de solicitudes', 'REGSOL', 'si', 1, 'sis_rastreo/vista/sol_vehiculo/SolVehiculo.php', 3, '', 'SolVehiculo', 'RAS');
select pxp.f_insert_tgui ('Vobo Solicitud', 'Visto Bueno Solicitud', 'vobosolv', 'si', 2, 'sis_rastreo/vista/sol_vehiculo/SolVehiculoVoBo.php', 3, '', 'SolVehiculoVoBo', 'RAS');
select pxp.f_insert_tgui ('Asignacion de Vehiculos', 'Asignacion de Vehiculos', 'ASIGVEHI', 'si', 3, 'sis_rastreo/vista/sol_vehiculo/SolVehiculoAsig.php', 3, '', 'SolVehiculoAsig', 'RAS');
select pxp.f_insert_tgui ('Elementos de seguridad y señalizacion', 'Elementos de seguridad y señalizacion', 'ELEMSEG', 'si', 8, 'sis_rastreo/vista/elemento_seg/ElementoSeg.php', 3, '', 'ElementoSeg', 'RAS');
select pxp.f_insert_tgui ('Incidencias', 'Incidencias', 'INCID', 'si', 9, 'sis_rastreo/vista/incidencia/Incidencia.php', 3, '', 'Incidencia', 'RAS');
select pxp.f_insert_tgui ('Estado de Vehiculos', 'Estado de Vehiculos', 'VEHEST', 'si', 9, 'sis_rastreo/vista/equipo/EquipoEstado.php', 3, '', 'EquipoEstado', 'RAS');
select pxp.f_insert_tgui ('Ubicación de Vehículos', 'Búsqueda de vehículos por diferentes criterios', 'RAS.4', 'si', 6, '', 2, '', '', 'RAS');


/***********************************F-DAT-EGS-RAS-0-15/07/2020****************************************/
/***********************************I-DAT-EGS-RAS-1-28/08/2020****************************************/
select param.f_import_tcatalogo_tipo ('insert','telemento_seg_equipo','RAS','telemento_seg_equipo');
select param.f_import_tcatalogo ('insert','RAS','Malo','malo','telemento_seg_equipo');
select param.f_import_tcatalogo ('insert','RAS','Regular','regular','telemento_seg_equipo');
select param.f_import_tcatalogo ('insert','RAS','Bueno','bueno','telemento_seg_equipo');
select param.f_import_tcatalogo ('insert','RAS','Excelento','excelente','telemento_seg_equipo');
/***********************************F-DAT-EGS-RAS-1-28/08/2020****************************************/
/***********************************I-DAT-EGS-RAS-2-16/12/2020****************************************/
select param.f_import_tcatalogo_tipo ('insert','tequipo_estado','RAS','tequipo_estado');
select param.f_import_tcatalogo ('insert','RAS','Asignado','asignado','tequipo_estado');
select param.f_import_tcatalogo ('insert','RAS','Mantenimiento','mantenimiento','tequipo_estado');
/***********************************F-DAT-EGS-RAS-2-16/12/2020****************************************/
/***********************************I-DAT-EGS-RAS-GDV-29-13/01/2021****************************************/
select wf.f_import_ttipo_estado ('insert','asignado','SOLVEH','asignado','no','no','si','anterior','','ninguno','','','no','no',NULL,'<font color="99CC00" size="5"><font size="4">{TIPO_PROCESO}</font></font><br><br><b>&nbsp;</b>Tramite:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <b>{NUM_TRAMITE}</b><br><b>&nbsp;</b>Usuario :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {USUARIO_PREVIO} </b>en estado<b>&nbsp; {ESTADO_ANTERIOR}<br></b>&nbsp;<b>Responsable:&nbsp;&nbsp; &nbsp;&nbsp; </b><b>{FUNCIONARIO_PREVIO}&nbsp; {DEPTO_PREVIO}<br>&nbsp;</b>Estado Actual<b>: &nbsp; &nbsp;&nbsp; {ESTADO_ACTUAL}</b><br><br><br>&nbsp;{OBS} <br>','Aviso WF ,  {PROCESO_MACRO}  ({NUM_TRAMITE})','','no','','','','','','','',NULL,'no','asignacion','','',NULL,'no',NULL,'','');
select wf.f_import_testructura_estado ('insert','borrador','vobojefedep','SOLVEH',1,'','no');
select wf.f_import_testructura_estado ('insert','vobojefedep','vobogerente','SOLVEH',1,'"{$tabla.alquiler_numero}"=1','no');
select wf.f_import_testructura_estado ('insert','vobojefedep','vobojefeserv','SOLVEH',1,'"{$tabla.alquiler_numero}"=0','no');
select wf.f_import_testructura_estado ('insert','vobojefeserv','asigvehiculo','SOLVEH',1,'','si');
select wf.f_import_testructura_estado ('insert','vobogerente','vobojefeserv','SOLVEH',1,'','no');
select wf.f_import_testructura_estado ('insert','asigvehiculo','asignado','SOLVEH',1,'','no');
/***********************************F-DAT-EGS-RAS-GDV-29-13/01/2021****************************************/

/***********************************I-DAT-JJA-RAS-GDV-29-19/02/2021****************************************/
--#RAS-3
select pxp.f_insert_tgui ('Historial de vehículos', 'Historial de vehículos', 'HISVEH', 'si', 4, 'sis_rastreo/reportes/RHistorialVehiculo.php', 3, '', 'RHistorialVehiculo', 'RAS');
/***********************************F-DAT-JJA-RAS-GDV-29-19/02/2021****************************************/
/***********************************I-DAT-JJA-RAS-GDV-34-24/02/2021****************************************/
select pxp.f_insert_tgui ('Historial Vehículos Kilometraje', 'Historial Vehículos Kilometraje', 'VHK', 'si', 5, 'sis_rastreo/vista/equipo/EquipoKilometraje.php', 3, '', 'EquipoKilometraje', 'RAS');
/***********************************F-DAT-JJA-RAS-GDV-34-24/02/2021****************************************/
/***********************************I-DAT-EGS-RAS-GDV-37-11/03/2021****************************************/
select param.f_import_tcatalogo_tipo ('insert','ttipo_responsable','RAS','tresponsable');
select param.f_import_tcatalogo ('insert','RAS','conductor','conductor','ttipo_responsable');
select param.f_import_tcatalogo ('insert','RAS','personal_autorizado','personal_autorizado','ttipo_responsable');
/***********************************F-DAT-EGS-RAS-GDV-37-11/03/2021****************************************/
/***********************************I-DAT-EGS-RAS-GDV-37-14/03/2021****************************************/

INSERT INTO pxp.variable_global ("variable", "valor", "descripcion")
VALUES
(E'ras_solicitud_multi_vehiculo', E'no', E'Hace que solo se pueda registrar un vehiculo por solicitud  y asigna todos los conductores a ese vehiculo');

/***********************************F-DAT-EGS-RAS-GDV-37-14/03/2021****************************************/
