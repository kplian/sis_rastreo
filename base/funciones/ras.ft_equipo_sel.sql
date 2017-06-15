CREATE OR REPLACE FUNCTION "ras"."ft_equipo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_equipo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tequipo'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:17
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
    		--Sentencia de la consulta
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
						tipeq.nombre as desc_tipo_equipo,
						model.id_marca,
						model.nombre as desc_modelo,
						marca.nombre as desc_marca
						from ras.tequipo equip
						left join ras.ttipo_equipo tipeq
						on tipeq.id_tipo_equipo = equip.id_tipo_equipo
						left join ras.tmodelo model
						on model.id_modelo = equip.id_modelo
						left join ras.tmarca marca
						on marca.id_marca = model.id_marca
						inner join segu.tusuario usu1 on usu1.id_usuario = equip.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = equip.id_usuario_mod
				        where  ';
			
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
					    from ras.tequipo equip
					    left join ras.ttipo_equipo tipeq
						on tipeq.id_tipo_equipo = equip.id_tipo_equipo
						left join ras.tmodelo model
						on model.id_modelo = equip.id_modelo
						left join ras.tmarca mar
						on mar.id_marca = model.id_marca
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_equipo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
