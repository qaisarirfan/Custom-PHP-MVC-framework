<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/upload-image.php" );
	include( "../core/classes/class.msg.php" );	
	
	include( "../core/models/class.members.php" );
	include( "../core/models/model.blog.php" );
	include( "../core/models/model.category.php" );
	include( "../core/models/model.preferences.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'blog';

	$theme->page_title = "Blog Posts";
	
	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if( !is_file( $blog->folder_path() ) ){
		@mkdir( $blog->folder_path() );
	}

	//print_r($_REQUEST);die();

	if( $_REQUEST['command'] == 'add' ) {
		
		$theme->category = $cate->get_category();
		$theme->page_title = "Add Post";
		$theme->render_file( 'add-post.php' );
		
	} elseif( $_REQUEST['command'] == 'add-post' ){

		$post_thumb = $_FILES['post_thumb'];
		$destination = $blog->folder_path();
		$name = $_REQUEST['post_title'] ."-". randCode( '4' );
		if( $upload_img->upload_image_with_thumbnail( $post_thumb, $destination, $name, 150, 150, 'width', 'thumb' ) ){
			$thumb = $upload_img->get_image_name();
			$upload_img->thumbnail_maker( BASE_URL . POST_PIC, $thumb, '48', '48', 'width', 'small', SITE_PATH . POST_PIC );
			$upload_img->thumbnail_maker( BASE_URL . POST_PIC, $thumb, '64', '64', 'width', 'medium', SITE_PATH . POST_PIC );
			$result = $blog->add_post( $_REQUEST, $thumb );
			if($result){
				header("location:blog.php");
			}
		}
		
	} elseif( $_REQUEST['command'] == 'edit' ){

		$theme->postid = intval( $_REQUEST['id'] );
		$theme->category = $cate->get_category();
		$theme->row = $blog->get_post_by_id( $theme->postid );
		$theme->subcategory = $cate->get_sub_category( $theme->row['category'] );
		$theme->page_title = "Edit Post";
		$theme->render_file( 'edit-post.php' );
		
	} elseif( $_REQUEST['command'] == 'save-post' ){

		$theme->postid = intval( $_REQUEST['id'] );
		$theme->row = $blog->get_post_by_id( $theme->postid );

		$post_thumb = $_FILES['post_thumb'];
		$destination = $blog->folder_path();
		
		if( file_exists( $destination . $theme->row['post_thumb'] ) ){
			unlink( $destination . $theme->row['post_thumb'] );
			unlink( $destination . "thumb-" . $theme->row['post_thumb'] );
			unlink( $destination . "small-" . $theme->row['post_thumb'] );
			unlink( $destination . "medium-" . $theme->row['post_thumb'] );
		}
		
		$name = $_REQUEST['post_title'] ."-". randCode( '4' );
		if( $upload_img->upload_image_with_thumbnail( $post_thumb, $destination, $name, 150, 150, 'width', 'thumb' ) ){
			$thumb = $upload_img->get_image_name();
			$upload_img->thumbnail_maker( BASE_URL . POST_PIC, $thumb, '48', '48', 'width', 'small', SITE_PATH . POST_PIC );
			$upload_img->thumbnail_maker( BASE_URL . POST_PIC, $thumb, '64', '64', 'width', 'medium', SITE_PATH . POST_PIC );
			$result = $blog->update_post( $_REQUEST, $thumb );
			if($result){
				header("location:blog.php");
			}
		}
		
	} elseif ($_REQUEST['command']=="delete"){

		$postid = intval( $_REQUEST['post_id'] );
		$result = $blog->delete_post( $postid );
		if( $result ){
			header( "location:blog.php" );
		}

	} elseif ($_REQUEST['command']=="setting"){

		$theme->blog_setting = array();
	
		$theme->blog_setting['blog_show'] = $pref->get_value('blog_show');
		$theme->blog_setting['blog_per_page_post'] = $pref->get_value('blog_per_page_post');
		$theme->blog_setting['blog_top_view_post'] = $pref->get_value('blog_top_view_post');
		$theme->blog_setting['blog_latest_post'] = $pref->get_value('blog_latest_post');
		$theme->blog_setting['blog_related_post'] = $pref->get_value('blog_related_post');
		$theme->blog_setting['blog_page_name'] = $pref->get_value('blog_page_name');
		$theme->blog_setting['blog_keywords'] = $pref->get_value('blog_keywords');
		$theme->blog_setting['blog_description'] = $pref->get_value('blog_description');

		$theme->page_title = "Blog Setting";
		$theme->render_file( 'blog-setting.php' );

	}else if( $_REQUEST['command'] == 'save-setting' ){
		
		foreach( $_REQUEST as $req => $val ){
			if( $req != 'command' && $req != 'PHPSESSID' && $req != 'submit' ){
				$pref->set_value( $req, $val);
			}
		}
		header("location:blog.php?command=setting");

	} else {
		
		$result = $blog->prepare_query();
		$total = $db->count_rows( $result );
		$per_page = 15;
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->posts = $blog->fetch_posts( $start, $per_page, '' );
		$theme->render_file( 'blog.php' );
	}
?>