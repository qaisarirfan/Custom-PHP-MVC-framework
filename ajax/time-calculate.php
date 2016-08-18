<?php

	$ptime=$_REQUEST['time'];
	function time_calculate($ptime){
		$now=time();
		$differ=$now-$ptime;
		
		if($differ<=60){
			return $differ." Second(s) ago";
		}elseif($differ<=3600){
			return round($differ/(60))." Minute(s) ago";
		}elseif($differ<=86400){
			$differ=round($differ/(3600));
			return $differ." Hour(s) ago";
			
		}elseif($differ<=2592000){
			$differ=round($differ/(86400));
			return $differ." Day(s) ago";
		}elseif($differ<=2592000){
			$differ=round($differ/(86400));
			return $differ." Month(s) ago";
		}else{
			$differ=round($differ/(31104000));
			return $differ." Year(s) ago";
		}

	}
	echo time_calculate($ptime);
	
	function getMyTimeDiff($t1,$t2){
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
		$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
		$diff = abs($time1-$time2);
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		$secs = floor(($diff-(($hours*60*60)+($mins*60))));
		$result = $hours.":".$mins.":".$secs;
		return $result;
	}
	$mytime1 = "09:00:00";
	$mytime2 = "09:25:00";
	$cool = getMyTimeDiff($mytime1,$mytime2);
	

?>
