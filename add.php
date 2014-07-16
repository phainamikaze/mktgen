<?php
//Create by phainamikaze MikrotikThai.co.,ltd
//Create Date 21/apr/2014-22/apr/2014

session_start();
if (!isset($_SESSION['login'])) {
	header('Location: login.php');
	exit();
}
require('routeros_api.class.php');
require('config.php');

$API = new routeros_api();
$API->debug = false;

	if($_REQUEST['run']=='submit'){
		$useradd = $_REQUEST['username'];
		if($encrypt==true){
			$passadd = md5($_REQUEST['password1']);// md5 encrypt
		}else{
			$passadd = $_REQUEST['password1'];
		}
		$profileadd = $_REQUEST['profile'];
		// add user
		if ($API->connect($mkthost,$mktuser,$mktpass)) {
			$API->write('/tool/user-manager/user/add',false);
			$API->write('=name='.$useradd,false);
			$API->write('=password='.$passadd,false);
			$API->write('=customer=admin');
			$number=$API->read();
			// add profile
			if(!empty($number)){
				$API->write('/tool/user-manager/user/create-and-activate-profile',false);
				$API->write('=numbers='.$number,false);
				$API->write('=profile='.$profileadd,false);
				$API->write('=customer=admin');
				$res=$API->read();
				$API->disconnect();
				echo '<script>alert("Operation successful!!")</script>';
				
			}else{$API->disconnect();$error = 'can\'t assign profile';}
		}else{$error = 'can\'t connect to mikrotik';}
	
	}
	
	if ($API->connect($mkthost,$mktuser,$mktpass)) {
			$API->write('/tool/user-manager/profile/print');
			$resProfile=$API->read();
			//print_r($resProfile);
			$API->disconnect();
	}else{
		$error = 'no profile';
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
		function lockfrom()
		{
			document.getElementById("username").readOnly="true";
			document.getElementById("password1").readOnly="true";
			document.getElementById("password2").readOnly="true";
			document.getElementById("profile").readOnly="true";
			document.getElementById("username").setAttribute("class", "text2");
			document.getElementById("password1").setAttribute("class", "text2");
			document.getElementById("password2").setAttribute("class", "text2");
			document.getElementById("profile").setAttribute("class", "text2");
			var loadp = document.getElementById('loading');
			
			
			var label = document.createElement('label');
			label.setAttribute('id','load');
			label.innerHTML = "&nbsp;Loading.....";
			loadp.appendChild(label);
			
		}


		$(document).ready(function(){
			$("#add").validationEngine('attach', {
				onValidationComplete: function(form, status){
					//alert("The form status is: " +status+", it will never submit");
					if (status === true) {
						//alert("The form status is: " +status+", it will never submit");
						lockfrom();
						$("#add").validationEngine('detach');
						$("#add").submit();
					}
				}  
			});
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
		<div class="notice" style="color: #c1c1c1; font-size: 9px"><a href="#">Add One</a> <a href="/user/addb.php">Add Batch</a> <a href="/user/logout.php">Logout</a></div><br />
		<table width="280" height="280" style="border: 1px solid #cccccc; padding: 0px;" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="center" height="175" colspan="2">
					<form id="add" name="add" class="formular" action='' method="post">
						<input  type="hidden" value="submit" name="run" />
							<table width="100" style="background-color: #ffffff">
								<tr><td align="right">owner</td>
										<td><input style="width: 100px" name="Owner" id="Owner" type="text" value="admin" readonly class="text2"/></td>
								</tr>
								<tr><td align="right">username</td>
										<td><input style="width: 100px" class="validate[required,ajax[ajaxUserCallPhp]] text-input" name="username" id="username" type="text" /></td>
								</tr>
								<tr><td align="right">password</td>
										<td><input style="width: 100px" name="password1" id="password1" type="password" class="validate[required,minSize[6]] text-input"/></td>
								</tr>
								<tr><td align="right">confirm password</td>
										<td><input style="width: 100px" name="password2" id="password2" type="password" class="validate[required,equals[password1]] text-input"/></td>
								</tr>
								<tr><td align="right">assign profile</td>
										<td><select style="width: 100px" name="profile" id="profile" type="sel"/>
											<?php foreach($resProfile as $key){
													echo '<option value="'.$key['name'].'">'.$key['name'].'</option>';
												}
											?>
											</select>
										</td>
								</tr>
								<tr><td>&nbsp;</td>
										<td><input type="submit" value="Add" /></td>
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
		document.add.username.focus();
</script>
	</td>
	</tr>
</table>


</body>
</html>