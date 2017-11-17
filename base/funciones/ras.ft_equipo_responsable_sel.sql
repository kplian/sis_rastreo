CREATE OR REPLACE FUNCTION "ras"."ft_equipo_responsable_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_equipo_responsable_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tequipo_responsable'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:22
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

	v_nombre_funcion = 'ras.ft_equipo_responsable_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_EQUCON_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:22
	***********************************/

	if(p_transaccion='RAS_EQUCON_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						equcon.id_equipo_responsable,
						equcon.estado_reg,
						equcon.id_responsable,
						equcon.fecha_fin,
						equcon.fecha_ini,
						equcon.id_equipo,
						equcon.id_usuario_reg,
						equcon.usuario_ai,
						equcon.fecha_reg,
						equcon.id_usuario_ai,
						equcon.id_usuario_mod,
						equcon.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						per.nombre_completo1 as desc_responsable
						from ras.tequipo_responsable equcon
						inner join segu.tusuario usu1 on usu1.id_usuario = equcon.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equcon.id_usuario_mod
						inner join ras.tresponsable resp
						on resp.id_responsable = equcon.id_responsable
						inner join segu.vpersona per
						on per.id_persona = resp.id_persona
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_EQUCON_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:22
	***********************************/

	elsif(p_transaccion='RAS_EQUCON_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_equipo_responsable)
					    from ras.tequipo_responsable equcon
					    inner join segu.tusuario usu1 on usu1.id_usuario = equcon.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equcon.id_usuario_mod
						inner join ras.tresponsable resp
						on resp.id_responsable = equcon.id_responsable
						inner join segu.vpersona per
						on per.id_persona = resp.id_persona
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
ALTER FUNCTION "ras"."ft_equipo_responsable_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
