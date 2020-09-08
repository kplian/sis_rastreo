CREATE OR REPLACE FUNCTION ras.ft_elemento_seg_equipo_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_elemento_seg_equipo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.telemento_seg_equipo'
 AUTOR:          (egutierrez)
 FECHA:            03-07-2020 14:59:28
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 14:59:28    egutierrez             Creacion
 #GDV-28              28/08/2020            EGS                 Se Agregan campos de estado y observacion
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_elemento_seg_equipo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_ELEMAV_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:59:28
    ***********************************/

    IF (p_transaccion='RAS_ELEMAV_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        elemav.id_elemento_seg_equipo,
                        elemav.estado_reg,
                        elemav.id_elemento_seg,
                        elemav.id_equipo,
                        elemav.existe,
                        elemav.id_usuario_reg,
                        elemav.fecha_reg,
                        elemav.id_usuario_ai,
                        elemav.usuario_ai,
                        elemav.id_usuario_mod,
                        elemav.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        elemav.id_asig_vehiculo,
                        ele.nombre as desc_elemento_seg,
                        elemav.observacion, --#GDV-28
                        elemav.estado_elemento --#GDV-28
                        FROM ras.telemento_seg_equipo elemav
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = elemav.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = elemav.id_usuario_mod
                        left join ras.telemento_seg ele on ele.id_elemento_seg = elemav.id_elemento_seg
                        left join ras.tasig_vehiculo asig on asig.id_asig_vehiculo = elemav.id_asig_vehiculo
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ELEMAV_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:59:28
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMAV_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_elemento_seg_equipo)
                         FROM ras.telemento_seg_equipo elemav
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = elemav.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = elemav.id_usuario_mod
                         left join ras.telemento_seg ele on ele.id_elemento_seg = elemav.id_elemento_seg
                         left join ras.tasig_vehiculo asig on asig.id_asig_vehiculo = elemav.id_asig_vehiculo
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