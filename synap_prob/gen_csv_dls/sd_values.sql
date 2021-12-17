SELECT 
    SynProSDStats.hippocampome_neuronal_class AS neuron,
    unique_id,
    SynProSDStats.neurite AS parcel,
    neurite_id,
    SynProSDStats.`avg` AS somatic_distance_avg,
    std_sd AS somatic_distance_std,
    count_sd AS somatic_distance_values_count,
    min_sd AS somatic_distance_min,
    max_sd AS somatic_distance_max
FROM
    SynProSDStats,
    SynproTypeTypeRel,
    SynProNetlistParcels
WHERE
    SynProSDStats.unique_id = SynproTypeTypeRel.type_id
	AND SynProSDStats.neurite = SynProNetlistParcels.parcel
ORDER BY SynproTypeTypeRel.id , SynProNetlistParcels.id;