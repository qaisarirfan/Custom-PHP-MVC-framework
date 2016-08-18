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
					<li><a data-toggle="modal" href="#add-file">Add File</a></li>
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
					<th>View File</th>
					<th>File Title</th>
					<th>Show</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach( $this->row as $row ){
						$count++; 
				?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><a href="<?php echo $row['url']; ?>" target="_blank">Click here to view</a></td>
					<td><?php echo stripcslashes($row['file_title']); ?></td>
					<td><?php if($row['is_show']=='no'){?>
						<span style="color:red">No</span>
						<?php }else{?>
						Yes
						<?php }?></td>
					<td>
						<a href="javascript:del('<?php echo intval($row['id']) ?>','<?php echo $row['file_name'] ?>');">Delete</a>
					</td>
				</tr>
				<?php 
					}
					if($count==0){
				?>
				<tr>
					<td class="no-found" colspan="5">No Record Found</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $this->paging; ?>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="add-file">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" name="add-file" onSubmit="return add_validate(this);" action="" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add File Repository</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="command" />

					<div class="control-group">
						<label class="control-label" for="file_type">file Type :</label>
						<div class="controls">
							<select name="file_type" id="file_type">
								<option value="">-select-</option>
								<option value="doc">Document</option>
								<option value="img">Image</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="file_title">file title :</label>
						<div class="controls">
							<input type="text" id="file_title" name="file_title" />
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="file_name">file :</label>
						<div class="controls">
							<input type="file" id="file_name" name="file_name" />
							<span class="help-inline">px</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="no">file Show :</label>
						<div class="controls">
							<label class="radio inline">
								<input type="radio" id="yes" name="is_show" value="yes" checked="checked" />
								Yes
							</label>
							<label class="radio inline">
								<input type="radio" id="no" name="is_show" value="no" />
								No
							</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save File</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content --> 
	</div>
	<!-- /.modal-dialog --> 
</div>
<!-- /.modal -->
<form name="option" action="" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="id" />
	<input type="hidden" name="file" />
</form>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/repository/js/isValidate.js?v1.1" type="text/javascript" language="javascript"></script>
</body>
</html>