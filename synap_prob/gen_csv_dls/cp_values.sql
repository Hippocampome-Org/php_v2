SELECT 
    tr1.type_name_new AS source_name,
    tr1.type_id AS source_id,
    tr2.type_name_new AS target_name,
    tr2.type_id AS target_id,
    CP_mean_total AS synaptic_probabilties_mean,
    IF(CP_stdev_total!=0,CP_stdev_total,'N/A') AS synaptic_probabilties_stdev
FROM
    SynproTypeTypeRel AS tr1,
    SynproTypeTypeRel AS tr2,
    SynproTotalCP AS cp
WHERE
    tr1.type_id = cp.source_id
AND tr2.type_id = cp.target_id
ORDER BY tr1.id , tr2.id;