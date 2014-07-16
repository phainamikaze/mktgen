<?php
//Create by phainamikaze MikrotikThai.co.,ltd
//Create Date 21/apr/2014-22/apr/2014

session_start();
if (isset($_SESSION['login'])) {
	header('Location: add.php');
	exit();
}
 
	if($_REQUEST['run']=='submit'){
		if($_REQUEST['username']=='admin' && $_REQUEST['password1']=='admin'){
			$_SESSION['login'] = "ok";
			header('Location: add.php');
			exit();
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
.text2{
background-color: #CBC3C5;
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
		<div class="notice" style="color: #c1c1c1; font-size: 9px">admin login</div><br />
		<table width="280" height="280" style="border: 1px solid #cccccc; padding: 0px;" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="center" height="175" colspan="2">
					<form id="login" name="login" class="formular" action='' method="post">
						<input  type="hidden" value="submit" name="run" />
							<table width="100" style="background-color: #ffffff">
								<tr><td align="right">username</td>
										<td><input style="width: 100px" name="username" id="username" type="text" /></td>
								</tr>
								<tr><td align="right">password</td>
										<td><input style="width: 100px" name="password1" id="password1" type="password" /></td>
								<tr><td>&nbsp;</td>
										<td><input type="submit" value="go" /></td>
								</tr>
							</table>
					</form>
				</td>
			</tr>
			<!--tr><td align="center"><a href="http://www.mikrotik.com" target="_blank" style="border: none;"><img src="img/logobottom.png" alt="mikrotik" /></a></td></tr-->
		</table>
		<p id="loading"></p>
		<p>
		<?php if($error!='') echo'<strong style="color: #FF0000;" id="error">Error : '.$error.'</strong>';?>	
		</p>		
	<br /><div style="color: #c1c1c1; font-size: 9px">Powered by MikroTik RouterOS</div>
<script type="text/javascript">
		document.login.username.focus();
</script>
	</td>
	</tr>
</table>


</body>
</html>