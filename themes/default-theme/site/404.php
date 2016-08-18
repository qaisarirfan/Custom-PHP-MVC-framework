<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<div id="page-not-found">
				<h6><?php echo $this->page_title; ?></h6>
				<p>Sorry, but the page you are looking for has not been found. <br />Try checking the URL for errors, then hit the refresh button on your browser.</p>
				<span id="time">30</span>
			</div>
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
<script>
	$(document).ready(function(e) {
		var elem = $('#time');
		var count = parseInt(elem.text());
		counter = setInterval(
			function() {
				count -= 1;
				if( count == '1' ){
					window.location = '<?php echo BASE_URL ?>index';
					clearInterval(counter);
				}
				elem.html(count);
			}, 1000
		);
	});
</script>

</body>
</html>