--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_incidencia_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_incidencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tincidencia'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_incidencia    INTEGER;

BEGIN

    v_nombre_funcion = 'ras.ft_incidencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_INCIDEN_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:42
    ***********************************/

    IF (p_transaccion='RAS_INCIDEN_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.tincidencia(
            estado_reg,
            nombre,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod,
            id_incidencia_fk
              ) VALUES (
            v_parametros.estado_reg,
            v_parametros.nombre,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null,
            v_parametros.id_incidencia_fk
            ) RETURNING id_incidencia into v_id_incidencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Incidencias almacenado(a) con exito (id_incidencia'||v_id_incidencia||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_incidencia',v_id_incidencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_INCIDEN_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:42
    ***********************************/

    ELSIF (p_transaccion='RAS_INCIDEN_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.tincidencia SET
            nombre = v_parametros.nombre,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            estado_reg= v_parametros.estado_reg,
            id_incidencia_fk = v_parametros.id_incidencia_fk
            WHERE id_incidencia=v_parametros.id_incidencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Incidencias modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_incidencia',v_parametros.id_incidencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_INCIDEN_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:42
    ***********************************/

    ELSIF (p_transaccion='RAS_INCIDEN_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.tincidencia
            WHERE id_incidencia=v_parametros.id_incidencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Incidencias eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_incidencia',v_parametros.id_incidencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    ELSE

        RAISE EXCEPTION 'Transaccion inexistente: %',p_transaccion;

    END IF;

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