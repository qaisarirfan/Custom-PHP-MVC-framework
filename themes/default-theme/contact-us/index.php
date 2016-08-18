<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="canonical" href="<?php echo BASE_URL ?>contact-us" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<h2 class="page-title"><?php echo $this->page_title; ?></h2>
			<?php if( $this->msg ){ ?>
			<div class="error_msg"><?php echo $this->msg; ?></div>
			<?php } ?>
			<?php if( $_REQUEST['msg'] ){ ?>
			<div class="success_msg"><?php echo $_REQUEST['msg']; ?></div>
			<?php } ?>
			<div id="contact-area-left" class="fl" itemscope itemtype="http://schema.org/LocalBusiness">
				<p>We are here to answer any questions you may have about our combadi experiences. Reach out to us and we'll respond as soon as we can.</p>
				<p>Even if there is something you have always wanted to experience and can't find it on combadi, let us know and we promise we'll do our best to find it for you and send you there.</p>
				<div id="contact-info">
					<dl>
						<dt>Name</dt>
						<dd itemprop="name"><?php echo APP_TITLE; ?></dd>
						<div class="clear">&nbsp;</div>
						<meta itemprop="description" content="<?php echo $this->preferences['seo_home_description']; ?>">
						<?php if( $this->preferences['social_contact_email'] ){ ?>
						<dt>Email</dt>
						<dd><a href="mailto:<?php echo $this->preferences['social_contact_email']; ?>" title="Click to send us an email" itemprop="email"><?php echo $this->preferences['social_contact_email']; ?></a></dd>
						<?php } ?>
						<div class="clear">&nbsp;</div>
						<?php if( $this->preferences['phone_no'] ){ ?>
						<dt>Telephone</dt>
						<dd><a href="tel:<?php echo $this->preferences['phone_no']; ?>" title="Click to call us" itemprop="telephone"><?php echo $this->preferences['phone_no']; ?></a></dd>
						<?php } ?>
						<div class="clear">&nbsp;</div>
						<?php if( $this->preferences['social_skype'] ){ ?>
						<dt>Skype</dt>
						<dd><a href="skype:<?php echo $this->preferences['social_skype']; ?>?call" title="Click to call us on Skype"><?php echo $this->preferences['social_skype']; ?></a></dd>
						<?php } ?>
						<div class="clear">&nbsp;</div>
						<dt>Address</dt>
						<dd>
							<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							<?php echo '<span itemprop="streetAddress">'.$this->preferences['address'].'</span>' . ", " . '<span itemprop="addressLocality">'.$this->preferences['city'].'</span>' . ", " . '<span itemprop="addressRegion">'.$this->preferences['state'].'</span>' . " " . '<span itemprop="postalCode">'.$this->preferences['zip'].'</span>' . ", " . $this->preferences['country']; ?>
							</address>
						</dd>
						<div class="clear">&nbsp;</div>
					</dl>
					<ul class="social" style="float:none">
						<li class="text">Our Social Community</li>
						<?php if( $this->preferences['social_facebook_text'] ){ ?>
						<li class="facebook"><a href="<?php echo $this->preferences['social_facebook_text']; ?>" target="_blank">Facebook</a></li>
						<?php } ?>
						<?php if( $this->preferences['social_twitter_text'] ){ ?>
						<li class="twitter"><a href="<?php echo $this->preferences['social_twitter_text']; ?>" target="_blank">Twitter</a></li>
						<?php } ?>
						<?php if( $this->preferences['social_gplus'] ){ ?>
						<li class="gplus"><a href="<?php echo $this->preferences['social_gplus']; ?>" target="_blank">Google Plus</a></li>
						<?php } ?>
						<?php if( $this->preferences['social_dailymotion'] ){ ?>
						<li class="dailymotion"><a href="<?php echo $this->preferences['social_dailymotion']; ?>" target="_blank">Dailymotion</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div id="contact-area-right" class="fr">
				<form name="support" method="post" action="" accept-charset="utf-8" onsubmit="return validateForm(this)">
					<input type="hidden" name="command" />
					<div class="control-group">
						<label class="control-label" for="name">Name</label>
						<div class="controls">
							<input name="name" id="name" value="<?php echo stripslashes( $_REQUEST['name'] ); ?>" type="text" />
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="phoneno">Phone No</label>
						<div class="controls">
							<input name="phoneno" id="phoneno" value="<?php echo stripslashes( $_REQUEST['phoneno'] ); ?>" type="text" />
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="email">E-mail</label>
						<div class="controls">
							<input name="email" id="email" value="<?php echo stripslashes( $_REQUEST['email'] ); ?>" type="text" />
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="subject">Subject</label>
						<div class="controls">
							<input name="subject" id="subject" value="<?php echo stripslashes( $_REQUEST['subject'] ); ?>" type="text" />
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="message">Message</label>
						<div class="controls">
							<textarea name="message" id="message" rows="8" cols="48"><?php echo stripslashes( $_REQUEST['message'] ); ?></textarea>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="captcha_text">Are you Human?</label>
						<div class="controls"> <img src="<?php echo $this->captcha ?>" id="captcha" /> <a href="javascript:void(0)" onClick="change_captcha();">Reload</a>
							<input name="captcha_text" id="captcha_text" type="text" autocomplete="off" />
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="control-group">
						<label class="control-label">&nbsp;</label>
						<div class="controls">
							<div class="Button"> <span>&nbsp;</span>
								<input type="submit" value="Send" />
								<div class="clear">&nbsp;</div>
							</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
				</form>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if( $this->msg != '' || $_REQUEST['msg'] != '' ){ ?>
		setInterval(function() {
		   $('.error_msg').fadeOut(900);
		   $('.success_msg').fadeOut(300);
		}, 3000);
		<?php } ?>
	});
	function change_captcha(){
		document.getElementById('captcha').src = '<?php echo $this->captcha ?>?'+Math.random();
		return false;
	}
	function validateForm( f ){
		var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if( f.name.value == '' ){
			alert("Please Enter Your Full Name");
			f.name.focus();
			return false;
		}else if( f.email.value == ''){
			alert("Please Enter E-mail address");
			f.email.focus();
			return false;
		}else if( !filter.test( f.email.value ) ){
			alert("Please Enter a valid E-mail address");
			f.email.focus();
			return false;
		}else if( f.subject.value == '' ){
			alert("Please Enter Subject of you Message");
			f.subject.focus();
			return false;
		}else if(f.captcha_text.value==''){
			alert( "Please Enter Captcha" );
			f.captcha_text.focus();
			return false;

		}else{
			f.command.value='send-mail';
			return true;
		}
	}
</script>
</body>
</html>