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
	include( "../core/models/model.preferences.php" );
	include( "../core/models/model.photo-album.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'album';

	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	$userid = $auth->get_userid();
	$theme->user_row = $member->get_row( $member->table_prefix.'admin', $userid );
	$theme->expire_session = $auth->expire_session();

	if( !is_file( $albuM->folder_path() ) ){
		@mkdir( $albuM->folder_path() );
	}

	if( $_REQUEST['command'] == 'add-album' ){

		$theme->category = $cate->get_category();
		$theme->page_title = "Add Album";
		$theme->render_file( 'add-album.php' );

	} elseif ( $_REQUEST['command'] == 'add-album-save' ){

		$albuM->add_album( $_REQUEST );

	} elseif ( $_REQUEST['command'] == 'edit-album' ){
		
		$id = intval( $_REQUEST['id'] );
		$theme->row = $albuM->get_allbum_by_id ( $id );
		$theme->category = $cate->get_category();
		$theme->subcategory = $cate->get_sub_category( $theme->row['category'] );
		$theme->page_title = "Edit Album - ". stripslashes( $theme->row['album_name'] );
		$theme->render_file( 'edit-album.php' );

	} elseif ( $_REQUEST['command'] == 'edit-album-save' ){

		$albuM->update_allbum( $_REQUEST );

	} elseif ( $_REQUEST['command'] == 'open' ){

		$theme->id = intval( $_REQUEST['id'] );
		$albuM->set_total_file( $theme->id );
		$theme->album_name = $albuM->smart_url( $albuM->get_album_name( $theme->id ) );
		$theme->page_title = "Photos";
		$query = "album_id = '$theme->id'";
		$result = $albuM->prepare_photo_query( '', '', $query, 'admin' );
		$total = $db->count_rows( $result );
		$per_page = 15;
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->rows = $albuM->fetch_photo_posts( $start, $per_page, $query, 'admin' );
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'all-photos.php' );

	} elseif ( $_REQUEST['command'] == 'add-photo' ){

		$theme->page_title = "Add Photo";
		$theme->render_file( 'add-photo.php' );

	} elseif ( $_REQUEST['command'] == 'add-photo-save' ){

		$id = intval( $_REQUEST['id'] );

		if( $_FILES['photo_name']['name'] != '' ){
			$uniqe = "-" . randCode('3');
			$allbum_name = $albuM->smart_url( $albuM->get_album_name( $id ) );
			$allbum_path = $albuM->get_dir_path_with_name( $allbum_name );
			$result = $upload_img->upload_image_with_auto_thumbnail( $_FILES['photo_name'], $allbum_path, $_REQUEST['photo_title'] . $uniqe, '128', 'thumb' );
			if( $result ){
				$array = array();
				$array['album_id'] = $id;
				foreach( $_REQUEST as $key => $value ){
					if( is_string( $value) ){
						$array[ $key ] = check_slashes( $value );
					}
				}
				$array['photo_name'] = $upload_img->get_image_name();
				$array['photo_size'] = $upload_img->display_filesize();
				$array['photo_resolution'] = $upload_img->get_image_resolution();
				$array['photo_type'] = $upload_img->format;
				
				$albuM->add_photo( $array );
			}
		}

	} elseif ( $_REQUEST['command'] == 'edit-photo' ){

		$id = intval( $_REQUEST['id'] );
		$theme->row = $albuM->get_photos_id( $id );
		$theme->album_name = $albuM->smart_url( $albuM->get_album_name( $theme->row['album_id'] ) );
		$theme->page_title = "Edit Photo";
		$theme->render_file( 'edit-photo.php' );

	} elseif ( $_REQUEST['command'] == 'edit-photo-save' ){

		$id = intval( $_REQUEST['id'] );
		$album = intval( $_REQUEST['album'] );

		if( $_FILES['photo_name']['name'] != '' ){
			$uniqe = "-" . $id;
			$allbum_name = $albuM->smart_url( $albuM->get_album_name( $album ) );
			$allbum_path = $albuM->get_dir_path_with_name( $allbum_name );
			unlink( $allbum_path . $albuM->get_photo_name ( $id ) );
			unlink( $allbum_path . "thumb-" . $albuM->get_photo_name ( $id ) );
			$result = $upload_img->upload_image_with_auto_thumbnail( $_FILES['photo_name'], $allbum_path, $_REQUEST['photo_title'] . $uniqe, '128', 'thumb' );
			if( $result ){
				$array = array();
				$array['id'] = $id;
				$array['album_id'] = $album;
				foreach( $_REQUEST as $key => $value ){
					if( is_string( $value) ){
						$array[ $key ] = check_slashes( $value );
					}
				}
				$array['photo_name'] = $upload_img->get_image_name();
				$array['photo_size'] = $upload_img->display_filesize();
				$array['photo_resolution'] = $upload_img->get_image_resolution();
				$array['photo_type'] = $upload_img->format;
				
				$albuM->update_photo( $array );
			}
		}

	} elseif ( $_REQUEST['command'] == 'delete-album' ){

		$id = intval( $_REQUEST['id'] );
		$albuM->delete_album( $id );

	} elseif ( $_REQUEST['command'] == 'delete-photo' ){
		
		$albuM->delete_photo( $_REQUEST );
		
	}else{

		$theme->page_title = "Photo Albums";
		$result = $albuM->prepare_query('','','','admin');
		$total = $db->count_rows( $result );
		$per_page = 15;
		$page = $_REQUEST['page'];
		$pg = new Paging( $total, $page, $per_page );
		$start = $pg->get_start();
		$theme->paging	= $pg->render_pages();
		$theme->rows = $albuM->fetch_posts( $start, $per_page, '', 'admin' );
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}
		$theme->render_file( 'index.php' );
	}
?>