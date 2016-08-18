<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo $this->video_setting['video_description']; ?>" />
<meta name="keywords" content="<?php echo $this->video_setting['video_keywords']; ?>" />
<?php if( $_REQUEST['page'] != '' && $_REQUEST['topics'] == '' && $_REQUEST['categories'] == '' ){ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos/page/<?php echo $_REQUEST['page'] ?>" />
<?php }elseif( $_REQUEST['topics'] != '' && $_REQUEST['page'] == '' && $_REQUEST['categories'] == '' ){ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos/topics/<?php echo $_REQUEST['topics'] ?>" />
<?php }elseif( $_REQUEST['topics'] != '' && $_REQUEST['page'] != '' && $_REQUEST['categories'] == '' ){ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos/topics/<?php echo $_REQUEST['topics'] ?>/page/<?php echo $_REQUEST['page'] ?>" />
<?php }elseif( $_REQUEST['topics'] != '' && $_REQUEST['page'] == '' && $_REQUEST['categories'] != '' ){ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos/topics/<?php echo $_REQUEST['topics'] ?>/categories/<?php echo $_REQUEST['categories'] ?>" />
<?php }elseif( $_REQUEST['topics'] != '' && $_REQUEST['page'] != '' && $_REQUEST['categories'] != '' ){ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos/topics/<?php echo $_REQUEST['topics'] ?>/categories/<?php echo $_REQUEST['categories'] ?>/page/<?php echo $_REQUEST['page'] ?>" />
<?php }else{ ?>
<link rel="canonical" href="<?php echo BASE_URL ?>videos" />
<?php } ?>
</head>
<body>
<!--<?php print_r($_REQUEST) ?>-->
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<div id="content_left" class="fl">
				<h2 class="page-title"><?php echo $this->page_title; ?></h2>
				<?php 
					$i = 0;
					foreach( $this->videos as $video ){ 
						$i++;
				?>
				<div class="video-box fl" <?php if($i%3==0){ ?>style="margin-right:0"<?php } ?>>
					<div class="video-img" style="background-image:url('<?php echo $video['video_thumb_url'] ?>?v1.1')"><a href="<?php echo $video['video_custom_url'] ?>"></a></div>
					<div class="video-detail">
						<h3><a href="<?php echo $video['video_custom_url'] ?>"><?php echo trimStr($video['video_title'],'48'); ?></a></h3>
						<div class="entry-meta">
							<span class="meta-published"><?php echo $video['video_date'] ?></span>
							<span class="meta-categories">
								<a href="<?php echo BASE_URL; ?>videos/topics/<?php echo $video['c_url'] ?>"><?php echo $video['c_name'] ?></a>
							</span>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="post-buttons-wrap">
							<div class="post-buttons">
								<div class="course-lesson-count"><?php echo $video['video_view'] ?> Views</div>
							</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
				<?php } ?>
				<div class="clear">&nbsp;</div>
				<?php echo $this->paging; ?>
			</div>
			<?php include( $this->get_theme_path()."/common/video.php" ); ?>			
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>