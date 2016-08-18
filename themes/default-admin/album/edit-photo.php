<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#photo_description",
		theme: "modern",
		height: 350,
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
		<div class="page_title ">
			<h1 class="font-share-techregular"><?php echo $this->page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="javascript:history.go(-1)">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<form class="form-horizontal" name="edit_images" onSubmit="return edit_images_validate()" enctype="multipart/form-data" method="post">
			<input type="hidden" name="command" >
			<div class="control-group">
				<div class="controls"> <img src="<?php echo BASE_URL . PHOTOS . $this->album_name . "/thumb-".$this->row['photo_name']; ?>"> </div>
			</div>
			<div class="control-group">
				<label class="control-label" for="photo_name">Choose a image :</label>
				<div class="controls">
					<input id="photo_name" type="file" size="20" name="photo_name" />
					<span class="help-inline">Valid size is <span id="valid-size"></span> KB <span id="size">&nbsp;</span></span> </div>
			</div>
			<div class="control-group">
				<label class="control-label" for="photo_title">Image Title :</label>
				<div class="controls">
					<input id="photo_title" type="text" name="photo_title" value="<?php echo $this->row['photo_title']; ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="photo_reference">Image Reference :</label>
				<div class="controls">
					<textarea id="photo_reference" name="photo_reference" style="width:50%; height:5%;" ><?php echo $this->row['photo_title']; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="photo_description">Image Desciption :</label>
				<div class="controls">
					<textarea id="photo_description" name="photo_description"><?php echo $this->row['photo_title']; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="publish">Status :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="publish" name="photo_status" value="publish"<?php if ( $this->row['photo_status'] == 'publish' ){ ?> checked="checked" <?php } ?> />
						Publish </label>
					<label class="radio inline">
						<input type="radio" id="draft" name="photo_status" value="draft" <?php if ( $this->row['photo_status'] == 'draft' ){ ?> checked="checked" <?php } ?> />
						Draft </label>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" name="submit" value="Save Photo" />
				</div>
			</div>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/album/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
</body>
</html>