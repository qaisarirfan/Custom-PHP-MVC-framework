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
		$('#category').change(function(){
			var category = $(this).val();
			if( category != '0' ){
				var dataString = 'category='+ category;
				$.ajax({
					type : "POST",
					url : "<?php echo BASE_URL; ?>ajax/select-category.php",
					data : dataString,
					cache : false,
					success : function(html){
						$("#subCategory").html(html);
					}
				})
			}else{
				$("#subCategory").html('');
			}
		});
	});
</script>
</head>
<body onLoad="oload();">
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
		<form class="form-horizontal" name="edit_post" onSubmit="return save_post_validate();" enctype="multipart/form-data" method="post">
			<input type="hidden" name="command" />
			<input type="hidden" name="postid" value="<?php echo $this->postid; ?>" />
			<div class="control-group">
				<div class="controls">
					<img alt="<?php echo stripslashes($row['title']); ?>" src="<?php echo BASE_URL . POST_PIC. 'medium-'.$this->row['post_thumb']; ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="post_thumb">Pic for thumb :</label>
				<div class="controls">
					<input type="file" id="post_thumb" name="post_thumb" value="<?php echo $_FILES['post_thumb']; ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="category">Category :</label>
				<div class="controls">
					<select name="category" id="category">
						<option value="0" selected="selected">Select Category</option>
						<?php foreach( $this->category as $category ){ ?>
						<option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div id="subCategory">
				<div class="control-group">
					<label class="control-label" for="sub_category">Sub Category :</label>
					<div class="controls">
						<select name="sub_category" id="sub_category">
							<option value="0" selected="selected">Select Category</option>
							<?php foreach( $this->subcategory as $sub_category ){ ?>
							<option value="<?php echo $sub_category['id'] ?>"><?php echo stripcslashes( $sub_category['name'] ); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="title">Post Title :</label>
				<div class="controls"><input type="text" id="title" name="post_title" value="<?php echo stripslashes($this->row['post_title']); ?>" /></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="descriptions">Post SEO Description:</label>
				<div class="controls">
					<textarea id="descriptions" onKeyDown="value_counter(this,155,'#description');" onKeyUp="value_counter(this,155,'#description');" style="width:50%; height:5%;" name="post_description" ><?php echo stripslashes($this->row['post_description']); ?></textarea>
					<span class="help-inline">Roughly <b id="description">155</b> Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="keywords">Post Searching Keywords:</label>
				<div class="controls">
					<textarea id="keywords" onKeyDown="value_counter(this,200,'#keyword');" onKeyUp="value_counter(this,200,'#keyword');" style="width:50%; height:5%;" name="post_keywords"><?php echo stripslashes($this->row['post_keywords']); ?></textarea>
					<span class="help-inline">Maximum <b>10</b> words with comma <b>(e.g. wallpaper, animals, fashion)</b> <br />and type <b id="keyword">200</b> Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="post_tags">Post Tags:</label>
				<div class="controls">
					<textarea id="post_tags" style="width:50%; height:5%;" name="post_tags"><?php echo $this->row['post_tags']; ?></textarea>
					<span class="help-inline">Type Post Tags separated by comma (,)</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="content">Post Content :</label>
				<div class="controls">
					<textarea name="post_content" id="content"><?php echo stripslashes($this->row['post_content']); ?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="no">Featured :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="yes" name="post_featured" value="yes" <?php if($this->row['post_featured']=="yes") echo 'checked="checked"'; ?> />
						Yes
					</label>
					<label class="radio inline">
						<input type="radio" id="no" name="post_featured" value="no" <?php if($this->row['post_featured']=="no") echo 'checked="checked"'; ?> />
						No
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="publish">Status :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="publish" name="post_status" value="publish" <?php if($this->row['post_status']=="publish") echo 'checked="checked"'; ?> />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="draft" name="post_status" value="draft" <?php if($this->row['post_status']=="draft") echo 'checked="checked"'; ?> />
						Draft
					</label>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Update Post" />
				</div>
			</div>
		</form>
	</div>
</div>
<?php include($this->get_theme_path()."/common/footer.php"); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/blog/js/isValidate_post.js?v1.1" type="text/javascript" language="javascript"></script>
<script language="javascript">
	function oload(){
		value_counter(document.edit_post.post_keywords,200,'#keyword');
		value_counter(document.edit_post.post_description,155,'#description');
	}
	document.edit_post.category.value='<?php echo $this->row['category'] ?>';
	document.edit_post.sub_category.value='<?php echo $this->row['sub_category'] ?>';
</script> 
</body>
</html>