<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<style> #screenshot { position:absolute; border:1px solid #ccc; background:#333; padding:5px; display:none; color:#fff; } </style>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title ">
			<h1 class="font-share-techregular"><?php echo $this->page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=add-photo&amp;id=<?php echo $this->id; ?>">Add Photo</a></li>
					<li class="divider"></li>
					<li><a href="javascript:history.go(-1)">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<table class="table table-bordered table-condensed table-hover table-striped">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Thumb / Name</th>
					<th>URL String</th>
					<th>Total View</th>
					<th>Create Date</th>
					<th>Publish</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$count = 0;
					foreach( $this->rows as $row ){
						$count++;
				?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><a class="screenshot" rel="<?php echo BASE_URL . PHOTOS . $this->album_name .'/thumb-'.$row['photo_name']; ?>" href="javascript:void(0)"><?php echo stripslashes($row['photo_title']);?></a></td>
					<td><a href="<?php echo $row['photo_url']; ?>" target="_blank"><?php echo $row['photo_url_str']; ?></a></td>
					<td><?php echo $row['photo_view']; ?></td>
					<td><?php echo $row['photo_date']; ?></td>
					<td><?php if( $row['photo_status'] != 'publish' ){?><span style="color:red">Draft</span><?php }else{?>Publish<?php }?></td>
					<td>
						<a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=edit-photo&amp;id=<?php echo $row['id']; ?>&amp;album=<?php echo $row['album_id'] ?>">Edit</a>&nbsp;| &nbsp;
						<a href="javascript:void(0)" onClick="photo_del('<?php echo $row['id']; ?>','<?php echo $row['album_id']; ?>','<?php echo stripslashes($row['photo_name']);?>')">Delete</a>
					</td>
				</tr>
				<?php } ?>
				<?php if( count( $this->rows ) == '0' ){ ?>
				<tr>
					<td colspan="8" class="no-found">Record no found.</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $this->paging; ?>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/album/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
<script src="<?php echo $this->get_resources_path(); ?>/js-jquery/screenshot-preview/js/main.js" type="text/javascript"></script> 
<form name="album_photo" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="name" />
	<input type="hidden" name="photo_id" />
	<input type="hidden" name="album_id" />
</form>
</body>
</html>