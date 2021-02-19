--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_incidencia_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_incidencia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tincidencia'
 AUTOR:          (egutierrez)
 FECHA:            09-07-2020 13:52:42
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                09-07-2020 13:52:42    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_incidencia_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_INCIDEN_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:42
    ***********************************/

    IF (p_transaccion='RAS_INCIDEN_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        inciden.id_incidencia,
                        inciden.estado_reg,
                        inciden.nombre,
                        inciden.id_usuario_reg,
                        inciden.fecha_reg,
                        inciden.id_usuario_ai,
                        inciden.usuario_ai,
                        inciden.id_usuario_mod,
                        inciden.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        inciden.id_incidencia_fk,
                        inci.nombre as desc_agrupador
                        FROM ras.tincidencia inciden
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = inciden.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = inciden.id_usuario_mod
                        LEFT JOIN ras.tincidencia inci on inci.id_incidencia = inciden.id_incidencia_fk
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    /*********************************
     #TRANSACCION:  'RAS_INCIDEN_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:42
    ***********************************/

    ELSIF (p_transaccion='RAS_INCIDEN_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_incidencia)
                         FROM ras.tincidencia inciden
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = inciden.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = inciden.id_usuario_mod
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