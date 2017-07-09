CREATE OR REPLACE FUNCTION "ras"."ft_positions_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
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
						eq.desc_equipo
						from ras.vequipo eq
						inner join devices dev
						on dev.uniqueid = eq.uniqueid
						on pos.id = dev.positionid
						left join ras.tequipo_responsable eres
						on eres.id_equipo = eq.id_equipo
						and eres.estado_reg = ''activo''
						left join ras.tresponsable re
						on re.id_responsable = eres.id_responsable
						left join segu.vpersona per
						on per.id_persona = re.id_persona
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
						eq.desc_equipo
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
						where eq.id_equipo in ('||v_parametros.ids||')'||'
						and to_char(pos.servertime,''dd-mm-yyyy HH24:MI:00'')::timestamp with time zone between '||v_parametros.fecha_ini||'::timestamp with time zone and '||v_parametros.fecha_fin||'::timestamp with time zone';

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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_positions_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
