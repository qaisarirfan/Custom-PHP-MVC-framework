<div id="content_right" class="fr">
	<div style="padding:12px 0"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.qadristudio.com%2Findex&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21&amp;appId=389867437807483" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></div>
	<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
	<div class="box">
		<h3>Top View Posts</h3>
		<?php
			foreach( $this->top_view_post as $top_view ){ 
				if( $top_view['post_thumb'] != '' ){
					$post_pic = BASE_URL . POST_PIC . 'thumb-' . $top_view['post_thumb'];
				}else{
					$post_pic = BASE_URL . POST_PIC . 'no-image.jpg';
				}

		?>
		<div class="related">
			<div class="related-img"><a href="<?php echo $top_view['post_url'] ?>"><img src="<?php echo $post_pic ?>" alt="<?php echo $top_view['post_title'] ?>" /></a></div>
			<div class="related-detail">
				<h4><a href="<?php echo $top_view['post_url'] ?>"><?php echo trimStr( $top_view['post_title'], 20); ?></a></h4>
				<div><?php echo trimStr( html_entity_decode( strip_tags( preg_replace( '/[^(\x20-\x7F)]*/', '', $top_view['post_content'] ) ) ), 75 ); ?></div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if( $this->video_setting['video_show']=='yes' ){ ?>
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
	<?php } ?>

	<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
	<div class="box">
		<ul class="tags green">
			<?php foreach( $this->tag_list as $tag=>$val ){ ?>
			<li><a href="<?php echo BASE_URL ?>blog/tag/<?php echo trim( $tag ) ?>"><?php echo trim( $tag ) ?> <span><?php echo $val ?></span></a></li>
			<?php } ?>
		</ul>
		<div class="clear">&nbsp;</div>
	</div>
	<?php } ?>
	<div style="padding:12px 0">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FMera-to-sab-kuch-mera-NABI-ha%2F164171377105064&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=389867437807483" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>	
	</div>
</div>
