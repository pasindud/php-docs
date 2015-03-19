<?php

// Temp folder exsits
$temp = "../temp";
$global_folder = "configs";
$doc_config_file = "configs/config.json";
$debug = true;

debug_log("Setting Temp folder $temp");
debug_log("Setting global folder $global_folder");
debug_log("Setting global config $doc_config_file");


if (!file_exists($temp)) {
	mkdir($temp, 0777);
};

$doc_config = file_get_contents($doc_config_file);
$doc_config = json_decode($doc_config,true);


// Create language temp dir and entities json
foreach ($doc_config["languages"] as $key => $value) {
	createLangDir($temp,$value['language']);

	debug_log("Creating ".$value['language']." entities.json");
	createJsonFiles($doc_config["lang_path"],"entities.json",$value['language']);

	debug_log("Creating ".$value['language']." url.json");
	createJsonFiles($doc_config["lang_path"],"url.json",$value['language']);
}

function debug_log($log){
	global $debug;
	if ($debug) {
		echo "$log\n";	
	}
}

function createJsonFiles($lang_path,$file_type,$language){
	
	global $global_folder;
	global $config_folder;
	global $temp;

	if (!file_exists($global_folder."/".$file_type)) {
		return false;
	}

	$global_config_file = file_get_contents($global_folder."/".$file_type);
	$global_config_json = json_decode($global_config_file,true);

	$langFile = $lang_path."/".$language."/".$file_type;

	if (!file_exists($langFile)) {
		return false;
	}

	$langJsonFile = file_get_contents($langFile);
	$langJson = json_decode($langJsonFile,true);

	$entitiesJson = createJson($global_config_json,$langJson);

	$temp_entity_path =  $temp."/".$language."/".$file_type;
	file_put_contents($temp_entity_path, json_encode($entitiesJson,JSON_UNESCAPED_SLASHES));
}


function createJson($gobal_json,$lang_json){
	foreach ($gobal_json as $key => $value) {
		if (!isset($lang_json[$key])) {
			$lang_json[$key] = $gobal_json[$key];
		}else{
			// overide lang config from global
		}
	}
	return $lang_json;
}

function createLangDir($temp,$lang){
	$lang_path =  $temp."/".$lang;
	if (!file_exists($lang_path )) {
		mkdir($lang_path,0777);
	};
}






