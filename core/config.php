<?php
	session_start();
	define("USERNAME","girlvalu_qadri");
	define("PASSWORD","2sVaApNSSXu6");
	define("DBNAME","girlvalu_qadristudio");

	define( 'DB_PREFIX', 'qadristudio_' );
	define( 'SLIDER', DB_PREFIX.'slider' );
	define( 'PREFERENCES', DB_PREFIX.'preferences' );
	define( 'CUSTOM_BACKGROUND', DB_PREFIX.'custom_backgrounds' );
	define( 'VIDEOS', DB_PREFIX.'videos' );
	define( 'VIDEO_VIEWER', DB_PREFIX.'video_viewer' );
	define( 'CATEGORIES', DB_PREFIX.'categories' );
	define( 'SUB_CATEGORIES', DB_PREFIX.'sub_categories' );
	define( 'PAGES', DB_PREFIX.'pages' );
	define( 'PAGE_VIEWER', DB_PREFIX.'page_viewer' );
	define( 'ALBUM', DB_PREFIX.'photo_album' );
	define( 'ALBUM_VIEWER', DB_PREFIX.'album_viewer' );
	define( 'ALBUM_PHOTOS', DB_PREFIX.'photos' );
	define( 'PHOTO_VIEWER', DB_PREFIX.'photo_viewer' );

	define( 'STATS_SESSIONS', DB_PREFIX.'stats_sessions' );
	define( 'STATS_PAGEVIEWS', DB_PREFIX.'stats_pageviews' );
			
	define( 'APP_TITLE', 'Qadri Studio' );
	define( 'APP_NAME', 'Qadri Studio' );

	define( 'SITE_PATH', dirname( dirname( __FILE__ ) ) . '/' );
	define( "BASE_URL", "http://".$_SERVER['HTTP_HOST']."/" );
	define( "BASE_URL_ADMIN", "http://".$_SERVER['HTTP_HOST']."/admin/" );
	define( "BASE_URL_STATS", "http://".$_SERVER['HTTP_HOST']."/webstats/" );

	define( "POST_PIC", "site-content/post-pic/" );
	define( "FILE_REPOSITORY", "site-content/file-repository/" );
	define( "SLIDER_PATH", "site-content/slider/" );
	define( "PHOTOS", "site-content/photos/" );
	define( "CUSTOM_BACKGROUND_DIR", "site-content/custom-background/" );

	if(!get_magic_quotes_gpc()){
		foreach($_REQUEST as $key=>$value){
			if(is_string($value))
				$_REQUEST[$key]=mysql_escape_string($value);
		}
	}

	foreach($_REQUEST as $key=>$value){
		if(is_array($value)) continue;
		$_REQUEST[$key]=html_entity_decode($value);
		$_REQUEST[$key]=htmlspecialchars($value);
	}
?>