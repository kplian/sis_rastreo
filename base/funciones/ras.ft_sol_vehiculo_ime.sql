--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_sol_vehiculo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:        Gestion Vehicular
 FUNCION:         ras.ft_sol_vehiculo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tsol_vehiculo'
 AUTOR:          (egutierrez)
 FECHA:            02-07-2020 22:13:48
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE                FECHA                AUTOR                DESCRIPCION
 #0                02-07-2020 22:13:48    egutierrez             Creacion
 #
 ***************************************************************************/

DECLARE

    v_nro_requerimiento        INTEGER;
    v_parametros               RECORD;
    v_id_requerimiento         INTEGER;
    v_resp                     VARCHAR;
    v_nombre_funcion           TEXT;
    v_mensaje_error            TEXT;
    v_id_sol_vehiculo    INTEGER;
      --variables wf
    v_id_proceso_macro      integer;
    v_num_tramite           varchar;
    v_codigo_tipo_proceso   varchar;
    v_fecha                 date;
    v_codigo_estado         varchar;
    v_id_proceso_wf         integer;
    v_id_estado_wf          integer;
    v_id_gestion            integer;

      -- variables de sig y ant estado de Wf
    v_id_tipo_estado        integer;
    v_codigo_estado_siguiente    varchar;
    v_id_depto              integer;
    v_obs                   varchar;
    v_acceso_directo        varchar;
    v_clase                 varchar;
    v_codigo_estados        varchar;
    v_id_cuenta_bancaria    integer;
    v_id_depto_lb           integer;
    v_parametros_ad         varchar;
    v_tipo_noti             varchar;
    v_titulo                varchar;
    v_id_estado_actual      integer;
    v_registros_proc        record;
    v_codigo_tipo_pro       varchar;
    v_id_usuario_reg        integer;
    v_id_estado_wf_ant       integer;
    v_id_funcionario        integer;

