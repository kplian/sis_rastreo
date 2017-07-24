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
  accuracy DOUBLE PRECISION DEFAULT 0 NOT NULL,
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

CREATE INDEX tmodelo_idx ON ras.tmodelo
  USING btree (id_modelo);  

CREATE INDEX devices_idx ON public.devices
  USING btree (uniqueid);

CREATE INDEX positions_idx ON public.positions
  USING btree (id);
/***********************************F-SCP-RCM-RAS-0-06/07/2017****************************************/    

/***********************************I-SCP-RCM-RAS-0-19/07/2017****************************************/
CREATE INDEX tequipo_responsable_idx1 ON ras.tequipo_responsable
  USING btree (fecha_ini, fecha_fin, id_equipo);
CREATE INDEX tequipo_responsable_idx ON ras.tequipo_responsable
  USING btree (id_equipo_responsable);
/***********************************F-SCP-RCM-RAS-0-19/07/2017****************************************/