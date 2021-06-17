/********************************************I-DAUP-AUTOR-SCHEMA-0-31/02/2019********************************************/
--SHEMA : Esquema (CONTA) contabilidad         AUTHOR:Siglas del autor de los scripts' dataupdate000001.txt
/********************************************F-DAUP-AUTOR-SCHEMA-0-31/02/2019********************************************/

/********************************************I-DAUP-AUTOR-RAS-ETR-4275-17/06/2021********************************************/
--SHEMA : Esquema (CONTA) contabilidad         AUTHOR:Siglas del autor de los scripts' dataupdate000001.txt
-- update ras.tsol_vehiculo Set
--     fecha_sol = '14/06/2021'
-- Where id_sol_vehiculo = 45;
-- update ras.tsol_vehiculo Set
--     fecha_sol = '15/06/2021'
-- Where id_sol_vehiculo = 35;

update ras.tsol_vehiculo Set
    fecha_sol = fecha_salida
Where id_sol_vehiculo = 45;
update ras.tsol_vehiculo Set
    fecha_sol = fecha_salida
Where id_sol_vehiculo = 35;
/********************************************F-DAUP-AUTOR-RAS-ETR-4275-17/06/2021********************************************/