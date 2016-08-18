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

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'category';

	$theme->page_title = "Categories";
	
	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if ($_REQUEST['command']=="category"){
		
		
	} elseif ($_REQUEST['command']=="add-category"){

		$result = $cate->add_category( $_REQUEST['name'] );
		if( $result ){
			header( "location:categories.php?msg=Category add successfuly.&type=success" );
		}else{
			header( "location:categories.php?msg=Category already exists.&type=attention" );
		}
		
	} elseif ($_REQUEST['command']=="edit-category"){
		
		$pcid = intval( $_REQUEST['pcid'] );
		$result = $cate->update_category( $_REQUEST['name'], $pcid );
		if( $result ){
			header( "location:categories.php?msg=Category update successfuly.&type=success" );
		}else{
			header( "location:categories.php?Category already exists.&type=attention" );
		}

	} elseif ( $_REQUEST['command'] == "delete-category" ){

		$pcid = intval( $_REQUEST['pcid'] );
		$cate->delete_category( $pcid );

	} elseif ( $_REQUEST['command'] == "add-sub-cat" ){

		$cate->add_sub_category( $_REQUEST );
		
	} elseif ( $_REQUEST['command'] == "edit-sub-cat" ){

		$cate->update_sub_category( $_REQUEST );
		
	} elseif ( $_REQUEST['command'] == "delete-sub-category" ){

		$pscid = intval( $_REQUEST['pscid'] );
		$cate->delete_sub_category( $pscid );

	}else{
		
		$theme->page_title = "Categories";
		$theme->category = $cate->get_category();
		$theme->subcategory = $cate->get_sub_category( );
		
		$theme->rang_one = $cate->categories( range('A', 'H'), 'edit-yes' );
		$theme->rang_two = $cate->categories( range('I', 'O'), 'edit-yes' );		
		$theme->rang_three = $cate->categories( range('P', 'Z'), 'edit-yes' );
		
		$theme->category_by_id = $cate->category_by_id( intval( $_REQUEST['pcid'] ) );
		$theme->sub_category_by_id = $cate->sub_cat_by_id( intval( $_REQUEST['pscid'] ) );
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}
		$theme->render_file( 'category.php' );

	}
?>