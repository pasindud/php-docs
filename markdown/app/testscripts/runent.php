<?php

$filename = "sam.ent";

$file_string = file_get_contents($filename);

if (!$file_string) { die ("Cannot open entity file ($filename)."); }


// Find all the entities in the file
preg_match_all("/<!ENTITY\s+(\S+)\s+([\"'])([^\\2]+)\\2\s*>/U",
	$file_string, $entities_found);


$entity_json_a  = array();

for ($i=0; $i <sizeof($entities_found[1]) ; $i++) { 

$entity_json_a[$i] = array( "key" => $entities_found[1][$i] , "value" => $entities_found[3][$i] );

}

$entity_json = json_encode($entity_json_a);
echo $entity_json;

