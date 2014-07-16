<?php

function generateRandomString($length = 6, $charset = 0 ) {
	$charactersall = array();
    $charactersall[0] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersall[1] = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersall[2] = '0123456789abcdefghijklmnopqrstuvwxyz';
	$charactersall[3] = '0123456789';
	$characters = $charactersall[$charset];
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

?>