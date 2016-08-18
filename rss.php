<?php 
	include( "core/config.php" );
	include( "core/classes/class.db.php" );
	include( "core/classes/class.themes.php" );

	include( "core/models/model.video.php" );
	include( "core/models/model.blog.php" );
	include( "core/models/model.pages.php" );

	include( "core/functions/functions.php" );

	$theme = new Themes( 'default-theme' );
	$theme->theme_dir = 'themes';

	function generator_xml ( $table, $lock, $order ){
		global $db;
		$xml = "";
		$query = "select * from `$table` where `$lock` = 'publish' order by `$order` asc";
		$result = $db->query( $query );
		while( $row = $db->fetch_assoc( $result) ){
			//print_r($row);
			$xml .= '<item>';
				$xml .= '<title>'.$row['video_title'].'</title>';
				$xml .= '<link>'.$row['video_vd_url'].'</link>';
				$xml .= '<description><![CDATA[<img src="'.$row['video_thumb_url'].'" align="left" width="100px">'. stripslashes( strip_tags( html_entity_decode( $row['video_description'] ) ) ).']]></description>';
				$xml .= '<guid>'.$row['video_vd_url'].'</guid>';
			$xml .= '</item>';
		}
		return $xml;
	}
	
	$xml = '';
	$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
	$xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
		$xml .= '<channel>';
			$xml .= '<atom:link href="'.BASE_URL.'rss" rel="self" type="application/rss+xml" />';
			$xml .= '<title>'.APP_TITLE.' Videos</title>';
			$xml .= '<link>'.BASE_URL.'videos</link>';
			$xml .= '<description>All about Naats</description>';
			$xml .= '<language>en-us</language>';
			$xml .= '<image>';
				$xml .= '<url>'.$theme->get_theme_name_with_http().'/css/imgs/logo.png</url>';
				$xml .= '<title>'.APP_TITLE.' Videos</title>';
				$xml .= '<link>'.BASE_URL.'videos</link>';
			$xml .= '</image>';
			$xml .= generator_xml( DB_PREFIX . $video->table_videos, 'video_status', 'video_date' );

		$xml .= '</channel>';
	$xml .= '</rss>';

	header("content-type:text/xml; charset:UTF-8");
	echo $xml;
?>