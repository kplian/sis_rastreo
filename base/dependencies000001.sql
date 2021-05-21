/***********************************I-DEP-RCM-RAS-0-05/07/2017*****************************************/
alter table ras.tmodelo
add constraint fk_tmodelo__id_marca foreign key (id_marca) references ras.tmarca(id_marca);

alter table ras.tequipo
add constraint fk_tequipo__id_tipo_equipo foreign key (id_tipo_equipo) references ras.ttipo_equipo(id_tipo_equipo);

alter table ras.tequipo
add constraint fk_tequipo__id_modelo foreign key (id_modelo) references ras.tmodelo(id_modelo);

alter table ras.tequipo
add constraint fk_tequipo__id_localizacion foreign key (id_localizacion) references ras.tlocalizacion(id_localizacion);

alter table ras.tresponsable
add constraint fk_tresponsable__id_persona foreign key (id_persona) references segu.tpersona(id_persona);

alter table ras.tlicencia
add constraint fk_tlicencia__id_responsable foreign key (id_responsable) references ras.tresponsable(id_responsable);

alter table ras.tlocalizacion
add constraint fk_tlocalizacion__id_localizacion_fk foreign key (id_localizacion_fk) references ras.tlocalizacion(id_localizacion);

/***********************************F-DEP-RCM-RAS-0-15/17/2017*****************************************/

/***********************************I-DEP-RCM-RAS-0-06/07/2017*****************************************/

CREATE VIEW ras.vequipo (
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_equipo,
    id_tipo_equipo,
    id_modelo,
    id_localizacion,
    pta,
    nro_chasis,
    nro_motor,
    cilindrada,
    nro_movil,
    traccion,
    color,
    cabina,
    monto,
    propiedad,
    placa,
    estado,
    fecha_alta,
    fecha_baja,
    gestion,
    uniqueid,
    marca,
    modelo,
    tipo_equipo,
    desc_equipo)
AS
SELECT eq.id_usuario_reg,
    eq.id_usuario_mod,
    eq.fecha_reg,
    eq.fecha_mod,
    eq.estado_reg,
    eq.id_usuario_ai,
    eq.usuario_ai,
    eq.id_equipo,
    eq.id_tipo_equipo,
    eq.id_modelo,
    eq.id_localizacion,
    eq.pta,
    eq.nro_chasis,
    eq.nro_motor,
    eq.cilindrada,
    eq.nro_movil,
    eq.traccion,
    eq.color,
    eq.cabina,
    eq.monto,
    eq.propiedad,
    eq.placa,
    eq.estado,
    eq.fecha_alta,
    eq.fecha_baja,
    eq.gestion,
    eq.uniqueid,
    mar.nombre AS marca,
    mod.nombre AS modelo,
    teq.nombre AS tipo_equipo,
    (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text) ||
        COALESCE(mar.nombre, ''::character varying)::text) || ' '::text) || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text) || COALESCE(eq.gestion::character varying, ''::character varying)::text) || ' '::text) || COALESCE(eq.color, ''::character varying)::text) || ' Placa '::text) || eq.placa::text AS desc_equipo
FROM ras.tequipo eq
     JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
     JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
     JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo;
/***********************************F-DEP-RCM-RAS-0-06/07/2017*****************************************/

/***********************************I-DEP-RCM-RAS-0-23/07/2017*****************************************/
alter table ras.tequipo
add constraint fk_tequipo__id_grupo foreign key (id_grupo) references ras.tgrupo(id_grupo);

 -- object recreation
DROP VIEW ras.vequipo;

CREATE VIEW ras.vequipo(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_equipo,
    id_tipo_equipo,
    id_modelo,
    id_localizacion,
    pta,
    nro_chasis,
    nro_motor,
    cilindrada,
    nro_movil,
    traccion,
    color,
    cabina,
    monto,
    propiedad,
    placa,
    estado,
    fecha_alta,
    fecha_baja,
    gestion,
    uniqueid,
    marca,
    modelo,
    tipo_equipo,
    desc_equipo,
    id_grupo,
    desc_grupo,
    color_grupo)
