--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_asig_vehiculo_incidencia_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_asig_vehiculo_incidencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tasig_vehiculo_incidencia'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_asig_vehiculo_incidedencia    INTEGER;

BEGIN

    v_nombre_funcion = 'ras.ft_asig_vehiculo_incidencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_ASINCI_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:29
    ***********************************/

    IF (p_transaccion='RAS_ASINCI_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.tasig_vehiculo_incidencia(
            estado_reg,
            id_asig_vehiculo,
            id_incidencia,
            observacion,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.id_asig_vehiculo,
            v_parametros.id_incidencia,
            v_parametros.observacion,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null
            ) RETURNING id_asig_vehiculo_incidedencia into v_id_asig_vehiculo_incidedencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Incidencias almacenado(a) con exito (tasig_vehiculo_incidedencia'||v_id_asig_vehiculo_incidedencia||')');
            v_resp = pxp.f_agrega_clave(v_resp,'tasig_vehiculo_incidedencia',v_id_asig_vehiculo_incidedencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ASINCI_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:29
    ***********************************/

    ELSIF (p_transaccion='RAS_ASINCI_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.tasig_vehiculo_incidencia SET
            id_asig_vehiculo = v_parametros.id_asig_vehiculo,
            id_incidencia = v_parametros.id_incidencia,
            observacion = v_parametros.observacion,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_asig_vehiculo_incidedencia=v_parametros.id_asig_vehiculo_incidedencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Incidencias modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'tasig_vehiculo_incidedencia',v_parametros.id_asig_vehiculo_incidedencia::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ASINCI_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        09-07-2020 13:52:29
    ***********************************/

    ELSIF (p_transaccion='RAS_ASINCI_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.tasig_vehiculo_incidencia
            WHERE id_asig_vehiculo_incidedencia=v_parametros.id_asig_vehiculo_incidedencia;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Incidencias eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'tasig_vehiculo_incidedencia',v_parametros.id_asig_vehiculo_incidedencia::varchar);

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
COST 100;