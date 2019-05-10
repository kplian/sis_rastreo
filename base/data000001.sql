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
