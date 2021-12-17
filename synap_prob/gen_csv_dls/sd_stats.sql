# Note: cast as decimal is used here because the csv2db code imported the values as text columns
# and not decimals. Decimals are needed to correctly find min() and max() values. The decimal(10,2)
# setting is used to have 2 digits after the decimal place, which is wanted for synaptic distances.
CREATE VIEW SynProSDStats AS SELECT 
	GROUP_CONCAT(DISTINCT hippocampome_neuronal_class) as hippocampome_neuronal_class,
	GROUP_CONCAT(DISTINCT unique_id) as unique_id,
	GROUP_CONCAT(DISTINCT neurite) as neurite,
	GROUP_CONCAT(DISTINCT neurite_id) as neurite_id,
	CAST(STD(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_sd, 
	CAST(AVG(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, 
	CAST(COUNT(CAST(avg_path_length AS DECIMAL(10))) AS DECIMAL(10)) AS count_sd, 
	CAST(AVG(CAST(avg_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg_trunk, 
	CAST(MIN(CAST(min_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS min_sd, 
	CAST(MAX(CAST(max_path_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS max_sd
FROM neurite_quantified 
WHERE avg_path_length!='' AND avg_path_length!=0 AND neurite NOT LIKE '%:All:A'
AND neurite NOT LIKE '%:All:D'
GROUP BY neurite, hippocampome_neuronal_class limit 50000;