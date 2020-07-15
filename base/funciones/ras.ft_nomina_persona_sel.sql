--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_nomina_persona_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_nomina_persona_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tnomina_persona'
 AUTOR:          (egutierrez)
 FECHA:            03-07-2020 14:58:25
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 14:58:25    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_nomina_persona_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_NOMIPER_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:58:25
    ***********************************/

    IF (p_transaccion='RAS_NOMIPER_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        nomiper.id_nomina_persona,
                        nomiper.estado_reg,
                        case
                        when nomiper.id_funcionario is not null then
                        initcap(desc_funcionario1::varchar)
                        else
                        nomiper.nombre
                        end as nombre,
                        nomiper.id_sol_vehiculo,
                        nomiper.id_usuario_reg,
                        nomiper.fecha_reg,
                        nomiper.id_usuario_ai,
                        nomiper.usuario_ai,
                        nomiper.id_usuario_mod,
                        nomiper.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        nomiper.id_funcionario
                        FROM ras.tnomina_persona nomiper
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = nomiper.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = nomiper.id_usuario_mod
                        LEFT JOIN orga.vfuncionario fun ON fun.id_funcionario = nomiper.id_funcionario
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    /*********************************
     #TRANSACCION:  'RAS_NOMIPER_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:58:25
    ***********************************/

    ELSIF (p_transaccion='RAS_NOMIPER_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_nomina_persona)
                         FROM ras.tnomina_persona nomiper
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = nomiper.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = nomiper.id_usuario_mod
                         WHERE ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    ELSE

        RAISE EXCEPTION 'Transaccion inexistente';

    END IF;

EXCEPTION

    WHEN OTHERS THEN
            v_resp='';
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
            v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
            v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
            RAISE EXCEPTION '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;