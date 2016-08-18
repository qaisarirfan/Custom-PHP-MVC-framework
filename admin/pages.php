<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/class.msg.php" );	
	
	include( "../core/models/class.members.php" );
	include( "../core/models/model.pages.php" );
	include( "../core/models/model.preferences.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'page';

	$theme->page_title = "Pages";
	
	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if( $_REQUEST['command'] == 'add' ){

		$theme->page_title = "Add New Page";
		$theme->render_file( 'add.php' );
	
	}else if( $_REQUEST['command'] == 'add-page' ){

		$page->add_page($_REQUEST);

	}else if( $_REQUEST['command'] == 'edit' ){

		$id = intval( $_REQUEST['id'] );

		$theme->row = $page->get_row_by_id( $id );

		$theme->page_title = "Edit Page";
		$theme->render_file( 'edit.php' );

	}else if( $_REQUEST['command'] == 'edit-page' ){

		$page->update_page($_REQUEST);

	} else if ($_REQUEST['command']=="delete"){

		$id = intval( $_REQUEST['id'] );
		$page->del_page( $id );

	}else{
		$result = $page->prepare_query('','','','admin');
		$total = $db->count_rows( $result );
		$per_page = 15;
		$pages = $_REQUEST['page'];
		$pg = new Paging( $total, $pages, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->rows = $page->fetch_posts( $start, $per_page, '', 'admin' );

		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'pages.php' );
	}
?>