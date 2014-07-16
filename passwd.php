<?php
require('routeros_api.class.php');
require('config.php');

$user=$_REQUEST['u'];
$uservalue=$_REQUEST['username'];
if($encrypt==true){
	$passvalue=md5($_REQUEST['password1']);
	$pass2value=md5($_REQUEST['password2']);
}else{
	$passvalue=$_REQUEST['password1'];
	$pass2value=$_REQUEST['password2'];
}

$API = new routeros_api();
$API->debug = false;
if($_REQUEST['run']=="submit"){
	$_REQUEST['run']="";
	if ($API->connect($mkthost,$mktuser,$mktpass)) {

		$API->write('/tool/user-manager/user/print',false);
		$API->write('?name='.$uservalue,false);
		$API->write('?password='.$passvalue);
		$number=$API->read();
		//print_r($number);
		if(!empty($number[0]))
		{
			$API->write('/tool/user-manager/user/set',false);
			$API->write('=numbers='.$number[0]['.id'],false);
			$API->write('=password='.$pass2value);
			$result=$API->read();
			//print_r($result);
			$API->disconnect();
			echo '<script>alert("Change Password Complete")</script>';
			echo '<script>window.location="'.$hotspotlogout.'"</script>';
			exit();
		}else{
			$error = 'invalid userlogin or password';
		}
		
		
		$API->disconnect();

	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>internet hotspot > change password</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="-1" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>

<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script>    
		$(document).ready(function(){
			$("#login").validationEngine();
		});
</script>
<style type="text/css">
body {color: #737373; font-size: 10px; font-family: verdana;}

textarea,input,select {
background-color: #FDFBFB;
border: 1px solid #BBBBBB;
padding: 2px;
margin: 1px;
font-size: 14px;
color: #808080;
}

a, a:link, a:visited, a:active { color: #AAAAAA; text-decoration: none; font-size: 10px; }
a:hover { border-bottom: 1px dotted #c1c1c1; color: #AAAAAA; }
img {border: none;}
td { font-size: 14px; color: #7A7A7A; }
</style>

</head>

<body>


<table width="100%" style="margin-top: 10%;">
	<tr>
	<td align="center" valign="middle">
		<div class="notice" style="color: #c1c1c1; font-size: 9px">Change Password</div><br />
		<table width="280" height="280" style="border: 1px solid #cccccc; padding: 0px;" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="center" height="175" colspan="2">
					<form id="login" name="login" class="formular" action='' method="post">
						<input  type="hidden" value="submit" name="run" />
							<table width="100" style="background-color: #ffffff">
								<tr><td align="right">username</td>
										<td><input style="width: 100px" class="validate[required] text-input" name="username" id="username" type="text" 
										<?php if($user!=''){echo 'value="'.$user.'" readonly';}?>/></td>
								</tr>
								<tr><td align="right">old password</td>
										<td><input style="width: 100px" name="password1" id="password1" type="password" class="validate[required] text-input"/></td>
								</tr>
								<tr><td align="right">new password</td>
										<td><input style="width: 100px" name="password2" id="password2" type="password" class="validate[required,minSize[6]] text-input" id="password2"/></td>
								</tr>
								<tr><td align="right">confirm password</td>
										<td><input style="width: 100px" name="password3" id="password3" type="password" class="validate[required,equals[password2]] text-input" /></td>
								</tr>
								<tr><td>&nbsp;</td>
										<td><input type="submit" value="Change Password" /></td>
								</tr>
							</table>
					</form>
				</td>
			</tr>
			<!--tr><td align="center"><a href="http://www.mikrotik.com" target="_blank" style="border: none;"><img src="img/logobottom.png" alt="mikrotik" /></a></td></tr-->
		</table>
		<p><strong style="color: #FF0000;"><?php if($error!='') echo 'Error : '.$error;?></strong></p>		
	<br /><div style="color: #c1c1c1; font-size: 9px">Powered by MikroTik RouterOS</div>
<script type="text/javascript">
	if(document.login.username.value==''){
		document.login.username.focus();
	}else{
		document.login.password1.focus();
	}

</script>
	</td>
	</tr>
</table>


</body>
</html>