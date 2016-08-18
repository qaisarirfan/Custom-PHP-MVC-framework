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

		<form class="form-horizontal" name="edit_slider_img" onSubmit="return edit_validate(this)" enctype="multipart/form-data" method="post">
			<input type="hidden" name="command" value="command" />

			<div class="control-group">
				<div class="controls">
					<img src="<?php echo BASE_URL . SLIDER_PATH; ?>thumb-<?php echo $this->row['slider_picture'];?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="slider_picture">Picture :</label>
				<div class="controls">
					<input type="file" id="slider_picture" name="slider_picture" />
					<span class="help-inline">Size: <?php //echo $Pref->get_value('slider_width').' &times; '.$Pref->get_value('slider_height'); ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="slider_title">Title :</label>
				<div class="controls">
					<input type="text" id="slider_title" name="slider_title" value="<?php echo stripcslashes($this->row['slider_title']); ?>" />
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="url">URL :</label>
				<div class="controls">
					<textarea name="slider_url" id="slider_url" style="width:500px; height:50px;"><?php echo stripcslashes($this->row['slider_url']); ?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="description">Desciption :</label>
				<div class="controls">
					<textarea name="slider_description" id="slider_description" style="width:500px; height:100px;"><?php echo stripcslashes($this->row['slider_description']); ?></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="no">Status :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="yes" name="slider_status" value="publish" <?php if($this->row['slider_status']=="publish") echo 'checked="checked"'; ?> />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="no" name="slider_status" value="draft" <?php if($this->row['slider_status']=="draft") echo 'checked="checked"'; ?> />
						Draft
					</label>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Update Slider Img" />
				</div>
			</div>
		</form>
				
	</div>
</div>
<?php include($this->get_theme_path()."/common/footer.php"); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/slider/js/isValidate.js" type="text/javascript" language="javascript"></script>
</body>
</html>