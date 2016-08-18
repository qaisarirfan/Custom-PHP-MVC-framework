<?php
	function randCode( $limit = '5' ){
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$length = strlen($alphabet);
		$code = array();
		for($i = 0; $i <= $limit; $i++){
			$rand = rand( 0, $length );
			$code[] = $alphabet[$rand];
		}
		return implode( $code );
	}

	function check_slashes( $str ){
		$str = preg_replace( '/\s\s+/', ' ', $str );
		$str = preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', "\n", $str));
		$str = rtrim( $str );
		if(!get_magic_quotes_gpc()){
			return addslashes($str);
		}else{
			return $str;
		}
	}

	function date_formate( $date, $formate = "short" ){
		if( $formate == "full"){
			$date = date( "l, F j, Y", $date );
		}elseif( $formate == "short" ){
			$date = date( "d-m-Y", $date );
		}elseif( $formate == "fdt" ){
			$date = date( "F-j-Y, g:i a", $date );
		}elseif( $formate == "sdt" ){
			$date = date( "d-m-Y, g:i a", $date );
		}
		return $date;
	}

	function breadcrumb( $separator = ' &raquo; ', $home = 'Home' ){
		$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
		$base_url = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
		$breadcrumbs = array('<a href="'.$base_url.'">'.$home.'</a>');
		$last = end(array_keys($path));
		foreach ($path as $x => $crumb) {
		   $title = ucwords(str_replace(array('.php', '_','-'), Array('', ' ',' '), $crumb));
		   if ($x != $last){
			  $breadcrumbs[] = '<a href="'.$base_url.$crumb.'">'.$title.'</a>';
		   }else{
			  $breadcrumbs[] = $title;
		   }
		}
		return implode($separator, $breadcrumbs);
	}
	
	function check_empty($str){
		if($str==''){
			$return = "n/a";
		}else{
			$return = $str;
		}
		return $return;
	}
	
	function smart_url($str) {
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", ' ', $clean);
		return $clean;
	}		

	function trimStr( $str, $limit ){
		if( strlen( $str ) >= $limit ){
			$result = strip_tags( stripcslashes( substr( $str, 0, $limit ) ) ) . ' &hellip;';
		}else{
			$result = strip_tags( stripcslashes( $str ) );
		}
		return $result;
	}

	function stripc_slashes($str){
		$result=stripcslashes($str);
		return $result;
	}

	function time_calculate($ptime){
		$now=time();
		$differ=$now-$ptime;
		
		if($differ<=60){
			return $differ." Second(s) ago";
		}elseif($differ<=3600){
			return floor($differ/(60))." Minute(s) ago";
		}elseif($differ<=86400){
			$differ=floor($differ/(3600));
			return $differ." Hour(s) ago";
		}elseif($differ<=2592000){
			$differ=floor($differ/(86400));
			return $differ." Day(s) ago";
		}else{
			$differ=floor($differ/(2592000));
			return $differ." Month(s) ago";
		}
	}	
?>