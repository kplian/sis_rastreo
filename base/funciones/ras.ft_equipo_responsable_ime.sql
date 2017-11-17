CREATE OR REPLACE FUNCTION "ras"."ft_equipo_responsable_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_equipo_responsable_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tequipo_responsable'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:22
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
	v_id_equipo_responsable	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_equipo_responsable_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_EQUCON_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:22
	***********************************/

	if(p_transaccion='RAS_EQUCON_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.tequipo_responsable(
			estado_reg,
			id_responsable,
			fecha_fin,
			fecha_ini,
			id_equipo,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.id_responsable,
			v_parametros.fecha_fin,
			v_parametros.fecha_ini,
			v_parametros.id_equipo,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_equipo_responsable into v_id_equipo_responsable;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores almacenado(a) con exito (id_equipo_responsable'||v_id_equipo_responsable||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_id_equipo_responsable::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_EQUCON_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:22
	***********************************/

	elsif(p_transaccion='RAS_EQUCON_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tequipo_responsable set
			id_responsable = v_parametros.id_responsable,
			fecha_fin = v_parametros.fecha_fin,
			fecha_ini = v_parametros.fecha_ini,
			id_equipo = v_parametros.id_equipo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_equipo_responsable=v_parametros.id_equipo_responsable;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_parametros.id_equipo_responsable::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_EQUCON_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:22
	***********************************/

	elsif(p_transaccion='RAS_EQUCON_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tequipo_responsable
            where id_equipo_responsable=v_parametros.id_equipo_responsable;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo_responsable',v_parametros.id_equipo_responsable::varchar);
              
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
ALTER FUNCTION "ras"."ft_equipo_responsable_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
