<?php
	include( "core/config.php" );
	include( "core/classes/class.db.php" );
	include( "core/classes/class.themes.php" );
	include( "core/classes/class.paginator.php" );

	include( "core/models/model.blog.php" );
	include( "core/models/model.category.php" );
	include( "core/models/model.pages.php" );
	include( "core/models/model.preferences.php" );

	include( "core/functions/functions.php" );

	include( "webstats/stat-counter.php" );	
	
	$theme = new Themes( 'default-theme' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'blog';
	
	$theme->page_title = "Blog";
	$theme->content = "Welcome to my Blog";

	if( $pref->get_value('blog_show') != 'yes' ){
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

	$theme->top_view = $blog->get_top_view_post($pref->get_value('blog_top_view_post'));
	$theme->tag_list = $blog->get_tags_list();
	$theme->video_menu = $cate->get_menu_category_list();
	//$theme->video_menu = $cate->get_category_list( 'video','video' );
	$theme->blog_menu = $cate->get_category_list( 'blog','post' );

	$theme->header_page = $page->get_header_pages();
	$theme->footer_page = $page->get_footer_pages();

	if( $_REQUEST['command'] == 'detail' ){

		$theme->post_row = $blog->get_post_by_name( $_REQUEST['url'] );
		$theme->page_title = $theme->post_row['post_title'];
		$blog->view_post_count( $theme->post_row['id'], $_SERVER['REMOTE_ADDR'] );
		$theme->related = $blog->related( $theme->post_row['id'], $theme->post_row['post_title'], $pref->get_value('blog_related_post') );
		$theme->render_file( 'blog-detail.php' );
		
	}else{

		if ( $_REQUEST['topics'] != '' ){
			$cat_row = $cate->get_cat_by_name( $_REQUEST['topics'] );
			$topics = $cat_row['id'];
			$title = $cat_row['name'];
			$theme->page_title = $title . " Blog";
		}
	
		if( $_REQUEST['categories'] != '' ){
			$sub_cat_row = $cate->get_sub_cat_by_name( $_REQUEST['topics'], $_REQUEST['categories'] );
			$categories = $sub_cat_row['id'];
			$title = stripcslashes( $cat_row['name'] ). " &rarr; " .stripcslashes( $sub_cat_row['name'] );
			$theme->page_title = $title . " Blog";
		}
	
		if( $_REQUEST['tag'] != '' && $_REQUEST['tag'] != '0' ){
			$tag = trim( $_REQUEST['tag'] );
			$query = " and `post_tags` like '%$tag%'";
		}
	
		if($topics!='' && $topics!=0){
			$query .= " and `category` = '$topics'";
		}
	
		if($categories!='' && $categories!=0){
			$query.=" and `sub_category` = '$categories'";
		}
	
		$result = $blog->prepare_query('','', $query, 'user');
		$total = $db->count_rows( $result );
		$per_page = $pref->get_value('blog_per_page_post');
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->posts = $blog->fetch_posts( $start, $per_page, $query, 'user' );
		$theme->render_file( 'index.php' );
		
	}
?>