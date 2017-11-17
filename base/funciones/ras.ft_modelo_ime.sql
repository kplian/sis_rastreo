CREATE OR REPLACE FUNCTION "ras"."ft_modelo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_modelo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tmodelo'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:49:58
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
	v_id_modelo	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_modelo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_MODEL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:58
	***********************************/

	if(p_transaccion='RAS_MODEL_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.tmodelo(
			id_marca,
			estado_reg,
			codigo,
			nombre,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_marca,
			'activo',
			v_parametros.codigo,
			v_parametros.nombre,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_modelo into v_id_modelo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Modelo almacenado(a) con exito (id_modelo'||v_id_modelo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_modelo',v_id_modelo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_MODEL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:58
	***********************************/

	elsif(p_transaccion='RAS_MODEL_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tmodelo set
			id_marca = v_parametros.id_marca,
			codigo = v_parametros.codigo,
			nombre = v_parametros.nombre,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_modelo=v_parametros.id_modelo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Modelo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_modelo',v_parametros.id_modelo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_MODEL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:58
	***********************************/

	elsif(p_transaccion='RAS_MODEL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tmodelo
            where id_modelo=v_parametros.id_modelo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Modelo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_modelo',v_parametros.id_modelo::varchar);
              
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
ALTER FUNCTION "ras"."ft_modelo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
