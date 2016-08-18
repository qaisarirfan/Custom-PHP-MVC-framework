<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo strip_tags(html_entity_decode($this->video_row['video_description'])); ?>" />
<meta name="keywords" content="<?php echo $this->video_row['video_keywords']; ?>" />
<link rel="canonical" href="<?php echo $this->video_row['video_custom_url']; ?>" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<h2 class="page-title"><?php echo $this->page_title; ?></h2>
			<div id="content_left" class="fl">
				<div class="entry-meta">
					<span class="meta-published"><?php echo $this->video_row['video_date']; ?></span>
					<?php if( $this->video_row['c_name'] != '' ){ ?>
					<span class="meta-categories">
						<a href="<?php echo BASE_URL; ?>videos/topics/<?php echo $this->video_row['c_url'] ?>"><?php echo stripcslashes($this->video_row['c_name']) ?></a>
						<?php if( $this->video_row['sc_name'] != '' ){ ?>
						&nbsp;/&nbsp;<a href="<?php echo BASE_URL; ?>videos/topics/<?php echo $this->video_row['c_url'] ?>/categories/<?php echo $this->video_row['sc_url'] ?>"><?php echo stripcslashes($this->video_row['sc_name']) ?></a>
						<?php } ?>
					</span>
					<?php } ?>
					<span class="meta-view"><?php echo $this->video_row['video_view']; ?> people(s) view this</span>
					<div class="clear">&nbsp;</div>
				</div>
				
				<div id="iframe">
					<?php echo html_entity_decode( $this->video_row['video_html'] ); ?>
				</div>
				
				<div>
					<?php echo html_entity_decode( preg_replace( '/[^(\x20-\x7F)]*/', '', $this->video_row['video_description'] ) ); ?>
				</div>
				<?php
					if( $this->video_row['video_tags'] != '' ){
				?>				
				<ol class="tags-list">
					<?php
						$tags = explode( ',', $this->video_row['video_tags'] );
						foreach( $tags as $tag ){
					?>
					<li><a href="<?php echo BASE_URL; ?>videos/tag/<?php echo $tag; ?>" title=""><?php echo $tag; ?></a></li>
					<?php } ?>
				</ol>
				<?php } ?>
				<div class="clear">&nbsp;</div>
				<h2 class="title-relate">Related Videos</h2>
				<div class="title-related">
					<?php 
						$count = 0;
						foreach( $this->related as $related ){ 
							$count++;
					?>
					<div class="related-box <?php if($count%5==0){ ?>margin-right<?php } ?>">
						<div class="img"><a href="<?php echo $related['video_custom_url'] ?>"><img src="<?php echo $related['video_thumb_url'] ?>" alt="<?php echo $related['video_title'] ?>"></a></div>
						<h3><a href="<?php echo $related['video_custom_url'] ?>"><?php echo trimStr( $related['video_title'], '32' ) ?></a></h3>
					</div>
					<?php } ?>
					<div class="clear">&nbsp;</div>
				</div>
				<br />
				<div id="disqus_thread"></div>
				<script type="text/javascript">
				   var disqus_shortname = 'qadristudio';
				   (function() {
					  var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					  dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				   })();
				</script>
    				
			</div>
			<?php include( $this->get_theme_path()."/common/video.php" ); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>