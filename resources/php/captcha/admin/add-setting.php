<?php
	$conn = mysql_connect("localhost",'root','') or die("Error in connection to the database server");
	mysql_select_db("photos_gallery_db",$conn) or die("Error opening database");

	if ( $_REQUEST['command'] == 'add' ){
		$page_name = $_REQUEST['page_name'];
		$default_captcha = $_REQUEST['default_captcha'];
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
		
		$check_query = "select * from `captcha_preferences` where `page_name` = '$page_name'";
		$query_result = mysql_query( $check_query, $conn );
		$count = mysql_num_rows($query_result);
		if($count=='0'){
			$query = "insert into `captcha_preferences` (`page_name`,`default_captcha`,`image_width`,`image_height`,`background`,`fonts`,`color`,`min_font_size`,`max_font_size`,`min_rotation`,`max_rotation`,`word_lenght`,`word_type`,`multiple_word`,`multiple_word_lenght`,`random_word_lenght`,`math_first_range`,`math_second_range`,`math_operator`)
					values ('$page_name','$default_captcha','$image_width','$image_height','$background','$fonts','$color','$min_font_size','$max_font_size','$min_rotation','$max_rotation','$word_lenght','$word_type','$multiple_word','$multiple_word_lenght','$random_word_lenght','$math_first_range','$math_second_range','$math_operator')";
			$query_result = mysql_query( $query, $conn );
			if( $query_result ){
				header("location:setting.php");
			}
		}

	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Captcha Setting</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
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
	<div class="btn-group pull-right">
		<button class="btn btn-inverse" data-toggle="dropdown">Option</button>
		<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
		<ul class="dropdown-menu pull-right">
			<li><a href="setting.php">Back</a></li>
		</ul>
	</div>
	<div class="clearfix">&nbsp;</div>
	<hr />
	<form class="form-horizontal"  name="movie_add" onSubmit="return validate(this)" enctype="multipart/form-data" method="post">
		<input type="hidden" name="command" />
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="page_name">Captcha For :</label>
					<div class="controls">
						<select id="page_name" name="page_name">
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
					<label class="control-label" for="default_captcha">Default Captcha :</label>
					<div class="controls">
						<select id="default_captcha" name="default_captcha">
							<option value="false">False</option>
							<option value="true">True</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="image_width">Captcha Width :</label>
					<div class="controls">
						<input type="text" id="image_width" name="image_width" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="image_height">Captcha Height :</label>
					<div class="controls">
						<input type="text" id="image_height" name="image_height" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
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
							<option value="<?php echo $b_row['id'] ?>"><?php echo $b_row['background'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
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
							<option value="<?php echo $f_row['id'] ?>"><?php echo $f_row['font'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="colorpickerField1">Text Color :</label>
					<div class="controls">
						<input type="text" id="colorpickerField1" name="color" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="min_font_size">Text min font size :</label>
					<div class="controls">
						<input type="text" id="min_font_size" name="min_font_size" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="max_font_size">Text max font size :</label>
					<div class="controls">
						<input type="text" id="max_font_size" name="max_font_size" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="min_rotation">Text min rotation :</label>
					<div class="controls">
						<input type="text" id="min_rotation" name="min_rotation" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="max_rotation">Text max rotation :</label>
					<div class="controls">
						<input type="text" id="max_rotation" name="max_rotation" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="word_lenght">Text word lenght :</label>
					<div class="controls">
						<input type="text" id="word_lenght" name="word_lenght" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="multiple_word">multiple word :</label>
					<div class="controls">
						<select id="multiple_word" name="multiple_word">
							<option value="false">False</option>
							<option value="true">True</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="multiple_word_lenght">multiple word lenght :</label>
					<div class="controls">
						<input type="text" id="multiple_word_lenght" name="multiple_word_lenght" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="random_word_lenght">random word lenght :</label>
					<div class="controls">
						<input type="text" id="random_word_lenght" name="random_word_lenght" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="math_first_range">math first range :</label>
					<div class="controls">
						<input type="text" id="math_first_range" name="math_first_range" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="math_second_range">math second range :</label>
					<div class="controls">
						<input type="text" id="math_second_range" name="math_second_range" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
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
		</div>
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
		function validate(f){
			f.command.value = 'add';
			return true;
		}
	</script>
</body>
</html>