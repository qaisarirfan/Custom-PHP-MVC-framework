<?php 
	include("../../core/config.php");
	include(SITE_PATH."/core/classes/auth.php");
	include(SITE_PATH."/core/classes/class.db.php");
	include(SITE_PATH."/core/classes/class.msg.php");
	include(SITE_PATH."/core/classes/paging.php");

	include(SITE_PATH."/core/models/class.members.php");
	include(SITE_PATH."/core/models/model.personality.php");
	include(SITE_PATH."/core/models/model.preferences.php");
	include(SITE_PATH."/core/functions.php");

	include(SITE_PATH."/admin/includes/common-preferences.php");
	
	require(SITE_PATH."/resources/php/facebook/src/facebook.php");

	$id = intval( $_REQUEST['id'] );

	$person_row = $Person->get_person_id( $id );

	$facebook = new Facebook(array(
		'appId'  => '389867437807483',
		'secret' => '31c0acf575168e549843e1642000f0f2',
		'cookie' => true
	));

	$user = $facebook->getUser();

	if($user) {
		if( session_id() ){
			
		}else{
			session_start();	
		}

		$access_token = $facebook->getAccessToken();
		
		$permissions_list = $facebook->api(
			'/me/permissions',
			'GET',
			array(
				'access_token' => $access_token
			)
		);
		$permissions_needed = array('publish_stream');

		foreach($permissions_needed as $perm) {
			if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 ) {
				$login_url_params = array(
					'scope' => 'publish_stream',
					'fbconnect' =>  1,
					'display'   =>  "page",
					'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
				);
				$login_url = $facebook->getLoginUrl($login_url_params);
				header("Location: {$login_url}");
				exit();
			}
		}

		$accounts = $facebook->api(
			'/me/accounts',
			'GET',
			array(
				'access_token' => $access_token
			)
		);
		print_r($accounts);
		die();
		$_SESSION['access_token'] = $access_token;
		$_SESSION['accounts'] = $accounts['data'];
		$_SESSION['active'] = $accounts['data'][1];

	} else {

		$login_url_params = array(
			'scope' => 'publish_stream',
			'fbconnect' =>  1,
			'display'   =>  "page",
			'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
		);
		$login_url = $facebook->getLoginUrl($login_url_params);
		header("Location: {$login_url}");
		exit();
	}

	$parameters = array(
		'message' => '',
		'picture' => VIEW_BASE_URL.'/'.PERSON_PATH.'thumb-'.$person_row['img_thumb'],
		'link' => $person_row['url'],
		'name' => $person_row['name'],
		'caption' => $person_row['description'],
		'description' => $person_row['detail']
	);

	$parameters['access_token'] = $_SESSION['active']['access_token'];

	$newpost = $facebook->api(
		'/me/posts',
		'POST',
		$parameters
	);

?>