CREATE OR REPLACE FUNCTION "ras"."ft_positions_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Traccar
 FUNCION: 		ras.ft_positions_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.positions'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 20:34:23
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

    v_nombre_funcion = 'ras.ft_positions_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:23
	***********************************/

	if(p_transaccion='PB_POSIC_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into positions(
			address,
			devicetime,
			accuracy,
			course,
			altitude,
			protocol,
			speed,
			network,
			servertime,
			longitude,
			valid,
			deviceid,
			attributes,
			latitude,
			fixtime
          	) values(
			v_parametros.address,
			v_parametros.devicetime,
			v_parametros.accuracy,
			v_parametros.course,
			v_parametros.altitude,
			v_parametros.protocol,
			v_parametros.speed,
			v_parametros.network,
			v_parametros.servertime,
			v_parametros.longitude,
			v_parametros.valid,
			v_parametros.deviceid,
			v_parametros.attributes,
			v_parametros.latitude,
			v_parametros.fixtime
			)RETURNING id into v_id;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Posiciones almacenado(a) con exito (id'||v_id||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_id::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:23
	***********************************/

	elsif(p_transaccion='PB_POSIC_MOD')then

		begin
			--Sentencia de la modificacion
			update positions set
			address = v_parametros.address,
			devicetime = v_parametros.devicetime,
			accuracy = v_parametros.accuracy,
			course = v_parametros.course,
			altitude = v_parametros.altitude,
			protocol = v_parametros.protocol,
			speed = v_parametros.speed,
			network = v_parametros.network,
			servertime = v_parametros.servertime,
			longitude = v_parametros.longitude,
			valid = v_parametros.valid,
			deviceid = v_parametros.deviceid,
			attributes = v_parametros.attributes,
			latitude = v_parametros.latitude,
			fixtime = v_parametros.fixtime
			where id=v_parametros.id;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Posiciones modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id',v_parametros.id::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'PB_POSIC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 20:34:23
	***********************************/

	elsif(p_transaccion='PB_POSIC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from positions
            where id=v_parametros.id;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Posiciones eliminado(a)'); 
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
ALTER FUNCTION "ras"."ft_positions_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
