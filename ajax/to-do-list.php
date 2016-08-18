<?php 
	include("../../core/config.php");
	include("../../core/classes/class.db.php");
	include("../../core/classes/auth.php");
	include("../../core/classes/upload-image.php");

	include("../../core/models/class.members.php");
	include("../../core/models/class.post.php");
	include("../../core/models/class.allbum.php");
	include("../../core/models/model.task.php");
	include("../../core/models/model.movies.php");
	include("../../core/models/class.videos.php");
	include("../../core/models/model.personality.php");
	include("../../core/models/web-pages.php");
	include("../../core/functions.php");
	include("../includes/common-preferences.php");

	$m_id = intval( $_REQUEST['m_id'] );
	$id = intval( $_REQUEST['id'] );
	$task_type = intval( $_REQUEST['task_type'] );
	
	$task_type_row = $task->get_task_type_by_id( $task_type );

	$start_date = strtotime( $_REQUEST['start_date'] );
	$end_date = strtotime( $_REQUEST['end_date'] );
	$start_date = date('Y-m-d',$start_date);
	$end_date = date('Y-m-d',$end_date);

	$task_qty = intval( $_REQUEST['task_qty'] );

	if( $task_type_row['name'] == 'Post' ){
		$post_query = "select * from `$p->post_table` where `m_id` = '$m_id' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') <= '$end_date'";
		$post_result = $db->query($post_query);
		$post_count = $db->count_rows($post_result);
		if( $post_count < $task_qty ){
			$msg = $task_qty - $post_count ." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $post_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}

	if( $task_type_row['name'] == 'Album' ){
		$album_query = "select * from `$allbum->table_allbum` where `m_id` = '$m_id' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') <= '$end_date'";
		$album_result = $db->query($album_query);
		$album_count = $db->count_rows($album_result);
		if( $album_count < $task_qty ){
			$msg = $task_qty - $album_count ." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $album_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}
	if( $task_type_row['name'] == 'Movie' ){
		$movie_query = "select * from `$movies->table_movies` where `m_id` = '$m_id' and FROM_UNIXTIME(`istime`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`istime`,'%Y-%m-%d') <= '$end_date'";
		$movie_result = $db->query($movie_query);
		$movie_count = $db->count_rows($movie_result);
		if( $movie_count < $task_qty ){
			$msg = $task_qty - $movie_count." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $movie_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}
	
	if( $task_type_row['name'] == 'Video' ){
		$video_query = "select * from `$video->table` where `m_id` = '$m_id' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`created_date`,'%Y-%m-%d') <= '$end_date'";
		$video_result = $db->query($video_query);
		$video_count = $db->count_rows($video_result);
		if( $video_count < $task_qty ){
			$msg = $task_qty - $video_count." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $video_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}
	if( $task_type_row['name'] == 'Personality' ){
		$person_query = "select * from `$Person->table_personality` where `m_id` = '$m_id' and FROM_UNIXTIME(`is_create_time`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`is_create_time`,'%Y-%m-%d') <= '$end_date'";
		$person_result = $db->query($person_query);
		$person_count = $db->count_rows($person_result);
		if( $person_count < $task_qty ){
			$msg = $task_qty - $person_count ." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $person_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}
	if( $task_type_row['name'] == 'Web Page' ){
		$page_query = "select * from `$Pages->table_web_pages` where `m_id` = '$m_id' and FROM_UNIXTIME(`date`,'%Y-%m-%d') >= '$start_date' and FROM_UNIXTIME(`date`,'%Y-%m-%d') <= '$end_date'";
		$page_result = $db->query($page_query);
		$page_count = $db->count_rows($page_result);
		if( $page_count < $task_qty ){
			$msg = $task_qty - $page_count ." is remaining";
			$task_query = "update `$task->table_to_do_list` set `is_pending` = 'yes' where `id` = '$id'";
			$db->query($task_query);
		}else{
			if( $page_count >= $task_qty ){
				$task_query = "update `$task->table_to_do_list` set `is_pending` = 'no' where `id` = '$id'";
				$db->query($task_query);
				$msg = "Task Complate";
			}else{
				$msg = "record not found";
			}
		}
	}
	
	$row = $task->get_task_by_id( $id );
?>
<span class="pull-left icon">
	<?php if( $row['is_pending'] == 'no' ){ ?>
	<i class="icon-check">&nbsp;</i>
	<?php }else{ ?>
	<i class="icon-arrow-right">&nbsp;</i>
	<?php } ?>
</span>
<span class="pull-left text <?php if( $row['is_pending'] == 'no' ){ ?>green<?php } ?>"><?php echo $row['task_qty']." ".$row['task'] ?> <em class="error-msg">- <?php echo $msg; ?></em></span>
<span class="pull-right text">
	<?php //if( $row['is_pending'] == 'yes' ){ ?>
	<a href="javascript:void(0)" onClick="ajaxCheck('<?php echo $row['id'] ?>','<?php echo $row['m_id'] ?>','<?php echo $row['task_type'] ?>','<?php echo $row['task_qty'] ?>','<?php echo $row['start_date'] ?>','<?php echo $row['end_date'] ?>')">Check</a>&nbsp;|&nbsp;
	<?php //} ?>
	<a href="<?php echo ADMIN_BASE_URL ?>/to-do-list/task-detail.php?id=<?php echo $row['id'] ?>">Detail</a>
</span>
<div class="clearfix">&nbsp;</div>