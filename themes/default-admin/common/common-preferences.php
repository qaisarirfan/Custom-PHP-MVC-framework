<?php
	$db->get_error();
	if(!$auth->authenticate()){
		@header( "location:index.php" );
		exit();
	}
	/**/
	$adminid = intval($auth->get_userid());
	$admin_type = $auth->get_type();
	/**/
	$result = $member->get_row('admin',$adminid);
	/**/
	$permission = $member->check_permission($admin_type,$adminid);
	/**/
	$page_url = basename($_SERVER['SCRIPT_FILENAME']);
	$page_name = pathinfo($page_url);
	$page_name = str_replace('-',' ',$page_name['filename']);
	/**/
?>