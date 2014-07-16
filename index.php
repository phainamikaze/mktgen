<?php
//Create by phainamikaze MikrotikThai.co.,ltd
//Create Date 21/apr/2014-22/apr/2014

session_start();
if (!isset($_SESSION['user'])) {
	header('Location: login.php');
 } else {
	header('Location: add.php');
 }
?>