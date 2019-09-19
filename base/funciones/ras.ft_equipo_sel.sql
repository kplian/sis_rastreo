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
                        equip.id_depto
						from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
						left join public.devices de
						on de.uniqueid = equip.uniqueid
						left join positions pos
						on pos.id = de.positionid
						/*left join events event
						on event.id  in (select
									    ev.id
									    from events ev
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
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_equipo)
					    from ras.vequipo equip
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
						left join public.devices de
						on de.uniqueid = equip.uniqueid
						left join positions pos
						on pos.id = de.positionid
						/*left join events event
						on event.positionid  in (select
									    ev.id
									    from events ev
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