AS
  SELECT eq.id_usuario_reg,
         eq.id_usuario_mod,
         eq.fecha_reg,
         eq.fecha_mod,
         eq.estado_reg,
         eq.id_usuario_ai,
         eq.usuario_ai,
         eq.id_equipo,
         eq.id_tipo_equipo,
         eq.id_modelo,
         eq.id_localizacion,
         eq.pta,
         eq.nro_chasis,
         eq.nro_motor,
         eq.cilindrada,
         eq.nro_movil,
         eq.traccion,
         eq.color,
         eq.cabina,
         eq.monto,
         eq.propiedad,
         eq.placa,
         eq.estado,
         eq.fecha_alta,
         eq.fecha_baja,
         eq.gestion,
         eq.uniqueid,
         mar.nombre AS marca,
         mod.nombre AS modelo,
         teq.nombre AS tipo_equipo,
         (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text
           ) || COALESCE(mar.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(eq.gestion::character varying, ''::character varying)::
           text) || ' '::text) || COALESCE(eq.color, ''::character varying)::
           text) || ' Placa '::text) || eq.placa::text AS desc_equipo,
         eq.id_grupo,
         grup.nombre as desc_grupo,
         grup.color as color_grupo
  FROM ras.tequipo eq
       JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
       JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
       JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo
       LEFT JOIN ras.tgrupo grup
       on grup.id_grupo = eq.id_grupo;
/***********************************F-DEP-RCM-RAS-0-23/07/2017*****************************************/




/***********************************I-DEP-RCM-RAS-0-26/07/2017*****************************************/
 -- object recreation
DROP VIEW ras.vequipo;

CREATE VIEW ras.vequipo(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_equipo,
    id_tipo_equipo,
    id_modelo,
    id_localizacion,
    pta,
    nro_chasis,
    nro_motor,
    cilindrada,
    nro_movil,
    traccion,
    color,
    cabina,
    monto,
    propiedad,
    placa,
    estado,
    fecha_alta,
    fecha_baja,
    gestion,
    uniqueid,
    marca,
    modelo,
    tipo_equipo,
    desc_equipo,
    id_grupo,
    desc_grupo,
    color_grupo,
    nro_celular)
AS
  SELECT eq.id_usuario_reg,
         eq.id_usuario_mod,
         eq.fecha_reg,
         eq.fecha_mod,
         eq.estado_reg,
         eq.id_usuario_ai,
         eq.usuario_ai,
         eq.id_equipo,
         eq.id_tipo_equipo,
         eq.id_modelo,
         eq.id_localizacion,
         eq.pta,
         eq.nro_chasis,
         eq.nro_motor,
         eq.cilindrada,
         eq.nro_movil,
         eq.traccion,
         eq.color,
         eq.cabina,
         eq.monto,
         eq.propiedad,
         eq.placa,
         eq.estado,
         eq.fecha_alta,
         eq.fecha_baja,
         eq.gestion,
         eq.uniqueid,
         mar.nombre AS marca,
         mod.nombre AS modelo,
         teq.nombre AS tipo_equipo,
         (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text
           ) || COALESCE(mar.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(eq.gestion::character varying, ''::character varying)::
           text) || ' '::text) || COALESCE(eq.color, ''::character varying)::
           text) || ' Placa '::text) || eq.placa::text AS desc_equipo,
         eq.id_grupo,
         grup.nombre AS desc_grupo,
         grup.color AS color_grupo,
         eq.nro_celular
  FROM ras.tequipo eq
       JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
       JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
       JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo
       LEFT JOIN ras.tgrupo grup ON grup.id_grupo = eq.id_grupo;
/***********************************F-DEP-RCM-RAS-0-26/07/2017*****************************************/




/***********************************I-DEP-RCM-RAS-0-15/08/2017*****************************************/
 -- object recreation
DROP VIEW ras.vequipo;

