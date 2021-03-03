--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_responsable_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_responsable_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tresponsable'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:03
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
 ISSUE			FECHA			AUTHOR 					DESCRIPCION
 #GDV-35       02/03/2020      EGS                     Se modifica codigo
***************************************************************************/

DECLARE

    v_consulta    		varchar;
    v_parametros  		record;
    v_nombre_funcion   	text;
    v_resp				varchar;

BEGIN

    v_nombre_funcion = 'ras.ft_responsable_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_CONDUC_SEL'
     #DESCRIPCION:	Consulta de datos
     #AUTOR:		admin
     #FECHA:		15-06-2017 17:50:03
    ***********************************/

    if(p_transaccion='RAS_CONDUC_SEL')then

        begin
            --Sentencia de la consulta
            v_consulta:='select
						conduc.id_responsable,
						conduc.id_persona,
						conduc.estado_reg,
						conduc.id_usuario_reg,
						conduc.usuario_ai,
						conduc.fecha_reg,
						conduc.id_usuario_ai,
						conduc.fecha_mod,
						conduc.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						per.nombre_completo1 as desc_persona,
                        case     --#GDV-35
                        when fun.id_funcionario is not null then
                        fun.codigo
                        else
                        conduc.codigo
                        end as codigo
						from ras.tresponsable conduc
						left join segu.vpersona per
						on per.id_persona = conduc.id_persona
						inner join segu.tusuario usu1 on usu1.id_usuario = conduc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = conduc.id_usuario_mod
                        Left join orga.tfuncionario fun on fun.id_persona = conduc.id_persona
				        where  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            return v_consulta;

        end;

        /*********************************
         #TRANSACCION:  'RAS_CONDUC_CONT'
         #DESCRIPCION:	Conteo de registros
         #AUTOR:		admin
         #FECHA:		15-06-2017 17:50:03
        ***********************************/

    elsif(p_transaccion='RAS_CONDUC_CONT')then

        begin
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(id_responsable)
					    from ras.tresponsable conduc
					    left join segu.vpersona per
						on per.id_persona = conduc.id_persona
					    inner join segu.tusuario usu1 on usu1.id_usuario = conduc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = conduc.id_usuario_mod
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
    PARALLEL UNSAFE
    COST 100;