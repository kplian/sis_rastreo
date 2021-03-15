--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_asig_vehiculo_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_asig_vehiculo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tasig_vehiculo'
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

v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;

BEGIN

    v_nombre_funcion = 'ras.ft_asig_vehiculo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_ASIGVEHI_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        03-07-2020 15:02:14
    ***********************************/

    IF (p_transaccion='RAS_ASIGVEHI_SEL') THEN

BEGIN
            --Sentencia de la consulta
            v_consulta:='SELECT
                        asigvehi.id_asig_vehiculo,
                        asigvehi.id_sol_vehiculo,
                        asigvehi.id_equipo,
                        asigvehi.observaciones,
                        asigvehi.id_sol_vehiculo_responsable::varchar,
                        asigvehi.estado_reg,
                        asigvehi.id_usuario_ai,
                        asigvehi.fecha_reg,
                        asigvehi.usuario_ai,
                        asigvehi.id_usuario_reg,
                        asigvehi.fecha_mod,
                        asigvehi.id_usuario_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod ,
                        case
                        when solv.alquiler = ''si'' then
                        equipa.placa
                        else
                        equip.placa
                        end as placa,
                        case
                        when solv.alquiler = ''si'' then
                        marc.nombre
                        else
                        mar.nombre
                        end as desc_marca,
                        case
                        when solv.alquiler = ''si'' then
                        equipa.modelo
                        else
                        mod.nombre
                        end as desc_modelo,
                        case
                        when solv.alquiler = ''si'' then
                        tipes.nombre
                        else
                        tipe.nombre
                        end as desc_tipo_equipo,
                      (SELECT  array_to_string(array_agg(pe.nombre_completo1), ''<br>''::
                            text)::character varying
                         from ras.tresponsable rs
                         left join segu.vpersona pe on pe.id_persona = rs.id_persona
                         left join ras.tsol_vehiculo_responsable r on r.id_responsable = rs.id_responsable
                         where r.id_sol_vehiculo_responsable  in ( SELECT element::integer
                                                        FROM UNNEST( string_to_array(asigvehi.id_sol_vehiculo_responsable,'',''))
                                                        as element)
                         ) as desc_persona,
                        asigvehi.km_inicio,
                        asigvehi.km_final,
                        asigvehi.recorrido,
                        asigvehi.observacion_viaje,
                        asigvehi.fecha_salida_ofi,
                        asigvehi.hora_salida_ofi,
                        asigvehi.fecha_retorno_ofi,
                        asigvehi.hora_retorno_ofi,
                        marc.nombre as marca,
                        equipa.modelo,
                        equipa.id_proveedor,
                        equipa.id_tipo_equipo,
                        asigvehi.incidencia,
                        case
                        when solv.alquiler = ''si'' then
                        equipa.id_marca
                        else
                        mar.id_marca
                        end as id_marca
                        FROM ras.tasig_vehiculo asigvehi
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = asigvehi.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = asigvehi.id_usuario_mod
                        Left join ras.tequipo equip on equip.id_equipo = asigvehi.id_equipo
                        Left join ras.tmodelo mod on mod.id_modelo = equip.id_modelo
                        Left join ras.tmarca mar on mar.id_marca = mod.id_marca
                        Left join ras.ttipo_equipo tipe on tipe.id_tipo_equipo = equip.id_tipo_equipo
                        Left join ras.tresponsable res on res.id_responsable = asigvehi.id_responsable
                        left join segu.vpersona per on per.id_persona = res.id_persona
                        left join ras.tsol_vehiculo solv on solv.id_sol_vehiculo = asigvehi.id_sol_vehiculo
                        left join ras.tequipo_alquilado equipa on equipa.id_asig_vehiculo = asigvehi.id_asig_vehiculo
                        Left join ras.ttipo_equipo tipes on tipes.id_tipo_equipo = equipa.id_tipo_equipo
                        Left join ras.tmarca marc on marc.id_marca = equipa.id_marca
                        WHERE  ';

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
RETURN v_consulta;

END;

        /*********************************
         #TRANSACCION:  'RAS_ASIGVEHI_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        egutierrez
         #FECHA:        03-07-2020 15:02:14
        ***********************************/

    ELSIF (p_transaccion='RAS_ASIGVEHI_CONT') THEN

BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='SELECT COUNT(asigvehi.id_asig_vehiculo)
                         FROM ras.tasig_vehiculo asigvehi
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = asigvehi.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = asigvehi.id_usuario_mod
                         Left join ras.tequipo equip on equip.id_equipo = asigvehi.id_equipo
                         Left join ras.tmodelo mod on mod.id_modelo = equip.id_modelo
                         Left join ras.tmarca mar on mar.id_marca = mod.id_marca
                         Left join ras.ttipo_equipo tipe on tipe.id_tipo_equipo = equip.id_tipo_equipo
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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100;