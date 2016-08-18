<?php
	include( "../core/config.php" );
	include( "../core/classes/class.db.php" );
	include( "../core/classes/class.auth.php" );
	include( "../core/classes/class.themes.php" );
	include( "../core/classes/class.paginator.php" );
	include( "../core/classes/upload-image.php" );
	include( "../core/classes/class.msg.php" );	

	include( "../core/models/class.members.php" );
	include( "../core/models/model.slider.php" );
	include( "../core/models/model.preferences.php" );

	include( "../core/functions/functions.php" );

	$theme = new Themes( 'default-admin' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'slider';

	$theme->page_title = "Slider";

	if( $auth->authenticate() < 1 ){
		header("location:login.php");
	}

	if( !is_file( $slider->folder_path() ) ){
		@mkdir( $slider->folder_path() );
	}

	if( $_REQUEST['command'] == 'add' ){

		$theme->page_title = "Add Slide";
		$theme->render_file( 'add.php' );

	}else if( $_REQUEST['command'] == 'edit' ){
		
		$theme->page_title = "Edit Slide";
		$theme->row = $slider->get_slide_by_id( intval( $_REQUEST['id'] ) );
		$theme->render_file( 'edit.php' );

	}else if( $_REQUEST['command'] == 'add-slide' ){

		$slider_pic = $_FILES["slider_picture"];
		$image_name = check_slashes($_REQUEST['slider_title']).'-'.randCode( '4' );

		if( $slider_pic['name'] != '' ){
			if( $upload_img->upload_image_with_thumbnail( $slider_pic, $slider->folder_path(), $image_name, '86', '56', 'width', 'thumb' ) ){
				$picture = $upload_img->get_image_name();
				$result = $slider->add_slider_image( $_REQUEST, $picture );

				if( $result ){
					header("location:slider.php?msg=Slider image successful added.&type=success");
				}else{
					header("location:slider.php?msg=Slider image not add.&type=error");
				}

			}else{
				header("location:slider.php?command=add&msg=".$upload_img->get_message());
			}
		}

	}else if( $_REQUEST['command'] == 'edit-slide' ){
		$id = intval( $_REQUEST['id'] );
		$theme->page_title = "Edit Slide";
		$theme->row = $slider->get_slide_by_id( $id );

		$slider_pic = $_FILES["slider_picture"];
		$image_name = check_slashes($_REQUEST['slider_title']).'-'.randCode( '4' );

		if( $slider_pic['name'] != '' ){
			$upload_img->upload_image_with_thumbnail( $slider_pic, $slider->folder_path(), $image_name, '86', '56', 'width', 'thumb' );
			$picture = $upload_img->get_image_name();
			@unlink( $slider->folder_path().$theme->row['slider_picture'] );
			@unlink( $slider->folder_path().'thumb-'.$theme->row['slider_picture'] );
			$slider->update_slider_pic( $picture, $id );
		}

		$result = $slider->update_slider_images( $_REQUEST );

		if( $result ){
			@header("location:slider.php?msg=Slider image successful updated.&type=success");
		}else{
			@header("location:slider.php?msg=Slider image not update.&type=error");
		}

	}else if( $_REQUEST['command'] == 'delete' ){
		$id = intval( $_REQUEST['id'] );
		$result = $slider->delete_slide( $id );
		if( $result ){
			@header("location:slider.php?msg=Slider image successful deleted.&type=success");
		}else{
			@header("location:slider.php?msg=Slider image not delete.&type=error");
		}

	}else if( $_REQUEST['command'] == 'setting' ){

		$theme->slider_setting = array();
	
		$theme->slider_setting['slider_show'] = $pref->get_value('slider_show');
		$theme->slider_setting['slider_shuffle'] = $pref->get_value('slider_shuffle');
		$theme->slider_setting['slider_width'] = $pref->get_value('slider_width');
		$theme->slider_setting['slider_height'] = $pref->get_value('slider_height');
		$theme->slider_setting['slider_scale_type'] = $pref->get_value('slider_scale_type');
		$theme->slider_setting['slider_align_type'] = $pref->get_value('slider_align_type');
		$theme->slider_setting['slider_effect_type'] = $pref->get_value('slider_effect_type');
		$theme->slider_setting['slider_skin'] = $pref->get_value('slider_skin');
		$theme->slider_setting['slider_slide_delay'] = $pref->get_value('slider_slide_delay');
		$theme->slider_setting['slider_slide_loop'] = $pref->get_value('slider_slide_loop');

		$theme->page_title = "Slider Setting";
		$theme->render_file( 'slider-setting.php' );

	}else if( $_REQUEST['command'] == 'save-setting' ){
		
		foreach( $_REQUEST as $req => $val ){
			if( $req != 'command' && $req != 'PHPSESSID' && $req != 'submit' ){
				$pref->set_value( $req, $val);
			}
		}
		header("location:slider.php?command=setting");
	}else{

		$theme->rows = $slider->get_slider_images();
		if( $_REQUEST['msg']!='' ){
			$theme->msg = $msg->get_msg_arrg($_REQUEST['msg'],$_REQUEST['type']);
		}

		$theme->render_file( 'slider.php' );

	}
?>