CREATE OR REPLACE FUNCTION ras.ft_positions_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.ft_positions_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.positions'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 20:34:23
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
	v_rec 				record;
	v_detenido 			boolean;
	v_total_distancia	numeric;
	v_distance 			text;
			    
BEGIN

	v_nombre_funcion = 'ras.ft_positions_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:23
	***********************************/

	if(p_transaccion='PB_POSIC_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						posic.id,
						posic.address,
						posic.devicetime,
						posic.accuracy,
						posic.course,
						posic.altitude,
						posic.protocol,
						posic.speed,
						posic.network,
						posic.servertime,
						posic.longitude,
						posic.valid,
						posic.deviceid,
						posic.attributes,
						posic.latitude,
						posic.fixtime
						from positions posic
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:23
	***********************************/

	elsif(p_transaccion='PB_POSIC_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id)
					    from positions posic
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_ULT'
 	#DESCRIPCION:	Devuelve la posición actual de los ids de equipos enviados
 	#AUTOR:			RCM
 	#FECHA:			06/07/2017
	***********************************/

	elsif(p_transaccion='PB_POSIC_ULT')then

		begin
			--Sentencia de la consulta
			v_consulta:='select
						eq.id_equipo, eq.uniqueid,
						eq.marca, eq.modelo, eq.placa, per.nombre_completo1 as responsable, per.ci,
						per.celular1, per.correo,
						pos.latitude, pos.longitude, pos.altitude, pos.speed, pos.course,
						pos.address, pos.attributes, pos.accuracy,
						eq.desc_equipo,
						ev.id as eventid,
						ev.type,
						ev.attributes as attributes_event,
						case ev.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else ev.type
						end as desc_type
						from ras.vequipo eq
						inner join devices dev
						on dev.uniqueid = eq.uniqueid
						inner join positions pos
						on pos.id = dev.positionid
						left join ras.tequipo_responsable eres
						on eres.id_equipo = eq.id_equipo
						and eres.estado_reg = ''activo''
						left join ras.tresponsable re
						on re.id_responsable = eres.id_responsable
						left join segu.vpersona per
						on per.id_persona = re.id_persona
						left join events ev
						on ev.positionid = pos.id
						where eq.id_equipo in ('||v_parametros.ids||')';


			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSRAN_SEL'
 	#DESCRIPCION:	Devuelve las posiciones en un rango de fechas de los ids de equipos enviados
 	#AUTOR:			RCM
 	#FECHA:			07/07/2017
	***********************************/

	elsif(p_transaccion='PB_POSRAN_SEL')then

		begin

			--Sentencia de la consulta
			v_consulta:='select
						eq.id_equipo, eq.uniqueid,
						eq.marca, eq.modelo, eq.placa,per.nombre_completo1 as responsable, per.ci,
						per.celular1, per.correo,
						pos.latitude, pos.longitude, pos.altitude, pos.speed, pos.course,
						pos.address, pos.attributes, pos.accuracy,
						eq.desc_equipo,
						ev.id as eventid,
						ev.type,
						ev.attributes as attributes_event,
						case ev.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else ev.type
						end as desc_type
						from ras.vequipo eq
						inner join devices de
						on de.uniqueid = eq.uniqueid
						inner join positions pos
						on pos.deviceid = de.id
						left join ras.tequipo_responsable eres
						on eres.id_equipo = eq.id_equipo
						and eres.estado_reg = ''activo''
						left join ras.tresponsable re
						on re.id_responsable = eres.id_responsable
						left join segu.vpersona per
						on per.id_persona = re.id_persona
						left join events ev
						on ev.positionid = pos.id
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.servertime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone
						order by pos.servertime';

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_PORAPRO_SEL'
 	#DESCRIPCION:	Devuelve las posiciones en un rango de fechas de los ids de equipos enviados, verificando que no se mande las posiciones cuando esta detenido
 	#AUTOR:			RCM
 	#FECHA:			09/07/2017
	***********************************/

	elsif(p_transaccion='PB_PORAPRO_SEL')then

		begin

			--Crea tabla temporal
			create temp table ras_posiciones (
				id serial,
				id_equipo integer,
				uniqueid varchar,
				marca varchar,
				modelo varchar,
				placa varchar,
				responsable text,
				ci varchar,
				celular1 varchar,
				correo varchar,
				latitude float8,
				longitude float8,
				altitude float8,
				speed float8,
				course float8,
				address varchar,
				attributes varchar,
				accuracy float8,
				desc_equipo text,
				eventid integer,
				type varchar,
				attributes_event varchar,
				desc_type varchar,
				send boolean default true,
				distance numeric,
				servertime timestamp
			) on commit drop;

			--Sentencia de la consulta
			v_consulta:='insert into ras_posiciones(
				id_equipo,
				uniqueid,
				marca,
				modelo,
				placa,
				responsable,
				ci,
				celular1,
				correo,
				latitude,
				longitude,
				altitude,
				speed,
				course,
				address,
				attributes,
				accuracy,
				desc_equipo,
				eventid,
				type,
				attributes_event,
				desc_type,
				servertime)
						select
						eq.id_equipo, eq.uniqueid,
						eq.marca, eq.modelo, eq.placa,per.nombre_completo1 as responsable, per.ci,
						per.celular1, per.correo,
						pos.latitude, pos.longitude, pos.altitude, pos.speed, pos.course,
						pos.address, pos.attributes, pos.accuracy,
						eq.desc_equipo,
						ev.id as eventid,
						ev.type,
						ev.attributes as attributes_event,
						case ev.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else ev.type
						end as desc_type,
						pos.servertime
						from ras.vequipo eq
						inner join devices de
						on de.uniqueid = eq.uniqueid
						inner join positions pos
						on pos.deviceid = de.id
						left join ras.tequipo_responsable eres
						on eres.id_equipo = eq.id_equipo
						and eres.estado_reg = ''activo''
						left join ras.tresponsable re
						on re.id_responsable = eres.id_responsable
						left join segu.vpersona per
						on per.id_persona = re.id_persona
						left join events ev
						on ev.positionid = pos.id
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.servertime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone
						order by pos.servertime';

			execute(v_consulta);
--raise notice 'CONS: %',v_consulta;

			--Recorrido de las posiciones obtenidas para verificar de no mandar posiciones repetidas cuando este detenido
			v_detenido = false;
			v_total_distancia = 0;
			for v_rec in select * from ras_posiciones loop
				v_distance = cast(v_rec.attributes as json)->>'distance';
				v_total_distancia = v_total_distancia + cast(v_distance as numeric);
				--Pregunta si esta detenido
				if v_rec.desc_type = 'deviceStopped'  then
					if v_detenido = true then
						update ras_posiciones set send = false where id = v_rec.id;
					else
						v_detenido = true;
					end if;
				else
					v_detenido = false;
				end if;


			end loop;

			for v_rec in select * from ras_posiciones order by servertime desc limit 1 loop
				update ras_posiciones set distance = v_total_distancia where id = v_rec.id;
			end loop;

			v_consulta = 'select * from ras_posiciones where send = true order by servertime';

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSVEL_SEL'
 	#DESCRIPCION:	Devuelve rango de velocidades en un rango de fechas para los equipos enviados
 	#AUTOR:			RCM
 	#FECHA:			13/07/2017
	***********************************/

	elsif(p_transaccion='PB_POSVEL_SEL')then

		begin

			--Sentencia de la consulta
			v_consulta:='select
						eq.id_equipo, eq.uniqueid,
						eq.marca, eq.modelo, eq.placa,
						pos.latitude, pos.longitude, pos.altitude, pos.speed, pos.course,
						pos.address, pos.attributes, pos.accuracy,
						eq.desc_equipo,
						ev.id as eventid,
						ev.type,
						ev.attributes as attributes_event,
						case ev.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else ev.type
						end as desc_type,
						pos.servertime,
						eq.tipo_equipo
						from ras.vequipo eq
						inner join devices de
						on de.uniqueid = eq.uniqueid
						inner join positions pos
						on pos.deviceid = de.id
						left join events ev
						on ev.positionid = pos.id
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.servertime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone
						and pos.speed between ' || v_parametros.velocidad_ini || ' and '||v_parametros.velocidad_fin || '
						order by pos.servertime';

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
	end if;
					
EXCEPTION
					
	WHEN OTHERS THEN
			v_resp='';
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
			v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
			v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
			raise exception '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;
