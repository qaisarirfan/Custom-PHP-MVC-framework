<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo $this->blog_setting['blog_description']; ?>" />
<meta name="keywords" content="<?php echo $this->blog_setting['blog_keywords']; ?>" />
<link rel="canonical" href="<?php echo BASE_URL ?>blog" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<div id="content_left" class="fl">
				<h2 class="page-title"><?php echo $this->page_title; ?></h2>
				<?php 
					foreach( $this->posts as $post ){
						if( $post['post_thumb'] != '' ){
							$post_pic = BASE_URL . POST_PIC . 'thumb-' . $post['post_thumb'];
						}else{
							$post_pic = BASE_URL . POST_PIC . 'no-image.jpg';
						}
				?>
				<div class="post-row">
					<div class="entry-meta">
						<span class="meta-published"><?php echo $post['post_date']; ?></span>
						<?php if( $post['c_name'] != '' ){ ?>
						<span class="meta-categories">
							<a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $post['c_url'] ?>" title="<?php echo stripcslashes($post['c_name']) ?>"><?php echo stripcslashes($post['c_name']) ?></a>
							<?php if( $post['sc_name'] != '' ){ ?>
							&nbsp;/&nbsp;<a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $post['c_url'] ?>/categories/<?php echo $post['sc_url'] ?>" title="<?php echo stripcslashes($post['sc_name']) ?>"><?php echo stripcslashes($post['sc_name']) ?></a>
							<?php } ?>
						</span>
						<?php } ?>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="fl post-img"><a href="<?php echo $post['post_url'] ?>"><img src="<?php echo $post_pic ?>" alt="<?php echo $post['post_title']; ?>" /></a></div>
					<div class="fr post-detail">
						<h3><a href="<?php echo $post['post_url'] ?>"><?php echo trimStr( $post['post_title'], 45 ); ?></a></h3>
						<div class="description"><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $post['post_content'] ) ) ), 300 ); ?></div>
						<div class="post-buttons-wrap">
							<div class="post-buttons is-wrapped">
								<?php if( $post['post_view'] != 0) { ?>
								<div class="course-lesson-count"><?php echo $post['post_view'] ?> Read</div>
								<?php } ?>
								<a href="<?php echo $post['post_url'] ?>" class="orange-button">Full Story</a>
							</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
				<?php } ?>
				<?php echo $this->paging; ?>
			</div>
			<?php include( $this->get_theme_path()."/common/blog.php" ); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>