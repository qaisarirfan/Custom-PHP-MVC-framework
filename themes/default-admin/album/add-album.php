<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="stylesheet" href="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.css">
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/examples/bower_components/angular/angular.min.js"></script> 
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.min.js"></script> 
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput-angular.js"></script> 
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#album_detail",
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
		$('#album_tags').tagsinput();
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
		<form class="form-horizontal" name="add" onSubmit="return add_allbum_validate()" method="post">
			<input type="hidden" name="command">

			<div class="control-group">
				<label class="control-label" for="category">Category</label>
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
				<label class="control-label" for="album_name">Name</label>
				<div class="controls"><input id="album_name" type="text" name="album_name" /></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="album_description">Description</label>
				<div class="controls">
					<textarea id="album_description" class="textarea" name="album_description" style="width:50%; height:5%;"></textarea>
					<span class="help-inline">Roughly 155 Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="album_keywords">Keywords</label>
				<div class="controls">
					<textarea id="album_keywords" class="textarea" style="width:50%; height:5%;" name="album_keywords"></textarea>
					<span class="help-inline">Maximum 10 words with comma (e.g. wallpaper, animals, fashion) and type 200 Characters</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="album_tags">Tags:</label>
				<div class="controls">
					<input type="text" id="album_tags" name="album_tags" value="<?php echo stripslashes( $this->row['album_tags'] ); ?>" data-role="tagsinput" placeholder="Add tags" />
					<span class="help-inline">Type Tags press enter</span>
				</div>
			</div>


			<div class="control-group">
				<label class="control-label" for="album_detail">Description</label>
				<div class="controls">
					<textarea id="album_detail" name="album_detail"></textarea>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" name="submit" value="Add Album" />
				</div>
			</div>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/album/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
</body>
</html>