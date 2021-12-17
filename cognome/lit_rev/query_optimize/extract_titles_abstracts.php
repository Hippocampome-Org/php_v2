<html>
<?php
	$base_dir = "";
	$filename = $base_dir."pubmed_core_collection.xml";
	$output_dir = $base_dir."dataset/";
	$titles = array();
	$abstracts = array();

	if (($fh = fopen($filename, "r")) !== FALSE) 
	{
	  while (! feof($fh)) 
	  {	
	  	$line = fgets($fh);
	  	preg_match('/<ArticleTitle>(.*)<\/ArticleTitle>/', $line, $matches_title);
	  	if (sizeof($matches_title) > 0) {
	  	  array_push($titles, $matches_title[1]);
	  	  //echo $matches_title[0]."<br>";
	  	}
	  	preg_match('/<AbstractText>(.*)<\/AbstractText>/', $line, $matches_abstract);
	  	if (sizeof($matches_abstract) > 0) {
	      array_push($abstracts, $matches_abstract[1]);
	  	  //echo $matches_abstract[0]."<br>";
	  	}
	  }
	}

	// Close the file
  	fclose($fh);

  	// Output dataset
	for ($i = 0; $i < sizeof($titles); $i++) {
		$output_file = fopen($output_dir.($i+1).".txt", 'w') or die("Can't open file.");
		fwrite($output_file, $titles[$i]);
		fwrite($output_file, "\n");
		fwrite($output_file, $abstracts[$i]);
		fclose($output_file);	
	}

	echo "<br><center><h2>Dataset creation completed.</h2></center><br>";
?>