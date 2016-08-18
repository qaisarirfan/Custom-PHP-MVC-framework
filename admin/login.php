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
	$theme->page_title = "Admin Login";

	if( $auth->authenticate() ){
		header("location:index.php");
		exit();
	}
	if( $_REQUEST['command'] == 'login' ){
		$username = $db->real_escape_string( $_REQUEST['username'] );
		$password = $db->real_escape_string( $_REQUEST['password'] );
		$row = $member->login( $member->table_admin, $username, $password );
		if( $row ){
			$auth->create_session( $row['id'] );
			if( $_REQUEST['auto_logout'] == 'on' ){
				$auto_logout = 'yes';
			}else{
				$auto_logout = 'no';
			}
			$member->update_login( $member->table_admin, $row['id'], 'true', $auto_logout );
			if( $_SESSION['redirect']['redirect_url'] != '' ){
				@header( "location:". $_SESSION['redirect']['redirect_url'] );
				exit();
			}else{
				@header( "location:dashboard.php" );
				exit();
			}
		}else{
			@header( "location:login.php?msg=Login Failed! Invalid Username/Password" );
			exit();
		}
	}else if($_REQUEST['command']=='logout'){
		$a->logout();
		header("location:login.php");
	}else{
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],'error');
		}
		$theme->render_file('login.php');
	}
?>