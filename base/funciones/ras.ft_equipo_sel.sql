--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_equipo_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_equipo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tequipo'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:17
 COMENTARIOS:
***************************************************************************

 HISTORIAL DE MODIFICACIONES:
 ISUUE			FECHA			 AUTHOR 		 DESCRIPCION
 * #6			19/09/2019		  JUAN		     Agregado de funcinalidad para el registro de vehiculos asociados a una regionales y grupos
   #RAS-1       15/01/2021        JJA            Actualizacion de traccar ultima version
   #RAS-3          19/02/2021      JJA         Nuevo reporte de historial de movimientos de vehículos
  #GDV-33       22/02/2021        EGS           Se recupera kilometraje
  #RAS-6        10/02/2021        JJA           Reporte de tiempo de parqueo en pdf
***************************************************************************/

DECLARE

    v_consulta    		varchar;
    v_parametros  		record;
    v_nombre_funcion   	text;
    v_resp				varchar;
    v_factor_vel		numeric = 1.852;
    v_utc				varchar = '- interval ''4 hour''';

    v_filtro            varchar;
    va_id_depto			integer[];
    v_registro          record;

    v_id_position integer; --#RAS-6
    v_bandera_aux integer; --#RAS-6
    v_hora TIMESTAMP;     --#RAS-6
    v_lat_ant           float8; --#RAS-6
    v_lon_ant           float8; --#RAS-6
    v_detenido 			boolean; --#RAS-6
    v_total_distancia	numeric; --#RAS-6
    v_distance 			text; --#RAS-6
    v_rec 				record; --#RAS-6

