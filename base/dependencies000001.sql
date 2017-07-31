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