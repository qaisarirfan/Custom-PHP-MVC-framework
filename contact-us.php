<?php
	session_start();

	include( "core/config.php" );
	include( "core/classes/class.db.php" );
	include( "core/classes/class.themes.php" );

	include( "core/PHPMailer-master/PHPMailerAutoload.php" );

	include( "core/models/model.category.php" );
	include( "core/models/model.video.php" );
	include( "core/models/model.preferences.php" );
	include( "core/models/model.pages.php" );

	include( "core/functions/functions.php" );

	include( "webstats/stat-counter.php" );
	
	$theme = new Themes( 'default-theme' );
	$theme->theme_dir = 'themes';
	$theme->theme_site_dir = 'contact-us';

	$theme->page_title = "Contact Us";

	$theme->blog_setting = array();

	$theme->blog_setting['blog_show'] = $pref->get_value('blog_show');
	$theme->blog_setting['blog_per_page_post'] = $pref->get_value('blog_per_page_post');
	$theme->blog_setting['blog_top_view_post'] = $pref->get_value('blog_top_view_post');
	$theme->blog_setting['blog_latest_post'] = $pref->get_value('blog_latest_post');
	$theme->blog_setting['blog_related_post'] = $pref->get_value('blog_related_post');
	$theme->blog_setting['blog_page_name'] = $pref->get_value('blog_page_name');
	$theme->blog_setting['blog_keywords'] = $pref->get_value('blog_keywords');
	$theme->blog_setting['blog_description'] = $pref->get_value('blog_description');

	$theme->video_setting = array();

	$theme->video_setting['video_show'] = $pref->get_value('video_show');
	$theme->video_setting['video_per_page_post'] = $pref->get_value('video_per_page_post');
	$theme->video_setting['video_top_view_post'] = $pref->get_value('video_top_view_post');
	$theme->video_setting['video_latest_post'] = $pref->get_value('video_latest_post');
	$theme->video_setting['video_related_post'] = $pref->get_value('video_related_post');
	$theme->video_setting['video_page_name'] = $pref->get_value('video_page_name') ? $pref->get_value('video_page_name') : "Videos";
	$theme->video_setting['video_keywords'] = $pref->get_value('video_keywords');
	$theme->video_setting['video_description'] = $pref->get_value('video_description');

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
	$theme->preferences['body_background'] = stripcslashes( $pref->get_value('body_background') );

	$theme->blog_menu = $cate->get_category_list( 'blog','post' );
	$theme->video_menu = $cate->get_menu_category_list();
	//$theme->video_menu = $cate->get_category_list( 'video','video' );
	$theme->top_view_video = $video->get_top_view_video( $theme->video_setting['video_top_view_post'] );
	$theme->header_page = $page->get_header_pages();
	$theme->footer_page = $page->get_footer_pages();

	$theme->captcha = "resources/php/captcha/captcha.php";
	
	if( $_REQUEST['command']=='send-mail' ){

		if ( $_SESSION['captcha'] != trim( $_REQUEST['captcha_text'] ) ){
			$theme->msg = "Please Enter Valid Captcha Code";
			$theme->render_file( 'index.php' );

		}else{

			$name = stripslashes( $_REQUEST['name'] );
			$phoneno = stripslashes( $_REQUEST['phoneno'] );
			$email = stripslashes( $_REQUEST['email'] );
			$subject = stripslashes( $_REQUEST['subject'] );
			$message = stripslashes( $_REQUEST['message'] );
			$html_message = '<div>';
				if($phoneno){
					$html_message .= '<div style="padding:0 0 12px 0; font-weight:bold">Phone Number : '. $phoneno . '</div>';
				}
				$html_message .= '<div>'. $message .'</div>';
			$html_message .= '</div>';

			$mail = new PHPMailer;
		
			$mail->isSMTP();
			$mail->Host = 'mail.girlvalue.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'support@qadristudio.com';
			$mail->Password = 'tTK#pg{lAoxE';
			$mail->SMTPSecure = 'tls';
			
			$mail->From = $email;
			$mail->FromName = $name;
			$mail->addAddress('support@qadristudio.com');
			$mail->addReplyTo($email);
			
			$mail->WordWrap = 250;
			$mail->isHTML(true);
			
			$mail->Subject = $subject;
			$mail->Body = $html_message;
			$mail->AltBody = $message;
			
			if( !$mail->send() ) {
				$theme->msg = 'Message could not be sent.';
				$theme->render_file( 'index.php' );
			}else{
			   header("location:contact-us?msg=Message has been sent");
			}

		}
	}else{
		$theme->render_file( 'index.php' );
	}
?>