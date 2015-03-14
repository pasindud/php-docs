<?php

$filename = "strpos.xml";

$fileData = file_get_contents($filename);

// Find &reftitle:seealso;
preg_match_all("/&([A-Za-z]+.[A-Za-z\-]+;)/i",$fileData, $entities_found);


for ($i=0; $i <sizeof($entities_found[0]) ; $i++) { 

	list($type,$other) = explode(".", $entities_found[0][$i] );

	// Remove &
	$type = ltrim ($type, '&');
	
	// Remove ;
	$other = rtrim ($other, ';');

	$fileData = str_replace($entities_found[0][$i] ,  "[$type:$other]" ,$fileData );
}


// echo $fileData;



$doc = new DomDocument("1.0");
$doc->loadXML( $fileData );
$doc = simplexml_load_string($fileData);

// $xmlArrar = xml2array($doc);



// function xml2array($xml)
// {
//     $arr = array();

//     foreach ($xml->getNamespaces() + array(null) as $prefix => $namespace) {
//         foreach ($xml->attributes($namespace) as $key => $value) {
//             // Add prefixes to prefixed attributes
//             if (is_string($prefix)) {
//                 $key = $prefix . '.' . $key;
//             }
//             $arr['attributes'][$key] = (string) $value;
//         }
//     }

//     foreach ($xml as $name => $element) {
//         $value = $element->children() ? xml2array($element) : trim($element);
//         if ($value) {
//             if (!isset($arr[$name])) {
//                 $arr[$name] = $value;
//             } else {
//                 foreach ((array) $value as $k => $v) {
//                     if (is_numeric($k)) {
                    	
//                     	if (is_numeric($name)) {

//                         $arr[$name][] = $v;
//                     	}
//                     } else {
//                         $arr[$name][$k] = array_merge(
//                             (array) $arr[$name][$k], 
//                             (array) $v
//                         );
//                     }
//                 }
//             }
//         }
//     }

//     if ($content = trim((string) $xml)) {
//         $arr[] = $content;
//     }

//     return $arr;
// }


// function xmltoMarkdown ($xmlArray){

// 	$refsec = $xmlArray["refsec1"];

// 	var_dump($refsec);



// }


function methodsynopsis_node (){}
function refnamediv_node (){}
function refpurpose_node (){}
function refname_node (){}


function methodsynopsis_node ( $data){

/*

int function strpos(
    string $haystack,
    mixed $needle,
    int $offset = 0
)
 */
	$str = "";
	$str .= $data["type"];
	$str .= " function " ;
	$str .= $data["methodname"]." \n";


		for ($i=0; $i < sizeof($data["type"]); $i++) { 

			$str .= "\t".$data["type"][$i]." $".$data[$i] ."\n";

		}



}




























