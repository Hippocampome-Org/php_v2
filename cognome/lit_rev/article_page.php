<html>
<head>
</head>
<body>
	<?php 
		$article_url = $_REQUEST['article_url'];
		$article_url2 = str_replace(" ", "+", $article_url);
		//$site = file_get_contents("http://google.com/search?igu=1&q=".$article_url2."&btnI");
		$site = file_get_contents("http://google.com/search?igu=1&q=".$article_url2);
		$site2 = str_replace("href=\"/url?q=", "target='blank' href=\"https://www.google.com/url?q=", $site);
		echo $site2;
	?>
	<!--iframe height="100%" width="100%" src="http://google.com/search?igu=1&q=A+synaptic+model+of+memoy%3A+long-term+potentiation+in+the+hippocampus&oq=A+synaptic+model+of+memory%3A+long-term+potentiation+in+the+hippocampus&btnI"></iframe-->
</body>
</html>