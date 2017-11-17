CREATE OR REPLACE FUNCTION ras.f_get_evento_ultimo (
  p_id_equipo INTEGER
)
RETURNS integer AS
$body$
/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.f_get_evento_ultimo
 DESCRIPCION:   Devuelve el id evento del ultimo encontrado
 AUTOR: 		RCM
 FECHA:	        19/07/2017
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
    v_eventoid	     		integer;

BEGIN

	v_nombre_funcion = 'ras.f_get_evento_ultimo';

	select
    ev.id
    into v_eventoid
    from ras.tequipo eq
    inner join devices dev
    on dev.uniqueid = eq.uniqueid
    inner join events ev
    on ev.deviceid = dev.id
    where eq.id_equipo = p_id_equipo
    order by ev.servertime desc
    limit 1;
    
    return v_eventoid;
    
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
