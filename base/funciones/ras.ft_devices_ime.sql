CREATE OR REPLACE FUNCTION "ras"."ft_devices_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.ft_devices_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'public.devices'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 20:34:33
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

    v_nombre_funcion = 'ras.ft_devices_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PB_DISP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:33
	***********************************/

	if(p_transaccion='PB_DISP_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into devices(
			uniqueid,
			phone,
			groupid,
			lastupdate,
			model,
			attributes,
			contact,
			name,
			category,
			positionid
          	) values(
			v_parametros.uniqueid,
			v_parametros.phone,
			v_parametros.groupid,
			v_parametros.lastupdate,
			v_parametros.model,
			v_parametros.attributes,
			v_parametros.contact,
			v_parametros.name,
			v_parametros.category,
			v_parametros.positionid
			)RETURNING id into v_id;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Dispositivos almacenado(a) con exito (id'||v_id||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_id::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_DISP_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:33
	***********************************/

	elsif(p_transaccion='PB_DISP_MOD')then

		begin
			--Sentencia de la modificacion
			update devices set
			uniqueid = v_parametros.uniqueid,
			phone = v_parametros.phone,
			groupid = v_parametros.groupid,
			lastupdate = v_parametros.lastupdate,
			model = v_parametros.model,
			attributes = v_parametros.attributes,
			contact = v_parametros.contact,
			name = v_parametros.name,
			category = v_parametros.category,
			positionid = v_parametros.positionid
			where id=v_parametros.id;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Dispositivos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_parametros.id::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'PB_DISP_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:33
	***********************************/

	elsif(p_transaccion='PB_DISP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from devices
            where id=v_parametros.id;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Dispositivos eliminado(a)'); 
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
ALTER FUNCTION "ras"."ft_devices_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
