--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_asig_vehiculo_ime (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_asig_vehiculo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tasig_vehiculo'
 AUTOR:          (egutierrez)
 FECHA:            03-07-2020 15:02:14
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 15:02:14    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento INTEGER;
    v_parametros RECORD;
    v_id_requerimiento INTEGER;
    v_resp VARCHAR;
    v_nombre_funcion TEXT;
    v_mensaje_error TEXT;
    v_id_asig_vehiculo INTEGER;
    v_record record;
    v_registro record;
    v_id_equipo_estado integer;
    v_id_marca integer;
    v_multi_vehiculo varchar;
    v_respon record;
    v_sol_resp varchar;

BEGIN

    v_nombre_funcion = 'ras.ft_asig_vehiculo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
       #TRANSACCION:  'RAS_ASIGVEHI_INS'
       #DESCRIPCION:    Insercion de registros
       #AUTOR:        egutierrez
       #FECHA:        03-07-2020 15:02:14
      ***********************************/

    IF (p_transaccion='RAS_ASIGVEHI_INS') THEN

        BEGIN

            v_multi_vehiculo = pxp.f_get_variable_global('ras_solicitud_multi_vehiculo');
            v_sol_resp = '';

            IF v_multi_vehiculo = 'no' THEN

                IF (
                       SELECT count(a.id_asig_vehiculo)
                       from ras.tasig_vehiculo a
                       WHERE a.id_sol_vehiculo = v_parametros.id_sol_vehiculo and
                               a.estado_reg = 'activo') >= 1  THEN

                    RAISE EXCEPTION 'No Puede registrar mas de una asignacion de vehiculo';

                END IF;

            END IF;
            SELECT solv.alquiler,
                   solv.fecha_salida,
                   solv.fecha_retorno
            INTO v_registro
            FROM ras.tsol_vehiculo solv
            WHERE solv.id_sol_vehiculo = v_parametros.id_sol_vehiculo;

            IF pxp.f_is_positive_integer(v_parametros.id_marca) THEN
                v_id_marca = v_parametros.id_marca::integer;
            ELSE
                SELECT m.id_marca
                into v_id_marca
                FROM ras.tmarca m
                WHERE upper(replace (m.nombre, '', ' ')) = upper(replace (v_parametros.id_marca, '', ' '));

                IF v_id_marca is null THEN
                    INSERT into ras.tmarca(
                        id_usuario_reg,
                        fecha_reg,
                        nombre)
                    VALUES (
                               p_id_usuario,
                               now(),
                               v_parametros.id_marca) RETURNING id_marca
                        into v_id_marca;
                END IF;

            END IF;

            --Sentencia de la insercion

            INSERT INTO ras.tasig_vehiculo(
                id_equipo,
                observaciones,
                id_sol_vehiculo_responsable,
                estado_reg, id_usuario_ai,
                fecha_reg, usuario_ai,
                id_usuario_reg,
                fecha_mod,
                id_usuario_mod,
                id_sol_vehiculo)
            VALUES (
                       v_parametros.id_equipo,
                       v_parametros.observaciones,
                       v_parametros.id_sol_vehiculo_responsable,
                       'activo',
                       v_parametros._id_usuario_ai,
                       now(),
                       v_parametros._nombre_usuario_ai,
                       p_id_usuario,
                       null,
                       null,
                       v_parametros.id_sol_vehiculo) RETURNING id_asig_vehiculo into v_id_asig_vehiculo;

            FOR v_record IN(
                SELECT ele.id_elemento_seg
                FROM ras.telemento_seg ele
                WHERE ele.estado_reg = 'activo')
                LOOP
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
                        id_asig_vehiculo)
                    VALUES (
                               'activo',
                               v_record.id_elemento_seg,
                               v_parametros.id_equipo,
                               false,
                               p_id_usuario,
                               now(),
                               v_parametros._id_usuario_ai,
                               v_parametros._nombre_usuario_ai,
                               null,
                               null,
                               v_id_asig_vehiculo);

                END LOOP;

            IF v_registro.alquiler = 'si' THEN
                INSERT INTO ras.tequipo_alquilado(
                    id_usuario_reg,
                    fecha_reg,
                    estado_reg,
                    id_usuario_ai,
                    usuario_ai,
                    placa,
                    --marca,
                    modelo,
                    id_proveedor,
                    id_tipo_equipo,
                    id_asig_vehiculo,
                    id_marca)
                VALUES (
                           p_id_usuario,
                           NOW(),
                           'activo',
                           v_parametros._id_usuario_ai,
                           v_parametros._nombre_usuario_ai,
                           v_parametros.placa,
                           -- v_parametros.marca,
                           v_parametros.modelo,
                           v_parametros.id_proveedor,
                           v_parametros.id_tipo_equipo,
                           v_id_asig_vehiculo,
                           v_id_marca);
            ELSE
                INSERT INTO ras.tequipo_estado(
                    id_usuario_reg,
                    fecha_reg,
                    estado_reg,
                    id_usuario_ai,
                    usuario_ai,
                    id_equipo,
                    fecha_inicio,
                    estado,
                    fecha_final)
                VALUES (
                           p_id_usuario,
                           now(),
                           'activo',
                           v_parametros._id_usuario_ai,
                           v_parametros._nombre_usuario_ai,
                           v_parametros.id_equipo,
                           v_registro.fecha_salida,
                           'asignado',
                           v_registro.fecha_retorno
                       ) RETURNING id_equipo_estado into v_id_equipo_estado;

                UPDATE ras.tasig_vehiculo
                SET id_equipo_estado = v_id_equipo_estado
                WHERE id_asig_vehiculo = v_id_asig_vehiculo;

            END IF;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Vehiculos almacenado(a) con exito (id_asig_vehiculo'||v_id_asig_vehiculo||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_asig_vehiculo',v_id_asig_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
             #TRANSACCION:  'RAS_ASIGVEHI_MOD'
             #DESCRIPCION:    Modificacion de registros
             #AUTOR:        egutierrez
             #FECHA:        03-07-2020 15:02:14
            ***********************************/

    ELSIF (p_transaccion='RAS_ASIGVEHI_MOD') THEN

        BEGIN
            SELECT solv.alquiler
            INTO v_registro
            FROM ras.tsol_vehiculo solv
            WHERE solv.id_sol_vehiculo = v_parametros.id_sol_vehiculo;

            IF pxp.f_is_positive_integer(v_parametros.id_marca) THEN
                v_id_marca = v_parametros.id_marca::integer;

            ELSE
                SELECT m.id_marca
                into v_id_marca
                FROM ras.tmarca m
                WHERE upper(replace (m.nombre, '', ' ')) = upper(replace (v_parametros.id_marca, '', ' '));

                IF v_id_marca is null THEN
                    INSERT into ras.tmarca(id_usuario_reg,
                                           fecha_reg,
                                           nombre)
                    VALUES (p_id_usuario,
                            now(),
                            v_parametros.id_marca
                           ) RETURNING id_marca
                        into v_id_marca;
                END IF;

            END IF;

            --Sentencia de la modificacion

            UPDATE ras.tasig_vehiculo
            SET id_equipo = v_parametros.id_equipo,
                observaciones = v_parametros.observaciones,
                id_sol_vehiculo_responsable = v_parametros.id_sol_vehiculo_responsable,
                fecha_mod = now(),
                id_usuario_mod = p_id_usuario,
                id_usuario_ai = v_parametros._id_usuario_ai,
                usuario_ai = v_parametros._nombre_usuario_ai,
                id_sol_vehiculo = v_parametros.id_sol_vehiculo
            WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;

            IF v_registro.alquiler = 'si' THEN

                --RAISE EXCEPTION 'v_parametros.id_marca % %',v_parametros.id_marca,v_id_marca;

                UPDATE ras.tequipo_alquilado
                SET id_usuario_mod = p_id_usuario,
                    fecha_mod = now(),
                    id_usuario_ai = v_parametros._id_usuario_ai,
                    usuario_ai = v_parametros._nombre_usuario_ai,
                    placa = v_parametros.placa,
                    --marca = v_parametros.marca,
                    modelo = v_parametros.modelo,
                    id_tipo_equipo = v_parametros.id_tipo_equipo,
                    id_proveedor = v_parametros.id_proveedor,
                    id_marca = v_id_marca
                WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;
            ELSE
                SELECT asigv.id_equipo_estado
                INTO v_id_equipo_estado
                FROM ras.tasig_vehiculo asigv
                WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;
                UPDATE ras.tequipo_estado
                SET id_equipo = v_parametros.id_equipo
                WHERE id_equipo_estado = v_id_equipo_estado;
            END IF;
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Vehiculos modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_asig_vehiculo',v_parametros.id_asig_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

        /*********************************
             #TRANSACCION:  'RAS_ASIGVEHI_ELI'
             #DESCRIPCION:    Eliminacion de registros
             #AUTOR:        egutierrez
             #FECHA:        03-07-2020 15:02:14
            ***********************************/

    ELSIF (p_transaccion='RAS_ASIGVEHI_ELI') THEN

        BEGIN
            SELECT av.id_equipo_estado
            INTO v_id_equipo_estado
            from ras.tasig_vehiculo av
            WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;

            --Sentencia de la eliminacion

            DELETE
            FROM ras.tasig_vehiculo
            WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;

            Delete from ras.tequipo_estado
            where id_equipo_estado = v_id_equipo_estado;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Vehiculos eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_asig_vehiculo',v_parametros.id_asig_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
        /*********************************
            #TRANSACCION:  'RAS_EDITFORVI_MOD'
            #DESCRIPCION:    Modificacion de registros
            #AUTOR:        egutierrez
            #FECHA:        03-07-2020 15:02:14
           ***********************************/

    ELSIF (p_transaccion='RAS_EDITFORVI_MOD') THEN

        BEGIN
            --Sentencia de la modificacion

            UPDATE ras.tasig_vehiculo
            SET km_inicio = v_parametros.km_inicio,
                km_final = v_parametros.km_final,
                recorrido = v_parametros.recorrido,
                fecha_mod = now(),
                observacion_viaje = v_parametros.observacion_viaje,
                fecha_retorno_ofi = v_parametros.fecha_retorno_ofi,
                fecha_salida_ofi = v_parametros.fecha_salida_ofi,
                hora_retorno_ofi = v_parametros.hora_retorno_ofi,
                hora_salida_ofi = v_parametros.hora_salida_ofi,
                incidencia = v_parametros.incidencia
            WHERE id_asig_vehiculo = v_parametros.id_asig_vehiculo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asignacion de Vehiculos modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_asig_vehiculo',v_parametros.id_asig_vehiculo::varchar);

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