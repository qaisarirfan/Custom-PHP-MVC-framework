<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title">
			<h1 class="font-share-techregular"><?php echo $page_title; ?></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="preferences.php?command=add-web-customize">Add</a></li>
					<li class="divider">&nbsp;</li>
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<form class="form-horizontal" name="background" action="" method="post">
			<input type="hidden" name="action" />
			<input type="hidden" name="id" />

			<div class="control-group">
				<label class="control-label" for="no">is Background :</label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" id="default" name="body_background" onClick="body_background1()" <?php if( $this->preferences['body_background'] == 'default' ){ ?> checked="checked" <?php } ?> value="default"> Default  
					</label>
					<label class="radio inline">
						<input type="radio" id="Custom" name="body_background" onClick="body_background1()" <?php if( $this->preferences['body_background'] == 'custom' ){ ?> checked="checked" <?php } ?> value="custom"> Custom
					</label>
				</div>
			</div>
			<ul class="thumbnails">
				<?php 
					if( !empty( $this->data ) ){
						foreach( $this->data as $row ){
				?>
				<li class="span3">
					<div class="thumbnail">
						<div class="box">
							<div class="background" style="background:url('<?php echo $this->get_site_content_path(); ?>/custom-background/<?php echo $row['backgrounds_image'] . "') " . $row['background_repeat'] . " " . $row['background_position'] . " " . $row['background_attachment'] . " " . $row['backgrounds_color']?>;"></div>
							<div class="action muted">
								<span class="color" style="background-color:<?php echo $row['backgrounds_color']; ?>;">&nbsp;</span>
								<span><?php echo $row['background_repeat']; ?></span>
								<span><?php echo $row['background_position']; ?></span>
								<span><?php echo $row['background_attachment']; ?></span>
							</div>
							<div class="option">
								<a href="javascript:void(0)"<?php if( $row['active'] == 'no' ){ ?> onClick="active('<?php echo $row['id']; ?>');"<?php } ?> class="btn btn-small btn-primary<?php if( $row['active'] == 'yes' ){ ?> disabled<?php } ?>"><?php if( $row['active'] == 'yes' ){ ?><i class="icon-star icon-white"></i><?php } ?> Set</a>
								<a href="preferences.php?command=edit-web-customize&amp;id=<?php echo $row['id']; ?>" class="btn btn-small">Edit </a>
								<a href="javascript:void(0)"<?php if( $row['active'] == 'no' ){ ?> onClick="isDelete('<?php echo $row['id']; ?>')"<?php } ?> class="btn btn-small btn-danger<?php if( $row['active'] == 'yes' ){ ?> disabled<?php } ?>">Delete</a>
							</div>
						</div>
					</div>
				</li>
				<?php
						}
					}else{
				?>
				<div class="no-found">No record return.</div>
				<?php } ?>
			</ul>
		</form>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script type="text/javascript">
	function active(id){
		var f = document.background;
		f.action.value = 'active';
		f.id.value = id;
		f.submit();
	}
	function isDelete(id){
		if( confirm("Are you sure that you want delete this one.") ){
			var f = document.background;
			f.action.value = 'delete';
			f.id.value = id;
			f.submit();
		}
	}
	function body_background1(){
		var f = document.background;
		f.action.value = 'body_background';
		f.submit();
	}
</script>
</body>
</html>