<div id="header">
	<div class="container">
		<div id="header_inner">
			<div id="logo" class="fl">
				<h1><a href="<?php echo BASE_URL; ?>index">Qadri Studio</a></h1>
			</div>
			<div class="fr">
				<ul class="social">
					<?php if( $this->preferences['social_facebook_text'] ){ ?>
					<li class="facebook"><a href="<?php echo $this->preferences['social_facebook_text']; ?>" target="_blank">Facebook</a></li>
					<?php } ?>
					<?php if( $this->preferences['social_twitter_text'] ){ ?>
					<li class="twitter"><a href="<?php echo $this->preferences['social_twitter_text']; ?>" target="_blank">Twitter</a></li>
					<?php } ?>
					<?php if( $this->preferences['social_gplus'] ){ ?>
					<li class="gplus"><a href="<?php echo $this->preferences['social_gplus']; ?>" target="_blank">Google Plus</a></li>
					<?php } ?>
					<?php if( $this->preferences['social_dailymotion'] ){ ?>
					<li class="dailymotion"><a href="<?php echo $this->preferences['social_dailymotion']; ?>" target="_blank">Dailymotion</a></li>
					<?php } ?>
				</ul>
			</div>
			<?php if( $this->preferences['phone_no'] ){ ?>
			<div class="phone"><?php echo $this->preferences['phone_no']; ?></div>
			<?php } ?>
			<div class="clear">&nbsp;</div>
			<div class="black">
				<ul id="mega-menu" class="mega-menu">
					<li><a href="<?php echo BASE_URL; ?>index">Home</a></li>
					<?php if( $this->blog_setting['blog_show']=='yes' ){ ?>
					<li><a href="<?php echo BASE_URL; ?>blog"><?php echo $this->blog_setting['blog_page_name']; ?></a> <?php echo $this->blog_menu; ?></li>
					<?php } ?>
					<?php if( $this->video_setting['video_show']=='yes' ){ ?>
					<?php /*?><li><a href="<?php echo BASE_URL ?>videos"><?php echo $this->video_setting['video_page_name']; ?></a><?php echo $this->video_menu; ?></li><?php */?>
					<?php echo $this->video_menu; ?>
					<?php } ?>
					<?php foreach( $this->header_page as $hpage ){ ?>
					<li><a href="<?php echo $hpage['page_url']; ?>"><?php echo $hpage['page_name']; ?></a></li>
					<?php } ?>
					<li><a href="<?php echo BASE_URL; ?>photo">Photo Albums</a></li>
					<li><a href="<?php echo BASE_URL; ?>contact-us">Contact Us</a></li>
				</ul>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
