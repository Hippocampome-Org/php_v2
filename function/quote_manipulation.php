<?php
function quote_replaceIDwithName($theQuote) {
	// find all <% cell ID %>
	if (preg_match_all ( '/\<% ([^<>]+) %\>/', $theQuote, $matches, PREG_PATTERN_ORDER )) {
		$u = 0;
		$newQuote = "";
		foreach ( $matches [1] as $match ) {
			$idArray [] = $match;
			$fetch_query = "SELECT subregion, nickname FROM Type WHERE id=$match";
			$query_result = mysqli_query($GLOBALS['conn'], $fetch_query );
			
			while ( $subs_and_nicks = mysqli_fetch_array ( $query_result, MYSQLI_ASSOC ) ) {
				// $subs[$u] = $subs_and_nicks['subregion'];
				// $nicks[$u] = $subs_and_nicks['nickname'];
				//$printable_subs_and_nicks [$u] = '{' . $subs_and_nicks ['subregion'] . ' ' . $subs_and_nicks ['nickname'] . '}';
				$printable_subs_and_nicks [$u] = '{' . $subs_and_nicks ['nickname'] . '}';
				$u ++;
			}
		}
		
		if (! empty ( $printable_subs_and_nicks )) {
			// replace <% cell ID %> with {cell type name} by using regular expression search
			$newQuote = preg_replace_callback ( '/\<% [^<>]+ %\>/', function ($matches) use(&$printable_subs_and_nicks) {
				return array_shift ( $printable_subs_and_nicks );
			}, $theQuote );
		} else {
			preg_match ( '/\<% ([^<>]+) %\>/', $theQuote, $matches );
			if (count ( $matches ) > 0)
				$newQuote = preg_replace ( '/\<% [^<>]+ %\>/', '{ <B>!! cell ID ' . $matches [1] . ' not found !!</B> }', $theQuote );
		}
		
		return ($newQuote);
	} else {
		return ($theQuote);
	}
}


function quote_replace_IDwithName($theQuote) {
	// find all <% cell ID %>
	if (preg_match_all ( '/<%([^<>]+)%\>/', $theQuote, $matches, PREG_PATTERN_ORDER )) {
		$u = 0;
		$newQuote = "";
		foreach ( $matches [1] as $match ) {
			$idArray [] = $match;
			$fetch_query = "SELECT subregion, nickname FROM Type WHERE id=$match";
			$query_result = mysqli_query($GLOBALS['conn'], $fetch_query );
				
			while ( $subs_and_nicks = mysqli_fetch_array ( $query_result, MYSQLI_ASSOC ) ) {
				// $subs[$u] = $subs_and_nicks['subregion'];
				// $nicks[$u] = $subs_and_nicks['nickname'];
				//$printable_subs_and_nicks [$u] = '{' . $subs_and_nicks ['subregion'] . ' ' . $subs_and_nicks ['nickname'] . '}';
				$printable_subs_and_nicks [$u] = '{' . $subs_and_nicks ['nickname'] . '}';
				$u ++;
			}
		}

		if (! empty ( $printable_subs_and_nicks )) {
			// replace <% cell ID %> with {cell type name} by using regular expression search
			$newQuote = preg_replace_callback ( '/<%[^<>]+%\>/', function ($matches) use(&$printable_subs_and_nicks) {
				return array_shift ( $printable_subs_and_nicks );
			}, $theQuote );
		} else {
			preg_match ( '/\<% ([^<>]+) %\>/', $theQuote, $matches );
			if (count ( $matches ) > 0)
				$newQuote = preg_replace ( '/:<%[^<>]+%\>:/', '{ <B>!! cell ID ' . $matches [1] . ' not found !!</B> }', $theQuote );
		}

		return ($newQuote);
	} 
}



?>
