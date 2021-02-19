--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_asig_vehiculo_incidencia_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_asig_vehiculo_incidencia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tasig_vehiculo_incidencia'
 AUTOR:          (egutierrez)
 FECHA:            09-07-2020 13:52:29
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                09-07-2020 13:52:29    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_asig_vehiculo_incidencia_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_ASINCI_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:29
    ***********************************/

    IF (p_transaccion='RAS_ASINCI_SEL') THEN

        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        asinci.id_asig_vehiculo_incidedencia,
                        asinci.estado_reg,
                        asinci.id_asig_vehiculo,
                        asinci.id_incidencia,
                        asinci.observacion,
                        asinci.id_usuario_reg,
                        asinci.fecha_reg,
                        asinci.id_usuario_ai,
                        asinci.usuario_ai,
                        asinci.id_usuario_mod,
                        asinci.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        inc.nombre as desc_incidencia,
                        incc.nombre as desc_incidencia_agrupador
                        FROM ras.tasig_vehiculo_incidencia asinci
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = asinci.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = asinci.id_usuario_mod
                        left join ras.tincidencia inc on inc.id_incidencia = asinci.id_incidencia
                        left join ras.tincidencia incc on incc.id_incidencia = inc.id_incidencia_fk
                        left join ras.tasig_vehiculo asig on asig.id_asig_vehiculo = asinci.id_asig_vehiculo
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

             If pxp.f_existe_parametro(p_tabla, 'groupBy') THEN

                IF v_parametros.groupBy = 'desc_incidencia_agrupador' THEN
                  v_consulta:=v_consulta||' order by incc.nombre ' ||v_parametros.groupDir|| ', ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' OFFSET ' || v_parametros.puntero;

                ELSE

                  v_consulta:=v_consulta||' order by ' ||v_parametros.groupBy|| ' ' ||v_parametros.groupDir|| ', ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' OFFSET ' || v_parametros.puntero;
                END IF;
       		Else
             	v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' OFFSET ' || v_parametros.puntero;
    		End If;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ASINCI_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:29
    ***********************************/

    ELSIF (p_transaccion='RAS_ASINCI_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(asinci.id_asig_vehiculo_incidedencia)
                         FROM ras.tasig_vehiculo_incidencia asinci
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = asinci.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = asinci.id_usuario_mod
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