CREATE VIEW ras.vequipo(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_equipo,
    id_tipo_equipo,
    id_modelo,
    id_localizacion,
    pta,
    nro_chasis,
    nro_motor,
    cilindrada,
    nro_movil,
    traccion,
    color,
    cabina,
    monto,
    propiedad,
    placa,
    estado,
    fecha_alta,
    fecha_baja,
    gestion,
    uniqueid,
    marca,
    modelo,
    tipo_equipo,
    desc_equipo,
    id_grupo,
    desc_grupo,
    color_grupo,
    nro_celular,
    id_marca)
AS
  SELECT eq.id_usuario_reg,
         eq.id_usuario_mod,
         eq.fecha_reg,
         eq.fecha_mod,
         eq.estado_reg,
         eq.id_usuario_ai,
         eq.usuario_ai,
         eq.id_equipo,
         eq.id_tipo_equipo,
         eq.id_modelo,
         eq.id_localizacion,
         eq.pta,
         eq.nro_chasis,
         eq.nro_motor,
         eq.cilindrada,
         eq.nro_movil,
         eq.traccion,
         eq.color,
         eq.cabina,
         eq.monto,
         eq.propiedad,
         eq.placa,
         eq.estado,
         eq.fecha_alta,
         eq.fecha_baja,
         eq.gestion,
         eq.uniqueid,
         mar.nombre AS marca,
         mod.nombre AS modelo,
         teq.nombre AS tipo_equipo,
         (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text
           ) || COALESCE(mar.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(eq.gestion::character varying, ''::character varying)::
           text) || ' '::text) || COALESCE(eq.color, ''::character varying)::
           text) || ' Placa '::text) || eq.placa::text AS desc_equipo,
         eq.id_grupo,
         grup.nombre AS desc_grupo,
         grup.color AS color_grupo,
         eq.nro_celular,
         mod.id_marca
  FROM ras.tequipo eq
       JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
       JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
       JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo
       LEFT JOIN ras.tgrupo grup ON grup.id_grupo = eq.id_grupo;
/***********************************F-DEP-RCM-RAS-0-15/08/2017*****************************************/

/***********************************I-DEP-RCM-RAS-0-06/09/2017*****************************************/
alter table ras.tgrupo_notificacion
add constraint fk_tgrupo_notificacion__id_grupo foreign key (id_grupo) references ras.tgrupo(id_grupo);
alter table ras.tgrupo_notificacion
add constraint fk_tgrupo_notificacion__id_usuario foreign key (id_usuario) references segu.tusuario(id_usuario);
/***********************************F-DEP-RCM-RAS-0-06/09/2017*****************************************/

/***********************************I-DEP-JJA-RAS-0-08/05/2019*****************************************/
select pxp.f_insert_testructura_gui ('MONREO', 'RAS.4');
/***********************************F-DEP-JJA-RAS-0-08/05/2019*****************************************/

/***********************************I-DEP-JJA-RAS-0-16/09/2019*****************************************/

CREATE OR REPLACE VIEW ras.vequipo(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_equipo,
    id_tipo_equipo,
    id_modelo,
    id_localizacion,
    pta,
    nro_chasis,
    nro_motor,
    cilindrada,
    nro_movil,
    traccion,
    color,
    cabina,
    monto,
    propiedad,
    placa,
    estado,
    fecha_alta,
    fecha_baja,
    gestion,
    uniqueid,
    marca,
    modelo,
    tipo_equipo,
    desc_equipo,
    id_grupo,
    desc_grupo,
    color_grupo,
    nro_celular,
    id_marca,
    id_depto)
