CREATE OR REPLACE FUNCTION "ras"."ft_elemento_seg_ime" (    
                p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_elemento_seg_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.telemento_seg'
 AUTOR:          (egutierrez)
 FECHA:            03-07-2020 15:00:54
 COMENTARIOS:    
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                03-07-2020 15:00:54    egutierrez             Creacion    
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_elemento_seg    INTEGER;
                
BEGIN

    v_nombre_funcion = 'ras.ft_elemento_seg_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'RAS_ELEMSEG_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez    
     #FECHA:        03-07-2020 15:00:54
    ***********************************/

    IF (p_transaccion='RAS_ELEMSEG_INS') THEN
                    
        BEGIN
            --Sentencia de la insercion
            INSERT INTO ras.telemento_seg(
            estado_reg,
            nombre,
            id_usuario_reg,
            fecha_reg,
            id_usuario_ai,
            usuario_ai,
            id_usuario_mod,
            fecha_mod
              ) VALUES (
            'activo',
            v_parametros.nombre,
            p_id_usuario,
            now(),
            v_parametros._id_usuario_ai,
            v_parametros._nombre_usuario_ai,
            null,
            null            
            ) RETURNING id_elemento_seg into v_id_elemento_seg;
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elementos de SEguridad y Señalizacion almacenado(a) con exito (id_elemento_seg'||v_id_elemento_seg||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg',v_id_elemento_seg::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************    
     #TRANSACCION:  'RAS_ELEMSEG_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez    
     #FECHA:        03-07-2020 15:00:54
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMSEG_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.telemento_seg SET
            nombre = v_parametros.nombre,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai
            WHERE id_elemento_seg=v_parametros.id_elemento_seg;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elementos de SEguridad y Señalizacion modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg',v_parametros.id_elemento_seg::varchar);
               
            --Devuelve la respuesta
            RETURN v_resp;
            
        END;

    /*********************************    
     #TRANSACCION:  'RAS_ELEMSEG_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez    
     #FECHA:        03-07-2020 15:00:54
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMSEG_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.telemento_seg
            WHERE id_elemento_seg=v_parametros.id_elemento_seg;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Elementos de SEguridad y Señalizacion eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_elemento_seg',v_parametros.id_elemento_seg::varchar);
              
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
ALTER FUNCTION "ras"."ft_elemento_seg_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
