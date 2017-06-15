CREATE OR REPLACE FUNCTION "ras"."ft_licencia_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_licencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tlicencia'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:08
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
	v_id_licencia	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_licencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_LICEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:08
	***********************************/

	if(p_transaccion='RAS_LICEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.tlicencia(
			estado_reg,
			calificacion_curso,
			id_responsable,
			fecha_autoriz,
			fecha_curso,
			nro_licencia,
			fecha_exp,
			tipo,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.calificacion_curso,
			v_parametros.id_responsable,
			v_parametros.fecha_autoriz,
			v_parametros.fecha_curso,
			v_parametros.nro_licencia,
			v_parametros.fecha_exp,
			v_parametros.tipo,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_licencia into v_id_licencia;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Licencias almacenado(a) con exito (id_licencia'||v_id_licencia||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_licencia',v_id_licencia::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_LICEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:08
	***********************************/

	elsif(p_transaccion='RAS_LICEN_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tlicencia set
			calificacion_curso = v_parametros.calificacion_curso,
			id_responsable = v_parametros.id_responsable,
			fecha_autoriz = v_parametros.fecha_autoriz,
			fecha_curso = v_parametros.fecha_curso,
			nro_licencia = v_parametros.nro_licencia,
			fecha_exp = v_parametros.fecha_exp,
			tipo = v_parametros.tipo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_licencia=v_parametros.id_licencia;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Licencias modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_licencia',v_parametros.id_licencia::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_LICEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:08
	***********************************/

	elsif(p_transaccion='RAS_LICEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tlicencia
            where id_licencia=v_parametros.id_licencia;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Licencias eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_licencia',v_parametros.id_licencia::varchar);
              
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
ALTER FUNCTION "ras"."ft_licencia_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