AS
  SELECT eq.id_usuario_reg,
         eq.id_usuario_mod,
         eq.fecha_reg,
         eq.fecha_mod,
         eq.estado_reg,
         eq.id_usuario_ai,
         eq.usuario_ai,
         eq.id_equipo,
         eq.id_tipo_equipo,
         eq.id_modelo,
         eq.id_localizacion,
         eq.pta,
         eq.nro_chasis,
         eq.nro_motor,
         eq.cilindrada,
         eq.nro_movil,
         eq.traccion,
         eq.color,
         eq.cabina,
         eq.monto,
         eq.propiedad,
         eq.placa,
         eq.estado,
         eq.fecha_alta,
         eq.fecha_baja,
         eq.gestion,
         eq.uniqueid,
         mar.nombre AS marca,
         mod.nombre AS modelo,
         teq.nombre AS tipo_equipo,
         (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text
           ) || COALESCE(mar.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(eq.gestion::character varying, ''::character varying)::
           text) || ' '::text) || COALESCE(eq.color, ''::character varying)::
           text) || ' Placa '::text) || eq.placa::text AS desc_equipo,
         eq.id_grupo,
         grup.nombre AS desc_grupo,
         grup.color AS color_grupo,
         eq.nro_celular,
         mod.id_marca,
         eq.id_depto
  FROM ras.tequipo eq
       JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
       JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
       JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo
       LEFT JOIN ras.tgrupo grup ON grup.id_grupo = eq.id_grupo;
/***********************************F-DEP-JJA-RAS-0-16/09/2019*****************************************/
/***********************************I-DEP-EGS-RAS-0-15/07/2020*****************************************/
CREATE OR REPLACE VIEW ras.vsol_vehiculo(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    obs_dba,
    estado,
    id_estado_wf,
    id_proceso_wf,
    nro_tramite,
    id_funcionario_jefe_depto,
    observacion,
    hora_retorno,
    fecha_retorno,
    hora_salida,
    fecha_salida,
    fecha_sol,
    motivo,
    destino,
    id_funcionario,
    id_sol_vehiculo,
    id_tipo_equipo,
    ceco_clco,
    alquiler,
    alquiler_numero)
AS
  SELECT tsol_vehiculo.id_usuario_reg,
         tsol_vehiculo.id_usuario_mod,
         tsol_vehiculo.fecha_reg,
         tsol_vehiculo.fecha_mod,
         tsol_vehiculo.estado_reg,
         tsol_vehiculo.id_usuario_ai,
         tsol_vehiculo.usuario_ai,
         tsol_vehiculo.obs_dba,
         tsol_vehiculo.estado,
         tsol_vehiculo.id_estado_wf,
         tsol_vehiculo.id_proceso_wf,
         tsol_vehiculo.nro_tramite,
         tsol_vehiculo.id_funcionario_jefe_depto,
         tsol_vehiculo.observacion,
         tsol_vehiculo.hora_retorno,
         tsol_vehiculo.fecha_retorno,
         tsol_vehiculo.hora_salida,
         tsol_vehiculo.fecha_salida,
         tsol_vehiculo.fecha_sol,
         tsol_vehiculo.motivo,
         tsol_vehiculo.destino,
         tsol_vehiculo.id_funcionario,
         tsol_vehiculo.id_sol_vehiculo,
         tsol_vehiculo.id_tipo_equipo,
         tsol_vehiculo.ceco_clco,
         tsol_vehiculo.alquiler,
         CASE
           WHEN tsol_vehiculo.alquiler::text = 'no'::text THEN 0
           ELSE 1
         END AS alquiler_numero
  FROM ras.tsol_vehiculo;
