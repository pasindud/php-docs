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



$doc = new DomDocument("1.0");
$doc->loadXML( $fileData );
$doc = simplexml_load_string($fileData);

$xmlArrar = xml2array($doc,1);

// var_dump($xmlArrar["refsect1"]);


// foreach ($xmlArrar["refsect1"] as $key => $value) {
// 	var_dump($key);

// 	var_dump($xmlArrar["refsect1"]["para"]);
// }



function xml2array($xml,$ii)
{
    $arr = array();

    foreach ($xml->getNamespaces() + array(null) as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $key => $value) {
            // Add prefixes to prefixed attributes
            if (is_string($prefix)) {
                $key = $prefix . '.' . $key;
            }
            $arr['attributes'][$key] = (string) $value;
        }
    }

    foreach ($xml as $name => $element) {


    	
        $value = $element->children() ? xml2array($element,$ii) : trim($element);
        for ($i=0; $i < $ii; $i++) { 
    		echo " ";
    	}

    	if ($name == "methodsynopsis") {

    		 // methodsynopsis_node($value);
    	}

    	if ($name == "refsect1") {
    		var_dump($value);
    	}
    	echo $ii.$name."\n";

    	$ii++;
    	// var_dump($value);
        if ($value) {
            if (!isset($arr[$name])) {
                $arr[$name] = $value;
            } else {
                foreach ((array) $value as $k => $v) {
                    if (is_numeric($k)) {
                    	
                    	if (is_numeric($name)) {

                        $arr[$name][] = $v;
                    	}
                    } else {
                        $arr[$name][$k] = array_merge(
                            (array) $arr[$name][$k], 
                            (array) $v
                        );
                    }
                }
            }
        }
    }

    if ($content = trim((string) $xml)) {
        $arr[] = $content;
    }

    return $arr;
}


function methodsynopsis_node ( $data){

/*

int function strpos(
    string $haystack,
    mixed $needle,
    int $offset = 0
)
 */

	$str = "\n";
	$str .= $data["type"];
	$str .= " function " ;
	$str .= $data["methodname"]."( \n";

		for ($i=0; $i < sizeof($data["methodparam"]["type"]); $i++) { 

			$str .= " ".$data["methodparam"]["type"][$i]." $".$data[$i] ."\n";

		}

		echo "$str \n)\n";
		//return $str."\n\n";
}



