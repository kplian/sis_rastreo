--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_grupo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_grupo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tgrupo'
 AUTOR: 		 (admin)
 FECHA:	        24-07-2017 08:28:12
 COMENTARIOS:
***************************************************************************

 HISTORIAL DE MODIFICACIONES:
 ISUUE			FECHA			 AUTHOR 		 DESCRIPCION
 * #6			19/09/2019		  JUAN		     Agregado de funcinalidad para el registro de vehiculos asociados a una regionales y grupos

***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_grupo	integer;

BEGIN

    v_nombre_funcion = 'ras.ft_grupo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'RAS_GRUPO_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin
 	#FECHA:		24-07-2017 08:28:12
	***********************************/

	if(p_transaccion='RAS_GRUPO_INS')then

        begin
        	--Sentencia de la insercion
        	insert into ras.tgrupo(
			codigo,
			nombre,
			color,
			fecha_reg,
			fecha_mod,
			estado_reg,
			id_usuario_reg,
			id_usuario_mod,
			id_usuario_ai,
            id_depto
          	) values(
			v_parametros.codigo,
			v_parametros.nombre,
			v_parametros.color,
			now(),
			null,
			'activo',
			p_id_usuario,
			null,
			v_parametros._id_usuario_ai,
            v_parametros.id_depto --#6
			) returning id_grupo into v_id_grupo;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Grupo almacenado(a) con exito (id_grupo'||v_id_grupo||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_grupo',v_id_grupo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'RAS_GRUPO_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin
 	#FECHA:		24-07-2017 08:28:12
	***********************************/

	elsif(p_transaccion='RAS_GRUPO_MOD')then

		begin
			--Sentencia de la modificacion
			update ras.tgrupo set
			codigo = v_parametros.codigo,
			nombre = v_parametros.nombre,
			color = v_parametros.color,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            id_depto = v_parametros.id_depto --#6
			where id_grupo=v_parametros.id_grupo;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Grupo modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_grupo',v_parametros.id_grupo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'RAS_GRUPO_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin
 	#FECHA:		24-07-2017 08:28:12
	***********************************/

	elsif(p_transaccion='RAS_GRUPO_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ras.tgrupo
            where id_grupo=v_parametros.id_grupo;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Grupo eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_grupo',v_parametros.id_grupo::varchar);

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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;