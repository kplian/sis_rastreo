CREATE OR REPLACE FUNCTION "ras"."ft_tipo_equipo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_tipo_equipo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.ttipo_equipo'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:49:49
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
	v_id_tipo_equipo	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_tipo_equipo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_TIPVEH_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:49
	***********************************/

	if(p_transaccion='RAS_TIPVEH_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.ttipo_equipo(
			estado_reg,
			nombre,
			codigo,
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
			now(),
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tipo_equipo into v_id_tipo_equipo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Vehiculo almacenado(a) con exito (id_tipo_equipo'||v_id_tipo_equipo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_equipo',v_id_tipo_equipo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_TIPVEH_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:49
	***********************************/

	elsif(p_transaccion='RAS_TIPVEH_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.ttipo_equipo set
			nombre = v_parametros.nombre,
			codigo = v_parametros.codigo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_equipo=v_parametros.id_tipo_equipo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Vehiculo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_equipo',v_parametros.id_tipo_equipo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_TIPVEH_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:49:49
	***********************************/

	elsif(p_transaccion='RAS_TIPVEH_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.ttipo_equipo
            where id_tipo_equipo=v_parametros.id_tipo_equipo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Vehiculo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_equipo',v_parametros.id_tipo_equipo::varchar);
              
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
ALTER FUNCTION "ras"."ft_tipo_equipo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
