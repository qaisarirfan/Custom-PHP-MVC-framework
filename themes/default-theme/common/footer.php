<div id="footer">
	<div class="footer-link-bar">
		<div class="container">
			<ul>
				<li style="border:0;"><a href="<?php echo BASE_URL ?>index">Home</a></li>
				<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
				<li><a href="<?php echo BASE_URL; ?>blog"><?php echo $this->blog_setting['blog_page_name']; ?></a></li>
				<?php } ?>
				<?php if( $this->video_setting['video_show']=='yes' ){ ?>
				<li><a href="<?php echo BASE_URL ?>videos"><?php echo $this->video_setting['video_page_name']; ?></a></li>
				<?php } ?>
				<?php foreach( $this->footer_page as $fpage ){ ?>
				<li><a href="<?php echo $fpage['page_url']; ?>"><?php echo $fpage['page_name']; ?></a></li>
				<?php } ?>
				<li><a href="<?php echo BASE_URL; ?>contact-us">Contact Us</a></li>
			</ul>
			<div id="copyright">&copy; <?php echo APP_TITLE ?> 2013, All Rights Reserved</div>
		</div>
	</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46471634-1', 'qadristudio.com');
  ga('send', 'pageview');

</script>