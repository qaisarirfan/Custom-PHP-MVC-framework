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
		
		<form class="form-horizontal"  name="slider-setting" onSubmit="return slider_setting_validate(this)" enctype="multipart/form-data" method="post" >
			<input type="hidden" name="command" value="save-setting" />
		
			<fieldset>
				<legend>Slider General Setting</legend>

				<div class="row">
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="yes_show">Slider Show</label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" id="yes_show" name="slider_show" value="yes" <?php if( $this->slider_setting['slider_show'] == 'yes' ){ ?>checked="checked"<?php } ?> />
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" id="no_show" name="slider_show" value="no" <?php if( $this->slider_setting['slider_show'] == 'no' ){ ?>checked="checked"<?php } ?> />
									No
								</label>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="shuffle_yes">Slider Shuffle</label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" id="shuffle_yes" name="slider_shuffle" value="true" <?php if( $this->slider_setting['slider_shuffle'] == 'true' ){ ?>checked="checked"<?php } ?> />
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" id="shuffle_no" name="slider_shuffle" value="false" <?php if( $this->slider_setting['slider_shuffle'] == 'false' ){ ?>checked="checked"<?php } ?> />
									No
								</label>
							</div>
						</div>
					</div>

				</div>

				<div class="row">
				
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_skin">Slider Skin</label>
							<div class="controls">
								<select name="slider_skin" id="slider_skin">
									<option value="pixel">Pixel</option>
									<option value="light-round">Light Round</option>
									<option value="minimal-small">Minimal Small</option>
								</select>
							</div>
						</div>
					</div>

					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_effect_type">Slider Transition Effects</label>
							<div class="controls">
								<select name="slider_effect_type" id="slider_effect_type">
									<option value="random">Random</option>
									<option value="slice">Slice</option>
									<option value="swipe">Swipe</option>
									<option value="slide">Slide</option>
									<option value="fade">Fade</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>

				<div class="row">
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_width">Slider Width</label>
							<div class="controls">
								<input type="text" id="slider_width" name="slider_width" value="<?php echo $this->slider_setting['slider_width'] ?>" />
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_height">Slider Height</label>
							<div class="controls">
								<input type="text" id="slider_height" name="slider_height" value="<?php echo $this->slider_setting['slider_height'] ?>" />
							</div>
						</div>
					</div>
				</div>

				<div class="row">
				
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_scale_type">Slider Scale Type</label>
							<div class="controls">
								<select name="slider_scale_type" id="slider_scale_type">
									<option value="insideFit">Inside Fit</option>
									<option value="outsideFit">Outside Fit</option>
									<option value="proportionalFit">Proportional Fit</option>
									<option value="exactFit">Exact Fit</option>
									<option value="noScale">No Scale</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_align_type">Slider Align Type</label>
							<div class="controls">
								<select name="slider_align_type" id="slider_align_type">
									<option value="leftTop">Left Top</option>
									<option value="leftCenter">Left Center</option>
									<option value="leftBottom">Left Bottom</option>
									<option value="centerTop">Center Center</option>
									<option value="centerBottom">Center Bottom</option>
									<option value="rightTop">Right Top</option>
									<option value="rightCenter">Right Center</option>
									<option value="rightBottom">Right Bottom</option>
								</select>
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row">

					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_slide_delay">Slider slide Delay</label>
							<div class="controls">
								<input type="text" id="slider_slide_delay" name="slider_slide_delay" value="<?php echo $this->slider_setting['slider_slide_delay'] ?>" />
							</div>
						</div>
					</div>

					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="slider_slide_loop_true">Slider Slides Loop</label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" id="slider_slide_loop_true" name="slider_slide_loop" value="true" <?php if( $this->slider_setting['slider_slide_loop'] == 'true' ){ ?>checked="checked"<?php } ?> />
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" id="slider_slide_loop_false" name="slider_slide_loop" value="false" <?php if( $this->slider_setting['slider_slide_loop'] == 'false' ){ ?>checked="checked"<?php } ?> />
									No
								</label>
							</div>
						</div>
					</div>

				</div>
				
			</fieldset>
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
		$('#slider_skin').val('<?php echo $this->slider_setting['slider_skin'] ?>');
		$('#slider_effect_type').val('<?php echo $this->slider_setting['slider_effect_type'] ?>');
		$('#slider_scale_type').val('<?php echo $this->slider_setting['slider_scale_type'] ?>');
		$('#slider_align_type').val('<?php echo $this->slider_setting['slider_align_type'] ?>');
	});
</script>
</body>
</html>