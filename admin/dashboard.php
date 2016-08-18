<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.msg.php" );	

	include( "../core/models/class.members.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'site';
	$theme->page_title = "Dashboard";

	if( $auth->authenticate() < 1 ){
		header("location:index.php");
		exit();
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	
	$theme->expire_session = $auth->expire_session();

	$theme->render_file('dashboard.php');
?>