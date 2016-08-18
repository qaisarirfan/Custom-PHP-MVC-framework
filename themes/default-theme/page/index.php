<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
<meta name="description" content="<?php echo $this->row['page_description'] ?>" />
<meta name="keywords" content="<?php echo $this->row['page_keywords'] ?>" />
<link rel="canonical" href="<?php echo $this->row['page_url'] ?>" />
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<h2 class="page-title"><?php echo $this->row['page_name'] ?></h2>
			<div class="main-text"><?php echo html_entity_decode($this->row['page_text']) ?></div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>