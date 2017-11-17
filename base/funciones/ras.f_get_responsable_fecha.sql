CREATE OR REPLACE FUNCTION ras.f_get_responsable_fecha (
  p_id_equipo INTEGER,
  p_fecha DATE
)
RETURNS integer AS
$body$
/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.f_get_responsable_fecha
 DESCRIPCION:   Devuelve el id persona del responsable a una fecha especifica
 AUTOR: 		RCM
 FECHA:	        17/07/2017
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/
DECLARE

	v_resp		            varchar;
	v_nombre_funcion        text;
    v_id_persona			integer;

BEGIN

	v_nombre_funcion = 'ras.f_get_responsable_fecha';

	select
    res.id_persona
    into v_id_persona
    from ras.vequipo eq
    left join ras.tequipo_responsable eres
    on eres.id_equipo = eq.id_equipo
    and p_fecha between eres.fecha_ini and eres.fecha_fin
    left join ras.tresponsable res
    on res.id_responsable = eres.id_responsable
    where eq.id_equipo = p_id_equipo
    order by eres.id_equipo_responsable desc
    limit 1;
    
    return v_id_persona;
    
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
SECURITY INVOKER;