BEGIN

    v_nombre_funcion = 'ras.ft_equipo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_EQUIP_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		admin
     #FECHA:		15-06-2017 17:50:17
    ***********************************/

    if(p_transaccion='RAS_EQUIP_SEL')then

        begin
            -- inicio #6
            v_filtro = '';
            IF p_administrador !=1 THEN

                select
                    pxp.aggarray(depu.id_depto)
                into
                    va_id_depto
                from param.tdepto_usuario depu
                where depu.id_usuario =  p_id_usuario and depu.cargo in ('responsable','administrador');

                v_filtro = ' ( equip.id_usuario_reg = '||p_id_usuario::varchar ||' or   (equip.id_depto  in ('|| COALESCE(array_to_string(va_id_depto,','),'0')||'))) and ';

            END IF;
            -- fin #6
            --#RAS-1
            v_consulta:='select
						equip.id_equipo,
						equip.id_tipo_equipo,
						equip.id_modelo,
						equip.id_localizacion,
						equip.nro_motor,
						equip.placa,
						equip.estado,
						equip.nro_movil,
						equip.fecha_alta,
						equip.cabina,
						equip.estado_reg,
						equip.propiedad,
						equip.nro_chasis,
						equip.cilindrada,
						equip.color,
						equip.pta,
						equip.traccion,
						equip.gestion,
						equip.fecha_baja,
						equip.monto,
						equip.usuario_ai,
						equip.fecha_reg,
						equip.id_usuario_reg,
						equip.id_usuario_ai,
						equip.fecha_mod,
						equip.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						equip.tipo_equipo as desc_tipo_equipo,
						equip.modelo as desc_modelo,
						equip.marca as desc_marca,
						equip.uniqueid,
						de.id as deviceid,
						--ras.f_get_time(pos.servertime::timestamp,CURRENT_TIMESTAMP::timestamp) as ultimo_envio,
						replace(replace(replace(replace(replace(replace(age(CURRENT_TIMESTAMP::timestamp,pos.servertime '||v_utc||')::text,''years'',''a os''),''year'',''a o''),''mons'',''meses''),''mon'',''mes''),''days'',''d as''),''day'',''d a'')::text as ultimo_envio,
						pos.latitude,
						pos.longitude,
						pos.speed * '||v_factor_vel||' as speed,
						pos.attributes,
						pos.address,
						/*case event.type
							when ''deviceStopped'' then ''Detenido''::varchar
							when ''deviceOffline'' then ''Desconectado''::varchar
							when ''deviceUnknown'' then ''Desconocido''::varchar
							when ''deviceMoving'' then ''En Movimiento''::varchar
							when ''deviceOnline'' then ''Online''::varchar
							when ''alarm'' then ''Alarma''::varchar
							else event.type
						end as desc_type,*/
						equip.desc_equipo,
						--per.nombre_completo1 as responsable,
						--event.type,
						equip.id_grupo,
						equip.desc_grupo,
						equip.color_grupo,
						equip.nro_celular,
						equip.id_marca,
                        equip.id_depto,
                        equip.km_inicial
						from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
						left join public.tc_devices de
						on de.uniqueid = equip.uniqueid
						left join public.tc_positions pos
						on pos.id = de.positionid
						/*left join public.tc_events event
						on event.id  in (select
									    ev.id
									    from public.tc_events ev
									    where ev.deviceid = de.id
									    order by ev.servertime desc
									    limit 1) --= ras.f_get_evento_ultimo(equip.id_equipo)*/
						--left join segu.vpersona per
						--on per.id_persona = ras.f_get_responsable_ultimo(equip.id_equipo)
				        where  '||v_filtro||'  '; -- fin #6

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --Devuelve la respuesta
            raise notice 'v_consulta %',v_consulta;
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_EQUIP_CONT'
         #DESCRIPCION:	Conteo de registros
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:17
        ***********************************/

    elsif(p_transaccion='RAS_EQUIP_CONT')then

        begin
            --#RAS-1
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(id_equipo)
					    from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
						left join public.tc_devices de
						on de.uniqueid = equip.uniqueid
						left join public.tc_positions pos
						on pos.id = de.positionid
						/*left join public.tc_events event
						on event.positionid  in (select
									    ev.id
									    from public.tc_events ev
									    where ev.deviceid = de.id
									    order by ev.servertime desc
									    limit 1) --= ras.f_get_evento_ultimo(equip.id_equipo)*/
						--left join segu.vpersona per
						--on per.id_persona = ras.f_get_responsable_ultimo(equip.id_equipo)
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_EQURAP_SEL'
         #DESCRIPCION:	Consulta de datos
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:17
        ***********************************/

    elsif(p_transaccion='RAS_EQURAP_SEL')then

        begin
            --Sentencia de la consulta
            v_filtro = '';
            IF p_administrador !=1 THEN

                select
                    pxp.aggarray(depu.id_depto)
                into
                    va_id_depto
                from param.tdepto_usuario depu
                where depu.id_usuario =  p_id_usuario and depu.cargo in ('responsable','administrador');

                v_filtro = ' ( equip.id_usuario_reg = '||p_id_usuario::varchar ||' or   (equip.id_depto  in ('|| COALESCE(array_to_string(va_id_depto,','),'0')||'))) and ';

            END IF;

            v_consulta:='select
						id_equipo, placa,nro_movil,marca,modelo,tipo_equipo
						from ras.vequipo equip
				        where '||v_filtro||' ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --raise notice 'noticeee %',v_consulta; raise exception 'error %',v_consulta;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_EQURAP_CONT'
         #DESCRIPCION:	Conteo de registros
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:17
        ***********************************/

    elsif(p_transaccion='RAS_EQURAP_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(1) as total
					    from ras.vequipo equip
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
     #TRANSACCION:  'RAS_EQUEST_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		admin
     #FECHA:		15-06-2017 17:50:17
    ***********************************/

    elsif(p_transaccion='RAS_EQUEST_SEL')then

        begin
            --Sentencia de la consulta
            SELECT
                solv.fecha_salida
            INTO
                v_registro
            FROM ras.tsol_vehiculo solv
            WHERE solv.id_sol_vehiculo = v_parametros.id_sol_vehiculo;
            v_filtro = '';
            IF p_administrador !=1 THEN

                select
                    pxp.aggarray(depu.id_depto)
                into
                    va_id_depto
                from param.tdepto_usuario depu
                where depu.id_usuario =  p_id_usuario and depu.cargo in ('responsable','administrador');

                v_filtro = ' ( equip.id_usuario_reg = '||p_id_usuario::varchar ||' or   (equip.id_depto  in ('|| COALESCE(array_to_string(va_id_depto,','),'0')||'))) and ';

            END IF;

            v_filtro = v_filtro ||'( es.fecha_final < '''|| v_registro.fecha_salida||'''::date or es.fecha_final is null ) and' ;

            v_consulta:='
            with estado (id_equipo,fecha_final,estado)as
            (   SELECT
                  equipes.id_equipo,
                  equipes.fecha_final,
                  equipes.estado
                FROM ras.tequipo_estado equipes
                WHERE equipes.fecha_final = ( SELECT
                                                max(e.fecha_final)
                                              FROM ras.tequipo_estado e
                                              WHERE e.id_equipo = equipes.id_equipo
                                              )

            )
            select
						equip.id_equipo,
                        equip.placa,
                        equip.nro_movil,
                        equip.marca,
                        equip.modelo,
                        equip.tipo_equipo,
                        equip.id_tipo_equipo
						from ras.vequipo equip
                        left join estado es on es.id_equipo = equip.id_equipo
    		where '||v_filtro||' ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            raise notice 'no %',v_consulta;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            raise notice 'noticeee %',v_consulta;
            --raise exception 'error %',v_consulta;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_EQUEST_CONT'
         #DESCRIPCION:	Conteo de registros
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:17
        ***********************************/

    elsif(p_transaccion='RAS_EQUEST_CONT')then

        begin
            --Sentencia de la consulta
            SELECT
                solv.fecha_salida
            INTO
                v_registro
            FROM ras.tsol_vehiculo solv
            WHERE solv.id_sol_vehiculo = v_parametros.id_sol_vehiculo;
            v_filtro = '';
            IF p_administrador !=1 THEN

                select
                    pxp.aggarray(depu.id_depto)
                into
                    va_id_depto
                from param.tdepto_usuario depu
                where depu.id_usuario =  p_id_usuario and depu.cargo in ('responsable','administrador');

                v_filtro = ' ( equip.id_usuario_reg = '||p_id_usuario::varchar ||' or   (equip.id_depto  in ('|| COALESCE(array_to_string(va_id_depto,','),'0')||'))) and ';

            END IF;

            v_filtro = v_filtro ||'( es.fecha_final < '''|| v_registro.fecha_salida||'''::date or es.fecha_final is null ) and' ;
            --Sentencia de la consulta de conteo de registros
            v_consulta:='
             with estado (id_equipo,fecha_final,estado)as
            (   SELECT
                  equipes.id_equipo,
                  equipes.fecha_final,
                  equipes.estado
                FROM ras.tequipo_estado equipes
                WHERE equipes.fecha_final = ( SELECT
                                                max(e.fecha_final)
                                              FROM ras.tequipo_estado e
                                              WHERE e.id_equipo = equipes.id_equipo
                                              )

            )
            select count(equip.id_equipo) as total
					    from ras.vequipo equip
                        left join estado es on es.id_equipo = equip.id_equipo

				        where  '||v_filtro||' ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            return v_consulta;

        end;
        /*********************************
     #TRANSACCION:  'RAS_HISVEH_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		JUAN
     #FECHA:		19-02-2021 17:50:17
    ***********************************/

    elsif(p_transaccion='RAS_HISVEH_SEL')then --#RAS-3

        begin

            v_consulta:='select
                    p.address::varchar as ubicacion,
                    p.latitude::numeric,
                    p.longitude::numeric,
                    (to_char( p.devicetime, ''DD-MM-YYYY'')||'' ''||to_char( p.devicetime, ''hh:mi:ss''))::VARCHAR   as fecha_hora,
                    p.speed::numeric as velocidad,
                    eq.placa::varchar,
                    (cast(p.attributes as json)->>''distance'')::numeric as distancia,
                    (cast(p.attributes as json)->>''power'')::numeric as volt_bateria,
                    (cast(p.attributes as json)->>''odometer'')::numeric as odometro,
                    (case when cast(p.attributes as json)->>''ignition''=''true'' then ''encendido'' else ''apagado'' end)::varchar as estado
                    from public.tc_positions p
                    join public.tc_devices dev on dev.id=p.deviceid
                    left join public.tc_events ev on ev.positionid=p.id
                    join ras.tequipo eq on eq.uniqueid=dev.uniqueid
                    where (cast(p.attributes as json)->>''event'')::integer =0
                    AND  ';

            v_consulta:=v_consulta||v_parametros.filtro||' order by p.devicetime asc';
            --v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            raise notice 'noticeee %',v_consulta;
            --raise exception 'error %',v_consulta;
            --Devuelve la respuesta
            return v_consulta;

        end;
        /*********************************
     #TRANSACCION:  'RAS_ESTVEH_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		JUAN
     #FECHA:		09-03-2021 17:50:17
    ***********************************/

    elsif(p_transaccion='RAS_ESTVEH_SEL')then --#RAS-6

        begin
                    create temp table ras_posiciones (
                        id serial,
                        ubicacion varchar,
                        latitude numeric,
                        longitude numeric,
                        fecha_hora timestamp,
                        velocidad numeric,
                        placa varchar,
                        distancia numeric,
                        volt_bateria numeric,
                        odometro numeric,
                        estado varchar,
                        attributes varchar,
                        tiempo_detenido varchar,
                        send boolean default false,
                        type varchar
                    ) on commit drop;


                    v_consulta:='insert into ras_posiciones(
                        ubicacion,
                        latitude,
                        longitude,
                        fecha_hora,
                        velocidad,
                        placa,
                        distancia,
                        volt_bateria,
                        odometro,
                        estado,
                        attributes,
                        tiempo_detenido,
                        type)
                            select
                            p.address,
                            p.latitude,
                            p.longitude,
                            (to_char( p.devicetime, ''DD-MM-YYYY'')||'' ''||to_char( p.devicetime, ''hh:mi:ss''))::timestamp as fecha_hora,
                            p.speed,
                            eq.placa,
                            (cast(p.attributes as json)->>''distance'')::numeric as distancia,
                            (cast(p.attributes as json)->>''power'')::numeric as volt_bateria,
                            (cast(p.attributes as json)->>''odometer'')::numeric as odometro,
                            (case when cast(p.attributes as json)->>''ignition''=''true'' then ''encendido'' else ''apagado'' end)::varchar as estado,
                            p.attributes,
                            0::varchar as tiempo_detenido,
                            ev.type
                            from public.tc_positions p
                            join public.tc_devices dev on dev.id=p.deviceid
                            left join public.tc_events ev on ev.positionid=p.id
                            join ras.tequipo eq on eq.uniqueid=dev.uniqueid
                            where  ';

                            v_consulta:=v_consulta||v_parametros.filtro||' order by p.devicetime asc ';

        execute(v_consulta);

        v_detenido = false;
                    v_total_distancia = 0;

                    v_id_position=0;
                    v_bandera_aux=0;
                    v_hora=now()::TIMESTAMP;

        for v_rec in select * from ras_posiciones order by fecha_hora asc loop
                        v_distance = cast(v_rec.attributes as json)->>'distance';
        v_total_distancia = v_total_distancia + cast(v_distance as numeric);

                        --calculo de tiempo de estacionado quitando eventos repetidos
                        if(v_rec.type = 'ignitionOff' and v_bandera_aux=0 and (cast(v_rec.attributes as json)->>'event')::integer !=0 )then
                          v_id_position=v_rec.id;
                          v_bandera_aux=1;
                          v_hora=v_rec.fecha_hora;
                          v_lat_ant=v_rec.latitude;
                          v_lon_ant=v_rec.longitude;
        update ras_posiciones set send = true where id = v_rec.id;
        else
                          if(v_bandera_aux=1 and (cast(v_rec.attributes as json)->>'event')::integer=0 and (cast(v_rec.attributes as json)->>'ignition')::varchar = 'true' and v_lat_ant!=v_rec.latitude )then
        update ras_posiciones set tiempo_detenido = to_char ((   extract(epoch from age(v_rec.fecha_hora::TIMESTAMP, v_hora::TIMESTAMP))    ||' seconds')::interval, 'HH24:MI:SS' ) where id = v_id_position;
        v_bandera_aux=0;
        end if;
        end if;

        end loop;


                    v_consulta = '
                    select
                        id::integer,
                        ubicacion::varchar,
                        latitude::numeric,
                        longitude::numeric,
                        fecha_hora::varchar,
                        velocidad::numeric,
                        placa::varchar,
                        distancia::numeric,
                        volt_bateria::numeric,
                        odometro::numeric,
                        estado::varchar,
                        attributes::varchar,
                        tiempo_detenido::varchar
                     from ras_posiciones
                     where send = true
                     and tiempo_detenido !=''0''
                     order by fecha_hora asc ';

        return v_consulta;

        end;
        /*********************************
        #TRANSACCION:  'RAS_EQUKILINI_SEL'
        #DESCRIPCION:	Consulta de datos
        #AUTOR:		admin
        #FECHA:		15-06-2017 17:50:17
        #ISSUE:     GDV-33
       ***********************************/

    elsif(p_transaccion='RAS_EQUKILINI_SEL')then

        begin
            --Sentencia de la consulta
            v_filtro = '';

            v_consulta:='
                        WITH km ( id_equipo, km_final, fecha_reg )as( SELECT
                                                     asi.id_equipo,
                                                     km_final,
                                                     asi.fecha_reg
                                              FROM ras.tasig_vehiculo asi
                                              WHERE
                                              asi.fecha_reg =(
                                                     SELECT MAX(a.fecha_reg)
                                                      FROM ras.tasig_vehiculo a
                                                      where a.id_equipo =
                                                        asi.id_equipo
                                                         and a.id_asig_vehiculo <> '||v_parametros.id_asig_vehiculo||'
                                                        )
                                              )
                                              SELECT sol.id_equipo,
                                                     CASE
                                                       WHEN k.km_final is not null THEN
                                                       k.km_final
                                                       ELSE
                                                       sol.km_inicial
                                                     END as
                                                       kilometraje_inicial
,
                                                     sol.fecha_reg

                                              FROM ras.tequipo sol
                                                   left join km k on  k.id_equipo =  sol.id_equipo
                                              WHERE sol.id_equipo = '||  v_parametros.id_equipo ;

            --Definicion de la respuesta
            --raise exception 'noticeee %',v_consulta;
            raise notice 'noticeee %',v_consulta;
            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
     #TRANSACCION:  'RAS_EQUIPKL_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		admin
     #FECHA:		15-06-2017 17:50:17
    ***********************************/

    elseif(p_transaccion='RAS_EQUIPKL_SEL')then

        begin
            v_filtro = '';
            IF p_administrador !=1 THEN

            END IF;

            v_consulta:='
            with km (
                    id_equipo,
                    km_final,
                    fecha_reg
              )
             AS
              ( SELECT
                  asi.id_equipo,
                  asi.km_final,
                  asi.fecha_reg
              FROM ras.tasig_vehiculo  asi
              WHERE asi.fecha_reg = (
                  SELECT
                      MAX(asis.fecha_reg)
                  FROM ras.tasig_vehiculo  asis
                  where asis.km_final is not null
                  and asis.id_equipo  = asi.id_equipo
              )
              )
            select
						equip.id_equipo,
						equip.id_tipo_equipo,
						equip.id_modelo,
						equip.id_localizacion,
						equip.placa,
						equip.estado,
						equip.fecha_alta,
						equip.estado_reg,
						equip.nro_chasis,
						equip.pta,
						equip.gestion,
						equip.fecha_baja,
						equip.usuario_ai,
						equip.fecha_reg,
						equip.id_usuario_reg,
						equip.id_usuario_ai,
						equip.fecha_mod,
						equip.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						equip.tipo_equipo as desc_tipo_equipo,
						equip.modelo as desc_modelo,
						equip.marca as desc_marca,
						equip.uniqueid,
						equip.desc_equipo,
						equip.id_grupo,
						equip.desc_grupo,
						equip.color_grupo,
						equip.id_marca,
                        equip.id_depto,
                        equip.km_inicial,
                        k.km_final as km_actual
						from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
                        left join km k on k.id_equipo = equip.id_equipo
				        where ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --Devuelve la respuesta
            raise notice 'v_consulta %',v_consulta;
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_EQUIPKL_CONT'
         #DESCRIPCION:	Conteo de registros
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:17
        ***********************************/

    elsif(p_transaccion='RAS_EQUIPKL_CONT')then

        begin
            --#RAS-1
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(id_equipo)
					    from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

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