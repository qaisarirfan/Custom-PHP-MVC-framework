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
					<li><a href="<?php echo BASE_URL_ADMIN ?>slider.php?command=add">Add Slider Image</a></li>
					<li><a href="<?php echo BASE_URL_ADMIN ?>slider.php?command=setting">Slider Setting</a></li>
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
					<th>Picture/URL</th>
					<th>Title</th>
					<th>Description</th>
					<th>Date</th>
					<th>Publish/Draft</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $this->rows as $row ){ ?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><a class="group3 screenshot" rel="<?php echo $slider_pic_thumb; ?>" href="<?php echo $row['slider_url']; ?>"><?php echo stripcslashes(trimStr($row['slider_url'],35)); ?></a></td>
					<td><?php echo stripcslashes(trimStr($row['slider_title'],23)); ?></td>
					<td><?php echo stripcslashes(trimStr($row['slider_description'],35)); ?></td>
					<td><?php echo $row['slider_date']; ?></td>
					<td>
						<?php if($row['slider_status']=='publish'){ ?>
							Publish
						<?php }else{?>
							Draft
						<?php } ?>
					</td>
					<td>
						<a href="<?php echo BASE_URL_ADMIN ?>slider.php?command=edit&id=<?php echo $row['id']; ?>">Edit</a>
						&nbsp;|&nbsp;
						<a href="javascript:void(0)" onClick="del('<?php echo intval($row['id']) ?>')">Delete</a>
					</td>
				</tr>
				<?php } ?>
				<?php if( count($this->rows) == '0' ){ ?>
				<tr>
					<td class="no-found" colspan="7">No Record Found</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal -->
<?php /*?><div class="modal fade" id="preferences">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" name="preferences" onSubmit="return preferences_validate(this);" action="" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Slider Preferences</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="command" />

					<div class="control-group">
						<label class="control-label" for="slider_width">Slider Width :</label>
						<div class="controls">
							<input type="text" id="slider_width" name="slider_width" value="<?php echo $Pref->get_value('slider_width'); ?>" />
							<span class="help-inline">px</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="slider_height">Slider Height :</label>
						<div class="controls">
							<input type="text" id="slider_height" name="slider_height" value="<?php echo $Pref->get_value('slider_height'); ?>" />
							<span class="help-inline">px</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="no">is Show :</label>
						<div class="controls">
							<label class="radio inline">
								<input type="radio" id="yes" name="slider_show" value="yes" <?php if( $Pref->get_value( 'slider_show' ) == 'yes' ){ ?> checked="checked" <?php } ?> />
								Yes
							</label>
							<label class="radio inline">
								<input type="radio" id="no" name="slider_show" value="no" <?php if( $Pref->get_value( 'slider_show' ) == 'no' ){ ?> checked="checked" <?php } ?> />
								No
							</label>
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
</div><?php */?>
<!-- /.modal -->
<form name="option" action="" method="post">
	<input type="hidden" name="command" />
	<input type="hidden" name="id" />
</form>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/slider/js/isValidate.js" type="text/javascript" language="javascript"></script>
</body>
</html>