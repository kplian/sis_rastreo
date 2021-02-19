--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.f_lista_funcionario_gerente_area (
  p_id_usuario integer,
  p_id_tipo_estado integer,
  p_fecha date = now(),
  p_id_estado_wf integer = NULL::integer,
  p_count boolean = false,
  p_limit integer = 1,
  p_start integer = 0,
  p_filtro varchar = '0=0'::character varying
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ...
***************************************************************************
 SCRIPT:        sopte.f_lista_funcionario_gerente_area
 DESCRIPCIÓN:
 AUTOR:          EGS
 FECHA:
 COMENTARIOS:
 ISSUE:         #2
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 ISSUE  FECHA:          AUTOR:    DESCRIPCIÓN:

***************************************************************************/

-------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
/*


  p_id_usuario integer,                                identificador del actual usuario de sistema
  p_id_tipo_estado integer,                            idnetificador del tipo estado del que se quiere obtener el listado de funcionario  (se correponde con tipo_estado que le sigue a id_estado_wf proporcionado)
  p_fecha date = now(),                                fecha  --para verificar asginacion de cargo con organigrama
  p_id_estado_wf integer = NULL::integer,              identificaro de estado_wf actual en el proceso_wf
  p_count boolean = false,                             si queremos obtener numero de funcionario = true por defecto false
  p_limit integer = 1,                                 los siguiente son parametros para filtrar en la consulta
  p_start integer = 0,
  p_filtro varchar = '0=0'::character varying




*/

DECLARE
    g_registros                  record;
    v_depto_asignacion            varchar;
    v_nombre_depto_func_list       varchar;
    v_consulta                     varchar;
    v_nombre_funcion             varchar;
    v_resp                         varchar;
    v_cad_ep                     varchar;
    v_cad_uo                     varchar;
    v_id_funcionario               integer;
    v_a_eps                     varchar[];
    v_a_uos                     varchar[];
    v_uos_eps                     varchar;
    v_size                        integer;
    v_i                           integer;
    v_id_proceso_wf               integer;
    vuo_id_uo               INTEGER[];
    vuo_id_funcionario      INTEGER[];
    vuo_gerencia            VARCHAR[];
    vuo_numero_nivel        VARCHAR[];
    v_fecha                 date;
    v_id_uo                 integer;

BEGIN
    v_nombre_funcion ='ras.f_lista_funcionario_gerente_area';
          select
           estwf.id_proceso_wf
          into
            v_id_proceso_wf
          from wf.testado_wf estwf
          where estwf.id_estado_wf =  p_id_estado_wf;

          SELECT
                help.id_funcionario
          INTO
                v_id_funcionario
          FROM  ras.tsol_vehiculo help
          WHERE help.id_proceso_wf = v_id_proceso_wf;

        v_fecha=now();

      WITH RECURSIVE path( id_funcionario, id_uo, gerencia, numero_nivel) AS (

                      SELECT uofun.id_funcionario,uo.id_uo,uo.gerencia, no.numero_nivel
                      FROM orga.tuo_funcionario uofun
                        inner join orga.tuo uo on uo.id_uo = uofun.id_uo
                        inner join orga.tnivel_organizacional no on no.id_nivel_organizacional = uo.id_nivel_organizacional
                      where uofun.fecha_asignacion <= v_fecha::date and (uofun.fecha_finalizacion is null or uofun.fecha_finalizacion >= v_fecha::date)
                        and uofun.estado_reg = 'activo' and uofun.id_funcionario = v_id_funcionario
                    UNION

                     SELECT uofun.id_funcionario,euo.id_uo_padre,uo.gerencia,no.numero_nivel
                     FROM orga.testructura_uo euo
                        inner join orga.tuo uo on uo.id_uo = euo.id_uo_padre
                        inner join orga.tnivel_organizacional no on no.id_nivel_organizacional = uo.id_nivel_organizacional
                        inner join path hijo on hijo.id_uo = euo.id_uo_hijo
                        left join orga.tuo_funcionario uofun on uo.id_uo = uofun.id_uo and uofun.estado_reg = 'activo' and uofun.fecha_asignacion <= v_fecha::date
                        and (uofun.fecha_finalizacion is null or uofun.fecha_finalizacion >= v_fecha::date)

                    )
                     SELECT
                        pxp.aggarray(id_uo),
                        pxp.aggarray(id_funcionario),
                        pxp.aggarray(gerencia),
                        pxp.aggarray(numero_nivel)
                     Into
                     vuo_id_uo,
                     vuo_id_funcionario,
                     vuo_gerencia,
                     vuo_numero_nivel
                     FROM path
                    WHERE numero_nivel not in (5,7,8,9,4,3,6)and id_funcionario is not null;

    p_filtro = 'fun.id_funcionario = '||vuo_id_funcionario[1]||'';

    IF not p_count then
             v_consulta:='SELECT
                            fun.id_funcionario,
                            fun.desc_funcionario1 as desc_funcionario,
                            ''''::text  as desc_funcionario_cargo,
                            1 as prioridad
                         FROM orga.vfuncionario fun WHERE '||p_filtro||'
                         ORDER BY fun.desc_funcionario1 ASC';


                   FOR g_registros in execute (v_consulta)LOOP
                     RETURN NEXT g_registros;
                   END LOOP;

      ELSE
                  v_consulta='select
                                  COUNT(fun.id_funcionario) as total
                                 FROM orga.vfuncionario fun WHERE '||p_filtro;

                   FOR g_registros in execute (v_consulta)LOOP
                     RETURN NEXT g_registros;
                   END LOOP;


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
COST 100 ROWS 1000;