<?php
	$conn = mysql_connect("localhost",'root','') or die("Error in connection to the database server");
	mysql_select_db("photos_gallery_db",$conn) or die("Error opening database");

	$id = intval( $_REQUEST['id'] );

	$query = "SELECT * FROM `captcha_preferences` WHERE `id` = '$id' LIMIT 0 , 1";
	$result = mysql_query( $query, $conn );
	$row = mysql_fetch_assoc( $result );

	if ( $_REQUEST['command'] == 'edit' ){
		$captcha_type = $_REQUEST['captcha_type'];
		$image_width = $_REQUEST['image_width'];
		$image_height = $_REQUEST['image_height'];
		$background = $_REQUEST['background'];
		$fonts = $_REQUEST['fonts'];
		$color = $_REQUEST['color'];
		$min_font_size = $_REQUEST['min_font_size'];
		$max_font_size = $_REQUEST['max_font_size'];
		$min_rotation = $_REQUEST['min_rotation'];
		$max_rotation = $_REQUEST['max_rotation'];
		$word_lenght = $_REQUEST['word_lenght'];
		$multiple_word_lenght = $_REQUEST['multiple_word_lenght'];
		$random_word_lenght = $_REQUEST['random_word_lenght'];
		$math_first_range = $_REQUEST['math_first_range'];
		$math_second_range = $_REQUEST['math_second_range'];
		$math_operator = $_REQUEST['math_operator'];
		$word_type = $_REQUEST['word_type'];
		$multiple_word = $_REQUEST['multiple_word'];
		
		$query = "UPDATE `captcha_preferences` SET 
			`captcha_type` = '$captcha_type', 
			`image_width` = '$image_width', 
			`image_height` = '$image_height',
			`background` = '$background',
			`fonts` = '$fonts',
			`color` = '$color',
			`min_font_size` = '$min_font_size',
			`max_font_size` = '$max_font_size',
			`min_rotation` = '$min_rotation',
			`max_rotation` = '$max_rotation',
			`word_lenght` = '$word_lenght',
			`word_type` = '$word_type',
			`multiple_word` = '$multiple_word',
			`multiple_word_lenght` = '$multiple_word_lenght',
			`random_word_lenght` = '$random_word_lenght',
			`math_first_range` = '$math_first_range',
			`math_second_range` = '$math_second_range',
			`math_operator` = '$math_operator'
		WHERE `id` = '$id'";

		$query_result = mysql_query( $query, $conn );
		if( $query_result ){
			header("location:setting.php");
		}

	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Captcha Setting</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="colorpicker/css/colorpicker.css" type="text/css" />
<script src="js/jquery-1.7.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="colorpicker/js/eye.js"></script>
<script type="text/javascript" src="colorpicker/js/utils.js"></script>
<script type="text/javascript" src="colorpicker/js/layout.js?ver=1.0.2"></script>
</head>

<body>
<div class="container">
	<?php include("../includes/header.php"); ?>
	<h3 class="pull-left">Captcha Setting</h3>
	<div class="btn-group pull-right">
		<button class="btn btn-inverse" data-toggle="dropdown">Option</button>
		<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
		<ul class="dropdown-menu pull-right">
			<li><a href="setting.php">Back</a></li>
		</ul>
	</div>
	<div class="clearfix">&nbsp;</div>
	<hr />
	<form class="form-horizontal"  name="edit_setting" onSubmit="return validate(this)" enctype="multipart/form-data" method="post">
		<input type="hidden" name="command" />
		<fieldset>
			<legend>Default Captcha</legend>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="page_name">Captcha For :</label>
						<div class="controls">
							<select id="page_name" name="page_name" disabled>
								<option value="blog">Blog</option>
								<option value="movies">Movies</option>
								<option value="contact">Contact</option>
								<option value="login">Login</option>
								<option value="register">Register</option>
							</select>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="captcha_type">Captcha Type :</label>
						<div class="controls">
							<select id="captcha_type" name="captcha_type">
								<option value="default">Default</option>
								<option value="custom">Custom</option>
								<option value="random">Random</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="word_type">Captcha Word Type :</label>
						<div class="controls">
							<select id="word_type" name="word_type">
								<option value="alphabetic">Alphabetic</option>
								<option value="mixstring">Mix String</option>
								<option value="number">Number</option>
								<option value="math">Math</option>
								<option value="dictionary">Dictionary</option>
							</select>
						</div>
					</div>
				</div>
				<div class="span6 math">
					<div class="control-group">
						<label class="control-label" for="math_operator">math operator :</label>
						<div class="controls">
							<select id="math_operator" name="math_operator">
								<option value="+">+</option>
								<option value="-">-</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6 math">
					<div class="control-group">
						<label class="control-label" for="math_first_range">math first range :</label>
						<div class="controls">
							<input type="text" id="math_first_range" name="math_first_range" value="<?php echo $row['math_first_range'] ?>" />
							<span class="help-inline">Greater then second range like 10, 19</span> </div>
					</div>
				</div>
				<div class="span6 math">
					<div class="control-group">
						<label class="control-label" for="math_second_range">math second range :</label>
						<div class="controls">
							<input type="text" id="math_second_range" name="math_second_range" value="<?php echo $row['math_second_range'] ?>" />
							<span class="help-inline">less then first range like 1, 9</span> </div>
					</div>
				</div>
			</div>
			<div class="row text">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="word_lenght">Single word lenght :</label>
						<div class="controls">
							<input type="text" id="word_lenght" name="word_lenght" value="<?php echo $row['word_lenght'] ?>" />
							<span class="help-inline">Word Lenght must between 2-10</span>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="multiple_word">multiple word :</label>
						<div class="controls">
							<select id="multiple_word" name="multiple_word">
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row text multiple">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="multiple_word_lenght">multiple word lenght :</label>
						<div class="controls">
							<input type="text" id="multiple_word_lenght" name="multiple_word_lenght" value="<?php echo $row['multiple_word_lenght'] ?>" />
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="random_word_lenght">multiple random word lenght :</label>
						<div class="controls">
							<input type="text" id="random_word_lenght" name="random_word_lenght" value="<?php echo $row['random_word_lenght'] ?>" />
							<span class="help-inline">this value must be comma sprated 2,3</span>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset class="default">
			<legend>Captcha Image Setting</legend>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="image_width">Captcha Width :</label>
						<div class="controls">
							<input type="text" id="image_width" name="image_width" value="<?php echo $row['image_width'] ?>" />
							<span class="help-inline">value must be &gt;= 200</span>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="image_height">Captcha Height :</label>
						<div class="controls">
							<input type="text" id="image_height" name="image_height" value="<?php echo $row['image_height'] ?>" />
							<span class="help-inline">value must be &gt;= 70</span>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="background">Captcha Background :</label>
						<div class="controls">
							<select id="background" name="background">
								<?php
										$query = "SELECT * FROM `captcha_background_preferences` ORDER BY `background` ASC";
										$result = mysql_query( $query );
										while ( $b_row = mysql_fetch_assoc($result) ) {
									?>
								<option value="<?php echo $b_row['id'] ?>"><?php echo $b_row['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset class="default">
			<legend>Captcha Text Setting</legend>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="fonts">Captcha Fonts :</label>
						<div class="controls">
							<select id="fonts" name="fonts">
								<?php
										$query = "SELECT * FROM `captcha_font_preferences` ORDER BY `font` ASC";
										$result = mysql_query( $query );
										while ( $f_row = mysql_fetch_assoc($result) ) {
									?>
								<option value="<?php echo $f_row['id'] ?>"><?php echo $f_row['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="colorpickerField1">Text Color :</label>
						<div class="controls">
							<input type="text" id="colorpickerField1" name="color" value="<?php echo $row['color'] ?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="min_font_size">Text min font size :</label>
						<div class="controls">
							<input type="text" id="min_font_size" name="min_font_size" value="<?php echo $row['min_font_size'] ?>" />
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="max_font_size">Text max font size :</label>
						<div class="controls">
							<input type="text" id="max_font_size" name="max_font_size" value="<?php echo $row['max_font_size'] ?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="min_rotation">Text min rotation :</label>
						<div class="controls">
							<input type="text" id="min_rotation" name="min_rotation" value="<?php echo $row['min_rotation'] ?>" />
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="max_rotation">Text max rotation :</label>
						<div class="controls">
							<input type="text" id="max_rotation" name="max_rotation" value="<?php echo $row['max_rotation'] ?>" />
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary btn-large" name="submit" value="Save" />
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script src="js/bootstrap.min.js" type="text/javascript" language="javascript"></script> 
<script type="text/javascript" language="javascript">
	
		$(document).ready(function(e) {
			var captcha_type = $('#captcha_type').val();
			if( captcha_type == 'default' ){
				$(".default").hide();
			}else{
				$(".default").show();
			}
			$('#captcha_type').change(function(){
				var type = $(this).val();
				if ( type == 'default' ){
					$(".default").hide();
				}else{
					$(".default").show();
				}

			});

			var word_type = $('#word_type').val();
			if( word_type == 'math' ){
				$(".math").show();
				$(".text").hide();
			}else{
				$(".math").hide();
				$(".text").show();
			}
			$('#word_type').change(function(){
				if ( $(this).val() != 'math' ){
					$(".math").hide();
					$(".text").show();
				}else{
					$(".math").show();
					$(".text").hide();
				}
			})

			var word_type = $('#multiple_word').val();
			if( word_type == 'no' ){
				$(".multiple").hide();
			}else{
				$(".multiple").show();
			}
			$('#multiple_word').change(function(){
				if ( $(this).val() != 'no' ){
					$(".multiple").show();
				}else{
					$(".multiple").hide();
				}
			})

		});
	
		function validate(f){
			f.command.value = 'edit';
			return true;
		}
		document.edit_setting.page_name.value = '<?php echo $row['page_name']; ?>';
		document.edit_setting.captcha_type.value = '<?php echo $row['captcha_type']; ?>';
		document.edit_setting.background.value = '<?php echo $row['background']; ?>';
		document.edit_setting.fonts.value = '<?php echo $row['fonts']; ?>';
		document.edit_setting.multiple_word.value = '<?php echo $row['multiple_word']; ?>';
		document.edit_setting.math_operator.value = '<?php echo $row['math_operator']; ?>';
		document.edit_setting.word_type.value = '<?php echo $row['word_type']; ?>';
	</script>
</body>
</html>