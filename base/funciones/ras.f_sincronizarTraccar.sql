CREATE OR REPLACE FUNCTION ras.f_sincronizartraccar (
  id varchar,
  imei varchar,
  placa varchar,
  evento varchar
)
RETURNS boolean AS
$body$
DECLARE
v_nombre_funcion      text;
v_resp		        varchar;
v_respuesta         varchar;
BEGIN

    v_nombre_funcion = 'ras.f_sincronizarTraccar';
    --validar que el plan de pago no estado finalizado

SELECT * into v_respuesta FROM  dblink_connect('dbetr','hostaddr=172.18.78.51 port=5432 dbname=dbetr user=postgres password=postgres');
SELECT * into v_respuesta  FROM dblink_exec('dbetr','BEGIN');

IF(evento='insert')then
SELECT *
into
    v_respuesta
FROM dblink_exec('dbetr','insert into public.tc_devices(
              uniqueid,
              phone,
              groupid,
              lastupdate,
              model,
              attributes,
              contact,
              name,
              category,
              positionid
                ) values(
              '''||imei||''',
              NULL,
              NULL,
              now(),
              NULL,
              NULL,
              NULL,
              '''||placa||''',
              NULL,
              NULL
              );');
end if;

    IF(evento='update')then
SELECT *
into
    v_respuesta
from dblink_exec('dbetr','update public.tc_devices set
            name = '''||placa||''',
            uniqueid = '''||imei||'''
            where uniqueid = '''||id||''';');
end if;

    IF(evento='delete')then
SELECT *
into
    v_respuesta
from  dblink_exec('dbetr',' delete from public.tc_devices where uniqueid = '''||id||''';');
end if;

SELECT *
into
    v_respuesta
FROM dblink_exec('dbetr','COMMIT');

SELECT *
into
    v_respuesta
FROM dblink_disconnect('dbetr');

return TRUE;

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