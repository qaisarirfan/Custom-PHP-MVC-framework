<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="stylesheet" href="<?php echo $this->get_theme_name_with_http(); ?>/css/login.css" />
</head><body>
<div class="container">
	<form name="form1" class="form-horizontal" onSubmit="return validate()" method="post" autocomplete="off">
		<input name="command" type="hidden" />
		<div class="modal">
			<div class="modal-header font-share-techregular">
				<h3><?php echo APP_TITLE; ?> Admin</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="password"></label>
					<div class="controls"> Please sign in </div>
				</div>
				<div class="control-group">
					<label class="control-label ie username" for="username">Email address or username</label>
					<div class="controls">
						<input name="username" type="text" id="username" placeholder="Email address or username" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label ie password" for="password">Password</label>
					<div class="controls">
						<input name="password" type="password" id="password" placeholder="Password" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="auto_logout" id="auto_logout" checked="checked" /> Auto logout </label>
					</div>
				</div>
			</div>
			<div class="modal-footer"> 
				<a href="<?php echo BASE_URL; ?>" target="_blank" title="Visit Website">&larr;&nbsp;Visit Website</a>
				<input class="btn btn-primary" name="submit" type="submit" value="Sign in" />
			</div>
		</div>
	</form>
</div>
<?php echo $this->msg; ?>
<script language="javascript" src="<?php echo $this->get_theme_name_with_http(); ?>/js/bootstrap.min.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		if ( $.browser.msie ) {
			$('.ie').show();
		}else{
			$('.ie').hide();
		}
		setInterval(function(){
			$('.notification').fadeOut('slow');
		},3000);
	})
	function validate(){
		var f=document.form1;
		if(f.username.value==''){
			if ( $.browser.msie ) {
				$('.username').html('Please enter email or username').css('color','red');
			}else{
				f.username.placeholder="Enter email please";
			}
			f.username.focus();
			return false;
		}
		else if(f.password.value==''){
			if ( $.browser.msie ) {
				$('.password').html('Please enter password').css('color','red');	
			}else{
				f.password.placeholder="Type your password please";
			}
			f.password.focus();
			return false;
		}else{
			f.command.value='login';
			return true;
		}
	}
</script>
</body>
</html>