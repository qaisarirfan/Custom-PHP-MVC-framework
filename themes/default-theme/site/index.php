<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo $this->preferences['seo_home_description']; ?>" />
<meta name="keywords" content="<?php echo $this->preferences['seo_home_keywords']; ?>" />
<link rel="canonical" href="<?php echo BASE_URL ?>index" />
<?php if( $this->slider_setting['slider_show'] == 'yes' ){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/css/base/advanced-slider-base.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/css/<?php echo $this->slider_setting['slider_skin']; ?>/<?php echo $this->slider_setting['slider_skin']; ?>.css" media="screen"/>
<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/js/jquery.advancedSlider.min.js"></script> 
<!--[if IE]><script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/js/excanvas.compiled.js"></script><![endif]--> 
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#minimal-slider').fadeIn('slow');
		$('#minimal-slider').advancedSlider({
			shuffle: <?php echo $this->slider_setting['slider_shuffle']; ?>,
			width: '<?php echo $this->slider_setting['slider_width'] ?>', 
			height: '<?php echo $this->slider_setting['slider_height'] ?>',
			scaleType:'<?php echo $this->slider_setting['slider_scale_type']; ?>',
			alignType:'<?php echo $this->slider_setting['slider_align_type']; ?>',
			effectType: '<?php echo $this->slider_setting['slider_effect_type']; ?>',
			skin: '<?php echo $this->slider_setting['slider_skin']; ?>',
			slideLoop: <?php echo $this->slider_setting['slider_slide_loop']; ?>,
			slideshowDelay: '<?php echo $this->slider_setting['slider_slide_delay']; ?>',
			allowScaleUp:true,

			slideshowControls: true, 
			slideshowControlsToggle: false, 
			pauseSlideshowOnHover: true, 
			slideArrowsToggle: false, 
			slideButtonsNumber: true,
			//timerAnimationControls: false,
			//timerAnimation:true,
			timerToggle:true,
			timerRadius: 18, 
			timerStrokeColor1: '#FF9999', 
			timerStrokeColor2: '#0F0000', 
			timerStrokeOpacity1: 0.8, 
			timerStrokeWidth1: 3, 
			timerStrokeWidth2: 1 

		});
	});