select pxp.f_insert_testructura_gui ('RAS', 'SISTEMA');
select pxp.f_insert_testructura_gui ('RAS.4', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.5', 'RAS.4');
select pxp.f_insert_testructura_gui ('RAS.6', 'RAS.4');
select pxp.f_insert_testructura_gui ('RAS.7', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.10', 'RAS.7');
select pxp.f_insert_testructura_gui ('RAS.11', 'RAS.7');
select pxp.f_insert_testructura_gui ('RAS.12', 'RAS.7');
select pxp.f_insert_testructura_gui ('MONREO', 'RAS.4');
select pxp.f_insert_testructura_gui ('CONVEH', 'RAS');
select pxp.f_insert_testructura_gui ('RAS.3', 'CONVEH');
select pxp.f_insert_testructura_gui ('RAS.1', 'CONVEH');
select pxp.f_insert_testructura_gui ('RAS.8', 'CONVEH');
select pxp.f_insert_testructura_gui ('RAS.2', 'CONVEH');
select pxp.f_insert_testructura_gui ('RAS.21', 'CONVEH');
select pxp.f_insert_testructura_gui ('RAS.20', 'CONVEH');
select pxp.f_insert_testructura_gui ('SOLVEHI', 'RAS');
select pxp.f_insert_testructura_gui ('REGSOL', 'SOLVEHI');
select pxp.f_insert_testructura_gui ('vobosolv', 'SOLVEHI');
select pxp.f_insert_testructura_gui ('ASIGVEHI', 'SOLVEHI');
select pxp.f_insert_testructura_gui ('ELEMSEG', 'CONVEH');
select pxp.f_insert_testructura_gui ('INCID', 'CONVEH');
select pxp.f_insert_testructura_gui ('VEHEST', 'CONVEH');

ALTER TABLE ras.tasig_vehiculo
  ADD CONSTRAINT tasig_vehiculo_fk_id_sol_vehiculo FOREIGN KEY (id_sol_vehiculo)
    REFERENCES ras.tsol_vehiculo(id_sol_vehiculo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE ras.tnomina_persona
  ADD CONSTRAINT tnomina_persona_fk_id_sol_vehiculo FOREIGN KEY (id_sol_vehiculo)
    REFERENCES ras.tsol_vehiculo(id_sol_vehiculo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.tequipo_alquilado
  ADD CONSTRAINT tequipo_alquilado_fk_id_asig_vehiculo FOREIGN KEY (id_asig_vehiculo)
    REFERENCES ras.tasig_vehiculo(id_asig_vehiculo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE ras.telemento_seg_equipo
  ADD CONSTRAINT telemento_seg_equipo_fk_id_elemento_seg FOREIGN KEY (id_elemento_seg)
    REFERENCES ras.telemento_seg(id_elemento_seg)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.telemento_seg_equipo
  ADD CONSTRAINT telemento_seg_equipo_fk_id_equipo FOREIGN KEY (id_equipo)
    REFERENCES ras.tequipo(id_equipo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.tequipo_estado
  ADD CONSTRAINT tequipo_estado_fk_id_equipo FOREIGN KEY (id_equipo)
    REFERENCES ras.tequipo(id_equipo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.tasig_vehiculo_incidencia
  ADD CONSTRAINT tasig_vehiculo_incidencia_fk_id_asig_vehiculo FOREIGN KEY (id_asig_vehiculo)
    REFERENCES ras.tasig_vehiculo(id_asig_vehiculo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.tasig_vehiculo_incidencia
  ADD CONSTRAINT tasig_vehiculo_incidencia_fk_incidencia FOREIGN KEY (id_incidencia)
    REFERENCES ras.tincidencia(id_incidencia)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
ALTER TABLE ras.tasig_vehiculo
  ADD CONSTRAINT tasig_vehiculo_fk_is_equipo_estado FOREIGN KEY (id_equipo_estado)
    REFERENCES ras.tequipo_estado(id_equipo_estado)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
/***********************************F-DEP-EGS-RAS-0-15/07/2020*****************************************/

/***********************************I-DEP-JJA-RAS-0-15/01/2021*****************************************/
--#RAS-1
CREATE TRIGGER tg_equipo
  AFTER INSERT OR UPDATE OR DELETE
  ON ras.tequipo

FOR EACH ROW
  EXECUTE PROCEDURE ras.ftrig_equipo();

/***********************************F-DEP-JJA-RAS-0-15/01/2021*****************************************/
/***********************************I-DEP-JJA-RAS-0-19/02/2021*****************************************/
--#RAS-3
select pxp.f_insert_testructura_gui ('HISVEH', 'RAS.7');
/***********************************F-DEP-JJA-RAS-0-19/02/2021*****************************************/
/***********************************I-DEP-EGS-RAS-1-22/02/2021*****************************************/
CREATE OR REPLACE VIEW ras.vequipo(
                                   id_usuario_reg,
                                   id_usuario_mod,
                                   fecha_reg,
                                   fecha_mod,
                                   estado_reg,
                                   id_usuario_ai,
                                   usuario_ai,
                                   id_equipo,
                                   id_tipo_equipo,
                                   id_modelo,
                                   id_localizacion,
                                   pta,
                                   nro_chasis,
                                   nro_motor,
                                   cilindrada,
                                   nro_movil,
                                   traccion,
                                   color,
                                   cabina,
                                   monto,
                                   propiedad,
                                   placa,
                                   estado,
                                   fecha_alta,
                                   fecha_baja,
                                   gestion,
                                   uniqueid,
                                   marca,
                                   modelo,
                                   tipo_equipo,
                                   desc_equipo,
                                   id_grupo,
                                   desc_grupo,
                                   color_grupo,
                                   nro_celular,
                                   id_marca,
                                   id_depto,
                                   km_inicial,
                                   km_actual)
AS
SELECT eq.id_usuario_reg,
       eq.id_usuario_mod,
       eq.fecha_reg,
       eq.fecha_mod,
       eq.estado_reg,
       eq.id_usuario_ai,
       eq.usuario_ai,
       eq.id_equipo,
       eq.id_tipo_equipo,
       eq.id_modelo,
       eq.id_localizacion,
       eq.pta,
       eq.nro_chasis,
       eq.nro_motor,
       eq.cilindrada,
       eq.nro_movil,
       eq.traccion,
       eq.color,
       eq.cabina,
       eq.monto,
       eq.propiedad,
       eq.placa,
       eq.estado,
       eq.fecha_alta,
       eq.fecha_baja,
       eq.gestion,
       eq.uniqueid,
       mar.nombre AS marca,
       mod.nombre AS modelo,
       teq.nombre AS tipo_equipo,
       (((((((((COALESCE(teq.nombre, ''::character varying)::text || ' '::text
                   ) || COALESCE(mar.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(mod.nombre, ''::character varying)::text) || ' '::text)
           || COALESCE(eq.gestion::character varying, ''::character varying)::
               text) || ' '::text) || COALESCE(eq.color, ''::character varying)::
             text) || ' Placa '::text) || eq.placa::text AS desc_equipo,
       eq.id_grupo,
       grup.nombre AS desc_grupo,
       grup.color AS color_grupo,
       eq.nro_celular,
       mod.id_marca,
       eq.id_depto,
       eq.km_inicial,
       eq.km_actual
FROM ras.tequipo eq
         JOIN ras.tmodelo mod ON mod.id_modelo = eq.id_modelo
         JOIN ras.tmarca mar ON mar.id_marca = mod.id_marca
         JOIN ras.ttipo_equipo teq ON teq.id_tipo_equipo = eq.id_tipo_equipo
         LEFT JOIN ras.tgrupo grup ON grup.id_grupo = eq.id_grupo;
/***********************************F-DEP-EGS-RAS-1-22/02/2021*****************************************/
/***********************************I-DEP-EGS-RAS-GDV-34-24/02/2021*****************************************/
select pxp.f_insert_testructura_gui ('VHK', 'RAS.7');
/***********************************F-DEP-EGS-RAS-GDV-34-24/02/2021*****************************************/

/***********************************I-DEP-EGS-RAS-GDV-37-14/03/2021****************************************/
select wf.f_import_ttipo_documento_estado ('insert','ASIGVEHI','SOLVEH','borrador','SOLVEH','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','REPVIAJ','SOLVEH','borrador','SOLVEH','crear','superior','');
select wf.f_import_ttipo_documento_estado ('insert','SOLVEHI','SOLVEH','borrador','SOLVEH','crear','superior','');
/***********************************F-DEP-EGS-RAS-GDV-37-14/03/2021****************************************/


/***********************************I-DEP-JJA-RAS-GDV-34-24/02/2021*****************************************/
DROP TRIGGER tg_equipo ON ras.tequipo; --#RAS-7
/***********************************F-DEP-JJA-RAS-GDV-34-24/02/2021*****************************************/

/***********************************I-DEP-JJA-RAS-GDV-34-21/05/2021*****************************************/
--#RAS-8
select pxp.f_insert_testructura_gui ('ASIVEHI', 'RAS.7');
/***********************************F-DEP-JJA-RAS-GDV-34-21/05/2021*****************************************/
