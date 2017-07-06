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