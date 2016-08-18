<?php
	$conn = mysql_connect( "localhost", "root", "" ) or die("Error in connection to the database server");
	mysql_select_db( "photos_gallery_db", $conn ) or die("Error opening database");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Captcha Setting</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.7.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="container">
	<?php include("../includes/header.php"); ?>
	<div class="btn-group pull-right">
		<button class="btn btn-inverse" data-toggle="dropdown">Option</button>
		<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
		<ul class="dropdown-menu pull-right">
			<li><a href="add-setting.php">Add Setting</a></li>
		</ul>
	</div>
	<div class="clearfix">&nbsp;</div>
	<hr />
	<table class="table table-bordered table-condensed table-hover table-striped">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>page_name</th>
				<th>captcha_type</th>
				<th>image_width</th>
				<th>image_height</th>
				<th>word_lenght</th>
				<th>word_type</th>
				<th>multiple_word</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM `captcha_preferences`";
				$result = mysql_query( $query, $conn );
				$i = 1;
				while ( $row = mysql_fetch_assoc( $result )){
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['page_name']; ?></td>
				<td><?php echo $row['captcha_type']; ?></td>
				<td><?php echo $row['image_width']; ?></td>
				<td><?php echo $row['image_height']; ?></td>
				<td><?php echo $row['word_lenght']; ?></td>
				<td><?php echo $row['word_type']; ?></td>
				<td><?php echo $row['multiple_word']; ?></td>
				<td><a href="edit-setting.php?id=<?php echo $row['id'] ?>">Edit</a></td>
			</tr>
			<?php
					$i++;
				}
			?>
		</tbody>
	</table>
</div>
<script src="js/bootstrap.min.js" type="text/javascript" language="javascript"></script>
</body>
</html>