<div id="content_right" class="fr">
	<div style="padding:24px 0 0 0">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FMera-to-sab-kuch-mera-NABI-ha%2F164171377105064&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=389867437807483" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>	
	</div>
	<div class="box">
		<h3>Top View Video</h3>
		<?php
			foreach( $this->top_view_video as $top_view_video ){ 
		?>
		<div class="related">
			<div class="related-img"><a href="<?php echo $top_view_video['video_custom_url'] ?>"><img src="<?php echo $top_view_video['video_thumb_url'] ?>" alt="<?php echo $top_view_video['video_title'] ?>" /></a></div>
			<div class="related-detail">
				<h4><a href="<?php echo $top_view_video['video_custom_url'] ?>"><?php echo trimStr( $top_view_video['video_title'], 20); ?></a></h4>
				<div><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $top_view_video['video_description'] ) ) ), 75 ); ?></div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<?php } ?>
	</div>
</div>
