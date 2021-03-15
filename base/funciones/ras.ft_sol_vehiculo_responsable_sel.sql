--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_sol_vehiculo_responsable_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_sol_vehiculo_responsable_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tsol_vehiculo_responsable'
 AUTOR:          (egutierrez)
 FECHA:            12-03-2021 14:10:00
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                12-03-2021 14:10:00    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_sol_vehiculo_responsable_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_SOLVERE_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        12-03-2021 14:10:00
    ***********************************/

    IF (p_transaccion='RAS_SOLVERE_SEL') THEN

BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        solvere.id_sol_vehiculo_responsable,
                        solvere.estado_reg,
                        solvere.id_sol_vehiculo,
                        solvere.id_responsable,
                        solvere.fecha_inicio,
                        solvere.fecha_fin,
                        solvere.solicitud,
                        solvere.id_usuario_reg,
                        solvere.fecha_reg,
                        solvere.id_usuario_ai,
                        solvere.usuario_ai,
                        solvere.id_usuario_mod,
                        solvere.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        per.nombre_completo1::varchar as desc_responsable
                        FROM ras.tsol_vehiculo_responsable solvere
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = solvere.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = solvere.id_usuario_mod
                        left join ras.tresponsable res on res.id_responsable = solvere.id_responsable
                        Left join segu.vpersona per on per.id_persona = res.id_persona
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
RETURN v_consulta;

END;

    /*********************************
     #TRANSACCION:  'RAS_SOLVERE_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez
     #FECHA:        12-03-2021 14:10:00
    ***********************************/

    ELSIF (p_transaccion='RAS_SOLVERE_CONT') THEN

BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_sol_vehiculo_responsable)
                         FROM ras.tsol_vehiculo_responsable solvere
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = solvere.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = solvere.id_usuario_mod
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
PARALLEL UNSAFE
COST 100;