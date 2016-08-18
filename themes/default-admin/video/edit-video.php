<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="stylesheet" href="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.css">
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/examples/bower_components/angular/angular.min.js"></script> 
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput.min.js"></script> 
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/bootstrap-tagsinput-master/dist/bootstrap-tagsinput-angular.js"></script> 
<script type="text/javascript">
	tinymce.init({
		selector: "textarea#video_description",
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

		var t = $( '#video_type' ).val();
		if( t == '' ){
			$( '#video_type' ).val( 'youtube' );
			$('#dailymotion-vimeo').hide();
			$('#youtube').show();
		}else if( t == 'dailymotion' ){
			$('#dailymotion-vimeom, #description').show();
			$('#youtube').hide();
		}else if( t == 'youtube' ){
			$('#dailymotion-vimeo').hide();
			$('#youtube, #description').show();
		}else if( t == 'vimeo' ){
			$('#dailymotion-vimeo').show();
			$('#youtube, #description').hide();
		}

		$('#video_type').change(function(){
			var type = $(this).val();
			if( type == 'dailymotion' ){
				$('#dailymotion-vimeo, #description').show();
				$('#youtube').hide();
				
			}else if( type == 'youtube' ){
				$('#dailymotion-vimeo').hide();
				$('#youtube').show();
			}else if( type == 'vimeo' ){
				$('#dailymotion-vimeo').show();
				$('#youtube, #description').hide();
			}

		});

		$('#category').on('change',function(){
			var category = $(this).val();
			if ( category != '0' ){
				var dataString = 'category='+ category;
				$.ajax({
					type : "POST",
					url : "<?php echo BASE_URL; ?>ajax/select-category.php",
					data : dataString,
					cache : false,
					beforeSend: function(){
						$("#loading").show();
					},
					success : function(html){
						$("#loading").hide();
						$("#subCategory").html(html);
					}
				});
			}else{
				$("#subCategory").html('');
			}
		});
		$('#video_tags').tagsinput();
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
		<form class="form-horizontal" name="edit_video" onSubmit="return edit_video_validate(this)" method="post">
			<input type="hidden" name="command" />

			<div class="control-group">
				<label class="control-label" for="video_type">Video Type :</label>
				<div class="controls">
					<select name="video_type" id="video_type">
						<option value="" selected="selected">Select Video Type</option>
						<option value="dailymotion">Dailymotion</option>
						<option value="youtube">YouTube</option>
						<option value="vimeo">Vimeo</option>
					</select>
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
					<span style="display:none" id="loading" class="help-inline">Loading...</span>					
				</div>
			</div>

			<div id="subCategory">
				<div class="control-group">
					<label class="control-label" for="sub_category">Sub Category :</label>
					<div class="controls">
						<select name="sub_category" id="sub_category">
							<option value="0" selected="selected">Select Sub Category</option>
							<?php foreach( $this->subcategory as $sub_category ){ ?>
							<option value="<?php echo $sub_category['id'] ?>"><?php echo stripcslashes( $sub_category['name'] ); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="video_title">Video Title :</label>
				<div class="controls"><input id="video_title" type="text" name="video_title" value="<?php echo stripcslashes($this->row['video_title']); ?>" /></div>
			</div>


			<div id="youtube">

				<div class="control-group">
					<label class="control-label" for="video_author_name">Author Name:</label>
					<div class="controls"><input id="video_author_name" type="text" name="video_author_name" value="<?php echo $this->row['video_author_name'] ?>" /></div>
				</div>

				<div class="control-group">
					<label class="control-label" for="video_author_url">Author Video URL :</label>
					<div class="controls"><textarea id="video_author_url" style="width:50%; height:5%" type="text" name="video_author_url"><?php echo $this->row['video_author_url'] ?></textarea></div>
				</div>

			</div>

			<div class="control-group" id="dailymotion-vimeo">
				<label class="control-label" for="video_url">Video URL :</label>
				<div class="controls"><textarea id="video_url" style="width:50%; height:5%" type="text" name="video_url"><?php echo $this->row['video_url']; ?></textarea></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="video_tags">Tags:</label>
				<div class="controls">
					<input type="text" id="video_tags" name="video_tags" value="<?php echo stripslashes( $this->row['video_tags'] ); ?>" data-role="tagsinput" placeholder="Add tags" />
					<span class="help-inline">Type Tags press enter</span>
				</div>
			</div>

			<div class="control-group" id="description">
				<label class="control-label" for="video_description">Video Description:</label>
				<div class="controls"><textarea id="video_description" name="video_description"><?php echo $this->row['video_description'] ?></textarea></div>
			</div>

			<div class="control-group">
				<label class="control-label" for="video_featured_no">Video Featured:</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="video_featured_yes" name="video_featured" value="yes" <?php if( $this->row['video_featured'] == 'yes' ){ ?>checked="checked"<?php } ?> />
						Yes
					</label>
					<label class="radio inline">
						<input type="radio" id="video_featured_no" name="video_featured" value="no" <?php if( $this->row['video_featured'] == 'no' ){ ?>checked="checked"<?php } ?> />
						No
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="video_status_no">Video Status:</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="video_status_yes" name="video_status" value="publish" <?php if( $this->row['video_status'] == 'publish' ){ ?>checked="checked"<?php } ?> />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="video_status_no" name="video_status" value="draft" <?php if( $this->row['video_status'] == 'draft' ){ ?>checked="checked"<?php } ?> />
						Draft
					</label>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Save Video" />
				</div>
			</div>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/video/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
<script>
	document.edit_video.video_type.value = '<?php echo $this->row['video_type'] ?>';
	document.edit_video.category.value = '<?php echo $this->row['category'] ?>';
	document.edit_video.sub_category.value = '<?php echo $this->row['sub_category'] ?>';
</script>
</body>
</html>