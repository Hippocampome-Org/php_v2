SELECT 
    tr1.type_name_new AS source_name,
    tr1.type_id AS source_id,
    tr2.type_name_new AS target_name,
    tr2.type_id AS target_id,
    NC_mean_total AS number_of_contacts_mean,
    IF(NC_stdev_total!=0,NC_stdev_total,'N/A') AS number_of_contacts_stdev
FROM
    SynproTypeTypeRel AS tr1,
    SynproTypeTypeRel AS tr2,
    SynproTotalNOC AS noc
WHERE
    tr1.type_id = noc.source_id
AND tr2.type_id = noc.target_id
ORDER BY tr1.id , tr2.id;