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

                    v_filtro = '(solvehi.id_funcionario = '||v_parametros.id_funcionario_usu::varchar||' ) and ';

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
                        solvehi.existe_conductor
                        '||v_col||'
                        FROM ras.tsol_vehiculo solvehi
                        JOIN segu.tusuario usu1 ON usu1.id_usuario = solvehi.id_usuario_reg
                        LEFT JOIN segu.tusuario usu2 ON usu2.id_usuario = solvehi.id_usuario_mod
                        LEFT JOIN ras.ttipo_equipo tipv on tipv.id_tipo_equipo = solvehi.id_tipo_equipo
                        LEFT JOIN orga.vfuncionario fun on fun.id_funcionario =solvehi.id_funcionario
                        inner join wf.testado_wf ew on ew.id_proceso_wf = solvehi.id_proceso_wf and  ew.estado_reg = ''activo''
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
                         inner join wf.testado_wf ew on ew.id_proceso_wf = solvehi.id_proceso_wf and  ew.estado_reg = ''activo''
                         left join orga.vfuncionario funi on funi.id_funcionario = ew.id_funcionario
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