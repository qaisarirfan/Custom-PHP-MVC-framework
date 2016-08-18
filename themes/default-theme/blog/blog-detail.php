<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo $this->post_row['post_description']; ?>" />
<meta name="keywords" content="<?php echo $this->post_row['post_keywords']; ?>" />
<link rel="canonical" href="<?php echo $this->post_row['post_url']; ?>" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?php echo APP_TITLE; ?>" />
<meta property="og:title" content="<?php echo $this->post_row['post_title']; ?>" />
<meta property="og:image" content="<?php echo BASE_URL . "/site-content/post-pic/".$this->post_row['post_thumb']; ?>" />
<meta property="og:url" content="<?php echo $this->post_row['post_url']; ?>" />
<meta property="og:description" content="<?php echo $this->post_row['post_description']; ?>" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<div id="content_left" class="fl">
				<h2 class="page-title"><?php echo $this->page_title; ?></h2>
				<div class="entry-meta"> <span class="meta-published"><?php echo $this->post_row['post_date']; ?></span>
					<?php if( $this->post_row['pc_name'] != '' ){ ?>
					<span class="meta-categories"> <a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $this->post_row['pc_url'] ?>" title="<?php echo stripcslashes($this->post_row['pc_name']) ?>"><?php echo stripcslashes($this->post_row['pc_name']) ?></a>
					<?php if( $this->post_row['psc_name'] != '' ){ ?>
					&nbsp;/&nbsp;<a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $this->post_row['pc_url'] ?>/categories/<?php echo $this->post_row['psc_url'] ?>" title="<?php echo stripcslashes($this->post_row['psc_name']) ?>"><?php echo stripcslashes($this->post_row['psc_name']) ?></a>
					<?php } ?>
					</span>
					<?php } ?>
					<div class="clear">&nbsp;</div>
				</div>
				<div class="post-detail"> <?php echo html_entity_decode( preg_replace( '/[^(\x20-\x7F)]*/', '', $this->post_row['post_content'] ) ); ?> </div>
				<div>
					<?php
						$tags = explode( ',', $this->post_row['post_tags'] );
					?>
					<ul class="simple">
						<?php foreach( $tags as $tag ){ ?>
						<li><a href="<?php echo BASE_URL ?>blog/tag/<?php echo trim( $tag ) ?>"><?php echo trim( $tag ) ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<h2 class="title-relate">Related Post</h2>
				<div class="title-related">
					<?php 
						$count = 0;
						foreach( $this->related as $related ){ 
						if( $related['post_thumb'] != '' ){
							$post_pic = BASE_URL . POST_PIC . 'thumb-' . $related['post_thumb'];
						}else{
							$post_pic = BASE_URL . POST_PIC . 'no-image.jpg';
						}
							$count++;
					?>
					<div class="related-box <?php if($count%5==0){ ?>margin-right<?php } ?>">
						<div class="img"><a href="<?php echo $related['post_url'] ?>"><img src="<?php echo $post_pic; ?>" alt="<?php echo $related['post_title'] ?>"></a></div>
						<h3><a href="<?php echo $related['post_url'] ?>"><?php echo trimStr( $related['post_title'], '32' ) ?></a></h3>
					</div>
					<?php } ?>
					<div class="clear">&nbsp;</div>
				</div>
			</div>
			<?php include( $this->get_theme_path()."/common/blog.php" ); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>