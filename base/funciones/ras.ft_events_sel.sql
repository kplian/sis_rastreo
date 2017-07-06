CREATE OR REPLACE FUNCTION "ras"."ft_events_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
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
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
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
    		--Sentencia de la consulta
			v_consulta:='select
						event.id,
						event.geofenceid,
						event.deviceid,
						event.servertime,
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
						from events event
						inner join positions pos
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
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(event.id)
					    from events event
					    inner join positions pos
						on pos.id = event.positionid
					    where ';
			
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_events_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
