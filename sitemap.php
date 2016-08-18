<?php 
	include( "core/config.php" );
	include( "core/classes/class.db.php" );

	include( "core/models/model.video.php" );
	include( "core/models/model.blog.php" );
	include( "core/models/model.pages.php" );
	include( "core/models/model.category.php" );

	include( "core/functions/functions.php" );

	$xml = '';
	$site_url = BASE_URL;
	function generator_xml ( $url, $table, $lock, $order ){
		global $db;
		$xml = "";
		$query = "select `$url` from `$table` where `$lock` = 'publish' order by `$order` desc";
		$result = $db->query( $query );
		while( $row = $db->fetch_assoc( $result) ){
			$xml .= "
				<url>
					<loc>$row[$url]</loc>
				</url>
			";
		}
		return $xml;
	}

	$xml .= '<?xml version="1.0" encoding="UTF-8"?>';
	$xml .= '<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	$xml .= "
		<url>
			<loc>".$site_url."index</loc>
			<lastmod>".date("Y-m-d",time())."</lastmod>
			<changefreq>daily</changefreq>
		</url>
		<url>
			<loc>".$site_url."blog</loc>
			<lastmod>".date("Y-m-d",time())."</lastmod>
			<changefreq>daily</changefreq>
		</url>
		<url>
			<loc>".$site_url."contact-us</loc>
			<lastmod>".date("Y-m-d",time())."</lastmod>
			<changefreq>daily</changefreq>
		</url>
		<url>
			<loc>".$site_url."videos</loc>
			<lastmod>".date("Y-m-d",time())."</lastmod>
			<changefreq>daily</changefreq>
		</url>
	";
	$xml .= $cate->get_category_list('videos','video',true);
	$xml .= generator_xml( 'post_url', DB_PREFIX . $blog->table_posts, 'post_status', 'post_date');
	$xml .= generator_xml( 'video_custom_url', DB_PREFIX . $video->table_videos, 'video_status', 'video_date');
	$xml .= generator_xml( 'page_url', $page->table_pages, 'page_status', 'page_date');
	$xml.='</urlset>';
	header("Content-type:text/xml");
	echo $xml;
	/*
	$path = SITE_PATH.'sitemap.xml';
	if( file_exists( $path ) ){
		unlink($path);
	}
	$filexml = fopen($path,'a+');
	if($filexml){
		$write = $xml;
		fputs($filexml,$write);
	}
	fclose($filexml);
	*/
?>