<?php 
	session_start();
	
	if ( $_REQUEST['command'] == 'submit' ) {
		if ( $_SESSION['captcha'] != trim( $_REQUEST['captcha_text'] ) ){
			echo $_SESSION['captcha'];
			die("Please Enter Valid Captcha Code");
		}elseif ( $_SESSION['captcha'] == trim( $_REQUEST['captcha_text'] ) ){
			echo $_SESSION['captcha'] . " = " . $_REQUEST['captcha_text'];
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script>
	function change_captcha(){
		document.getElementById('captcha').src = 'captcha.php?'+Math.random();
		return false;
	}
	function validate(f){
		if(f.captcha_text.value==''){
			alert( "Please Enter Captcha" );
			f.captcha_text.focus();
			return false;
		}else{
			f.command.value = 'submit';
			f.submit();
			return true;
		}
	}
</script>
</head>

<body>
	<form name="test" method="post" action="" onSubmit="return validate(this);" autocomplete="off">
		<input type="hidden" name="command">
		<table>
			<tr valign="top">
				<th>Are you Human?</th>
				<td>
					<img src="captcha.php" id="captcha" />
					<a href="javascript:void(0)" onClick="change_captcha();">Reload</a>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="text" name="captcha_text"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" value="Submit"></td>
			</tr>

		</table>
	</form>
</body>
</html>