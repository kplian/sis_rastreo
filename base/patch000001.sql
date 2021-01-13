/***********************************I-SCP-RCM-RAS-0-05/07/2017****************************************/
 
create table ras.ttipo_equipo (
  id_tipo_equipo serial,
  codigo varchar(20),
  nombre varchar(100),
  constraint pk_ttipo_equipo__id_tipo_equipo PRIMARY KEY (id_tipo_equipo)
) inherits (pxp.tbase)
with oids;

create table ras.tmarca (
  id_marca serial,
  nombre varchar(100),
  procedencia varchar(100),
  constraint pk_tmarca__id_marca PRIMARY KEY (id_marca)
) inherits (pxp.tbase)
with oids;

create table ras.tmodelo (
  id_modelo serial,
  id_marca integer not null,
  codigo varchar(20),
  nombre varchar(100),
  constraint pk_tmodelo__id_modelo PRIMARY KEY (id_modelo)
) inherits (pxp.tbase)
with oids;

create table ras.tresponsable (
  id_responsable serial,
  id_persona integer,
  codigo varchar(20),
  constraint pk_tresponsable__id_responsable PRIMARY KEY (id_responsable)
) inherits (pxp.tbase)
with oids;

create table ras.tlicencia (
  id_licencia SERIAL,
  id_responsable INTEGER NOT NULL,
  tipo VARCHAR(20),
  nro_licencia VARCHAR(30),
  fecha_exp DATE,
  fecha_curso DATE,
  calificacion_curso NUMERIC(18,2),
  fecha_autoriz DATE,
  constraint pk_tlicencia primary key(id_licencia)
) inherits (pxp.tbase)

with (oids = true);

create table ras.tlocalizacion (
  id_localizacion SERIAL,
  id_localizacion_fk INTEGER,
  codigo VARCHAR(30),
  nombre VARCHAR(150),
  latitud DOUBLE PRECISION,
  longitud DOUBLE PRECISION,
  constraint pk_tlocalizacion__id_localizacion primary key(id_localizacion)
) inherits (pxp.tbase)
with (oids = true);

create table ras.tequipo (
  id_equipo serial,
  id_tipo_equipo integer,
  id_modelo integer,
  id_localizacion integer,
  pta varchar(50),
  nro_chasis varchar(50),
  nro_motor varchar(50),
  cilindrada numeric(18,2),
  nro_movil varchar(50),
  traccion varchar(30),
  color varchar(50),
  cabina varchar(20),
  monto numeric(18,2),
  propiedad varchar(50),
  placa varchar(20),
  estado varchar(15),
  fecha_alta date,
  fecha_baja date,
  gestion integer,
  constraint pk_tequipo__id_equipo PRIMARY KEY (id_equipo)
) inherits (pxp.tbase)
with oids;

create table ras.tequipo_responsable (
  id_equipo_responsable serial,
  id_equipo integer not null,
  id_responsable integer not null,
  fecha_ini date,
  fecha_fin date,
  constraint pk_tequipo_responsable__id_equipo_responsable PRIMARY KEY (id_equipo_responsable)
) inherits (pxp.tbase)
with oids;

/* TABLAS TRACCAR
CREATE TABLE public.devices (
  id SERIAL,
  name VARCHAR(128) NOT NULL,
  uniqueid VARCHAR(128) NOT NULL,
  lastupdate TIMESTAMP WITHOUT TIME ZONE,
  positionid INTEGER,
  groupid INTEGER,
  attributes VARCHAR(4000),
  phone VARCHAR(128),
  model VARCHAR(128),
  contact VARCHAR(512),
  category VARCHAR(128),
  CONSTRAINT pk_devices PRIMARY KEY(id),
  CONSTRAINT uk_device_uniqueid UNIQUE(uniqueid)
) 
WITH (oids = false);

CREATE TABLE public.events (
  id SERIAL,
  type VARCHAR(128) NOT NULL,
  servertime TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  deviceid INTEGER,
  positionid INTEGER,
  geofenceid INTEGER,
  attributes VARCHAR(4000),
  CONSTRAINT pk_events PRIMARY KEY(id)
) 
WITH (oids = false);

CREATE TABLE public.positions (
  id SERIAL,
  protocol VARCHAR(128),
  deviceid INTEGER NOT NULL,
  servertime TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  devicetime TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  fixtime TIMESTAMP WITHOUT TIME ZONE NOT NULL,
  valid BOOLEAN NOT NULL,
  latitude DOUBLE PRECISION NOT NULL,
  longitude DOUBLE PRECISION NOT NULL,
  altitude DOUBLE PRECISION NOT NULL,
  speed DOUBLE PRECISION NOT NULL,
  course DOUBLE PRECISION NOT NULL,
  address VARCHAR(512),
  attributes VARCHAR(4000),
  accuracy DOUBLE PRECISION DEFAULT 0 NOT NULL
  network VARCHAR(4000),
  CONSTRAINT pk_positions PRIMARY KEY(id)
) 
WITH (oids = false);

CREATE TABLE public.notifications (
  id SERIAL,
  userid INTEGER NOT NULL,
  type VARCHAR(128) NOT NULL,
  attributes VARCHAR(4000),
  web BOOLEAN DEFAULT false,
  mail BOOLEAN DEFAULT false,
  sms BOOLEAN DEFAULT false,
  CONSTRAINT pk_notifications PRIMARY KEY(id)
) 
WITH (oids = false);*/
/***********************************F-SCP-RCM-RAS-0-05/07/2017****************************************/

