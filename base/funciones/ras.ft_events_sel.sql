--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_events_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.ft_events_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.events'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 20:34:28
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
  #RAS-1       15/01/2021        JJA            Actualizacion de traccar ultima version 
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
	v_eventos			varchar;
	v_factor_vel		numeric = 1.852;
	v_utc				varchar = '- interval ''4 hour''';
			    
BEGIN

	v_nombre_funcion = 'ras.ft_events_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PB_EVENT_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:28
	***********************************/

	if(p_transaccion='PB_EVENT_SEL')then
     				
    	begin
            --#RAS-1
    		--Sentencia de la consulta
			v_consulta:='select
						event.id,
						event.geofenceid,
						event.deviceid,
						event.servertime '||v_utc||' as servertime,
						event.attributes,
						event.type,
						event.positionid,
						pos.latitude,
						pos.longitude,
						case event.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else event.type
						end as desc_type
						from public.tc_events event
						inner join public.tc_positions pos
						on pos.id = event.positionid
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'PB_EVENT_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:28
	***********************************/

	elsif(p_transaccion='PB_EVENT_CONT')then

		begin
            --#RAS-1
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(event.id)
					    from public.tc_events event
					    inner join public.tc_positions pos
						on pos.id = event.positionid
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_EVRAN_SEL'
 	#DESCRIPCION:	Devuelve los eventos en un rango de tiempo
 	#AUTOR:			RCM
 	#FECHA:			13/07/2017
	***********************************/

	elsif(p_transaccion='PB_EVRAN_SEL')then

		begin

			v_eventos = '';

			--Procesa el parámetro de eventos
			v_eventos = replace(v_parametros.events,'deviceStopped','''deviceStopped''');
			v_eventos = replace(v_eventos,'deviceOffline','''deviceOffline''');
			v_eventos = replace(v_eventos,'deviceUnknown','''deviceUnknown''');
			v_eventos = replace(v_eventos,'deviceMoving','''deviceMoving''');
			v_eventos = replace(v_eventos,'deviceOnline','''deviceOnline''');
			v_eventos = replace(v_eventos,'alarm','''alarm''');
			v_eventos = replace(v_eventos,'4001','''4001''');
			v_eventos = replace(v_eventos,'4006','''4006''');
			v_eventos = replace(v_eventos,'6002','''6002''');
			v_eventos = replace(v_eventos,'6006','''6006''');
			v_eventos = replace(v_eventos,'6007','''6007''');
			v_eventos = replace(v_eventos,'6009','''6009''');
			v_eventos = replace(v_eventos,'6010','''6010''');
			v_eventos = replace(v_eventos,'6011','''6011''');
			v_eventos = replace(v_eventos,'6012','''6012''');
			v_eventos = replace(v_eventos,'6016','''6016''');
			v_eventos = replace(v_eventos,'6017','''6017''');
			v_eventos = replace(v_eventos,'6018','''6018''');

			--Sentencia de la consulta
            --#RAS-1
			v_consulta:='select
                        eq.id_equipo, 
                        eq.uniqueid, 
                        eq.desc_equipo, 
                        eq.placa,
                        eq.tipo_equipo,
                        eq.marca,
                        eq.modelo,
                        ev.id as eventid,
                        ev.servertime '||v_utc||' as devicetime,
                        ev.deviceid, --10
                        ev.attributes,
                        case ev.type
                            when ''deviceStopped'' then ''Detenido''::varchar
                            when ''deviceOffline'' then ''Desconectado''::varchar
                            when ''deviceUnknown'' then ''Desconocido''::varchar
                            when ''deviceMoving'' then ''En Movimiento''::varchar
                            when ''deviceOnline'' then ''Online''::varchar
                            when ''alarm'' then ''Alarma''::varchar
                            else ev.type
                        end as desc_type,
                        pos.latitude,
                        pos.longitude,
                        pos.altitude,
                        pos.speed * '||v_factor_vel||',
                        pos.course,
						pos.address,
						pos.attributes as attributes_pos, 
						pos.accuracy --20
                        from public.tc_events ev
                        inner join public.tc_devices dev
                        on dev.id = ev.deviceid
                        left join ras.vequipo eq
                        on eq.uniqueid = dev.uniqueid
                        left join public.tc_positions pos
                        on pos.id = ev.positionid
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.devicetime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone ';
			

			v_consulta = v_consulta || ' union
						select
						eq.id_equipo,
						eq.uniqueid,
						eq.desc_equipo,
						eq.placa,
						eq.tipo_equipo,
						eq.marca,
						eq.modelo,
						tev.id_tipo_evento as eventid,
						pos.devicetime '||v_utc||' as devicetime,
						dev.id as deviceid, --10
						pos.attributes,
						tev.codigo || '' - '' || tev.nombre desc_type,
						pos.latitude,
						pos.longitude,
						pos.altitude,
						pos.speed * '||v_factor_vel||',
						pos.course,
						pos.address,
						pos.attributes as attributes_pos,
						pos.accuracy --20
						from public.tc_positions pos
						inner join public.tc_devices dev
						on dev.id = pos.deviceid
						left join ras.vequipo eq
						on eq.uniqueid = dev.uniqueid
						inner join ras.ttipo_evento tev
						on tev.codigo = cast(pos.attributes as json)->>''event''
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.devicetime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone ';
                        
			if v_parametros.events <> '' then
            	v_consulta = v_consulta || ' and cast(pos.attributes as json)->>''event'' in ('||v_eventos||') and ';
            else
            	v_consulta = v_consulta || ' and ';
            end if;

            --Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_EVRAN_CONT'
 	#DESCRIPCION:	Devuelve conteo de los eventos en un rango de tiempo
 	#AUTOR:			RCM
 	#FECHA:			13/07/2017
	***********************************/

	elsif(p_transaccion='PB_EVRAN_CONT')then

		begin

			--Procesa el parámetro de eventos
			v_eventos = replace(v_parametros.events,'deviceStopped','''deviceStopped''');
			v_eventos = replace(v_eventos,'deviceOffline','''deviceOffline''');
			v_eventos = replace(v_eventos,'deviceUnknown','''deviceUnknown''');
			v_eventos = replace(v_eventos,'deviceMoving','''deviceMoving''');
			v_eventos = replace(v_eventos,'deviceOnline','''deviceOnline''');
			v_eventos = replace(v_eventos,'alarm','''alarm''');
            v_eventos = replace(v_eventos,'4001','''4001''');            
			v_eventos = replace(v_eventos,'4006','''4006''');
			v_eventos = replace(v_eventos,'6002','''6002''');
			v_eventos = replace(v_eventos,'6006','''6006''');
			v_eventos = replace(v_eventos,'6007','''6007''');
			v_eventos = replace(v_eventos,'6009','''6009''');
			v_eventos = replace(v_eventos,'6010','''6010''');
			v_eventos = replace(v_eventos,'6011','''6011''');
			v_eventos = replace(v_eventos,'6012','''6012''');
			v_eventos = replace(v_eventos,'6016','''6016''');
			v_eventos = replace(v_eventos,'6017','''6017''');
			v_eventos = replace(v_eventos,'6018','''6018''');

			--Sentencia de la consulta
            --#RAS-1
			v_consulta:='select count(1) as total from (select
                        eq.id_equipo, 
                        eq.uniqueid, 
                        eq.desc_equipo, 
                        eq.placa,
                        eq.tipo_equipo,
                        eq.marca,
                        eq.modelo,
                        ev.id as eventid,
                        ev.servertime '||v_utc||' as devicetime,
                        ev.deviceid, --10
                        ev.attributes,
                        case ev.type
                            when ''deviceStopped'' then ''Detenido''::varchar
                            when ''deviceOffline'' then ''Desconectado''::varchar
                            when ''deviceUnknown'' then ''Desconocido''::varchar
                            when ''deviceMoving'' then ''En Movimiento''::varchar
                            when ''deviceOnline'' then ''Online''::varchar
                            when ''alarm'' then ''Alarma''::varchar
                            else ev.type
                        end as desc_type,
                        pos.latitude,
                        pos.longitude,
                        pos.altitude,
                        pos.speed * '||v_factor_vel||',
                        pos.course,
						pos.address,
						pos.attributes as attributes_pos, 
						pos.accuracy --20
                        from public.tc_events ev
                        inner join public.tc_devices dev
                        on dev.id = ev.deviceid
                        left join ras.vequipo eq
                        on eq.uniqueid = dev.uniqueid
                        left join public.tc_positions pos
                        on pos.id = ev.positionid
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.devicetime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone ';
                        
			if v_parametros.events <> '' then
            	v_consulta = v_consulta || ' and ev.type in ('||v_eventos||') and ';
            else
            	v_consulta = v_consulta || ' and ';
            end if;

            v_consulta:=v_consulta||v_parametros.filtro;

            v_consulta = v_consulta || ' union 
						select
						eq.id_equipo,
						eq.uniqueid,
						eq.desc_equipo,
						eq.placa,
						eq.tipo_equipo,
						eq.marca,
						eq.modelo,
						tev.id_tipo_evento as eventid,
						pos.devicetime '||v_utc||' as devicetime,
						dev.id as deviceid, --10
						pos.attributes,
						tev.codigo || '' - '' || tev.nombre desc_type,
						pos.latitude,
						pos.longitude,
						pos.altitude,
						pos.speed * '||v_factor_vel||',
						pos.course,
						pos.address,
						pos.attributes as attributes_pos,
						pos.accuracy --20
						from public.tc_positions pos
						inner join public.tc_devices dev
						on dev.id = pos.deviceid
						left join ras.vequipo eq
						on eq.uniqueid = dev.uniqueid
						inner join ras.ttipo_evento tev
						on tev.codigo = cast(pos.attributes as json)->>''event''
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.devicetime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '''||v_parametros.fecha_ini||'''::timestamp with time zone and '''||v_parametros.fecha_fin||'''::timestamp with time zone ';
                        
			if v_parametros.events <> '' then
            	v_consulta = v_consulta || ' and cast(pos.attributes as json)->>''event'' in ('||v_eventos||') and ';
            else
            	v_consulta = v_consulta || ' and ';
            end if;

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			v_consulta = v_consulta || ') as tcont';

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
PARALLEL UNSAFE
COST 100;