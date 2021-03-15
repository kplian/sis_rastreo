--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_sol_vehiculo_responsable_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_sol_vehiculo_responsable_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tsol_vehiculo_responsable'
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

v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_sol_vehiculo_responsable    INTEGER;

BEGIN

    v_nombre_funcion = 'ras.ft_sol_vehiculo_responsable_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_SOLVERE_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        12-03-2021 14:10:00
    ***********************************/

    IF (p_transaccion='RAS_SOLVERE_INS') THEN

BEGIN
            --Sentencia de la insercion
INSERT INTO ras.tsol_vehiculo_responsable(
    estado_reg,
    id_sol_vehiculo,
    id_responsable,
    fecha_inicio,
    fecha_fin,
    id_usuario_reg,
    fecha_reg,
    id_usuario_ai,
    usuario_ai,
    id_usuario_mod,
    fecha_mod
) VALUES (
             'activo',
             v_parametros.id_sol_vehiculo,
             v_parametros.id_responsable,
             v_parametros.fecha_inicio,
             v_parametros.fecha_fin,
             p_id_usuario,
             now(),
             v_parametros._id_usuario_ai,
             v_parametros._nombre_usuario_ai,
             null,
             null
         ) RETURNING id_sol_vehiculo_responsable into v_id_sol_vehiculo_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de conductores almacenado(a) con exito (id_sol_vehiculo_responsable'||v_id_sol_vehiculo_responsable||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo_responsable',v_id_sol_vehiculo_responsable::varchar);

            --Devuelve la respuesta
RETURN v_resp;

END;

    /*********************************
     #TRANSACCION:  'RAS_SOLVERE_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        12-03-2021 14:10:00
    ***********************************/

    ELSIF (p_transaccion='RAS_SOLVERE_MOD') THEN

BEGIN
            --Sentencia de la modificacion
UPDATE ras.tsol_vehiculo_responsable SET
                                         id_sol_vehiculo = v_parametros.id_sol_vehiculo,
                                         id_responsable = v_parametros.id_responsable,
                                         fecha_inicio = v_parametros.fecha_inicio,
                                         fecha_fin = v_parametros.fecha_fin,
                                         id_usuario_mod = p_id_usuario,
                                         fecha_mod = now(),
                                         id_usuario_ai = v_parametros._id_usuario_ai,
    usuario_ai = v_parametros._nombre_usuario_ai
WHERE id_sol_vehiculo_responsable=v_parametros.id_sol_vehiculo_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de conductores modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo_responsable',v_parametros.id_sol_vehiculo_responsable::varchar);

            --Devuelve la respuesta
RETURN v_resp;

END;

    /*********************************
     #TRANSACCION:  'RAS_SOLVERE_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        12-03-2021 14:10:00
    ***********************************/

    ELSIF (p_transaccion='RAS_SOLVERE_ELI') THEN

BEGIN
            --Sentencia de la eliminacion
DELETE FROM ras.tsol_vehiculo_responsable
WHERE id_sol_vehiculo_responsable=v_parametros.id_sol_vehiculo_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignación de conductores eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo_responsable',v_parametros.id_sol_vehiculo_responsable::varchar);

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