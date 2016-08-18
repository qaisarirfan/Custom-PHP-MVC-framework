<?php
	include("../../core/config.php");
	include("../../core/classes/class.db.php");
	include("../../core/classes/post.php");
	
	$response = array();
	$names = $p->post_tags();
	sort($names);
	foreach ($names as $i => $name){
		$filename = str_replace(' ', '', strtolower($name));
		$response[] = array($i, $name, null, $name);
	}
	header('Content-type: application/json');
	echo json_encode($response);