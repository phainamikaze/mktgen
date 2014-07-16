<?php
require('../routeros_api.class.php');
require('../config.php');

$validateValue=$_REQUEST['fieldValue'];
$validateId=$_REQUEST['fieldId'];


$validateError= "This username is already.";
$validateSuccess= "This username is available.";

$arrayToJs = array();
$arrayToJs[0] = $validateId;

$API = new routeros_api();
$API->debug = false;	
if ($API->connect($mkthost,$mktuser,$mktpass)) {

		$API->write('/tool/user-manager/user/print',false);
		$API->write('?name='.$validateValue);
		$res=$API->read();
		if(empty($res[0]))
		{
			$arrayToJs[1] = true;			
			echo json_encode($arrayToJs);
		}else{
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);
		}
	
}

?>