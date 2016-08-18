<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
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
					<li><a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=add-album">Add Album</a></li>
					<li class="divider"></li>
					<li><a href="javascript:history.go(-1)">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<table class="table table-bordered table-condensed table-hover table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>URL String</th>
					<th>Total image</th>
					<th>Total View</th>
					<th>Create Date</th>
					<th>Publish</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach( $this->rows as $row ){
				?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><i class="icon-folder-close"></i>&nbsp;<a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=open&amp;id=<?php echo $row['id']; ?>"><?php echo stripslashes($row['album_name']);?></a></td>
					<td><a href="<?php echo $row['album_url']; ?>" target="_blank"><?php echo $row['album_url_str']; ?></a></td>
					<td><?php echo $row['album_total_file']; ?></td>
					<td><?php echo $row['album_view']; ?></td>
					<td><?php echo $row['album_date']; ?></td>
					<td><?php if( $row['album_status'] != 'publish' ){?><span style="color:red">Draft</span><?php }else{?>Publish<?php }?></td>
					<td>
						<a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=open&amp;id=<?php echo $row['id']; ?>">Open</a>
						&nbsp;| &nbsp;<a href="<?php echo BASE_URL_ADMIN; ?>album.php?command=edit-album&amp;id=<?php echo $row['id']; ?>">Edit</a>
						&nbsp;| &nbsp;<a href="javascript:void(0)" onClick="album_del('<?php echo $row['id']; ?>','<?php echo stripslashes($row['album_name']);?>')">Delete</a>
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
<form name="allbums" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="name" />
	<input type="hidden" name="id" />
</form>
</body>
</html>