--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_grupo_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_grupo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tgrupo'
 AUTOR: 		 (admin)
 FECHA:	        24-07-2017 08:28:12
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

    v_filtro            varchar;
    va_id_depto			integer[];
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


            --Inicio #6
            v_filtro = '';
            IF p_administrador !=1 THEN

                select
                   pxp.aggarray(depu.id_depto)
                into
                   va_id_depto
                from param.tdepto_usuario depu
                where depu.id_usuario =  p_id_usuario and depu.cargo in ('responsable','administrador');

	            v_filtro = ' ( grupo.id_usuario_reg = '||p_id_usuario::varchar ||' or   (grupo.id_depto  in ('|| COALESCE(array_to_string(va_id_depto,','),'0')||'))) and ';

            END IF;
            -- fin #6

			v_consulta:='select
						grupo.id_grupo,
						grupo.codigo,
						grupo.nombre,
						grupo.color,
						grupo.estado_reg,
						grupo.fecha_reg,
						grupo.fecha_mod,
						grupo.id_usuario_reg,
						grupo.id_usuario_mod,
						grupo.id_usuario_ai,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						grupo.usuario_ai,
                        grupo.id_depto
						from ras.tgrupo grupo
						inner join segu.tusuario usu1 on usu1.id_usuario = grupo.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = grupo.id_usuario_mod
				        where  '||v_filtro||' '; -- fin #6

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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;