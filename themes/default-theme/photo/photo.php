<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<link rel="canonical" href="<?php echo $this->photo_row['photo_url']; ?>" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?php echo APP_TITLE; ?>" />
<meta property="og:title" content="<?php echo $this->photo_row['photo_title']; ?>" />
<meta property="og:image" content="<?php echo $this->album_path . "/" . $this->photo_row['photo_name']; ?>" />
<meta property="og:url" content="<?php echo $this->photo_row['photo_url']; ?>" />
<meta property="og:description" content="<?php echo strip_tags( html_entity_decode( preg_replace( '/[^(\x20-\x7F)]*/', '', $this->photo_row['photo_description'] ) ) ); ?>" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<div id="content_left" class="fl">
				<h2 class="page-title"><?php echo $this->page_title; ?></h2>
				<div class="entry-meta"> <span class="meta-published"><?php echo $this->photo_row['photo_date']; ?></span>
					<?php if( $this->photo_row['pc_name'] != '' ){ ?>
					<span class="meta-categories"> <a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $this->photo_row['pc_url'] ?>" title="<?php echo stripcslashes($this->photo_row['pc_name']) ?>"><?php echo stripcslashes($this->photo_row['pc_name']) ?></a>
					<?php if( $this->photo_row['psc_name'] != '' ){ ?>
					&nbsp;/&nbsp;<a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $this->photo_row['pc_url'] ?>/categories/<?php echo $this->photo_row['psc_url'] ?>" title="<?php echo stripcslashes($this->photo_row['psc_name']) ?>"><?php echo stripcslashes($this->photo_row['psc_name']) ?></a>
					<?php } ?>
					</span>
					<?php } ?>
					<div class="clear">&nbsp;</div>
				</div>
				<div class="img"><img src="<?php echo $this->album_path . "/" . $this->photo_row['photo_name']; ?>" alt="<?php echo $this->page_title; ?>" /></div>
				<div class="post-detail"> <?php echo html_entity_decode( preg_replace( '/[^(\x20-\x7F)]*/', '', $this->photo_row['photo_description'] ) ); ?> </div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>