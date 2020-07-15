CREATE OR REPLACE FUNCTION "ras"."ft_equipo_estado_sel"(    
                p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_equipo_estado_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tequipo_estado'
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

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
                
BEGIN

    v_nombre_funcion = 'ras.ft_equipo_estado_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************    
     #TRANSACCION:  'RAS_EQUIESTA_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez    
     #FECHA:        09-07-2020 13:52:37
    ***********************************/

    IF (p_transaccion='RAS_EQUIESTA_SEL') THEN
                     
        BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        equiesta.id_equipo_estado,
                        equiesta.estado_reg,
                        equiesta.id_equipo,
                        equiesta.fecha_inicio,
                        equiesta.fecha_final,
                        equiesta.estado,
                        equiesta.id_usuario_reg,
                        equiesta.fecha_reg,
                        equiesta.id_usuario_ai,
                        equiesta.usuario_ai,
                        equiesta.id_usuario_mod,
                        equiesta.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod    
                        FROM ras.tequipo_estado equiesta
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = equiesta.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = equiesta.id_usuario_mod
                        WHERE  ';
            
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
                        
        END;

    /*********************************    
     #TRANSACCION:  'RAS_EQUIESTA_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        egutierrez    
     #FECHA:        09-07-2020 13:52:37
    ***********************************/

    ELSIF (p_transaccion='RAS_EQUIESTA_CONT') THEN

        BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(id_equipo_estado)
                         FROM ras.tequipo_estado equiesta
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = equiesta.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = equiesta.id_usuario_mod
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
ALTER FUNCTION "ras"."ft_equipo_estado_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
