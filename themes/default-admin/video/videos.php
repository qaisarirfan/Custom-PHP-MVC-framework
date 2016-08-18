<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="page_title">
			<h1 class="font-share-techregular"><a href="<?php echo BASE_URL_ADMIN; ?>videos.php"><?php echo $this->page_title; ?></a></h1>
			<div class="btn-group pull-right">
				<button class="btn btn-inverse" data-toggle="dropdown">Action</button>
				<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret">&nbsp;</span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="<?php echo BASE_URL_ADMIN; ?>videos.php?command=add">Add Video</a></li>
					<li><a href="<?php echo BASE_URL_ADMIN ?>videos.php?command=setting">Video Setting</a></li>
					<li class="divider">&nbsp;</li>
					<li><a href="javascript:history.go(-1)" title="Back">Back</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
			<ol class="order">
				<li>Order By</li>
				<li>View <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?order=asc&c=view">Low</a> | <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?order=desc&c=view">Top</a></li>
				<li>Date <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?order=asc&c=date">Old</a> | <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?order=desc&c=date">New</a></li>
				<li>Status <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?status=publish&c=status">Publish</a> | <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?status=trash&c=status">Trash</a> | <a href="<?php echo BASE_URL_ADMIN; ?>videos.php?status=draft&c=status">Draft</a></li>
			</ol>
		</div>
		<ul class="thumbnails">
			<?php
				foreach( $this->videos as $row){
			?>
			<li class="span3">
				<div class="thumbnail video-box">
					<div class="video-img"><img src="<?php echo $row['video_thumb_url']; ?>" alt="<?php echo $row['video_title']; ?>" /></div>
					<div class="video-detail">
						<h3><?php echo trimStr( $row['video_title'], 30 ); ?></h3>
						<div class="entry-meta">
							<span class="meta-published"><?php echo $row['video_date']; ?></span>
							<span class="meta-categories">
								<?php
									if( $row['category'] != '0' ){
										echo stripslashes( $row['c_name'] );
									}
								?>
							</span>
						</div>
						<div class="clear">&nbsp;</div>
						<div class="options">
							<div class="course-lesson-count"><span><a href="<?php echo $row['video_custom_url']; ?>" target="_blank"><?php echo $row['video_view']; ?> Views</a></span></div>
							<div class="opation">
								<a class="btn btn-small btn-primary" href="videos.php?command=edit&amp;id=<?php echo $row['id']; ?>">Edit</a>
								<?php if( $row['video_status'] == 'trash' ){ ?>
								<a class="btn btn-small btn-danger" href="javascript:void(0);" onClick="delete_permanent_video('<?php echo $row['id']; ?>');">Delete Permanent</a>
								<?php }else{ ?>
								<a class="btn btn-small btn-danger" href="javascript:void(0);" onClick="delete_video('<?php echo $row['id']; ?>');">Delete</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
			</li>
			<?php } ?>
		</ul>
		<div class="clear">&nbsp;</div>
		<?php if($this->videos==''){ ?>
		<div class="no-found">Record no found.</div>
		<?php } ?>
		<?php echo $this->paging; ?>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<form name="video" method="post">
	<input type="hidden" name="command" value="command">
	<input type="hidden" name="id">
	<input type="hidden" name="order">
</form>
<script src="<?php echo $this->get_theme_name_with_http(); ?>/js/isValidate_videos.js?v1.1" type="text/javascript" language="javascript"></script>
</body>
</html>