/***********************************I-SCP-RCM-RAS-0-06/07/2017****************************************/
ALTER TABLE ras.tequipo
  ADD COLUMN uniqueid VARCHAR(128);

ALTER TABLE ras.tequipo
  ADD CONSTRAINT uq_tequipo__uniqueid 
    UNIQUE (uniqueid) NOT DEFERRABLE;  

ALTER TABLE ras.tequipo
  ADD CONSTRAINT uq_tequipo__placa 
    UNIQUE (placa) NOT DEFERRABLE; 

CREATE INDEX tequipo_idx ON ras.tequipo
  USING btree (id_equipo);

CREATE INDEX tmodelo_idx ON ras.tequipo
  USING btree (id_modelo);  

CREATE INDEX tmarca_idx ON ras.tmarca
  USING btree (id_marca);

/*CREATE INDEX tmodelo_idx ON ras.tmodelo
  USING btree (id_modelo); 

CREATE INDEX devices_idx ON public.devices
  USING btree (uniqueid);

CREATE INDEX positions_idx ON public.positions
  USING btree (id);
*/ 

/***********************************F-SCP-RCM-RAS-0-06/07/2017****************************************/

/***********************************I-SCP-RCM-RAS-0-19/07/2017****************************************/
CREATE INDEX tequipo_responsable_idx1 ON ras.tequipo_responsable
  USING btree (fecha_ini, fecha_fin, id_equipo);
CREATE INDEX tequipo_responsable_idx ON ras.tequipo_responsable
  USING btree (id_equipo_responsable);
/***********************************F-SCP-RCM-RAS-0-19/07/2017****************************************/

/***********************************I-SCP-RCM-RAS-0-23/07/2017****************************************/
create table ras.tgrupo (
  id_grupo serial,
  codigo varchar(20),
  nombre varchar(100),
  color varchar(15),
  constraint pk_tgrupo__id_grupo PRIMARY KEY (id_grupo)
) inherits (pxp.tbase)
with oids;

alter table ras.tequipo
add column id_grupo integer;
/***********************************F-SCP-RCM-RAS-0-23/07/2017****************************************/

/***********************************I-SCP-RCM-RAS-0-30/07/2017****************************************/
create table ras.ttipo_evento (
  id_tipo_evento serial,
  codigo varchar(20),
  nombre varchar(100),
  constraint pk_ttipo_evento__id_tipo_evento PRIMARY KEY (id_tipo_evento)
) inherits (pxp.tbase)
with oids;
/***********************************F-SCP-RCM-RAS-0-30/07/2017****************************************/

/***********************************I-SCP-RCM-RAS-1-30/07/2017****************************************/
alter table ras.tequipo
add column nro_celular VARCHAR(30);
/***********************************F-SCP-RCM-RAS-1-30/07/2017****************************************/


/***********************************I-SCP-RCM-RAS-1-12/08/2017****************************************/
/*
CREATE INDEX idx_devices__id ON public.devices
  USING btree (id);
CREATE INDEX idx_events__deviceid_servertime ON public.events
  USING btree (deviceid, servertime);
*/
/***********************************F-SCP-RCM-RAS-1-12/08/2017****************************************/

/***********************************I-SCP-RCM-RAS-1-06/09/2017****************************************/
create table ras.tgrupo_notificacion (
  id_grupo_notificacion serial,
  id_grupo integer,
  --id_usuario varchar(20),
  id_usuario integer,
  constraint pk_tgrupo_notificacion__id_grupo_notificacion PRIMARY KEY (id_grupo_notificacion)
) inherits (pxp.tbase)
with oids;
/***********************************F-SCP-RCM-RAS-1-06/09/2017****************************************/

/***********************************I-SCP-JDJ-RAS-1-29/08/2019****************************************/
ALTER TABLE ras.tequipo
  ADD COLUMN id_depto INTEGER;
/***********************************F-SCP-JDJ-RAS-1-29/08/2019****************************************/


/***********************************I-SCP-JDJ-RAS-1-19/09/2019****************************************/

ALTER TABLE ras.tgrupo
  ADD COLUMN id_depto INTEGER;
