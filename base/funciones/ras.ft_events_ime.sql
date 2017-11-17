CREATE OR REPLACE FUNCTION "ras"."ft_events_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.ft_events_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.events'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 20:34:28
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_events_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PB_EVENT_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:28
	***********************************/

	if(p_transaccion='PB_EVENT_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into events(
			geofenceid,
			deviceid,
			servertime,
			attributes,
			type,
			positionid
          	) values(
			v_parametros.geofenceid,
			v_parametros.deviceid,
			v_parametros.servertime,
			v_parametros.attributes,
			v_parametros.type,
			v_parametros.positionid
			)RETURNING id into v_id;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos almacenado(a) con exito (id'||v_id||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_id::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_EVENT_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:28
	***********************************/

	elsif(p_transaccion='PB_EVENT_MOD')then

		begin
			--Sentencia de la modificacion
			update events set
			geofenceid = v_parametros.geofenceid,
			deviceid = v_parametros.deviceid,
			servertime = v_parametros.servertime,
			attributes = v_parametros.attributes,
			type = v_parametros.type,
			positionid = v_parametros.positionid
			where id=v_parametros.id;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_parametros.id::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'PB_EVENT_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:28
	***********************************/

	elsif(p_transaccion='PB_EVENT_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from events
            where id=v_parametros.id;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_parametros.id::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ras"."ft_events_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
