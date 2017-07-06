CREATE OR REPLACE FUNCTION "ras"."ft_equipo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_equipo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tequipo'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:17
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
	v_id_equipo	integer;
			    
BEGIN

    v_nombre_funcion = 'ras.ft_equipo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'RAS_EQUIP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:17
	***********************************/

	if(p_transaccion='RAS_EQUIP_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ras.tequipo(
			id_tipo_equipo,
			id_modelo,
			id_localizacion,
			nro_motor,
			placa,
			estado,
			nro_movil,
			fecha_alta,
			cabina,
			estado_reg,
			propiedad,
			nro_chasis,
			cilindrada,
			color,
			pta,
			traccion,
			gestion,
			fecha_baja,
			monto,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod,
			uniqueid
          	) values(
			v_parametros.id_tipo_equipo,
			v_parametros.id_modelo,
			v_parametros.id_localizacion,
			v_parametros.nro_motor,
			v_parametros.placa,
			v_parametros.estado,
			v_parametros.nro_movil,
			v_parametros.fecha_alta,
			v_parametros.cabina,
			'activo',
			v_parametros.propiedad,
			v_parametros.nro_chasis,
			v_parametros.cilindrada,
			v_parametros.color,
			v_parametros.pta,
			v_parametros.traccion,
			v_parametros.gestion,
			v_parametros.fecha_baja,
			v_parametros.monto,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null,
			v_parametros.uniqueid			
			)RETURNING id_equipo into v_id_equipo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vehiculos almacenado(a) con exito (id_equipo'||v_id_equipo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_id_equipo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'RAS_EQUIP_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:17
	***********************************/

	elsif(p_transaccion='RAS_EQUIP_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tequipo set
			id_tipo_equipo = v_parametros.id_tipo_equipo,
			id_modelo = v_parametros.id_modelo,
			id_localizacion = v_parametros.id_localizacion,
			nro_motor = v_parametros.nro_motor,
			placa = v_parametros.placa,
			estado = v_parametros.estado,
			nro_movil = v_parametros.nro_movil,
			fecha_alta = v_parametros.fecha_alta,
			cabina = v_parametros.cabina,
			propiedad = v_parametros.propiedad,
			nro_chasis = v_parametros.nro_chasis,
			cilindrada = v_parametros.cilindrada,
			color = v_parametros.color,
			pta = v_parametros.pta,
			traccion = v_parametros.traccion,
			gestion = v_parametros.gestion,
			fecha_baja = v_parametros.fecha_baja,
			monto = v_parametros.monto,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
			uniqueid = v_parametros.uniqueid
			where id_equipo=v_parametros.id_equipo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vehiculos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_parametros.id_equipo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'RAS_EQUIP_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-06-2017 17:50:17
	***********************************/

	elsif(p_transaccion='RAS_EQUIP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tequipo
            where id_equipo=v_parametros.id_equipo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Vehiculos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_equipo',v_parametros.id_equipo::varchar);
              
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
ALTER FUNCTION "ras"."ft_equipo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
