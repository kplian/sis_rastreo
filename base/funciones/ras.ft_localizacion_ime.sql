CREATE OR REPLACE FUNCTION "ras"."ft_localizacion_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_localizacion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tlocalizacion'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:13
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
	v_id_localizacion		integer;
	v_id_localizacion_fk	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_localizacion_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_LOCAL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:13
	***********************************/

	if(p_transaccion='RAS_LOCAL_INS')then
					
        begin

        	if v_parametros.id_localizacion_fk = 'id' then
        		v_id_localizacion_fk = null;
        	else 
        		v_id_localizacion_fk = v_parametros.id_localizacion_fk::integer;
        	end if;

        	--Sentencia de la insercion
        	insert into ras.tlocalizacion(
			estado_reg,
			nombre,
			codigo,
			latitud,
			longitud,
			id_localizacion_fk,
			fecha_reg,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.nombre,
			v_parametros.codigo,
			v_parametros.latitud,
			v_parametros.longitud,
			v_id_localizacion_fk,
			now(),
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_localizacion into v_id_localizacion;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Areas almacenado(a) con exito (id_localizacion'||v_id_localizacion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_localizacion',v_id_localizacion::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_LOCAL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:13
	***********************************/

	elsif(p_transaccion='RAS_LOCAL_MOD')then

		begin
			if v_parametros.id_localizacion_fk = 'id' then
        		v_id_localizacion_fk = null;
        	else 
        		v_id_localizacion_fk = v_parametros.id_localizacion_fk::integer;
        	end if;

			--Sentencia de la modificacion
			update ras.tlocalizacion set
			nombre = v_parametros.nombre,
			codigo = v_parametros.codigo,
			latitud = v_parametros.latitud,
			longitud = v_parametros.longitud,
			id_localizacion_fk = v_id_localizacion_fk,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_localizacion=v_parametros.id_localizacion;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Areas modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_localizacion',v_parametros.id_localizacion::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_LOCAL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:13
	***********************************/

	elsif(p_transaccion='RAS_LOCAL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tlocalizacion
            where id_localizacion=v_parametros.id_localizacion;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Areas eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_localizacion',v_parametros.id_localizacion::varchar);
              
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
ALTER FUNCTION "ras"."ft_localizacion_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
