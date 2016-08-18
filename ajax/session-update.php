<?php

	ini_set( 'max_execution_time', time()+3600*24*7 );

	include("../core/config.php");
	include("../core/classes/class.db.php");
	require '../core/UASparser/UASparser.php';

	include("../core/models/model-today-webstats.php");
	include("../core/models/model.webstats.php");

	$parser = new UASparser();
	$parser->SetCacheDir(getcwd()."/core/UASparser/cache/");
	
	$time = $_REQUEST['time'];

	$query = "SELECT * FROM `".STATS_SESSIONS."` WHERE `country` = '' AND FROM_UNIXTIME(`time`,'%d-%m-%Y') = '$time'";
	$q_result = $db->query($query);
	$count = $db->count_rows( $q_result );
	if( $count ){
		while ( $q_row = $db->fetch_assoc($q_result) ){
			$new_array = array();

			$url = "http://api.ipinfodb.com/v3/ip-city/?key=448df4a44b79199c4fb05b5f8db345a9b06dc121b887816d7c0a346c4280fa1c&ip=$q_row[ip]&format=json";
			$json = file_get_contents($url);
			$data = json_decode( $json, true );
			$new_array['country'] = addslashes( $data['countryCode'] );
			$new_array['country_name'] = addslashes( $data['countryName'] );
			$new_array['region_name'] = addslashes( $data['regionName'] );
			$new_array['city_name'] = addslashes( $data['cityName'] );

			$ret = $parser->Parse( $q_row['user_agent'] );
			$new_array['os'] = addslashes( $ret['os_name'] );
			$new_array['wb'] = addslashes( $ret['ua_name'] );
			$new_array['is_bot'] = $ret['typ'];

			$db->update_custom_field( STATS_SESSIONS, 'serial', $new_array, $q_row['serial'] );
		}
	}
?>