/***********************************F-SCP-JDJ-RAS-1-19/09/2019****************************************/
/***********************************I-SCP-EGS-RAS-1-15/07/2020****************************************/
CREATE TABLE ras.tsol_vehiculo (
  estado VARCHAR,
  id_estado_wf INTEGER,
  id_proceso_wf INTEGER,
  nro_tramite VARCHAR,
  id_funcionario_jefe_depto INTEGER,
  observacion VARCHAR,
  hora_retorno TIME WITHOUT TIME ZONE,
  fecha_retorno DATE,
  hora_salida TIME WITHOUT TIME ZONE,
  fecha_salida DATE,
  fecha_sol DATE,
  motivo VARCHAR,
  destino VARCHAR,
  id_funcionario INTEGER,
  id_sol_vehiculo SERIAL,
  id_tipo_equipo INTEGER,
  ceco_clco VARCHAR,
  alquiler VARCHAR DEFAULT 'no'::character varying,
  monto NUMERIC,
  id_centro_costo INTEGER,
  CONSTRAINT tsol_vehiculo_pkey PRIMARY KEY(id_sol_vehiculo)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE ras.tnomina_persona (
  id_nomina_persona SERIAL,
  nombre VARCHAR,
  id_sol_vehiculo INTEGER,
  id_funcionario INTEGER,
  CONSTRAINT tnomina_persona_pkey PRIMARY KEY(id_nomina_persona)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE ras.tincidencia (
  id_incidencia SERIAL,
  nombre VARCHAR,
  id_incidencia_fk INTEGER,
  CONSTRAINT tincidencia_pkey PRIMARY KEY(id_incidencia)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE ras.tequipo_estado (
  id_equipo_estado SERIAL,
  id_equipo INTEGER,
  fecha_inicio DATE,
  estado VARCHAR,
  fecha_final DATE,
  CONSTRAINT tequipo_estado_pkey PRIMARY KEY(id_equipo_estado)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE ras.tequipo_alquilado (
  id_equipo_alquilado SERIAL,
  placa VARCHAR,
  marca VARCHAR,
  modelo VARCHAR,
  id_proveedor INTEGER,
  id_asig_vehiculo INTEGER,
  id_tipo_equipo INTEGER,
  id_marca INTEGER,
  CONSTRAINT tequipo_alquilado_pkey PRIMARY KEY(id_equipo_alquilado)
) INHERITS (pxp.tbase)
WITH (oids = false);
CREATE TABLE ras.telemento_seg (
  id_elemento_seg SERIAL,
  nombre VARCHAR,
  CONSTRAINT telemento_seg_pkey PRIMARY KEY(id_elemento_seg)
) INHERITS (pxp.tbase)
WITH (oids = false);
CREATE TABLE ras.telemento_seg_equipo (
  id_elemento_seg_equipo SERIAL,
  id_elemento_seg INTEGER,
  id_equipo INTEGER,
  existe BOOLEAN,
  id_asig_vehiculo INTEGER,
  CONSTRAINT telemento_seg_equipo_pkey PRIMARY KEY(id_elemento_seg_equipo)
) INHERITS (pxp.tbase)
WITH (oids = false);
CREATE TABLE ras.tasig_vehiculo (
  id_asig_vehiculo SERIAL,
  id_responsable INTEGER,
  id_equipo INTEGER,
  observaciones VARCHAR,
  id_sol_vehiculo INTEGER,
  km_inicio NUMERIC,
  km_final NUMERIC,
  recorrido NUMERIC,
  observacion_viaje VARCHAR,
  hora_salida_ofi TIME WITHOUT TIME ZONE,
  hora_retorno_ofi TIME WITHOUT TIME ZONE,
  fecha_salida_ofi DATE,
  fecha_retorno_ofi DATE,
  id_equipo_estado INTEGER,
  incidencia VARCHAR DEFAULT 'no'::character varying NOT NULL,
  CONSTRAINT tasig_vehiculo_pkey PRIMARY KEY(id_asig_vehiculo)
) INHERITS (pxp.tbase)
WITH (oids = false);

CREATE TABLE ras.tasig_vehiculo_incidencia (
  id_asig_vehiculo_incidedencia SERIAL,
  id_asig_vehiculo INTEGER,
  id_incidencia SERIAL,
  observacion VARCHAR,
  CONSTRAINT tasig_vehiculo_incidencia_pkey PRIMARY KEY(id_asig_vehiculo_incidedencia)
) INHERITS (pxp.tbase)
WITH (oids = false);
/***********************************F-SCP-EGS-RAS-1-15/07/2020****************************************/
/***********************************I-SCP-EGS-RAS-2-26/08/2020****************************************/
ALTER TABLE ras.telemento_seg_equipo
  ADD COLUMN observacion VARCHAR;
ALTER TABLE ras.telemento_seg_equipo
  ADD COLUMN estado_elemento VARCHAR DEFAULT 'bueno' NOT NULL;
/***********************************F-SCP-EGS-RAS-2-26/08/2020****************************************/
/***********************************I-SCP-EGS-RAS-3-29/12/2020****************************************/
ALTER TABLE ras.tsol_vehiculo
    ADD COLUMN existe_conductor VARCHAR(2) DEFAULT 'si' NOT NULL;
/***********************************F-SCP-EGS-RAS-3-29/12/2020****************************************/



