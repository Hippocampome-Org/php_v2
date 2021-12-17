<?php

function result_set_to_array($result_set, $field="all") {
  $records = array();
  while($record = mysqli_fetch_assoc($result_set)) {
    if ($field == "all") {  // extract a particular field
      $records[] = $record;
    } else {
      $records[] = $record[$field];
    }
  }
  return $records;
}

function to_name($record) {
  if (strpos($record["nickname"], $record["subregion"]) !== false) {
    $name = $record["nickname"];
  } else {
    $name = $record["subregion"] . ' ' . $record["nickname"];
  }
  return $name;
}

function quote_for_mysql($str) {
  $quoted = "'$str'";
  return $quoted;
}

// takes a set of type_ids and returns their records sorted by position
function get_sorted_records($type_ids) {  // used to sort type records
        $quoted_ids = array_map("quote_for_mysql", $type_ids);
        $query = "SELECT * FROM Type WHERE id IN (" . implode(', ', $quoted_ids) . ') ORDER BY position';
        $result = mysqli_query($GLOBALS['conn'],$query);
        $records = result_set_to_array($result);
        //$names = array_map("to_name", $records);
        return $records;
      }

// returns a set of type_ids that have either axons or dendrites in an array of parcels
function filter_types_by_morph_property($axon_dendrite, $parcel_array) {
  $morphology_properties_query = "SELECT DISTINCT t.name, t.subregion, t.nickname, p.subject, p.predicate, p.object, eptr.Type_id, eptr.Property_id
      FROM EvidencePropertyTypeRel eptr
      JOIN (Property p, Type t) ON (eptr.Property_id = p.id AND eptr.Type_id = t.id)
      WHERE predicate = 'in' AND object REGEXP ':'";
  $quoted_parcels = array_map("quote_for_mysql", $parcel_array);
  $query = $morphology_properties_query . " AND status = 'active' AND subject = '$axon_dendrite'" . " AND object IN " . '(' . implode(', ', $quoted_parcels) . ')';
  //print "<br><br>TYPE FILTERING QUERY:<br>"; print_r($query);
  $result = mysqli_query($GLOBALS['conn'],$query);
  $ids = result_set_to_array($result, "Type_id");
  return $ids;
}

?>
