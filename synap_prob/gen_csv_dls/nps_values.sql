SELECT 
    tr1.type_name_new AS source_name,
    tr1.type_id AS source_id,
    tr2.type_name_new AS target_name,
    tr2.type_id AS target_id,
    NPS_mean_total AS number_of_potential_synapses_mean,
    IF(NPS_stdev_total!=0,NPS_stdev_total,'N/A') AS number_of_potential_synapses_stdev
FROM
    SynproTypeTypeRel AS tr1,
    SynproTypeTypeRel AS tr2,
    SynproTotalNPS AS nps
WHERE
    tr1.type_id = nps.source_id
AND tr2.type_id = nps.target_id
ORDER BY tr1.id , tr2.id;