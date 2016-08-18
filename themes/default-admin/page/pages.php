<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<style> #screenshot { position:absolute; border:1px solid #ccc; background:#333; padding:5px; display:none; color:#fff; } </style>
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
					<li><a href="<?php echo BASE_URL_ADMIN ?>pages.php?command=add">Add New Page</a></li>
					<li class="divider">&nbsp;</li>
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<table class="table table-bordered table-condensed table-hover table-striped">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Name</th>
					<th>URL String</th>
					<th>Description</th>
					<th>Date</th>
					<th>Status</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$count=0;
					foreach ( $this->rows as $row ){
						$count++;
				?>
				<tr>
					<td align="center"><?php echo $count; ?></td>
					<td><?php echo stripcslashes( trimStr( $row['page_name'], 23 ) ); ?></td>
					<td><a href="<?php echo $row['page_url']; ?>" target="_blank"><?php echo trimStr( $row['page_url_str'],23); ?></a></td>
					<td><?php echo check_empty( trimStr( $row['page_description'], '42' ) ); ?></td>
					<td><?php echo $row['page_date']; ?></td>
					<td>
						<?php if( $row['page_status'] == 'publish' ){?>
						Publish
						<?php } elseif ( $row['page_status'] == 'trash' ){?>
						Trash
						<?php }else{ ?>
						Draft
						<?php } ?>
					</td>
					<td>
						<a href="<?php echo BASE_URL_ADMIN ?>pages.php?command=edit&amp;id=<?php echo $row['id']; ?>" title="Edit">Edit</a>&nbsp;|&nbsp;
						<a href="javascript:void(0)" onClick="del('<?php echo $row['id']; ?>')" title="Delete">Delete</a>
					</td>
				</tr>
				<?php
					} 
					if( $count == 0 ){
				?>
				<tr>
					<td class="no-found" colspan="7">No <?php echo $page_title; ?> Found</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $this->paging; ?>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/page/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
<form name="option" action="" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="id" />
</form>
</body>
</html>