<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#page_text",
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
		<form class="form-horizontal" name="edit" onSubmit="return edit_validate()" method="post">
			<input type="hidden" name="command" />

			<div class="control-group">
				<label class="control-label" for="page_name">Page Title</label>
				<div class="controls"><input type="text" id="page_name" name="page_name" value="<?php echo $this->row['page_name']; ?>" /></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="page_description">Page Description</label>
				<div class="controls">
					<textarea id="page_description" style="width:50%; height:5%;" name="page_description" ><?php echo $this->row['page_description']; ?></textarea>
					<span class="help-inline">Roughly 155 Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="page_keywords">Page Keywords</label>
				<div class="controls">
					<textarea id="page_keywords" style="width:50%; height:5%;" name="page_keywords"><?php echo $this->row['page_keywords']; ?></textarea>
					<span class="help-inline">Maximum 10 words with comma (e.g. wallpaper, animals, fashion)</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="page_text">Page Content</label>
				<div class="controls">
					<textarea name="page_text" id="page_text"><?php echo $this->row['page_text']; ?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="footer">Page Section</label>
				<div class="controls">
					<select name="page_section">
						<option value="header">Header</option>
						<option value="footer">Footer</option>
						<option value="both">Both</option>
					</select>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="publish">Status</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="publish" name="page_status" value="publish" <?php if( $this->row['page_status'] == 'publish' ){ ?>checked="checked"<?php } ?> />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="draft" name="page_status" value="draft" <?php if( $this->row['page_status'] == 'draft' ){ ?>checked="checked"<?php } ?> />
						Draft
					</label>
				</div>
			</div>


			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Save Page" />
				</div>
			</div>

		</form>
	</div>
</div>
<?php include($this->get_theme_path()."/common/footer.php"); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/page/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
	document.edit.page_section.value = '<?php echo $this->row['page_section']; ?>';
</script>
</body>
</html>