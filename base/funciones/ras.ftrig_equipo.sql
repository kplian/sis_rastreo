CREATE OR REPLACE FUNCTION ras.ftrig_equipo (
)
RETURNS trigger AS
$body$
DECLARE

	v_id integer;

BEGIN

	IF (TG_OP = 'DELETE') THEN
        delete from devices where uniqueid = OLD.uniqueid;
        RETURN NULL;
    ELSIF (TG_OP = 'UPDATE') THEN
        update devices set
        name = NEW.placa
        where uniqueid = OLD.uniqueid;
        RETURN NULL;
    ELSIF (TG_OP = 'INSERT') THEN
        insert into devices(
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
		NEW.uniqueid,
		NULL,
		NULL,
		now(),
		NULL,
		NULL,
		NULL,
		NEW.placa,
		NULL,
		NULL
		);
        RETURN NEW;
    END IF;
    RETURN NULL; 

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

/*
CREATE TRIGGER tg_equipo
  AFTER INSERT OR UPDATE OR DELETE 
  ON ras.tequipo FOR EACH ROW 
  EXECUTE PROCEDURE ras.ftrig_equipo();*/