<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
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
		
		<form class="form-horizontal"  name="slider-setting" onSubmit="return video_setting_validate(this)" enctype="multipart/form-data" method="post" >
			<input type="hidden" name="command" value="save-setting" />
		
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="yes_show">Video Show</label>
						<div class="controls">
							<label class="radio inline">
								<input type="radio" id="yes_show" name="video_show" value="yes" <?php if( $this->video_setting['video_show'] == 'yes' ){ ?>checked="checked"<?php } ?> />
								Yes
							</label>
							<label class="radio inline">
								<input type="radio" id="no_show" name="video_show" value="no" <?php if( $this->video_setting['video_show'] == 'no' ){ ?>checked="checked"<?php } ?> />
								No
							</label>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_per_page_post">Per Page Video Post</label>
						<div class="controls">
							<select name="video_per_page_post" id="video_per_page_post">
								<?php for( $i = 8; $i <= 24; $i++ ){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
			
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_top_view_post">Top View Video Post</label>
						<div class="controls">
							<select name="video_top_view_post" id="video_top_view_post">
								<?php for( $i = 4; $i <= 14; $i = $i + 2 ){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_latest_post">Latest Video Post</label>
						<div class="controls">
							<select name="video_latest_post" id="video_latest_post">
								<?php for( $i = 4; $i <= 14; $i = $i + 2 ){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_featured_post">Featured Video Post</label>
						<div class="controls">
							<select name="video_featured_post" id="video_featured_post">
								<?php for( $i = 4; $i <= 14; $i = $i + 2 ){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				
			</div>

			<div class="row">
			
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_related_post">Related Video Post</label>
						<div class="controls">
							<select name="video_related_post" id="video_related_post">
								<?php for( $i = 5; $i <= 20; $i = $i + 1 ){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="video_page_name">Video Page Name</label>
						<div class="controls">
							<input type="text" name="video_page_name" id="video_page_name" value="<?php echo $this->video_setting['video_page_name'] ?>" />
						</div>
					</div>
				</div>

			</div>

			<div class="control-group">
				<label class="control-label" for="video_keywords">Video Keywords</label>
				<div class="controls">
					<textarea id="video_keywords" style="width:50%; height:5%;" name="video_keywords"><?php echo $this->video_setting['video_keywords'] ?></textarea>
					<span class="help-inline">Maximum 10 words with comma (e.g. wallpaper, animals, fashion)</span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="video_description">Video Description</label>
				<div class="controls">
					<textarea id="video_description" style="width:50%; height:5%;" name="video_description"><?php echo $this->video_setting['video_description'] ?></textarea>
					<span class="help-inline">Roughly 155 Characters</span>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" name="submit" value="Save Setting" />
				</div>
			</div>
		
		</form>		
		
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/slider/js/isValidate.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(e) {
		$('#video_per_page_post').val('<?php echo $this->video_setting['video_per_page_post'] ?>');
		$('#video_top_view_post').val('<?php echo $this->video_setting['video_top_view_post'] ?>');
		$('#video_latest_post').val('<?php echo $this->video_setting['video_latest_post'] ?>');
		$('#video_related_post').val('<?php echo $this->video_setting['video_related_post'] ?>');
		$('#video_featured_post').val('<?php echo $this->video_setting['video_featured_post'] ?>');
	});
</script>
</body>
</html>