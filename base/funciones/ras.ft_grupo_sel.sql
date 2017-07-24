CREATE OR REPLACE FUNCTION "ras"."ft_grupo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_grupo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tgrupo'
 AUTOR: 		 (admin)
 FECHA:	        24-07-2017 08:28:12
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

	v_nombre_funcion = 'ras.ft_grupo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_GRUPO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		24-07-2017 08:28:12
	***********************************/

	if(p_transaccion='RAS_GRUPO_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						grupo.id_grupo,
						grupo.codigo,
						grupo.nombre,
						grupo.color,
						grupo.estado_reg,
						grupo.id_usuario_reg,
						grupo.id_usuario_ai,
						grupo.fecha_reg,
						grupo.usuario_ai,
						grupo.id_usuario_mod,
						grupo.fecha_mod
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ras.tgrupo grupo
						inner join segu.tusuario usu1 on usu1.id_usuario = grupo.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = grupo.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_GRUPO_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		24-07-2017 08:28:12
	***********************************/

	elsif(p_transaccion='RAS_GRUPO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_grupo)
					    from ras.tgrupo grupo
					    inner join segu.tusuario usu1 on usu1.id_usuario = grupo.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = grupo.id_usuario_mod
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
ALTER FUNCTION "ras"."ft_grupo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
