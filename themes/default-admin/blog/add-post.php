<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#content",
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
	$(document).ready(function(){
		$('#category').on('change',function(){
			var category = $(this).val();
			if ( category != '0' ){
				var dataString = 'category='+ category;
				$.ajax({
					type : "POST",
					url : "<?php echo BASE_URL; ?>ajax/select-category.php",
					data : dataString,
					cache : false,
					success : function(html){
						$("#subCategory").html(html);
					}
				});
			}else{
				$("#subCategory").html('');
			}
		});
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
		<form class="form-horizontal" name="add_post" onSubmit="return add_post_validate(this)" method="post" enctype="multipart/form-data">
			<input type="hidden" name="command" />

			<div class="control-group">
				<label class="control-label" for="post_thumb">Pic for thumb :</label>
				<div class="controls">
					<input type="file" id="post_thumb" name="post_thumb" value="<?php echo $_FILES['post_thumb']; ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="category">Post Category :</label>
				<div class="controls">
					<select name="category" id="category">
						<option value="0" selected="selected">Select Category</option>
						<?php foreach( $this->category as $category ){ ?>
						<option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div id="subCategory"></div>

			<div class="control-group">
				<label class="control-label" for="title">Post Title :</label>
				<div class="controls"><input type="text" id="title" name="post_title" value="<?php echo $_REQUEST['post_title']; ?>" /></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="descriptions">Post SEO Description:</label>
				<div class="controls">
					<textarea id="descriptions" onKeyDown="value_counter(this,155,'#description');" onKeyUp="value_counter(this,155,'#description');" style="width:50%; height:5%;" name="post_description" ><?php echo $_REQUEST['post_description']; ?></textarea>
					<span class="help-inline">Roughly <b id="description">155</b> Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="keywords">Post Searching Keywords:</label>
				<div class="controls">
					<textarea id="keywords" onKeyDown="value_counter(this,200,'#keyword');" onKeyUp="value_counter(this,200,'#keyword');"  style="width:50%; height:5%;" name="post_keywords"><?php echo $_REQUEST['post_keywords']; ?></textarea>
					<span class="help-inline">Maximum <b>10</b> words with comma <b>(e.g. wallpaper, animals, fashion)</b> <br />and type <b id="keyword">200</b> Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="post_tags">Post Tags:</label>
				<div class="controls">
					<textarea id="post_tags" style="width:50%; height:5%;" name="post_tags"><?php echo $_REQUEST['post_tags']; ?></textarea>
					<span class="help-inline">Type Post Tags separated by comma (,)</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="content">Post Content :</label>
				<div class="controls">
					<textarea name="post_content" id="content"><?php echo $_REQUEST['post_content']; ?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="no">Featured :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="yes" name="post_featured" value="yes" <?php if( $_REQUEST['post_featured'] == 'yes' ){ ?>checked="checked"<?php } ?> />
						Yes
					</label>
					<label class="radio inline">
						<input type="radio" id="no" name="post_featured" value="no" <?php if( $_REQUEST['post_featured'] == 'no' ){ ?>checked="checked"<?php }else{ ?>checked="checked"<?php } ?> />
						No
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="publish">Status :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="publish" name="post_status" value="publish" <?php if( $_REQUEST['post_status'] == 'publish' ){ ?>checked="checked"<?php } ?> />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="draft" name="post_status" value="draft" <?php if( $_REQUEST['post_status'] == 'draft' ){ ?>checked="checked"<?php }else{ ?>checked="checked"<?php } ?> />
						Draft
					</label>
				</div>
			</div>


			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Add Post" />
				</div>
			</div>

		</form>
	</div>
</div>
<?php include($this->get_theme_path()."/common/footer.php"); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/blog/js/isValidate_post.js?v1.1" type="text/javascript" language="javascript"></script>
</body>
</html>