<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/upload-image.php" );
	include( "../core/classes/class.msg.php" );	

	include( "../core/models/class.members.php" );
	include( "../core/models/model.preferences.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'web-preferences';

	$theme->page_title = "Web Preferences";

	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	if( $_REQUEST['command'] == 'save-setting' ){
		
		foreach( $_REQUEST as $req => $val ){
			if( $req != 'command' && $req != 'PHPSESSID' && $req != 'submit' ){
				$pref->set_value( $req, check_slashes($val) );
			}
		}
		header("location:preferences.php?command=setting");

	}elseif( $_REQUEST['command'] == 'web-customize' ){

		$page_title = "Web Customize";
	
		if( !file_exists ( SITE_PATH.'/site-content/custom-background' ) || !is_dir( SITE_PATH.'/site-content/custom-background' ) ){
			mkdir( SITE_PATH.'/site-content/custom-background' );
		}
	
		if ($_REQUEST['action'] == 'active'){
			$pref->get_active_background($_REQUEST['id']);
		}
	
		if ($_REQUEST['action'] == 'delete'){
			$pref->delete_background($_REQUEST['id']);
		}
	
		if ($_REQUEST['action'] == 'body_background'){	
			$pref->background_preferences( 'body_background', $_REQUEST['body_background'] );
		}

		$theme->preferences['body_background'] = stripcslashes( $pref->get_value( 'body_background' ) );
		$theme->data = $pref->get_background( 0, 0, 'no', 'active' ); 

		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'web-customize.php' );

	}elseif( $_REQUEST['command'] == 'add-web-customize' ){

		$theme->render_file( 'add-web-customize.php' );

	}elseif( $_REQUEST['command'] == 'add-customize' ){

		$path = SITE_PATH.'/site-content/custom-background/';
	
		$upload_img->upload_image( $_FILES['background_image'], $path, $_FILES['background_image']['name'].'_'.time() );
		$image_name = $upload_img->get_image_name();
		if (!empty($image_name)){
			$pref->add_background( $_REQUEST, $image_name );
		}

	}elseif( $_REQUEST['command'] == 'edit-web-customize' ){

		$id = intval($_REQUEST['id']);
		$theme->row = $pref->get_background_row ( $id );

		$theme->render_file( 'edit-web-customize.php' );

	}elseif( $_REQUEST['command'] == 'edit-customize' ){

		$id = intval($_REQUEST['id']);
		$theme->row = $pref->get_background_row ( $id );
	
		$path = SITE_PATH.'/site-content/custom-background/';

		
		$upload_img->upload_image( $_FILES['background_image'], $path, $_FILES['background_image']['name'].'_'.time() );
		$image_name = $upload_img->get_image_name();
		if (!empty($image_name)){
			$query = "select * from $pref->table_custom_backgrounds where id='$id'";
			$result = $db->query ( $query );
			$fetch = $db->fetch_assoc ( $result );
			$image_path = $path.$fetch['backgrounds_image'];
			@unlink( $image_path );
			$pref->edit_background( $_REQUEST, $id, $image_name );
		}else{
			$pref->edit_background( $_REQUEST, $id, '' );
		}

	}else{

		$theme->preferences = array();

		$theme->preferences['social_skype'] = stripcslashes( $pref->get_value( 'social_skype' ) );	
		$theme->preferences['social_contact_email'] = stripcslashes( $pref->get_value( 'social_contact_email' ) );
		$theme->preferences['social_facebook_text'] = stripcslashes( $pref->get_value( 'social_facebook_text' ) );
		$theme->preferences['social_twitter_text'] = stripcslashes( $pref->get_value( 'social_twitter_text' ) );
		$theme->preferences['social_gplus'] = stripcslashes( $pref->get_value( 'social_gplus' ) );
		$theme->preferences['social_dailymotion'] = stripcslashes( $pref->get_value('social_dailymotion'));
		$theme->preferences['home_text'] = stripcslashes( $pref->get_value('home_text') );

		$theme->preferences['address'] = stripcslashes( $pref->get_value('address') );
		$theme->preferences['city'] = stripcslashes( $pref->get_value('city') );
		$theme->preferences['state'] = stripcslashes( $pref->get_value('state') );
		$theme->preferences['zip'] = stripcslashes( $pref->get_value('zip') );
		$theme->preferences['country'] = stripcslashes( $pref->get_value('country') );
		$theme->preferences['phone_no'] = stripcslashes( $pref->get_value('phone_no') );

		$theme->preferences['seo_home_title'] = stripcslashes( $pref->get_value('seo_home_title') );
		$theme->preferences['seo_home_keywords'] = stripcslashes( $pref->get_value('seo_home_keywords') );
		$theme->preferences['seo_home_description'] = stripcslashes( $pref->get_value('seo_home_description') );
		$theme->preferences['footer_text'] = stripcslashes( $pref->get_value('footer_text') );

		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'preferences.php' );

	}

?>