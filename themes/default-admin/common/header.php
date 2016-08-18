<?php
	$user_row = $this->user_row;
	if(
		$page_url == 'categories.php' ||
		$page_url == 'blog.php' || 
		$page_url == 'add-post.php' || 
		$page_url == 'edit-post.php' || 

		$page_url == 'pages.php' || 
		$page_url == 'add-page.php' || 
		$page_url == 'edit-page.php' || 

		$page_url == 'slider.php' || 
		$page_url == 'add-slider-img.php' || 
		$page_url == 'edit-slider-img.php' ||
		
		$page_url == 'album.php' || 
		$page_url == 'add-album.php' || 
		$page_url == 'edit-album.php' || 
		
		$page_url == 'allbum-photos.php' || 
		$page_url == 'add-photo.php' || 
		$page_url == 'edit-photo.php' || 
		$page_url == 'add-multi-photo.php' ||
		
		$page_url == 'video.php' || 
		$page_url == 'add.php' || 
		$page_url == 'edit.php'

	){
		$WebManagement = true;
	}else{
		$WebManagement = false;
	}

	if(
		$page_url == 'preferences.php' ||
		$page_url == 'web-customize.php' ||
		$page_url == 'add-web-customize.php' ||
		$page_url == 'edit-web-customize.php'
	){ 
		$preferences = true;
	}else{
		$preferences = false;
	}

?>

<div id="header">
	<div class="container">
		<div class="context">
			<?php if ( $result['auto_logout'] == 'yes' ){ ?>
			<div id="expireDiv">Your session is about to expire. You will be logged out in <span id="currentSeconds"></span> seconds. If you want to continue, please save your work and click <u>here</u> to refresh the page.</div>
			<?php } ?>
			<div style="height:50px;">
				<div id="logo" class="fl font-chunkfive"><?php echo APP_TITLE; ?> Admin</div>
				<div class="clear">&nbsp;</div>
			</div>
			<div class="navbar">
				<div class="navbar-inner">
					<div class=""> <a class="brand" title="Menu" href="javascript:void(0)">Menu</a> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar">&nbsp;</span> <span class="icon-bar">&nbsp;</span> <span class="icon-bar">&nbsp;</span> </a>
						<div class="nav-collapse navbar-responsive-collapse collapse">
							<ul class="nav">
								<li<?php if($page_url == 'dashboard.php'){ ?> class="active"<?php } ?>><a href="<?php echo BASE_URL_ADMIN ?>dashboard.php" title="Home">Home</a></li>
								<li class="<?php if( $WebManagement ){ ?>active <?php } ?>dropdown"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" title="Web Management">Web Management <b class="caret"></b></a>
									<ul class="dropdown-menu">

										<?php if( $page_url == 'categories.php' ){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>categories.php" title="Categories">Categories</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>categories.php" title="Categories">Categories</a></li>
										<?php } ?>

										<?php if( $page_url == 'blog.php' || $page_url == 'add-post.php' || $page_url == 'edit-post.php' || $page_url == 'blog-category.php' ){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>blog.php" title="My Posts">Blog</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>blog.php" title="My Posts">Blog</a></li>
										<?php } ?>
										
										<?php if($page_url == 'album.php' || $page_url == 'add-album.php' || $page_url == 'edit-album.php' || $page_url == 'album-photos.php' || $page_url == 'add-photo.php' || $page_url == 'edit-photo.php'){  ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>album.php" title="Web Gallery">Web Gallery</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>album.php" title="Web Gallery">Web Gallery</a></li>
										<?php } ?>
										
										<?php if($page_url == 'videos.php' || $page_url == 'add-video.php' || $page_url == 'edit-video.php' || $page_url == 'video-categories.php' ){  ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>videos.php" title="Videos">Videos</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>videos.php" title="Videos">Videos</a></li>
										<?php } ?>
										
										<?php if($page_url == 'pages.php' || $page_url == 'add-page.php' || $page_url == 'edit-page.php'){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>pages.php" title="Pages">Pages</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>pages.php" title="Pages">Pages</a></li>
										<?php } ?>

										<?php if($page_url == 'slider.php' || $page_url == 'add-slider-img.php' || $page_url == 'edit-slider-img.php'){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>slider.php" title="Slider">Slider</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>slider.php" title="Slider">Slider</a></li>
										<?php } ?>

										<?php if($page_url == 'repository.php' ){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>repository.php" title="Slider">Repository</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>repository.php" title="Slider">Repository</a></li>
										<?php } ?>

									</ul>
								</li>

								<li class="dropdown<?php if( $preferences ){ ?> active<?php } ?>"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" title="Web Preferences">Web Preferences <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<?php if( $page_url == 'preferences.php' ){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>preferences.php" title="Web Preferences">Web Preferences</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>preferences.php" title="Web Preferences">Web Preferences</a></li>
										<?php } ?>

										<?php if( $page_url == 'web-customize.php' || $page_url == 'add-web-customize.php'  || $page_url == 'edit-web-customize.php' ){ ?>
										<li class="active"><a href="<?php echo BASE_URL_ADMIN ?>preferences.php?command=web-customize" title="Web Customize">Web Customize</a></li>
										<?php }else{ ?>
										<li><a href="<?php echo BASE_URL_ADMIN ?>preferences.php?command=web-customize" title="Web Customize">Web Customize</a></li>
										<?php } ?>
									</ul>
								</li>

							</ul>
							<ul class="nav pull-right">
								<li class="dropdown"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $user_row['firstname']. " " .$user_row['lastname'];?>"><?php echo $user_row['firstname']. " " .$user_row['lastname'];?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URL; ?>" target="_blank" title="Visit Website">Visit Website</a></li>
										<li class="divider">&nbsp;</li>
										<li><a href="<?php echo BASE_URL_ADMIN ?>logout.php" title="Logout">Logout</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>