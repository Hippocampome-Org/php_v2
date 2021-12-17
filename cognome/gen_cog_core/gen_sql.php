<!--
	Generate SQL for Cognome core
-->
<html>
<?php
	$cog_core_db = "cognome_core";
	$art_file = "remove_articles.sql";
	$aut_file = "remove_authors.sql";
	$det_file = "remove_details.sql";
	$impl_file = "remove_implementations.sql";
	$kwd_file = "remove_keywords.sql";
	$nrn_file = "remove_neurons.sql";
	$reg_file = "remove_regions.sql";
	$scl_file = "remove_scales.sql";
	$sub_file = "remove_subjects.sql";
	$subevi_file = "remove_subjects_evi.sql";
	$thr_file = "remove_theories.sql";
	$all_files = array($art_file, $aut_file, $det_file, $impl_file, $kwd_file, $nrn_file, $reg_file, $scl_file, $sub_file, $subevi_file, $thr_file);
	$ids_for_removal = array(1,2,3,4,5,6,7,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,41,42,43,44,60,61,62,63,64,65,67,68,69,70,73,76,77,78,79,81,82,89,90,91,92,93,94,95,313,96,97,98,99,100,101,102,103,104,105,106,107,108,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,138,139,140,141,142,144,146,147,148,149,150,152,153,154,155,156,157,159,161,162,163,164,165,166,167,168,170,171,172,173,174,175,176,177,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,205,206,207,208,209,210,211,212,213,214,215,216,217,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,249,250,251,252,253,254,256,257,258,259,260,261,262,263,264,265,266,267,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,289,290,291,292,293,294,295,296,297,298,299,300,302,303,304,305,306,307,308,309,310,311,314,315,316,317,321,322,323,324,325,326,327,328,333,337,338,339,344,349,350,351,352,355,356,362,363,381,394,398,408,410,429);

	/* articles */
	// clear files
	for ($i = 0; $i < count($all_files); $i++) {
		$file = fopen($all_files[$i], 'w') or die("Can't open file.");
		fclose($file);
	}
	// open in append mode
	$out_art = fopen($art_file, 'a') or die("Can't open file.");
	$out_aut = fopen($aut_file, 'a') or die("Can't open file.");
	$out_det = fopen($det_file, 'a') or die("Can't open file.");
	$out_impl = fopen($impl_file, 'a') or die("Can't open file.");
	$out_kwd = fopen($kwd_file, 'a') or die("Can't open file.");
	$out_nrn = fopen($nrn_file, 'a') or die("Can't open file.");
	$out_reg = fopen($reg_file, 'a') or die("Can't open file.");
	$out_scl = fopen($scl_file, 'a') or die("Can't open file.");
	$out_sub = fopen($sub_file, 'a') or die("Can't open file.");
	$out_subevi = fopen($subevi_file, 'a') or die("Can't open file.");
	$out_thr = fopen($thr_file, 'a') or die("Can't open file.");

	for ($i = 0; $i < count($ids_for_removal); $i++) {
		$id = $ids_for_removal[$i];

		$line = "DELETE FROM `$cog_core_db`.`articles` WHERE (`id` = '$id');\n";
		fwrite($out_art, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_author` WHERE (`article_id` = '$id');\n";
		fwrite($out_aut, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_detail` WHERE (`article_id` = '$id');\n";
		fwrite($out_det, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_implmnt` WHERE (`article_id` = '$id');\n";
		fwrite($out_impl, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_keyword` WHERE (`article_id` = '$id');\n";
		fwrite($out_kwd, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_neuron` WHERE (`article_id` = '$id');\n";
		fwrite($out_nrn, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_region` WHERE (`article_id` = '$id');\n";
		fwrite($out_reg, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_scale` WHERE (`article_id` = '$id');\n";
		fwrite($out_scl, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_subject` WHERE (`article_id` = '$id');\n";
		fwrite($out_sub, $line);
		$line = "DELETE FROM `$cog_core_db`.`evidence_of_subjects` WHERE (`article_id` = '$id');\n";
		fwrite($out_subevi, $line);
		$line = "DELETE FROM `$cog_core_db`.`article_has_theory` WHERE (`article_id` = '$id');\n";
		fwrite($out_thr, $line);
	}

	fclose($out_art);	
	fclose($out_aut);	
	fclose($out_det);	
	fclose($out_impl);	
	fclose($out_kwd);	
	fclose($out_nrn);	
	fclose($out_reg);	
	fclose($out_scl);	
	fclose($out_sub);	
	fclose($out_subevi);	
	fclose($out_thr);	

	echo "<br><br>SQL files written.";
?>
</html>