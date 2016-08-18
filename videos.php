<?php
	include( "core/config.php" );
	include( "core/classes/class.db.php" );
	include( "core/classes/class.themes.php" );
	include( "core/classes/class.paginator.php" );

	include( "core/models/model.category.php" );
	include( "core/models/model.video.php" );
	include( "core/models/model.preferences.php" );
	include( "core/models/model.pages.php" );

	include( "core/functions/functions.php" );

		
	
	$theme = new Themes( 'default-theme' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'video';

	$theme->page_title = "Video";

	if( $pref->get_value('video_show') != 'yes' ){
		header("location:index");
	}

	$theme->blog_setting = array();

	$theme->blog_setting['blog_show'] = $pref->get_value('blog_show');
	$theme->blog_setting['blog_per_page_post'] = $pref->get_value('blog_per_page_post');
	$theme->blog_setting['blog_top_view_post'] = $pref->get_value('blog_top_view_post');
	$theme->blog_setting['blog_latest_post'] = $pref->get_value('blog_latest_post');
	$theme->blog_setting['blog_related_post'] = $pref->get_value('blog_related_post');
	$theme->blog_setting['blog_page_name'] = $pref->get_value('blog_page_name');
	$theme->blog_setting['blog_keywords'] = $pref->get_value('blog_keywords');
	$theme->blog_setting['blog_description'] = $pref->get_value('blog_description');

	$theme->video_setting = array();

	$theme->video_setting['video_show'] = $pref->get_value('video_show');
	$theme->video_setting['video_per_page_post'] = $pref->get_value('video_per_page_post');
	$theme->video_setting['video_top_view_post'] = $pref->get_value('video_top_view_post');
	$theme->video_setting['video_latest_post'] = $pref->get_value('video_latest_post');
	$theme->video_setting['video_related_post'] = $pref->get_value('video_related_post');
	$theme->video_setting['video_page_name'] = $pref->get_value('video_page_name') ? $pref->get_value('video_page_name') : "Videos";
	$theme->video_setting['video_keywords'] = $pref->get_value('video_keywords');
	$theme->video_setting['video_description'] = $pref->get_value('video_description');

	$theme->preferences = array();

	$theme->preferences['social_contact_email'] = stripcslashes( $pref->get_value( 'social_contact_email' ) );
	$theme->preferences['social_facebook_text'] = stripcslashes( $pref->get_value( 'social_facebook_text' ) );
	$theme->preferences['social_twitter_text'] = stripcslashes( $pref->get_value( 'social_twitter_text' ) );
	$theme->preferences['social_gplus'] = stripcslashes( $pref->get_value( 'social_gplus' ) );
	$theme->preferences['social_dailymotion'] = stripcslashes( $pref->get_value('social_dailymotion'));
	$theme->preferences['home_text'] = stripcslashes( $pref->get_value('home_text') );
	$theme->preferences['footer_text'] = stripcslashes( $pref->get_value('footer_text') );
	$theme->preferences['phone_no'] = stripcslashes( $pref->get_value('phone_no') );
	$theme->preferences['seo_home_title'] = stripcslashes( $pref->get_value('seo_home_title') );
	$theme->preferences['seo_home_keywords'] = stripcslashes( $pref->get_value('seo_home_keywords') );
	$theme->preferences['seo_home_description'] = stripcslashes( $pref->get_value('seo_home_description') );
	$theme->preferences['body_background'] = stripcslashes( $pref->get_value('body_background') );

	$theme->blog_menu = $cate->get_category_list( 'blog','post' );
	$theme->video_menu = $cate->get_menu_category_list();
	//$theme->video_menu = $cate->get_category_list( 'video','video' );
	$theme->top_view_video = $video->get_top_view_video( $theme->video_setting['video_top_view_post'] );
	$theme->header_page = $page->get_header_pages();
	$theme->footer_page = $page->get_footer_pages();


	if( $_REQUEST['command'] == 'detail' ){

		if( $_REQUEST['id'] == '' ){
			$theme->video_row = $video->get_video_by_name( $_REQUEST['url'] );
		}else{
			$theme->video_row = $video->get_view_video_by_id( intval($_REQUEST['id']) );
		}

		$theme->page_title = stripslashes($theme->video_row['video_title']);
		$video->view_video_count( $theme->video_row['id'], $_SERVER['REMOTE_ADDR'] );
		$theme->related = $video->related( $theme->video_row['id'], $theme->video_row['video_title'], $theme->video_setting['video_related_post'] );
		$theme->render_file( 'video-detail.php' );
		
	}else{

		if ( $_REQUEST['topics'] != '' ){
			$cat_row = $cate->get_cat_by_name( $_REQUEST['topics'] );
			$topics = $cat_row['id'];
			$title = $cat_row['name'];
			$theme->page_title = $title . " Video";
			$url = "/topics/".$cat_row['url'];
		}
	
		if( $_REQUEST['categories'] != '' ){
			$sub_cat_row = $cate->get_sub_cat_by_name( $_REQUEST['topics'], $_REQUEST['categories'] );
			$categories = $sub_cat_row['id'];
			$title = stripcslashes( $cat_row['name'] ). " &rarr; " .stripcslashes( $sub_cat_row['name'] );
			$theme->page_title = $title . " Video";
			$url = "/topics/".$cat_row['url']."/categories/".$sub_cat_row['url'];
		}

		if( $_REQUEST['tag'] != '' ){
			$tag = addslashes( $_REQUEST['tag'] );
			$query .= " and `video_tags` LIKE '%$tag%'";
			$url = "/tag/".$tag;
		}
	
		if($topics!='' && $topics!=0){
			$query .= " and `category` = '$topics'";
		}
	
		if($categories!='' && $categories!=0){
			$query.=" and `sub_category` = '$categories'";
		}
	
		$result = $video->prepare_query('','', $query, 'user');
		$total = $db->count_rows( $result );
		$per_page = $theme->video_setting['video_per_page_post'];
		$page = $_REQUEST['page'];
		$conf['query_string'] = BASE_URL . 'videos' . $url;
		$pg = new Paging( $total, $page, $per_page, $conf );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->videos = $video->fetch_posts( $start, $per_page, $query, 'user' );
	
		$theme->render_file( 'index.php' );
		
	}
?>