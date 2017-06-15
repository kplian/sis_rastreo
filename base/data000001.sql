/***********************************I-DAT-RCM-RAS-0-05/07/2017****************************************/
insert into segu.tsubsistema(codigo,nombre,prefijo,nombre_carpeta) values
('RAS','Rastreo Satelital','RAS','rastreo');

-------------------------------------
--DEFINICION DE INTERFACES
-------------------------------------

select pxp.f_insert_tgui ('Rastreo Satelital', '', 'RAS', 'si', 1, '', 1, '../../../lib/imagenes/gema32x32.png', '', 'RAS');
select pxp.f_insert_tgui ('Tipos de Vehículos', 'Registro de Tipos de Vehículos', 'RAS.1', 'si', 2, 'sis_rastreo/vista/tipo_equipo/TipoEquipo.php', 2, '', 'TipoEquipo', 'RAS');
select pxp.f_insert_tgui ('Condutores', 'Registro Conductores', 'RAS.2', 'si', 4, 'sis_rastreo/vista/responsable/Responsable.php', 2, '', 'Responsable', 'RAS');
select pxp.f_insert_tgui ('Vehículos', 'Registro de Vehículos', 'RAS.3', 'si', 5, 'sis_rastreo/vista/localizacion/Localizacion.php', 2, '', 'Localizacion', 'RAS');
select pxp.f_insert_tgui ('Ubicación de Vehículos', 'Búsqueda de vehículos por diferentes criterios', 'RAS.4', 'si', 1, '', 2, '', '', 'RAS');
select pxp.f_insert_tgui ('Posiciones capturadas', 'Posiciones capturadas', 'RAS.5', 'si', 2, 'sis_rastreo/vista/posicion/Posicion.php', 3, '', 'Posicion', 'RAS');
select pxp.f_insert_tgui ('Consultas', 'Consultas', 'RAS.6', 'si', 4, 'sis_rastreo/vista/posicion/Consultas.php', 3, '', 'Consultas', 'RAS');
select pxp.f_insert_tgui ('Reportes', 'Búsqueda de vehículos por diferentes criterios', 'RAS.7', 'si', 1, '', 2, '', '', 'RAS');

select pxp.f_insert_tgui ('Marcas', 'Marcas y modelos', 'RAS.8', 'si', 2, 'sis_rastreo/vista/marca/Marca.php', 3, '', 'Marca', 'RAS');
select pxp.f_insert_tgui ('Areas', 'Areas', 'RAS.9', 'si', 2, 'sis_rastreo/vista/localizacion/Localizacion.php', 3, '', 'Localizacion', 'RAS');

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