<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/upload-image.php" );
	include( "../core/classes/class.msg.php" );	
	
	include( "../core/models/class.members.php" );
	include( "../core/models/model.category.php" );
	include( "../core/models/model.video.php" );
	include( "../core/models/model.preferences.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'video';

	$theme->page_title = "Video";
	
	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if ( $_REQUEST['command'] == 'add' ){

		$theme->page_title = "Add Video";
		$theme->category = $cate->get_category();
		$theme->render_file( 'add-video.php' );

	}elseif ( $_REQUEST['command'] == 'add-video' ){

		$video->add_video( $_REQUEST );

	}elseif ( $_REQUEST['command'] == 'edit' ){

		$id = intval( $_REQUEST['id'] );
		$theme->page_title = "Edit Video";
		$theme->category = $cate->get_category();
		$theme->row = $video->get_video_by_id( $id );
		$theme->subcategory = $cate->get_sub_category( $theme->row['category'] );
		$theme->render_file( 'edit-video.php' );

	}elseif ( $_REQUEST['command'] == 'save-video' ){

		$video->update_video( $_REQUEST );

	}elseif ( $_REQUEST['command'] == 'delete' ){

		$id = intval( $_REQUEST['id'] );
		$video->delete_video( $id );

	}elseif ( $_REQUEST['command'] == 'delete_permanent' ){

		$id = intval( $_REQUEST['id'] );
		$video->delete_permanent_video( $id );

	} elseif ($_REQUEST['command']=="setting"){

		$theme->video_setting = array();
	
		$theme->video_setting['video_show'] = $pref->get_value('video_show');
		$theme->video_setting['video_per_page_post'] = $pref->get_value('video_per_page_post');
		$theme->video_setting['video_top_view_post'] = $pref->get_value('video_top_view_post');
		$theme->video_setting['video_latest_post'] = $pref->get_value('video_latest_post');
		$theme->video_setting['video_related_post'] = $pref->get_value('video_related_post');
		$theme->video_setting['video_page_name'] = $pref->get_value('video_page_name');
		$theme->video_setting['video_keywords'] = $pref->get_value('video_keywords');
		$theme->video_setting['video_description'] = $pref->get_value('video_description');

		$theme->page_title = "Video Setting";
		$theme->render_file( 'video-setting.php' );

	}else if( $_REQUEST['command'] == 'save-setting' ){
		
		foreach( $_REQUEST as $req => $val ){
			if( $req != 'command' && $req != 'PHPSESSID' && $req != 'submit' ){
				$pref->set_value( $req, $val);
			}
		}
		header("location:videos.php?command=setting");

	}else{
		
		$query = " WHERE";
		if( $_REQUEST['c'] != '' && $_REQUEST['status'] != '' ){
			$query .= " `video_$_REQUEST[c]` = '$_REQUEST[status]'";
		}else{
			$query .= " `video_status` != 'trash'";
		}
		if( $_REQUEST['c'] != '' && $_REQUEST['order'] != '' ){
			$query .= " ORDER BY `video_$_REQUEST[c]` $_REQUEST[order]";
		}else{
			$query .= " ORDER BY `video_date` DESC";
		}

		$result = $video->prepare_query( '', '', $query, 'admin');
		$total = $db->count_rows( $result );
		$per_page = 12;
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();

		$theme->paging	= $pg->render_pages();
		$theme->videos = $video->fetch_posts( $start, $per_page, $query, 'admin' );
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'videos.php' );

	}
?>