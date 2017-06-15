CREATE OR REPLACE FUNCTION "ras"."ft_marca_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_marca_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tmarca'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:49:54
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
	v_id_marca	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_marca_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_MARCA_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:54
	***********************************/

	if(p_transaccion='RAS_MARCA_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.tmarca(
			procedencia,
			estado_reg,
			nombre,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.procedencia,
			'activo',
			v_parametros.nombre,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_marca into v_id_marca;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Marca almacenado(a) con exito (id_marca'||v_id_marca||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_marca',v_id_marca::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_MARCA_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:54
	***********************************/

	elsif(p_transaccion='RAS_MARCA_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tmarca set
			procedencia = v_parametros.procedencia,
			nombre = v_parametros.nombre,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_marca=v_parametros.id_marca;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Marca modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_marca',v_parametros.id_marca::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_MARCA_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:54
	***********************************/

	elsif(p_transaccion='RAS_MARCA_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tmarca
            where id_marca=v_parametros.id_marca;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Marca eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_marca',v_parametros.id_marca::varchar);
              
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
ALTER FUNCTION "ras"."ft_marca_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
