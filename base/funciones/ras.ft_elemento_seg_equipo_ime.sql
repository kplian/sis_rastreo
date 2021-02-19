CREATE OR REPLACE FUNCTION ras.ft_elemento_seg_equipo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_elemento_seg_equipo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.telemento_seg_equipo'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_elemento_seg_equipo    INTEGER;

BEGIN

    v_nombre_funcion = 'ras.ft_elemento_seg_equipo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_ELEMAV_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:59:28
    ***********************************/

    IF (p_transaccion='RAS_ELEMAV_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.telemento_seg_equipo(
            estado_reg,
            id_elemento_seg,
            id_equipo,
            existe,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod,
            id_asig_vehiculo,
            observacion, --#GDV-28
            estado_elemento  --#GDV-28
              ) VALUES (
            'activo',
            v_parametros.id_elemento_seg,
            v_parametros.id_equipo,
            v_parametros.existe,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null,
            v_parametros.id_asig_vehiculo,
            v_parametros.observacion, --#GDV-28
            v_parametros.estado_elemento --#GDV-28
            ) RETURNING id_elemento_seg_equipo into v_id_elemento_seg_equipo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elemenotos de seguridad asignados a un vehiculo almacenado(a) con exito (id_elemento_seg_equipo'||v_id_elemento_seg_equipo||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg_equipo',v_id_elemento_seg_equipo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ELEMAV_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:59:28
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMAV_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.telemento_seg_equipo SET
            id_elemento_seg = v_parametros.id_elemento_seg,
            id_equipo = v_parametros.id_equipo,
            existe = v_parametros.existe,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            observacion = v_parametros.observacion,  --#GDV-28
            estado_elemento = v_parametros.estado_elemento  --#GDV-28
            WHERE id_elemento_seg_equipo=v_parametros.id_elemento_seg_equipo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elemenotos de seguridad asignados a un vehiculo modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg_equipo',v_parametros.id_elemento_seg_equipo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_ELEMAV_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:59:28
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMAV_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.telemento_seg_equipo
            WHERE id_elemento_seg_equipo=v_parametros.id_elemento_seg_equipo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elemenotos de seguridad asignados a un vehiculo eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg_equipo',v_parametros.id_elemento_seg_equipo::varchar);

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