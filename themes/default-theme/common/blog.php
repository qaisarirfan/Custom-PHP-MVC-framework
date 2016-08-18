<div id="content_right" class="fr">
	<div class="box">
		<h3>Top View Posts</h3>
		<?php
			foreach( $this->top_view as $top_view ){ 
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
	<div class="box">
		<ul class="tags green">
			<?php foreach( $this->tag_list as $tag=>$val ){ ?>
			<li><a href="<?php echo BASE_URL ?>blog/tag/<?php echo trim( $tag ) ?>"><?php echo trim( $tag ) ?> <span><?php echo $val ?></span></a></li>
			<?php } ?>
		</ul>
		<div class="clear">&nbsp;</div>
	</div>
</div>
