CREATE OR REPLACE FUNCTION "ras"."ft_equipo_estado_ime" (    
                p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_equipo_estado_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tequipo_estado'
 AUTOR:          (egutierrez)
 FECHA:            09-07-2020 13:52:37
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                09-07-2020 13:52:37    egutierrez             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_equipo_estado    INTEGER;
                
BEGIN

    v_nombre_funcion = 'ras.ft_equipo_estado_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'RAS_EQUIESTA_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez    
     #FECHA:        09-07-2020 13:52:37
    ***********************************/

    IF (p_transaccion='RAS_EQUIESTA_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.tequipo_estado(
            estado_reg,
            id_equipo,
            fecha_inicio,
            fecha_final,
            estado,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.id_equipo,
            v_parametros.fecha_inicio,
            v_parametros.fecha_final,
            v_parametros.estado,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null            
            ) RETURNING id_equipo_estado into v_id_equipo_estado;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estado de Vehiculo almacenado(a) con exito (id_equipo_estado'||v_id_equipo_estado||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_estado',v_id_equipo_estado::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'RAS_EQUIESTA_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez    
     #FECHA:        09-07-2020 13:52:37
    ***********************************/

    ELSIF (p_transaccion='RAS_EQUIESTA_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.tequipo_estado SET
            id_equipo = v_parametros.id_equipo,
            fecha_inicio = v_parametros.fecha_inicio,
            fecha_final = v_parametros.fecha_final,
            estado = v_parametros.estado,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_equipo_estado=v_parametros.id_equipo_estado;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estado de Vehiculo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_estado',v_parametros.id_equipo_estado::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'RAS_EQUIESTA_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez    
     #FECHA:        09-07-2020 13:52:37
    ***********************************/

    ELSIF (p_transaccion='RAS_EQUIESTA_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.tequipo_estado
            WHERE id_equipo_estado=v_parametros.id_equipo_estado;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Estado de Vehiculo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_estado',v_parametros.id_equipo_estado::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_equipo_estado_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
