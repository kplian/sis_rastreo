--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ras.ft_responsable_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Rastreo Satelital
 FUNCION: 		ras.ft_responsable_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ras.tresponsable'
 AUTOR: 		 (admin)
 FECHA:	        15-06-2017 17:50:03
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
	v_id_responsable	integer;

BEGIN

    v_nombre_funcion = 'ras.ft_responsable_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'RAS_CONDUC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin
 	#FECHA:		15-06-2017 17:50:03
	***********************************/

	if(p_transaccion='RAS_CONDUC_INS')then

begin
        	--Sentencia de la insercion
insert into ras.tresponsable(
    id_persona,
    estado_reg,
    codigo,
    id_usuario_reg,
    usuario_ai,
    fecha_reg,
    id_usuario_ai,
    fecha_mod,
    id_usuario_mod,
    tipo_responsable
) values(
            v_parametros.id_persona,
            'activo',
            v_parametros.codigo,
            p_id_usuario,
            v_parametros._nombre_usuario_ai,
            now(),
            v_parametros._id_usuario_ai,
            null,
            null,
            v_parametros.tipo_responsable



        )RETURNING id_responsable into v_id_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores almacenado(a) con exito (id_responsable'||v_id_responsable||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_responsable',v_id_responsable::varchar);

            --Devuelve la respuesta
return v_resp;

end;

	/*********************************
 	#TRANSACCION:  'RAS_CONDUC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin
 	#FECHA:		15-06-2017 17:50:03
	***********************************/

	elsif(p_transaccion='RAS_CONDUC_MOD')then

begin
			--Sentencia de la modificacion
update ras.tresponsable set
                            id_persona = v_parametros.id_persona,
                            codigo = v_parametros.codigo,
                            fecha_mod = now(),
                            id_usuario_mod = p_id_usuario,
                            id_usuario_ai = v_parametros._id_usuario_ai,
    usuario_ai = v_parametros._nombre_usuario_ai,
    tipo_responsable = v_parametros.tipo_responsable
where id_responsable=v_parametros.id_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_responsable',v_parametros.id_responsable::varchar);

            --Devuelve la respuesta
return v_resp;

end;

	/*********************************
 	#TRANSACCION:  'RAS_CONDUC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin
 	#FECHA:		15-06-2017 17:50:03
	***********************************/

	elsif(p_transaccion='RAS_CONDUC_ELI')then

begin
			--Sentencia de la eliminacion
delete from ras.tresponsable
where id_responsable=v_parametros.id_responsable;

--Definicion de la respuesta
v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Conductores eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_responsable',v_parametros.id_responsable::varchar);

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
PARALLEL UNSAFE
COST 100;