CREATE OR REPLACE FUNCTION ras.f_get_time (
  p_fecha_hora_ini timestamp,
  p_fecha_hora_fin timestamp
)
RETURNS varchar AS
$body$
DECLARE

	v_time double precision;
    v_time_entero double precision;
    v_time_entero1 double precision;
    v_time_entero2 double precision;
    v_min varchar = 'mins.';
    v_hora varchar = 'hrs.';
    v_dias varchar = 'dias';
    v_resp varchar;

BEGIN

	--Se obtiene la diferncia en minutos entre las dos fechas
	v_time = (DATE_PART('day', p_fecha_hora_fin - p_fecha_hora_ini) * 24 + 
        DATE_PART('hour', p_fecha_hora_fin - p_fecha_hora_ini)) * 60 +
        DATE_PART('minute', p_fecha_hora_fin - p_fecha_hora_ini);
        
    if v_time > 59 then
    	v_time_entero = trunc(v_time/60); --horas

        if v_time_entero >= 24 then
        	--Dias
			v_time_entero1 = trunc(v_time_entero/24); --dias
            v_time_entero2 = round((((v_time_entero/24)-v_time_entero1)*24)::numeric,2);
            v_resp = v_time_entero1 || ' ' || v_dias || ' ' || v_time_entero2 || ' ' || v_hora;            
        else
        	--Horas
            v_time_entero1 = round((((v_time/60) - v_time_entero)*60)::numeric,2); --minutos
            v_resp = v_time_entero || ' ' || v_hora || ' ' || v_time_entero1 || ' ' || v_min;
        end if;
    else
    	--Minutos
        v_resp = v_time::varchar || ' ' ||v_min;
    end if;

	return v_resp;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;