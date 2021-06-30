--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_sol_vehiculo_sel (
    p_administrador integer,
    p_id_usuario integer,
    p_tabla varchar,
    p_transaccion varchar
)
    RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_sol_vehiculo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ras.tsol_vehiculo'
 AUTOR:          (egutierrez)
 FECHA:            02-07-2020 22:13:48
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                02-07-2020 22:13:48    egutierrez             Creacion
#GDV-29                 13/01/2021          EGS                  Se agrega si exite conductor o no
#GDV-36                 02/03/2021          EGS                   Se agrega tab para filtro de estado
#GDV-37                 11/03/2021          EGS                  Se agrega el telefono_contacto
#RAS-8                  21/05/2021          JJA                  Reporte de conductores asignados
 ***************************************************************************/

DECLARE

    v_consulta            VARCHAR;
    v_parametros          RECORD;
    v_nombre_funcion      TEXT;
    v_resp                VARCHAR;
    v_filtro              varchar;
    v_with                varchar;
    v_join                varchar;
    v_col                 varchar;
    v_estado              varchar;

BEGIN

    v_nombre_funcion = 'ras.ft_sol_vehiculo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_SOLVEHI_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        egutierrez
     #FECHA:        02-07-2020 22:13:48
    ***********************************/

    IF (p_transaccion='RAS_SOLVEHI_SEL') THEN

        BEGIN
            v_with ='';
            v_join = '';
            v_col = '';

            IF p_administrador !=1 then

                IF  pxp.f_existe_parametro(p_tabla,'estado') THEN

                    v_estado = v_parametros.estado;
                ELSE
                    v_estado = '';
                END IF;


                --raise exception 'v_parametros.nombreVista %',v_parametros.nombreVista;
                --si es la vista del help y estan en estado asignado y finalizado muestra solo os registristros del funcionario solicitante
                IF v_parametros.nombreVista = 'SolVehiculo'   THEN

                    v_filtro = '(solvehi.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) or solvehi.id_usuario_reg = '||p_id_usuario||' and '; --RAS-11

                    --Si no soy administrador y estoy en pendiente no veo nada
                ElSIF v_parametros.nombreVista = 'SolVehiculoVoBo' or (v_parametros.nombreVista = 'SolVehiculoAsig' and v_estado = 'asigvehiculo') THEN --#GDV-36
                    v_filtro = '(ew.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) and ';
                ELSE
                    v_filtro = ' ';
                END IF;


            ELSE
                v_filtro = ' ';
            END IF;

            IF pxp.f_existe_parametro(p_tabla,'tipo_reporte') THEN
                IF v_parametros.tipo_reporte = 'auto_PI' or v_parametros.tipo_reporte = 'auto_PII' THEN
                    v_with='with fun_jefe (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                      SELECT
                           es.id_proceso_wf,
                           es.id_funcionario,
                           fun.desc_funcionario1 as desc_funcionario
                      FROM wf.testado_wf es
                      left join orga.vfuncionario fun on fun.id_funcionario = es.id_funcionario
                      left join wf.ttipo_estado ti on ti.id_tipo_estado = es.id_tipo_estado
                      WHERE  ti.codigo =''vobojefedep'' and es.fecha_reg = (  SELECT
                                                                                  max(eswf.fecha_reg)
                                                                                 FROM wf.testado_wf eswf
                                                                                 left join wf.ttipo_estado tipp on tipp.id_tipo_estado = eswf.id_tipo_estado
                                                                                 WHERE  tipp.codigo =''vobojefedep'' and  eswf.id_proceso_wf = es.id_proceso_wf
                                                                                  )
                       ),
                      fun_geren  (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                      SELECT
                           ess.id_proceso_wf,
                           ess.id_funcionario,
                           fun.desc_funcionario1 as desc_funcionario
                      FROM wf.testado_wf ess
                      left join orga.vfuncionario fun on fun.id_funcionario = ess.id_funcionario
                      left join wf.ttipo_estado ti on ti.id_tipo_estado = ess.id_tipo_estado
                      WHERE  ti.codigo =''vobogerente'' and ess.fecha_reg =(  SELECT
                                                                                  max(eswff.fecha_reg)
                                                                                 FROM wf.testado_wf eswff
                                                                                 left join wf.ttipo_estado tippp on tippp.id_tipo_estado = eswff.id_tipo_estado
                                                                                 WHERE  tippp.codigo =''vobogerente'' and  eswff.id_proceso_wf = ess.id_proceso_wf
                                                                                  )
                       ),
                      fun_jefe_ser (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                      SELECT
                           esss.id_proceso_wf,
                           esss.id_funcionario,
                           fun.desc_funcionario1 as desc_funcionario
                      FROM wf.testado_wf esss
                      left join orga.vfuncionario fun on fun.id_funcionario = esss.id_funcionario
                      left join wf.ttipo_estado ti on ti.id_tipo_estado = esss.id_tipo_estado
                      WHERE  ti.codigo =''vobojefeserv'' and esss.fecha_reg = (
                                                                                 SELECT
                                                                                  max(eswfff.fecha_reg)
                                                                                 FROM wf.testado_wf eswfff
                                                                                 left join wf.ttipo_estado tippppp on tippppp.id_tipo_estado = eswfff.id_tipo_estado
                                                                                 WHERE  tippppp.codigo =''vobojefeserv'' and  eswfff.id_proceso_wf = esss.id_proceso_wf
                                                                                  )
                       )';
                    v_col='
              ,fj.desc_funcionario::varchar as desc_jefe_dep
              ,ge.desc_funcionario::varchar as desc_gerente
              ,fjs.desc_funcionario::varchar as desc_jefe_serv
              ';

                    v_join='left join fun_jefe fj on fj.id_proceso_wf = solvehi.id_proceso_wf
                      left join fun_geren ge on ge.id_proceso_wf = solvehi.id_proceso_wf
                      left join fun_jefe_ser fjs on fjs.id_proceso_wf = solvehi.id_proceso_wf
              ';

                END IF;
            END IF;
            --Sentencia de la consulta
            v_consulta:='
                '||v_with||'
                SELECT
                        solvehi.id_sol_vehiculo,
                        solvehi.motivo,
                        solvehi.alquiler,
                        solvehi.ceco_clco,
                        solvehi.id_proceso_wf,
                        solvehi.hora_salida,
                        solvehi.fecha_salida,
                        solvehi.nro_tramite,
                        solvehi.id_estado_wf,
                        solvehi.hora_retorno,
                        solvehi.id_funcionario_jefe_depto,
                        solvehi.estado_reg,
                        solvehi.destino,
                        solvehi.fecha_sol,
                        solvehi.id_tipo_equipo,
                        solvehi.fecha_retorno,
                        solvehi.id_funcionario,
                        solvehi.observacion,
                        solvehi.estado,
                        solvehi.id_usuario_ai,
                        solvehi.id_usuario_reg,
                        solvehi.fecha_reg,
                        solvehi.usuario_ai,
                        solvehi.id_usuario_mod,
                        solvehi.fecha_mod,
                        usu1.cuenta as usr_reg,
                        usu2.cuenta as usr_mod,
                        tipv.nombre as desc_tipo_equipo,
                        fun.desc_funcionario1::varchar as desc_funcionario,
                        solvehi.monto,
                        solvehi.id_centro_costo,
                        cec.codigo_cc::varchar as desc_centro_costo,
                        solvehi.existe_conductor,
                        solvehi.telefono_contacto,  --#GDV-37
                        (select sr.id_responsable from ras.tsol_vehiculo_responsable sr
                        where sr.id_sol_vehiculo = solvehi.id_sol_vehiculo AND
                        solicitud = true limit 1) as id_responsable ,
                        (SELECT
                        p.nombre_completo1::varchar
                        FROM ras.tresponsable r
                        left join segu.vpersona p on p.id_persona = r.id_persona
                        WHERE r.id_responsable = (select sr.id_responsable from ras.tsol_vehiculo_responsable sr
                        where sr.id_sol_vehiculo = solvehi.id_sol_vehiculo AND
                        solicitud = true limit 1)) as desc_reponsable,
                        funi.desc_funcionario1::varchar as desc_funcionario_wf
                        '||v_col||'
                        FROM ras.tsol_vehiculo solvehi
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = solvehi.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = solvehi.id_usuario_mod
                        LEFT JOIN ras.ttipo_equipo tipv on tipv.id_tipo_equipo = solvehi.id_tipo_equipo
                        LEFT JOIN orga.vfuncionario fun on fun.id_funcionario =solvehi.id_funcionario
                        inner join wf.testado_wf ew on ew.id_estado_wf = solvehi.id_estado_wf and  ew.estado_reg = ''activo''
                        left join orga.vfuncionario funi on funi.id_funcionario = ew.id_funcionario
                        LEFT JOIN param.vcentro_costo cec on cec.id_centro_costo = solvehi.id_centro_costo
                        '||v_join||'
                        WHERE  '||v_filtro;

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;

        /*********************************
         #TRANSACCION:  'RAS_SOLVEHI_CONT'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        egutierrez
         #FECHA:        02-07-2020 22:13:48
        ***********************************/

    ELSIF (p_transaccion='RAS_SOLVEHI_CONT') THEN

        BEGIN
            v_with ='';
            v_join = '';
            IF p_administrador !=1 then

                --raise exception 'v_parametros.nombreVista %',v_parametros.nombreVista;
                --si es la vista del help y estan en estado asignado y finalizado muestra solo os registristros del funcionario solicitante
                IF v_parametros.nombreVista = 'SolVehiculo'   THEN

                    v_filtro = '(solvehi.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) and ';

                    --Si no soy administrador y estoy en pendiente no veo nada
                ElSIF v_parametros.nombreVista = 'SolVehiculoVoBo' THEN
                    v_filtro = '(ew.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) and ';

                ELSE
                    v_filtro = ' ';
                END IF;
            ELSE
                v_filtro = ' ';
            END IF;

            IF pxp.f_existe_parametro(p_tabla,'tipo_reporte') THEN
                IF v_parametros.tipo_reporte = 'auto_PI' or v_parametros.tipo_reporte = 'auto_PII' THEN
                    v_with='with fun_jefe (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                          SELECT
                               es.id_proceso_wf,
                               es.id_funcionario,
                               fun.desc_funcionario1 as desc_funcionario
                          FROM wf.testado_wf es
                          left join orga.vfuncionario fun on fun.id_funcionario = es.id_funcionario
                          left join wf.ttipo_estado ti on ti.id_tipo_estado = es.id_tipo_estado
                          WHERE  ti.codigo =''vobojefedep'' and es.fecha_reg = (  SELECT
                                                                                      max(eswf.fecha_reg)
                                                                                     FROM wf.testado_wf eswf
                                                                                     left join wf.ttipo_estado tipp on tipp.id_tipo_estado = eswf.id_tipo_estado
                                                                                     WHERE  tipp.codigo =''vobojefedep'' and  eswf.id_proceso_wf = es.id_proceso_wf
                                                                                      )
                           ),
                          fun_geren  (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                          SELECT
                               ess.id_proceso_wf,
                               ess.id_funcionario,
                               fun.desc_funcionario1 as desc_funcionario
                          FROM wf.testado_wf ess
                          left join orga.vfuncionario fun on fun.id_funcionario = ess.id_funcionario
                          left join wf.ttipo_estado ti on ti.id_tipo_estado = ess.id_tipo_estado
                          WHERE  ti.codigo =''vobogerente'' and ess.fecha_reg =(  SELECT
                                                                                      max(eswff.fecha_reg)
                                                                                     FROM wf.testado_wf eswff
                                                                                     left join wf.ttipo_estado tippp on tippp.id_tipo_estado = eswff.id_tipo_estado
                                                                                     WHERE  tippp.codigo =''vobogerente'' and  eswff.id_proceso_wf = ess.id_proceso_wf
                                                                                      )
                           ),
                          fun_jefe_ser (id_proceso_wf,id_funcionario,desc_funcionario)AS(
                          SELECT
                               esss.id_proceso_wf,
                               esss.id_funcionario,
                               fun.desc_funcionario1 as desc_funcionario
                          FROM wf.testado_wf esss
                          left join orga.vfuncionario fun on fun.id_funcionario = esss.id_funcionario
                          left join wf.ttipo_estado ti on ti.id_tipo_estado = esss.id_tipo_estado
                          WHERE  ti.codigo =''vobojefeserv'' and esss.fecha_reg = (
                                                                                     SELECT
                                                                                      max(eswfff.fecha_reg)
                                                                                     FROM wf.testado_wf eswfff
                                                                                     left join wf.ttipo_estado tippppp on tippppp.id_tipo_estado = eswfff.id_tipo_estado
                                                                                     WHERE  tippppp.codigo =''vobojefeserv'' and  eswfff.id_proceso_wf = esss.id_proceso_wf
                                                                                      )
                           )';

                    v_join='left join fun_jefe fj on fj.id_proceso_wf = solvehi.id_proceso_wf
                        left join fun_geren ge on ge.id_proceso_wf = solvehi.id_proceso_wf
                        left join fun_jefe_ser fjs on fjs.id_proceso_wf = solvehi.id_proceso_wf
                ';

                END IF;
            END IF;

            --Sentencia de la consulta de conteo de registros
            v_consulta:='
                        '||v_with||'
                        SELECT COUNT(solvehi.id_sol_vehiculo)
                         FROM ras.tsol_vehiculo solvehi
                         JOIN segu.tusuario usu1 ON usu1.id_usuario = solvehi.id_usuario_reg
                         LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = solvehi.id_usuario_mod
                         LEFT JOIN ras.ttipo_equipo tipv on tipv.id_tipo_equipo = solvehi.id_tipo_equipo
                        inner join wf.testado_wf ew on ew.id_estado_wf = solvehi.id_estado_wf and  ew.estado_reg = ''activo''
                         left join orga.vfuncionario funi on funi.id_funcionario = ew.id_funcionario
                         LEFT JOIN orga.vfuncionario fun on fun.id_funcionario =solvehi.id_funcionario
                         LEFT JOIN param.vcentro_costo cec on cec.id_centro_costo = solvehi.id_centro_costo
                         '||v_join||'
                         WHERE '||v_filtro;

            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

        END;
        /*********************************
 #TRANSACCION:  'RAS_SOLVEHIKIL_SEL'
 #DESCRIPCION:    Conteo de registros
 #AUTOR:        egutierrez
 #FECHA:        02-07-2020 22:13:48
***********************************/

    ELSIF (p_transaccion='RAS_SOLVEHIKIL_SEL') THEN

        BEGIN
            v_consulta = 'SELECT
                      solv.id_sol_vehiculo,
                      solv.nro_tramite,
                      asi.km_inicio,
                      asi.km_final,
                      asi.recorrido,
                      fun.desc_funcionario1::varchar as desc_funcionario, --#GDV-32
                      solv.destino  --#GDV-32
                  FROM ras.tsol_vehiculo solv
                  left join ras.tasig_vehiculo asi on asi.id_sol_vehiculo =  solv.id_sol_vehiculo
                  left join orga.vfuncionario fun on fun.id_funcionario = solv.id_funcionario
                  WHERE ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
        END;
        /*********************************
           #TRANSACCION:  'RAS_SSOLVEHIKIL_CONT'
           #DESCRIPCION:    Conteo de registros
           #AUTOR:        egutierrez
           #FECHA:        02-07-2020 22:13:48
          ***********************************/
    ELSEIF (p_transaccion='RAS_SOLVEHIKIL_CONT') THEN
        BEGIN
            v_consulta = '
              SELECT
                  count(solv.id_sol_vehiculo)
              FROM ras.tsol_vehiculo solv
              left join ras.tasig_vehiculo asi on asi.id_sol_vehiculo =  solv.id_sol_vehiculo
              left join orga.vfuncionario fun on fun.id_funcionario = solv.id_funcionario

                WHERE ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            RETURN v_consulta;
        END;
        /*********************************
         #TRANSACCION:  'RAS_DASIGVEH_SEL'
         #DESCRIPCION:    Conteo de registros
         #AUTOR:        JJA
         #FECHA:        20-05-2021 22:13:48
        ***********************************/

    ELSIF (p_transaccion='RAS_DASIGVEH_SEL') THEN --#RAS-8

        BEGIN
            v_consulta = ' select asig.id_asig_vehiculo::integer,
           pe.nombre_completo1::varchar as conductor_responsable,
           eq.placa::varchar,
           fun.desc_funcionario1::varchar as funcionario_solicitante,
           to_char(sol.fecha_retorno,''DD/MM/YYYY'')::varchar as fecha_retorno,
           --sol.fecha_retorno::date,
           uo.nombre_unidad::varchar
            FROM ras.tasig_vehiculo asig
            left join ras.tsol_vehiculo sol on sol.id_sol_vehiculo::INTEGER = asig.id_sol_vehiculo::integer
            left join ras.tequipo eq on eq.id_equipo=asig.id_equipo
            LEFT JOIN orga.vfuncionario fun on fun.id_funcionario = sol.id_funcionario
            JOIN orga.tuo_funcionario uff on uff.id_funcionario=fun.id_funcionario
            AND uff.fecha_asignacion<=CURRENT_DATE AND (uff.fecha_finalizacion IS NULL OR CURRENT_DATE<=uff.fecha_finalizacion)
            join orga.tuo uo on uo.id_uo=orga.f_get_uo_departamento(uff.id_uo,fun.id_funcionario,null)
            left join ras.tsol_vehiculo_responsable r on r.id_sol_vehiculo_responsable::text = ANY (string_to_array(asig.id_sol_vehiculo_responsable,'',''))
            --left join ras.tsol_vehiculo_responsable r on r.id_sol_vehiculo_responsable::integer = asig.id_sol_vehiculo_responsable::integer
            left join ras.tresponsable rs on rs.id_responsable=r.id_responsable
            left join segu.vpersona pe on pe.id_persona = rs.id_persona
            where sol.estado = ''asignado'' and ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by asig.id_asig_vehiculo  ASC limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
        END;
        /*********************************
           #TRANSACCION:  'RAS_DASIGVEH_CONT'
           #DESCRIPCION:    Conteo de registros
           #AUTOR:        JJA
           #FECHA:        20-05-2021 22:13:48
          ***********************************/
    ELSEIF (p_transaccion='RAS_DASIGVEH_CONT') THEN --#RAS-8
        BEGIN
            v_consulta = ' select COUNT(*)
            FROM ras.tasig_vehiculo asig
            left join ras.tsol_vehiculo sol on sol.id_sol_vehiculo::INTEGER = asig.id_sol_vehiculo::integer
            left join ras.tequipo eq on eq.id_equipo=asig.id_equipo
            LEFT JOIN orga.vfuncionario fun on fun.id_funcionario = sol.id_funcionario
            JOIN orga.tuo_funcionario uff on uff.id_funcionario=fun.id_funcionario
            AND uff.fecha_asignacion<=CURRENT_DATE AND (uff.fecha_finalizacion IS NULL OR CURRENT_DATE<=uff.fecha_finalizacion)
            join orga.tuo uo on uo.id_uo=orga.f_get_uo_departamento(uff.id_uo,fun.id_funcionario,null)
            left join ras.tsol_vehiculo_responsable r on r.id_sol_vehiculo_responsable::text = ANY (string_to_array(asig.id_sol_vehiculo_responsable,'',''))
            --left join ras.tsol_vehiculo_responsable r on r.id_sol_vehiculo_responsable::integer = asig.id_sol_vehiculo_responsable::integer
            left join ras.tresponsable rs on rs.id_responsable=r.id_responsable
            left join segu.vpersona pe on pe.id_persona = rs.id_persona
            where sol.estado = ''asignado'' and ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

            RETURN v_consulta;
        END;
    ELSIF (p_transaccion='RAS_CONSUVEHI_SEL') THEN --#RAS-8

        BEGIN
            v_consulta = ' select
            SOL.id_sol_vehiculo,
            fun.desc_funcionario1::varchar as solicitante,
            (tcc.codigo||'' - ''||tcc.descripcion)::varchar as ceco,
             to_char(sol.fecha_salida,''DD/MM/YYYY'')::varchar as inicio,
            to_char(sol.fecha_retorno,''DD/MM/YYYY'')::varchar as finalizacion,
            sol.destino,
            uo.nombre_unidad::varchar as depto,
            g.nombre_unidad::varchar as gerencia,
            sol.alquiler::varchar
            FROM  ras.tsol_vehiculo sol
            join param.tcentro_costo cc on cc.id_centro_costo=sol.id_centro_costo
            join param.ttipo_cc tcc on tcc.id_tipo_cc=cc.id_tipo_cc
            JOIN orga.vfuncionario fun on fun.id_funcionario = sol.id_funcionario
            JOIN orga.tuo_funcionario uff on uff.id_funcionario=fun.id_funcionario
            AND uff.fecha_asignacion<=CURRENT_DATE AND (uff.fecha_finalizacion IS NULL OR CURRENT_DATE<=uff.fecha_finalizacion)
            join orga.tuo uo on uo.id_uo=orga.f_get_uo_departamento(uff.id_uo,fun.id_funcionario,null)
            join orga.tuo g on g.id_uo=orga.f_get_uo_gerencia(uff.id_uo,fun.id_funcionario,null)
            where ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;
            v_consulta:=v_consulta||' order by sol.id_sol_vehiculo  ASC limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

            --Devuelve la respuesta
            RETURN v_consulta;
        END;
        /*********************************
           #TRANSACCION:  'RAS_DASIGVEH_CONT'
           #DESCRIPCION:    Conteo de registros
           #AUTOR:        JJA
           #FECHA:        20-05-2021 22:13:48
          ***********************************/
    ELSEIF (p_transaccion='RAS_CONSUVEHI_CONT') THEN --#RAS-8
        BEGIN
            v_consulta = ' select count(*)
            FROM  ras.tsol_vehiculo sol
            join param.tcentro_costo cc on cc.id_centro_costo=sol.id_centro_costo
            join param.ttipo_cc tcc on tcc.id_tipo_cc=cc.id_tipo_cc
            JOIN orga.vfuncionario fun on fun.id_funcionario = sol.id_funcionario
            JOIN orga.tuo_funcionario uff on uff.id_funcionario=fun.id_funcionario
            AND uff.fecha_asignacion<=CURRENT_DATE AND (uff.fecha_finalizacion IS NULL OR CURRENT_DATE<=uff.fecha_finalizacion)
            join orga.tuo uo on uo.id_uo=orga.f_get_uo_departamento(uff.id_uo,fun.id_funcionario,null)
            join orga.tuo g on g.id_uo=orga.f_get_uo_gerencia(uff.id_uo,fun.id_funcionario,null) where ';
            --Definicion de la respuesta
            v_consulta:=v_consulta||v_parametros.filtro;

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
