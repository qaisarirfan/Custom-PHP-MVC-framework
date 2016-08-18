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
		<form class="form-horizontal"  name="add_slider_img" onSubmit="return add_validate(this)" enctype="multipart/form-data" method="post">
			<input type="hidden" name="command" />

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
					<input type="text" id="slider_title" name="slider_title" />
				</div>
			</div>


			<div class="control-group">
				<label class="control-label" for="slider_url">URL :</label>
				<div class="controls">
					<textarea name="slider_url" id="slider_url" style="width:50%; height:5%;"></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="slider_description">Desciption :</label>
				<div class="controls">
					<textarea name="slider_description" id="slider_description" style="width:50%; height:5%;"></textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="no">Status :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="yes" name="slider_status" value="publish" />
						Publish
					</label>
					<label class="radio inline">
						<input type="radio" id="no" name="slider_status" value="draft" checked="checked" />
						Draft
					</label>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Save Slider Img" />
				</div>
			</div>

		</form>		
	</div>
</div>
<?php include($this->get_theme_path()."/common/footer.php"); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/slider/js/isValidate.js" type="text/javascript" language="javascript"></script>
</body>
</html>