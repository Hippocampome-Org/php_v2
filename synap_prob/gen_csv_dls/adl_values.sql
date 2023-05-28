SELECT SynProADLStats.hippocampome_neuronal_class as neuron, unique_id, SynProADLStats.neurite as parcel, 
neurite_id, SynProADLStats.`avg` as total_length_avg, std_tl as total_length_std, 
count_tl as total_length_values_count FROM SynProADLStats, SynproTypeTypeRel, SynProNetlistParcels
WHERE SynProADLStats.unique_id=SynproTypeTypeRel.type_id
AND SynProADLStats.neurite=SynProNetlistParcels.parcel
ORDER BY SynproTypeTypeRel.id, SynProNetlistParcels.id;