<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="stylesheet" href="<?php echo $this->get_resources_path(); ?>/js-jquery/colorpicker/css/colorpicker.css?v1.1" type="text/css" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title">
			<h1 class="font-share-techregular"><?php echo $page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<form class="form-horizontal" name="add_background" onSubmit="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="command" value="add-customize" />
			<div class="control-group">
				<label class="control-label" for="colorpickerField1">Backgrounds Color :</label>
				<div class="controls">
					<input name="backgrounds_color" type="text" maxlength="6" id="colorpickerField1" value="ffffff" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="background_image">Backgrounds Image :</label>
				<div class="controls">
					<input name="background_image" id="background_image" type="file" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="position_x">Background Position :</label>
				<div class="controls">
					<select class="select" id="position_x" name="position_x">
						<option selected="selected" value="">-&nbsp;select&nbsp;-</option>
						<option value="left">Left</option>
						<option value="center">Center</option>
						<option value="right">Right</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<select class="select" id="position_y" name="position_y">
						<option selected="selected" value="">-&nbsp;select&nbsp;-</option>
						<option value="top">Top</option>
						<option value="center">Center</option>
						<option value="bottom">Bottom</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="background_repeat">Background Repeat :</label>
				<div class="controls">
					<select class="select" id="background_repeat" name="background_repeat">
						<option selected="selected" value="">-&nbsp;select&nbsp;-</option>
						<option value="no-repeat">no-repeat</option>
						<option value="repeat">repeat</option>
						<option value="repeat-x">repeat-x</option>
						<option value="repeat-y">repeat-y</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="background_repeat">Background Attachment :</label>
				<div class="controls">
					<select class="select" id="background_attachment" name="background_attachment">
						<option selected="selected" value="">-&nbsp;select&nbsp;-</option>
						<option value="fixed">fixed</option>
						<option value="scroll">scroll</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="no">is Lock :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="yes" name="locked" value="yes" />
						Yes </label>
					<label class="radio inline">
						<input type="radio" id="no" name="locked" value="no" checked="checked" />
						No </label>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary btn-large" name="submit" value="Save" />
				</div>
			</div>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/colorpicker/js/colorpicker.js"></script> 
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/colorpicker/js/eye.js"></script> 
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/colorpicker/js/utils.js"></script> 
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/colorpicker/js/layout.js?ver=1.0.2"></script>
</body>
</html>