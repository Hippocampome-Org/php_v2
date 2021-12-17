<?php
	function find_pdf($dir, $art_mod_id) {
		$links = array();
		$links[0] = '';
		for ($l_i = 1; $l_i < 1000; $l_i++) {
			if ($l_i < 10) {
				$links[$l_i] = 'article_00'.$l_i.'.pdf';
			}
			else if ($l_i < 100) {
				$links[$l_i] = 'article_0'.$l_i.'.pdf';
			}
			else {
				$links[$l_i] = 'article_'.$l_i.'.pdf';
			}
		}

		return $dir.$links[$art_mod_id];
	}
?>