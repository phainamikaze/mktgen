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
require('helper.php');

$API = new routeros_api();
$API->debug = false;

	if($_REQUEST['run']=='submit'){
		$numof = $_REQUEST['numberof'];
		$namepre = $_REQUEST['usernamepre'];
		$namelen = $_REQUEST['usernamelen'];
		$passsame = $_REQUEST['pwdsame'];
		$passlen = $_REQUEST['passwordlen'];
		$profileadd = $_REQUEST['profile'];
		if ($API->connect($mkthost,$mktuser,$mktpass)) {
			$printuser = array();
			$printuser[0][0] = "username";
			$printuser[0][1] = "password";
			for($num=1;$num<=$numof;$num++){
				
				// add user
				if($usertype==4){
					$useradd = $namepre.$num;
				}else{
					$useradd = $namepre.generateRandomString($namelen,$usertype);
				}
				
				if($passsame==="yes"){
					$passadd = $useradd;
				}else{
					$passadd = generateRandomString($passlen,$passtype);
				}
				$printuser[$num][0] = $useradd;
				$printuser[$num][1] = $passadd;
				if($encrypt==true){
					$passadd=md5($passadd); // md5 encrypt
				}
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
					//echo '<script>alert("Operation successful!!")</script>';
					
				}else{
					$API->disconnect();
					$error = 'can\'t assign profile';
				}
			
			
			}
			$API->disconnect();
			echo '<script>alert("Operation successful!!")</script>';
		}else{
			$error = 'can\'t connect to mikrotik';
		}
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
			document.getElementById("numberof").readOnly="true";
			document.getElementById("usernamepre").readOnly="true";
			document.getElementById("usernamelen").readOnly="true";
			document.getElementById("pwdsame").readOnly="true";
			document.getElementById("passwordlen").readOnly="true";
			document.getElementById("profile").readOnly="true";
			
			document.getElementById("numberof").setAttribute("class", "text2");
			document.getElementById("usernamepre").setAttribute("class", "text2");
			document.getElementById("usernamelen").setAttribute("class", "text2");
			document.getElementById("passwordlen").setAttribute("class", "text2");
			document.getElementById("profile").setAttribute("class", "text2");
			var loadp = document.getElementById('loading');
			
			
			var label = document.createElement('label');
			label.setAttribute('id','load');
			label.innerHTML = "&nbsp;Loading.....";
			loadp.appendChild(label);
		}


		$(document).ready(function(){
			$("#addb").validationEngine('attach', {
				onValidationComplete: function(form, status){
					//alert("The form status is: " +status+", it will never submit");
					if (status === true) {
						//alert("The form status is: " +status+", it will never submit");
						lockfrom();
						$("#addb").validationEngine('detach');
						$("#addb").submit();
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
		<div class="notice" style="color: #c1c1c1; font-size: 9px"><a href="/user/add.php">Add One</a> <a href="#">Add Batch</a> <a href="/user/logout.php">Logout</a></div><br />
		<table width="280" height="280" style="border: 1px solid #cccccc; padding: 0px;" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="center" height="175" colspan="2">
					<form id="addb" name="addb" class="formular" action='' method="post">
						<input  type="hidden" value="submit" name="run" />
							<table width="100" style="background-color: #ffffff">
								<tr><td align="right">owner</td>
										<td><input style="width: 100px" name="Owner" id="Owner" type="text" value="admin" readonly class="text2"/></td>
								</tr>
								<tr><td align="right">number of users</td>
										<td><input style="width: 100px" class="validate[required,custom[integer],min[1],max[100]] text-input" name="numberof" id="numberof" type="text" value="1"/></td>
								</tr>
								<tr><td align="right">username prefix</td>
										<td><input style="width: 100px" class="validate[required] text-input" name="usernamepre" id="usernamepre" type="text" /></td>
								</tr>
								<tr><td align="right">username length</td>
										<td><select style="width: 100px" name="usernamelen" id="usernamelen" />
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6" selected>6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
											</select>
										</td>
								</tr>
								<tr><td align="right">pwd same as login</td>
										<td><input type="checkbox" name="pwdsame" id="pwdsame" value="yes"></td>
								</tr>
								<tr><td align="right">password length</td>
										<td><select style="width: 100px" name="passwordlen" id="passwordlen" />
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6" selected>6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
											</select>
										</td>
								</tr>
								<tr><td align="right">assign profile</td>
										<td><select style="width: 100px" name="profile" id="profile" />
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
		<br /><div style="color: #c1c1c1; font-size: 9px">Powered by MikroTik RouterOS</div>
		<p id="print">
		<table>
		<?php 
			if(!empty($printuser)){
				foreach($printuser as $val){
					echo "<tr><td>".$val[0]."</td><td>".$val[1]."</td></tr>";
				}
			}
		?>
		</table>
		</p>
		<p>
		<?php if($error!='') echo'<strong style="color: #FF0000;" id="error">Error : '.$error.'</strong>';?>	
		</p>		
	
<script type="text/javascript">
		document.addb.usernamepre.focus();
</script>
	</td>
	</tr>
</table>


</body>
</html>