BEGIN

    v_nombre_funcion = 'ras.ft_sol_vehiculo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

    /*********************************
     #TRANSACCION:  'RAS_solvehi_INS'
     #DESCRIPCION:    Insercion de registros
     #AUTOR:        egutierrez
     #FECHA:        02-07-2020 22:13:48
    ***********************************/

    IF (p_transaccion='RAS_SOLVEHI_INS') THEN

        BEGIN
                     -- codigo de proceso WF de presolicitudes de compra
            v_codigo_tipo_proceso = 'SOLVEH';
            --Recoleccion de datos para el proceso WF #4
             --obtener id del proceso macro

             select
             pm.id_proceso_macro
             into
             v_id_proceso_macro
             from wf.tproceso_macro pm
             left join wf.ttipo_proceso tp on tp.id_proceso_macro  = pm.id_proceso_macro
             where tp.codigo = v_codigo_tipo_proceso;

             --RAISE EXCEPTION 'v_id_proceso_macro %',v_id_proceso_macro;
             If v_id_proceso_macro is NULL THEN
               raise exception 'El proceso macro  de codigo % no esta configurado en el sistema WF',v_codigo_tipo_proceso;
             END IF;

            --Obtencion de la gestion #4
             v_fecha= now()::date;
              select
                per.id_gestion
                into
                v_id_gestion
                from param.tperiodo per
                where per.fecha_ini <=v_fecha and per.fecha_fin >= v_fecha
                limit 1 offset 0;

             -- inciar el tramite en el sistema de WF   #4
            SELECT
                   ps_num_tramite ,
                   ps_id_proceso_wf ,
                   ps_id_estado_wf ,
                   ps_codigo_estado
                into
                   v_num_tramite,
                   v_id_proceso_wf,
                   v_id_estado_wf,
                   v_codigo_estado

            FROM wf.f_inicia_tramite(
                   p_id_usuario,
                   v_parametros._id_usuario_ai,
                   v_parametros._nombre_usuario_ai,
                   v_id_gestion,
                   v_codigo_tipo_proceso,
                   v_parametros.id_funcionario,
                   null,
                   'Inicio de Solicitud de vehiculo',
                   '' );
            --Sentencia de la insercion
            INSERT INTO ras.tsol_vehiculo(
            motivo,
            alquiler,
            ceco_clco,
            id_proceso_wf,
            hora_salida,
            fecha_salida,
            nro_tramite,
            id_estado_wf,
            hora_retorno,
            id_funcionario_jefe_depto,
            estado_reg,
            destino,
            fecha_sol,
            id_tipo_equipo,
            fecha_retorno,
            id_funcionario,
            observacion,
            estado,
            id_usuario_ai,
            id_usuario_reg,
            fecha_reg,
            usuario_ai,
            id_usuario_mod,
            fecha_mod,
            monto,
            id_centro_costo
              ) VALUES (
            v_parametros.motivo,
            v_parametros.alquiler,
            v_parametros.ceco_clco,
            v_id_proceso_wf,
            v_parametros.hora_salida,
            v_parametros.fecha_salida,
            v_num_tramite,
            v_id_estado_wf,
            v_parametros.hora_retorno,
            v_parametros.id_funcionario_jefe_depto,
            'activo',
            v_parametros.destino,
            v_parametros.fecha_sol,
            v_parametros.id_tipo_equipo,
            v_parametros.fecha_retorno,
            v_parametros.id_funcionario,
            v_parametros.observacion,
            v_codigo_estado,
            v_parametros._id_usuario_ai,
            p_id_usuario,
            now(),
            v_parametros._nombre_usuario_ai,
            null,
            null,
            v_parametros.monto,
            v_parametros.id_centro_costo
            ) RETURNING id_sol_vehiculo into v_id_sol_vehiculo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SOLVEHI almacenado(a) con exito (id_sol_vehiculo'||v_id_sol_vehiculo||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo',v_id_sol_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_SOLVEHI_MOD'
     #DESCRIPCION:    Modificacion de registros
     #AUTOR:        egutierrez
     #FECHA:        02-07-2020 22:13:48
    ***********************************/

    ELSIF (p_transaccion='RAS_SOLVEHI_MOD') THEN

        BEGIN
            --Sentencia de la modificacion
            UPDATE ras.tsol_vehiculo SET
            motivo = v_parametros.motivo,
            alquiler = v_parametros.alquiler,
            ceco_clco = v_parametros.ceco_clco,
            hora_salida = v_parametros.hora_salida,
            fecha_salida = v_parametros.fecha_salida,
            hora_retorno = v_parametros.hora_retorno,
            id_funcionario_jefe_depto = v_parametros.id_funcionario_jefe_depto,
            destino = v_parametros.destino,
            fecha_sol = v_parametros.fecha_sol,
            id_tipo_equipo = v_parametros.id_tipo_equipo,
            fecha_retorno = v_parametros.fecha_retorno,
            id_funcionario = v_parametros.id_funcionario,
            observacion = v_parametros.observacion,
            id_usuario_mod = p_id_usuario,
            fecha_mod = now(),
            id_usuario_ai = v_parametros._id_usuario_ai,
            usuario_ai = v_parametros._nombre_usuario_ai,
            monto = v_parametros.monto,
            id_centro_costo = v_parametros.id_centro_costo
            WHERE id_sol_vehiculo=v_parametros.id_sol_vehiculo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SOLVEHI modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo',v_parametros.id_sol_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;

    /*********************************
     #TRANSACCION:  'RAS_SOLVEHI_ELI'
     #DESCRIPCION:    Eliminacion de registros
     #AUTOR:        egutierrez
     #FECHA:        02-07-2020 22:13:48
    ***********************************/

    ELSIF (p_transaccion='RAS_SOLVEHI_ELI') THEN

        BEGIN
            --Sentencia de la eliminacion
            DELETE FROM ras.tsol_vehiculo
            WHERE id_sol_vehiculo=v_parametros.id_sol_vehiculo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SOLVEHI eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sol_vehiculo',v_parametros.id_sol_vehiculo::varchar);

            --Devuelve la respuesta
            RETURN v_resp;

        END;
          /*********************************
      #TRANSACCION:      'RAS_SIGESOLVEH_INS'
      #DESCRIPCION:      Controla el cambio al siguiente estado
      #AUTOR:           EGS
      #FECHA:
      #ISSUE:
      ***********************************/


      elseif(p_transaccion='RAS_SIGESOLVEH_INS')then

          begin
              --Obtenemos datos basico
              select
              ew.id_proceso_wf,
              c.id_estado_wf,
              c.estado
              into
              v_id_proceso_wf,
              v_id_estado_wf,
              v_codigo_estado
              from ras.tsol_vehiculo c
              inner join wf.testado_wf ew on ew.id_estado_wf = c.id_estado_wf
              where c.id_sol_vehiculo = v_parametros.id_sol_vehiculo;

              --Recupera datos del estado
              select
              ew.id_tipo_estado,
              te.codigo
              into
              v_id_tipo_estado,
              v_codigo_estados
              from wf.testado_wf ew
              inner join wf.ttipo_estado te on te.id_tipo_estado = ew.id_tipo_estado
              where ew.id_estado_wf = v_parametros.id_estado_wf_act;

              -- obtener datos tipo estado
              select
              te.codigo
              into
              v_codigo_estado_siguiente
              from wf.ttipo_estado te
              where te.id_tipo_estado = v_parametros.id_tipo_estado;

              if pxp.f_existe_parametro(p_tabla,'id_depto_wf') then
                  v_id_depto = v_parametros.id_depto_wf;
              end if;

              if pxp.f_existe_parametro(p_tabla,'obs') then
                  v_obs=v_parametros.obs;
              else
                  v_obs='---';
              end if;

              --Acciones por estado siguiente que podrian realizarse
              if v_codigo_estado_siguiente in ('') then
              end if;

              ---------------------------------------
              -- REGISTRA EL SIGUIENTE ESTADO DEL WF
              ---------------------------------------
              --Configurar acceso directo para la alarma
              v_acceso_directo = '';
              v_clase = '';
              v_parametros_ad = '';
              v_tipo_noti = 'notificacion';
              v_titulo  = 'VoBo';
              --raise exception 'v_codigo_estado_siguiente %',v_codigo_estado_siguiente;
              if v_codigo_estado_siguiente not in('borrador','finalizado','anulado') then
                  v_acceso_directo = '../../../sis_planillas/vista/licencia/Licencia.php';
                  v_clase = 'Licencia';
                  v_parametros_ad = '{filtro_directo:{campo:"lice.id_proceso_wf",valor:"'||v_id_proceso_wf::varchar||'"}}';
                  v_tipo_noti = 'notificacion';
                  v_titulo  = 'VoBo';
              end if;
              v_id_estado_actual = wf.f_registra_estado_wf(
                                                     v_parametros.id_tipo_estado,
                                                     v_parametros.id_funcionario_wf,
                                                     v_parametros.id_estado_wf_act,
                                                     v_id_proceso_wf,
                                                     p_id_usuario,
                                                     v_parametros._id_usuario_ai,
                                                     v_parametros._nombre_usuario_ai,
                                                     v_id_depto,                       --depto del estado anterior
                                                     v_obs,
                                                     v_acceso_directo,
                                                     v_clase,
                                                     v_parametros_ad,
                                                     v_tipo_noti,
                                                     v_titulo );


                  --raise exception 'v_id_estado_actual %',v_id_estado_actual;
              --------------------------------------
              -- Registra los procesos disparados
              --------------------------------------
              for v_registros_proc in ( select * from json_populate_recordset(null::wf.proceso_disparado_wf, v_parametros.json_procesos::json)) loop

                  --Obtencion del codigo tipo proceso
                  select
                  tp.codigo
                  into
                  v_codigo_tipo_pro
                  from wf.ttipo_proceso tp
                  where tp.id_tipo_proceso =  v_registros_proc.id_tipo_proceso_pro;

                  --Disparar creacion de procesos seleccionados
                  select
                  ps_id_proceso_wf,
                  ps_id_estado_wf,
                  ps_codigo_estado
                  into
                  v_id_proceso_wf,
                  v_id_estado_wf,
                  v_codigo_estado
                  from wf.f_registra_proceso_disparado_wf(
                  p_id_usuario,
                  v_parametros._id_usuario_ai,
                  v_parametros._nombre_usuario_ai,
                  v_id_estado_actual,
                  v_registros_proc.id_funcionario_wf_pro,
                  v_registros_proc.id_depto_wf_pro,
                  v_registros_proc.obs_pro,
                  v_codigo_tipo_pro,
                  v_codigo_tipo_pro);

              end loop;

              if ras.f_fun_inicio_sol_vehiculo_wf(
                      v_parametros.id_sol_vehiculo,
                      p_id_usuario,
                      v_parametros._id_usuario_ai,
                      v_parametros._nombre_usuario_ai,
                      v_id_estado_actual,
                      v_id_proceso_wf,
                      v_codigo_estado_siguiente,
                      v_codigo_estado
                  ) then

              end if;
              -- si hay mas de un estado disponible  preguntamos al usuario
              v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado del pago simple id='||v_parametros.id_sol_vehiculo);
              v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');
              -- Devuelve la respuesta
              return v_resp;
          end;

      /*********************************
      #TRANSACCION:      'RAS_ANSOLVEH_IME'
      #DESCRIPCION:     Retrocede el estado proyectos
      #AUTOR:           EGS
      #FECHA:
      #ISSUE:
      ***********************************/

      elseif(p_transaccion='RAS_ANSOLVEH_IME')then

          begin
              --Obtenemos datos basicos
              select
              c.id_sol_vehiculo,
              ew.id_proceso_wf,
              c.id_estado_wf,
              c.estado
              into
              v_registros_proc
              from ras.tsol_vehiculo c
              inner join wf.testado_wf ew on ew.id_estado_wf = c.id_estado_wf
              where c.id_sol_vehiculo = v_parametros.id_sol_vehiculo;

           v_id_proceso_wf = v_registros_proc.id_proceso_wf;
           select
                ps_id_tipo_estado,
                ps_id_funcionario,
                ps_id_usuario_reg,
                ps_id_depto,
                ps_codigo_estado,
                ps_id_estado_wf_ant
              into
                v_id_tipo_estado,
                v_id_funcionario,
                v_id_usuario_reg,
                v_id_depto,
                v_codigo_estado,
                v_id_estado_wf_ant
              from wf.f_obtener_estado_ant_log_wf(v_parametros.id_estado_wf);

              --Configurar acceso directo para la alarma
                    v_acceso_directo = '';
                    v_clase = '';
                    v_parametros_ad = '';
                    v_tipo_noti = 'notificacion';
                    v_titulo  = 'Visto Bueno';

                    if v_codigo_estado_siguiente not in('borrador','finalizado','anulado') then

                        v_acceso_directo = '../../../sis_planillas/vista/licencia/Licencia.php';
                        v_clase = 'Licencia';
                        v_parametros_ad = '{filtro_directo:{campo:"lice.id_proceso_wf",valor:"'||v_id_proceso_wf::varchar||'"}}';
                        v_tipo_noti = 'notificacion';
                        v_titulo  = 'Visto Bueno';
                    end if;


                    --Registra nuevo estado
                    v_id_estado_actual = wf.f_registra_estado_wf(
                        v_id_tipo_estado,                --  id_tipo_estado al que retrocede
                        v_id_funcionario,                --  funcionario del estado anterior
                        v_parametros.id_estado_wf,       --  estado actual ...
                        v_id_proceso_wf,                 --  id del proceso actual
                        p_id_usuario,                    -- usuario que registra
                        v_parametros._id_usuario_ai,
                        v_parametros._nombre_usuario_ai,
                        v_id_depto,                       --depto del estado anterior
                        '[RETROCESO] '|| v_parametros.obs,
                        v_acceso_directo,
                        v_clase,
                        v_parametros_ad,
                        v_tipo_noti,
                        v_titulo);
                    --raise exception 'v_id_estado_actual %', v_id_estado_actual;
                    if not ras.f_fun_regreso_sol_vehiculo_wf(
                                                        v_parametros.id_sol_vehiculo,
                                                        p_id_usuario,
                                                        v_parametros._id_usuario_ai,
                                                        v_parametros._nombre_usuario_ai,
                                                        v_id_estado_actual,
                                                        v_parametros.id_proceso_wf,
                                                        v_codigo_estado) then

                        raise exception 'Error al retroceder estado';

                    end if;

              v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se realizo el cambio de estado de la solicitud de Licencia)');
              v_resp = pxp.f_agrega_clave(v_resp,'operacion','cambio_exitoso');

              --Devuelve la respuesta
              return v_resp;


    end;

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
COST 100;