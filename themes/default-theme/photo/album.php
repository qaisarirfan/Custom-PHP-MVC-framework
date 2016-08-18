<?php include( $this->get_theme_path()."/common/common-header.php" ); ?>
</head>
<body>
<?php include( $this->get_theme_path()."/common/header.php" ); ?>
<div id="content">
	<div class="container">
		<div id="content-inner">
			<h2 class="page-title"><?php echo $this->page_title; ?></h2>
			<div class="entry-meta">
				<span class="meta-published"><?php echo $this->album_row['album_date']?></span>
				<span class="meta-categories">
					<a href="<?php echo BASE_URL; ?>photo/topics/<?php echo $this->album_row['c_url']?>"><?php echo $this->album_row['c_name']?></a>
					<?php if( $this->album_row['sc_name'] ){?>
					 / 
					 <a href="<?php echo BASE_URL; ?>photo/topics/<?php echo $this->album_row['c_url']?>/categories/<?php echo $this->album_row['sc_url']?>"><?php echo $this->album_row['sc_name']?></a>
					<?php } ?>
				</span>
				<span class="meta-reader"><?php echo $this->album_row['album_view']?> People(s) View this</span>
				<div class="clear">&nbsp;</div>
			</div>
			<?php
				$box_height = '128';
				$allbum_count = 0;
				foreach( $this->photo_row as $prow ){ 
					$allbum_count++;
					$pic = $this->album_row['album_path']."/thumb-".$prow['photo_name'];
					$size = getimagesize($pic);
					if( $size[1] == $box_height ){
						$padding = '';
					}else{
						$new_height = ($box_height - $size[1]) / 2;
						$padding = 'style="padding-top:'.$new_height.'px;"';
					}
			?>
			<div class="allbum<?php if( $allbum_count%6==0 ){ ?> margin-right<?php } ?>">
				<a href="<?php echo $prow['photo_url']; ?>" <?php echo $padding ?>>
					<img src="<?php echo $this->album_row['album_path']."/thumb-".$prow['photo_name']; ?>" alt="<?php echo $prow['photo_title']; ?>">
				</a>
			</div>
			<?php } ?>
			<div class="clear">&nbsp;</div>
			<?php echo $this->paging; ?> 
		</div>
	</div>
</div>
<?php include( $this->get_theme_path()."/common/footer.php" ); ?>
</body>
</html>