</script>
<?php } ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<?php if( $this->slider_setting['slider_show'] == 'yes' ){ ?>
			<div class="advanced-slider" id="minimal-slider">
				<ul class="slides">

					<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
					<li class="slide">
						<?php
							$count = 0;
							foreach( $this->top_view_post as $top_view ){ 
								$count++;
								if( $top_view['post_thumb'] != '' ){
									$post_pic = BASE_URL . POST_PIC . 'thumb-' . $top_view['post_thumb'];
								}else{
									$post_pic = BASE_URL . POST_PIC . 'no-image.jpg';
								}
								$total = $this->blog_setting['blog_top_view_post'] / 2;
				
						?>
						<div class="slide-related slide-related-<?php echo $total; ?> <?php if( $count%$total==0 ){ ?>margin-right<?php } ?>">
							<div class="slide-related-img"><a href="<?php echo $top_view['post_url'] ?>"><img src="<?php echo $post_pic ?>" alt="<?php echo $top_view['post_title'] ?>" /></a></div>
							<div class="slide-related-detail">
								<h4><a href="<?php echo $top_view['post_url'] ?>"><?php echo trimStr( $top_view['post_title'], 43); ?></a></h4>
								<?php if( $total == '2' ){ ?>
								<p><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $top_view['post_content'] ) ) ), 300 ); ?></p>
								<?php } ?>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
						<?php } ?>
					</li>
					<?php } ?>

					<?php if( $this->video_setting['video_show']=='yes' ){ ?>
					<li class="slide">
						<?php 
							$count = 0;
							foreach( $this->top_view_video as $top_view_video ){ 
								$count++;
								$total = $this->video_setting['video_top_view_post'] / 2;
						?>
						<div class="slide-related slide-related-<?php echo $total; ?> <?php if( $count%$total==0 ){ ?>margin-right<?php } ?>">
							<div class="slide-related-img"><a href="<?php echo $top_view_video['video_custom_url'] ?>"><img src="<?php echo $top_view_video['video_thumb_url'] ?>" alt="<?php echo $top_view_video['video_title'] ?>" /></a></div>
							<div class="slide-related-detail">
								<h4><a href="<?php echo $top_view_video['video_custom_url'] ?>"><?php echo trimStr( $top_view_video['video_title'], 20); ?></a></h4>
								<?php if( $total == '2' ){ ?>
								<p><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $top_view_video['video_description'] ) ) ), 75 ); ?></p>
								<?php } ?>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
						<?php } ?>
					</li>
					<?php } ?>

					<?php foreach( $this->slider as $slide ){ ?>
					<li class="slide">
						<?php if( $slide['slider_url'] != ''  ){ ?>
						<a target="_blank" href="<?php echo $slide['slider_url']; ?>"><img class="image" src="<?php echo $this->get_site_content_path(); ?>/slider/<?php echo $slide['slider_picture']; ?>" alt="<?php echo $slide['slider_title']; ?>" /></a>
						<?php }else{ ?>
						<img class="image" src="<?php echo $this->get_site_content_path(); ?>/slider/<?php echo $slide['slider_picture']; ?>" alt="<?php echo $slide['slider_title']; ?>" />
						<?php } ?>
						<img class="thumbnail" src="<?php echo $this->get_site_content_path(); ?>/slider/thumb-<?php echo $slide['slider_picture']; ?>" alt="" />
						<div class="caption">
							<h4><?php echo $slide['slider_title'] ?></h4>
							<p><?php echo $slide['slider_description'] ?></p>
						</div>
					</li>
					<?php } ?>

					<?php if( count( $this->slider ) == '0' && $this->top_view_video == '' && $this->top_view_post == '' ){ ?>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image1.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb1.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image2.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb2.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image3.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb3.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image4.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb4.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image5.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb5.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image6.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb6.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image7.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb7.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image8.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb8.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image9.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb9.jpg" alt=""/> </li>
					<li class="slide"> <img class="image" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/images/image10.jpg" alt=""/> <img class="thumbnail" src="<?php echo $this->get_resources_path(); ?>/js-jquery/Advanced-Slider-jQuery-XML-slider/thumbnails/thumb10.jpg" alt=""/> </li>
					<?php } ?>

				</ul>
			</div>
			<?php } ?>
			<div id="content_left" class="fl">

				<?php if( $this->video_setting['video_show']=='yes' ){ ?>
					<div class="heading-section">
						<h2>Latest Video</h2>
						<span class="link"><a href="<?php echo BASE_URL; ?>videos">More Videos &rarr;</a></span>
						<div class="clear">&nbsp;</div>
					</div>
					<?php 
						$i = 0;
						foreach( $this->letest_video as $letest_video ){ 
							$i++;
					?>
					<div class="video-box fl" <?php if($i%3==0){ ?>style="margin-right:0"<?php } ?>>
						<div class="video-img" style="background-image:url('<?php echo $letest_video['video_thumb_url'] ?>?v1.1')"><a href="<?php echo $letest_video['video_custom_url'] ?>"></a></div>
						<div class="video-detail">
							<h3><a href="<?php echo $letest_video['video_custom_url'] ?>"><?php echo trimStr($letest_video['video_title'],'45'); ?></a></h3>
							<div class="entry-meta"> 
								<span class="meta-published"><?php echo $letest_video['video_date'] ?></span> 
								<span class="meta-categories">
									<a href="<?php echo BASE_URL; ?>videos/topics/<?php echo $letest_video['c_url'] ?>"><?php echo $letest_video['c_name'] ?></a>
								</span>
								<div class="clear">&nbsp;</div>
							</div>
							<div class="post-buttons-wrap">
								<div class="post-buttons">
									<div class="course-lesson-count"><?php echo $letest_video['video_view'] ?> Views</div>
								</div>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<?php } ?>
					<div class="clear">&nbsp;</div>
				<?php } ?>

				<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
					<div class="heading-section">
						<h2>Latest Blog</h2>
						<span class="link"><a href="<?php echo BASE_URL; ?>blog">More Posts &rarr;</a></span>
						<div class="clear">&nbsp;</div>
					</div>
					<?php 
						foreach( $this->letest_post as $letest_post ){
							if( $letest_post['post_thumb'] != '' ){
								$post_pic = BASE_URL . POST_PIC . 'thumb-' . $letest_post['post_thumb'];
							}else{
								$post_pic = BASE_URL . POST_PIC . 'no-image.jpg';
							}
					?>
					<div class="post-row">
						<div class="entry-meta"> <span class="meta-published"><?php echo $letest_post['post_date']; ?></span>
							<?php if( $letest_post['c_name'] != '' ){ ?>
							<span class="meta-categories"> <a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $letest_post['c_url'] ?>" title="<?php echo $letest_post['c_name'] ?>"><?php echo stripcslashes($letest_post['c_name']) ?></a>
							<?php if( $letest_post['sc_name'] != '' ){ ?>
							&nbsp;/&nbsp;<a href="<?php echo BASE_URL; ?>blog/topics/<?php echo $letest_post['c_url'] ?>/categories/<?php echo $letest_post['sc_url'] ?>" title="<?php echo $letest_post['sc_name'] ?>"><?php echo stripcslashes($letest_post['sc_name']) ?></a>
							<?php } ?>
							</span>
							<?php } ?>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="fl post-img"><a href="<?php echo $letest_post['post_url'] ?>"><img src="<?php echo $post_pic ?>" alt="<?php echo $letest_post['post_title']; ?>" /></a></div>
						<div class="fr post-detail">
							<h3><a href="<?php echo $letest_post['post_url'] ?>"><?php echo trimStr( $letest_post['post_title'], 45 ); ?></a></h3>
							<div class="description"><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $letest_post['post_content'] ) ) ), 300 ); ?></div>
							<div class="post-buttons-wrap">
								<div class="post-buttons is-wrapped">
									<?php if( $letest_post['post_view'] != 0) { ?>
									<div class="course-lesson-count"><?php echo $letest_post['post_view'] ?> Read</div>
									<?php } ?>
									<a href="<?php echo $letest_post['post_url'] ?>" class="orange-button">Full Story</a> </div>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<?php } ?>
				<?php } ?>
				<div class="clear">&nbsp;</div>
			</div>
			<?php include( $this->get_theme_path()."/common/right.php" ); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>