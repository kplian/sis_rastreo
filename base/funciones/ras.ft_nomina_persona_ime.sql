--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_nomina_persona_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_nomina_persona_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tnomina_persona'
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

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_nomina_persona    INTEGER;

BEGIN

    v_nombre_funcion = 'ras.ft_nomina_persona_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_NOMIPER_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:58:25
    ***********************************/

    IF (p_transaccion='RAS_NOMIPER_INS') THEN

        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.tnomina_persona(
            estado_reg,
            nombre,
            id_sol_vehiculo,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod,
            id_funcionario
              ) VALUES (
            'activo',
            v_parametros.nombre,
            v_parametros.id_sol_vehiculo,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null,
            v_parametros.id_funcionario
            ) RETURNING id_nomina_persona into v_id_nomina_persona;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Nomina Personas almacenado(a) con exito (id_nomina_persona'||v_id_nomina_persona||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nomina_persona',v_id_nomina_persona::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_NOMIPER_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:58:25
    ***********************************/

    ELSIF (p_transaccion='RAS_NOMIPER_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.tnomina_persona SET
            nombre = v_parametros.nombre,
            id_sol_vehiculo = v_parametros.id_sol_vehiculo,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            id_funcionario = v_parametros.id_funcionario
            WHERE id_nomina_persona=v_parametros.id_nomina_persona;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Nomina Personas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nomina_persona',v_parametros.id_nomina_persona::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_NOMIPER_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 14:58:25
    ***********************************/

    ELSIF (p_transaccion='RAS_NOMIPER_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.tnomina_persona
            WHERE id_nomina_persona=v_parametros.id_nomina_persona;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Nomina Personas eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_nomina_persona',v_parametros.id_nomina_persona::varchar);

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