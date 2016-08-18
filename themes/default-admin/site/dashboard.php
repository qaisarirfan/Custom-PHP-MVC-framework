<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div class="container">
	<div class="context">
		<div class="row">
			<div class="dashboard span6"> 
				<ul class="thumbnails">

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>categories.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>categories.php" class="thumbnail" title="Categories">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/category.png" title="Categories" alt="Categories" /></div>
							<h3 class="font-share-techregular">Categories</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>blog.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>blog.php" class="thumbnail" title="Blog Post">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/post.png" title="Post" alt="Post" /></div>
							<h3 class="font-share-techregular">Blog Post</h3>
						</a>
					</li>
					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>album.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>album.php" class="thumbnail" title="Web Gallery">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/album.png" title="Allbums" alt="Allbums" /></div>
							<h3 class="font-share-techregular">Web Gallery</h3>
						</a>
					</li>
					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>videos.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>videos.php" class="thumbnail" title="Videos">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/Videos.png" title="Videos" alt="Videos" /></div>
							<h3 class="font-share-techregular">Videos</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>pages.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>pages.php" class="thumbnail" title="Pages">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/page.png" title="Pages" alt="Pages" /></div>
							<h3 class="font-share-techregular">Pages</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>slider.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>slider.php" class="thumbnail" title="Slider">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/Image.png" title="Slider" alt="Slider" /></div>
							<h3 class="font-share-techregular">Slider</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>repository.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>repository.php" class="thumbnail" title="Repository">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/Folder.png" title="Repository" alt="Repository" /></div>
							<h3 class="font-share-techregular">Repository</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>preferences.php'">
						<a href="<?php echo BASE_URL_ADMIN ?>preferences.php" class="thumbnail" title="Settings">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/web-management.png" title="Settings" alt="Settings" /></div>
							<h3 class="font-share-techregular">Settings</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL_ADMIN ?>preferences.php?command=web-customize'">
						<a href="<?php echo BASE_URL_ADMIN ?>preferences.php?command=web-customize" class="thumbnail" title="Web Customize">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/setting.png" title="Web Customize" alt="Web Customize" /></div>
							<h3 class="font-share-techregular">Web Customize</h3>
						</a>
					</li>

					<li class="span2" onClick="window.location='<?php echo BASE_URL ?>webstats'">
						<a href="<?php echo BASE_URL ?>webstats" class="thumbnail" title="Webstats">
							<div class="image"><img src="<?php echo $this->get_theme_name_with_http(); ?>/css/imgs/db-images/stats.png" title="Webstats" alt="Webstats" /></div>
							<h3 class="font-share-techregular">Webstats</h3>
						</a>
					</li>

				</ul>
			</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>