<?php
	$conn = mysql_connect("localhost",'root','') or die("Error in connection to the database server");
	mysql_select_db("photos_gallery_db",$conn) or die("Error opening database");

	if ( $_REQUEST['command'] == 'add' ){
		$path = "../fonts/";
		$font = $_FILES['font'];
		$query = "select * from `captcha_font_preferences` where `font` = '$font[name]'";
		$query_result = mysql_query( $query, $conn );
		$count = mysql_num_rows($query_result);
		if($count=='0'){
			$result = move_uploaded_file( $font['tmp_name'], $path.$font['name'] );
			
			if( $result ){
				$query = "insert into `captcha_font_preferences` (`name`,`font`) values ('$_REQUEST[name]','$font[name]')";
				$query_result = mysql_query( $query, $conn );
				if( $result ){
					header("location:setting.php");
				}
			}
		}
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Captcha Background Preferences</title>
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
			<li><a data-toggle="modal" href="#add-background">Add Font</a></li>
		</ul>
	</div>
	<div class="clearfix">&nbsp;</div>
	<hr />
	<table class="table table-bordered table-condensed table-hover table-striped">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>name</th>
				<th>font</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM `captcha_font_preferences`";
				$result = mysql_query( $query, $conn );
				$i = 1;
				while ( $row = mysql_fetch_assoc( $result )){
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['font']; ?></td>
				<td><a href="">Delete</a></td>
			</tr>
			<?php
					$i++;
				}
			?>
		</tbody>
	</table>
	<div class="modal fade" id="add-background">
		<div class="modal-dialog">
			<div class="modal-content">
				<form class="form-horizontal" name="captcha_background_preferences" onSubmit="return validate(this);" enctype="multipart/form-data" method="post">
					<input type="hidden" name="command" />
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Add Font</h4>
					</div>
					<div class="modal-body">

						<div class="control-group">
							<label class="control-label" for="font">Captcha Font :</label>
							<div class="controls">
								<input type="file" id="font" name="font" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="name">Font Name :</label>
							<div class="controls">
								<input type="text" id="name" name="name" />
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
			<!-- /.modal-content --> 
		</div>
		<!-- /.modal-dialog --> 
	</div>
</div>
<script src="js/bootstrap.min.js" type="text/javascript" language="javascript"></script> 
<script type="text/javascript" language="javascript">
		function validate(f){
			if( f.font.value == '' ){
				alert( "Select font" );
				f.background.focus();
				return false;
			}else if( f.name.value == '' ){
				alert( "Select name" );
				f.name.focus();
				return false;
			}else{
				f.command.value = 'add';
				return true;
			}
		}
	</script>
</body>
</html>