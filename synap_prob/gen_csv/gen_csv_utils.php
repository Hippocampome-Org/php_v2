<?php
	function neurite_to_neuriteID($prop_parcel_rel, $neurite) {
		$neurite_id='';
		for ($i=0;$i<count($prop_parcel_rel);$i++) {
			// case insensitive match used here
			if (strtolower($neurite)==strtolower($prop_parcel_rel[$i][1])) {
				$neurite_id=$prop_parcel_rel[$i][0];
				//echo $neurite.' '.$prop_parcel_rel[$i][1].'<br>';
			}
		}
		return $neurite_id;
	}

	function refID_to_fragID($fragments, $refID) {
		$found=false; // only return the first result found
		for ($i=0;$i<count($fragments);$i++) {
			$frag_id_temp = $fragments[$i][1];
			if ($refID==$frag_id_temp && $found==false) {
				$frag_id=$fragments[$i][0];
				$found=true;
				echo "found";
			}
			//echo "r:".$refID." f:".$frag_id_temp."|";
		}
		return $frag_id;
	}	

	function fragID_to_eviID($evidence, $fragID) {
		for ($i=0;$i<count($evidence);$i++) {
			if ($fragID==$evidence[$i][0]) {
				$evi_id=$evidence[$i][1];
			}
		}
		return $evi_id;
	}
?>