CREATE OR REPLACE FUNCTION "ras"."ft_elemento_seg_sel"(    
                p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_elemento_seg_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.telemento_seg'
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

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'ras.ft_elemento_seg_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'RAS_ELEMSEG_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez    
     #FECHA:        03-07-2020 15:00:54
    ***********************************/

    IF (p_transaccion='RAS_ELEMSEG_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        elemseg.id_elemento_seg,
                        elemseg.estado_reg,
                        elemseg.nombre,
                        elemseg.id_usuario_reg,
                        elemseg.fecha_reg,
                        elemseg.id_usuario_ai,
                        elemseg.usuario_ai,
                        elemseg.id_usuario_mod,
                        elemseg.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod    
                        FROM ras.telemento_seg elemseg
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = elemseg.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = elemseg.id_usuario_mod
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'RAS_ELEMSEG_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez    
     #FECHA:        03-07-2020 15:00:54
    ***********************************/

    ELSIF (p_transaccion='RAS_ELEMSEG_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_elemento_seg)
                         FROM ras.telemento_seg elemseg
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = elemseg.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = elemseg.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_elemento_seg_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
