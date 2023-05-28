CREATE VIEW SynProADLStats AS 
SELECT 
GROUP_CONCAT(DISTINCT hippocampome_neuronal_class) as hippocampome_neuronal_class, 
GROUP_CONCAT(DISTINCT unique_id) as unique_id, 
GROUP_CONCAT(DISTINCT neurite) as neurite, 
GROUP_CONCAT(DISTINCT neurite_id) as neurite_id, 
CAST(STD(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS std_tl, 
CAST(AVG(CAST(filtered_total_length AS DECIMAL(10,2))) AS DECIMAL(10,2)) AS avg, 
CAST(COUNT(CAST(filtered_total_length AS DECIMAL(10))) AS DECIMAL(10)) AS count_tl
FROM neurite_quantified 
WHERE filtered_total_length!='' AND filtered_total_length!=0 AND neurite NOT LIKE '%:All:A'
AND neurite NOT LIKE '%:All:D'
GROUP BY neurite, hippocampome_neuronal_class limit 50000;