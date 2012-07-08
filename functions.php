<?php
function fbQueryGraph($objects, $access_token){
	// queries fb graph
	// from https://developers.facebook.com/docs/reference/fql/

	if(is_array($objects)){
		//$objects = array_slice($objects, 0, 10);
		$ids = implode(',', $objects);

	} else {
		$ids = $objects;
	} 

	$url = ''; 
	$url .= 'https://graph.facebook.com/'; 
	$url .= "?ids=$ids&access_token=$access_token";

  $result = file_get_contents($url);
  $resultObj = json_decode($result, true);

  debug($resultObj);
  //return $resultObj['data'];

}

function debug($arr){
	echo '<pre>';
  print_r("query results:");
  print_r($arr);
  echo '</pre>';
  exit;
}

?>