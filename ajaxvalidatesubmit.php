<?php
require('routeros_api.class.php');
require('config.php');

$uservalue=$_REQUEST['username'];
$passvalue=$_REQUEST['password1'];

$validateError= "This username is already taken";
$validateSuccess= "This username is available";

$arrayToJs = array();
$arrayToJs[0] = array();
//$arrayToJs[1] = array();

$API = new routeros_api();
$API->debug = false;
	if ($API->connect($mkthost,$mktuser,$mktpass)) {

		$API->write('/tool/user-manager/user/print',false);
		$API->write('?name='.$uservalue,false);
		$API->write('?password='.$passvalue);
		$number=$API->read();
		//print_r($number);
		if(!empty($number[0]))
		{
			
			$arrayToJs[0][0] = 'password1';
			$arrayToJs[0][1] = false;	
			$arrayToJs[0][2] = "password user is available";
		}else{
			$arrayToJs[0][0] = 'password1';
			$arrayToJs[0][1] = false;
			$arrayToJs[0][2] = "This name is already taken";
		}
		
		
		$API->disconnect();

	}
	echo json_encode($arrayToJs);
?>