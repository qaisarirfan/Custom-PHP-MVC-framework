<?php
	ini_set('post_max_size', '8M');
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/class.msg.php" );	
	
	include( "../core/models/class.members.php" );
	include( "../core/models/model.repository.php" );

	include( "../core/functions/functions.php" );

	
	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'repository';

	$theme->page_title = "Repository";
	
	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if( !is_file( $FR->folder_path() ) ){
		@mkdir( $FR->folder_path() );
	}
	
	if( $_REQUEST['command'] == 'add' ){

		$FR->add_file( $_REQUEST, $_FILES );

	}elseif( $_REQUEST['command'] == 'delete' ){

		$FR->delete_file( $_REQUEST );

	}else{
		$theme->msg = $FR->return_msg();
		$result = $FR->prepare_query();
		$total = $db->count_rows( $result );
		$per_page = 15;
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->row = $FR->fetch_row( $start, $per_page, '' );
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}
		$theme->render_file( 'repository.php' );
	}
?>