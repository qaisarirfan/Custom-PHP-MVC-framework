<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#content",
		theme: "modern",
		height: 200,
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons template paste textcolor"
	   ],
	   //content_css: "css/content.css",
	   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
	   style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]
	});
</script>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title">
			<h1 class="font-share-techregular"><?php echo $this->page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="preferences" >
			<input type="hidden" name="command" value="save-setting" />
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="social_skype">Skype</label>
						<div class="controls">
							<input style="width:96%" id="social_skype" type="text" name="social_skype" value="<?php echo $this->preferences['social_skype']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="social_contact_email">Contact Email</label>
						<div class="controls">
							<input style="width:96%" id="social_contact_email" type="text" name="social_contact_email" value="<?php echo $this->preferences['social_contact_email']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="social_facebook_text">Facebook Link</label>
						<div class="controls">
							<input style="width:96%" id="social_facebook_text" type="text" name="social_facebook_text" value="<?php echo $this->preferences['social_facebook_text']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="social_twitter_text">Twitter Link</label>
						<div class="controls">
							<input style="width:96%" id="social_twitter_text" type="text" name="social_twitter_text" value="<?php echo $this->preferences['social_twitter_text']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="social_gplus">G+ Link</label>
						<div class="controls">
							<input  style="width:96%" id="social_gplus" type="text" name="social_gplus" value="<?php echo $this->preferences['social_gplus']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="social_dailymotion">Dailymotion</label>
						<div class="controls">
							<input  style="width:96%" id="social_dailymotion" type="text" name="social_dailymotion" value="<?php echo $this->preferences['social_dailymotion']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="content">Home Page Text</label>
						<div class="controls">
							<textarea id="content" name="home_text"><?php echo $this->preferences['home_text']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="address">Address</label>
						<div class="controls">
							<input id="address" style="width:96%;" type="text" name="address" value="<?php echo $this->preferences['address']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="city">City</label>
						<div class="controls">
							<input id="city" style="width:96%;" type="text" name="city" value="<?php echo $this->preferences['city']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="state">State</label>
						<div class="controls">
							<input id="state" style="width:96%;" type="text" name="state" value="<?php echo $this->preferences['state']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="zip">Zip</label>
						<div class="controls">
							<input id="zip" style="width:96%;" type="text" name="zip" value="<?php echo $this->preferences['zip']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="country">Country</label>
						<div class="controls">
							<input id="country" style="width:96%;" type="text" name="country" value="<?php echo $this->preferences['country']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="phone_no">Phone No</label>
						<div class="controls">
							<input id="phone_no" style="width:96%;" type="text" name="phone_no" value="<?php echo $this->preferences['phone_no']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="seo_home_title">Home Page Title</label>
						<div class="controls">
							<input id="seo_home_title" style="width:96%;" type="text" name="seo_home_title" value="<?php echo $this->preferences['seo_home_title']; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="seo_home_keywords">Home Page SEO Keywords</label>
						<div class="controls">
							<textarea style="width:96%; height:5%;" id="seo_home_keywords" name="seo_home_keywords"><?php echo $this->preferences['seo_home_keywords']; ?></textarea>
							<span class="help-inline">Type Your Keywords with comma (,) separated</span> </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="seo_home_description">Home Page SEO Meta Description</label>
						<div class="controls">
							<textarea style="width:96%; height:5%;" id="seo_home_description" name="seo_home_description"><?php echo $this->preferences['seo_home_description']; ?></textarea>
							<span class="help-inline">The part of your website's that tells a search engine the relevant information for the content of your website.</span> </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="footer_text">Footer Text</label>
						<div class="controls">
							<textarea style="width:96%; height:5%;" id="footer_text" name="footer_text"><?php echo $this->preferences['footer_text']; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div align="right">
				<input type="submit" class="btn btn-primary" value="Save" />
			</div>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>