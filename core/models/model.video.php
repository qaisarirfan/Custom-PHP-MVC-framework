<?php
	class Videos{
		
		public $db;
		public $table_prefix = DB_PREFIX;
		public $table_videos = 'videos';
		public $table_video_viewer = 'video_viewer';
		public $table_categories = "categories";
		public $table_sub_categories ="sub_categories";
		public $table_feed ="feed";

		var $msg;
		private $message = array(
			"add" => "Your item was add successfuly.",
			"update" => "Your item was update successfuly.",
			"delete" => "Your item was delete successfuly.",
			"error" => "some error",
			"exists" => "Your item already exists"
		);

		function __construct($db){
			$this->db=$db;
		}

		function get_error_msg(){
			return $this->msg;
		}

		private function get_youtube_video($url){
			$new_array = array();
			$url = parse_url($url, PHP_URL_QUERY);
			parse_str($url, $param);
			$new_array['provider'] = "http://www.youtube.com/";
			$new_array['thumb'] = "http://img.youtube.com/vi/$param[v]/mqdefault.jpg";
			$new_array['video'] = "http://www.youtube.com/v/$param[v]";
			return $new_array;
		}

		private function get_dailymotion_video($url){
			$new_array = array();
			$url = check_slashes($url);
			$json_content = "http://www.dailymotion.com/services/oembed?format=json&url=".$url;
			$content = file_get_contents($json_content);
			$daily_moation_data = json_decode($content,true);
			$new_array['video_provider_url'] = $daily_moation_data['provider_url'];
			$new_array['video_title'] = $daily_moation_data['title'];
			$new_array['video_author_name'] = $daily_moation_data['author_name'];
			$new_array['video_author_url'] = $daily_moation_data['author_url'];
			$new_array['video_html'] = $daily_moation_data['html'];
			$new_array['video_thumb_url'] = $daily_moation_data['thumbnail_url'];
			return $new_array;
		}

		private function get_vimeo_video($url){
			$new_array = array();
			$url = check_slashes($url);
			$json_content = "http://www.vimeo.com/api/oembed.json?url=".$url;
			$content = file_get_contents($json_content);
			$vimeo_data = json_decode($content,true);
			$new_array['video_provider_url'] = $vimeo_data['provider_url'];
			$new_array['video_title'] = addslashes($vimeo_data['title']);
			$new_array['video_author_name'] = addslashes($vimeo_data['author_name']);
			$new_array['video_author_url'] = $vimeo_data['author_url'];
			$new_array['video_html'] = $vimeo_data['html'];
			$new_array['video_thumb_url'] = $vimeo_data['thumbnail_url'];
			$new_array['video_description'] = addslashes($vimeo_data['description']);
			return $new_array;
		}

		function prepare_query( $start = 0, $limit = 0, $parma = '', $user_type = 'admin' ){
			if( $user_type == 'user' ){
				$v_table = $this->table_prefix . $this->table_videos;
				$c_table = $this->table_prefix . $this->table_categories;
				$sc_table = $this->table_prefix . $this->table_sub_categories;
				$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category WHERE `video_status` = 'publish' $parma ORDER BY `video_date` DESC";
			}
			if( $user_type == 'admin' ){
				$table = $this->table_prefix . $this->table_videos;
				$query = "SELECT * FROM `$table` $parma";
			}
			if ($limit > 0){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_posts ( $start = 0, $limit = 0, $parma = '', $user_type = 'admin' ){

			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			if( $user_type == 'user' ){
				$parma = "WHERE `video_status` = 'publish' $parma";
			}
			if( $user_type == 'admin' ){
				$parma = $parma;
			}
			$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category $parma";

			if ($limit > 0){
				$query .= " LIMIT $start , $limit";
			}
			$result = $this->db->query( $query );
			$new_array = array();
			while( $rows = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $rows;
			}
			return $new_array;
		}


		public function add_video( $array ){
			$table = $this->table_prefix . $this->table_videos;
			$new_array = array();
			$new_array['category'] = $array['category'];
			$new_array['sub_category'] = $array['sub_category'];

			$new_array['video_url'] = check_slashes( $array['video_url'] );

			/*if( $array['video_type'] == 'youtube' ){
				$video = $this->get_youtube_video( $array['url'] );
				$new_array['provider_url'] = check_slashes( $video['provider'] );
				$new_array['author_name'] = $array['author_name'];
				$new_array['author_url'] = check_slashes( $array['author_url'] );
				$new_array['video_title'] = check_slashes($array['video_title']);
				$new_array['description'] = check_slashes($array['description']);
				$new_array['v_html'] = check_slashes($video['video']);
				$new_array['thumbnail_url'] = check_slashes($video['thumb']);
			}*/

			if( $array['video_type'] == 'dailymotion' ){
				$video = $this->get_dailymotion_video ( $array['video_url'] );
				$new_array['video_provider_url'] = check_slashes( $video['video_provider_url'] );
				$new_array['video_author_name'] = check_slashes( $video['video_author_name'] );
				$new_array['video_author_url'] = check_slashes( $video['video_author_url'] );
				$new_array['video_title'] = check_slashes( $video['video_title'] );
				$new_array['video_description'] = check_slashes ($array['video_description'] );
				$new_array['video_html'] = check_slashes( $video['video_html'] );
				$new_array['video_thumb_url'] = check_slashes( $video['video_thumb_url'] );
			}

			if($array['video_type'] == 'vimeo'){
				$video = $this->get_vimeo_video($array['video_url']);
				$new_array['video_provider_url'] = check_slashes($video['video_provider_url']);
				$new_array['video_title'] = check_slashes($video['video_title']);
				$new_array['video_author_name'] = check_slashes($video['video_author_name']);
				$new_array['video_author_url'] = check_slashes($video['video_author_url']);
				$new_array['video_html'] = check_slashes($video['video_html']);
				$new_array['video_thumb_url'] = check_slashes($video['video_thumb_url']);
				$new_array['video_description'] = check_slashes($video['video_description']);
			}
			$uniqe = "-" . randCode('3');
			$new_array['video_url_str'] = $this->smart_url( trim( $new_array['video_title'] . $uniqe ) );
			$new_array['video_vd_url'] = $this->video_permalink( trim( $new_array['video_title'] . $uniqe ) );
			$new_array['video_tags'] = strtolower( str_replace(' ', ',', $array['video_tags'] ) );
			$new_array['video_type'] = $array['video_type'];
			$new_array['video_date'] = date("Y-m-d H:i:s",time());
			$new_array['video_featured'] = $array['video_featured'];
			$new_array['video_status'] = 'draft';
			
			$result = $this->db->insert( $new_array, $table );

			if($result){
				@header("location:videos.php?msg=".$this->message['add']."&type=success");
			}else{
				@header("location:videos.php?msg=".$this->message['error']."&type=error");
			}
		}

		public function update_video( $array ){

			$id = intval($array['id']);
			$table = $this->table_prefix . $this->table_videos;
			$new_array = array();
			$new_array['category'] = $array['category'];
			$new_array['sub_category'] = $array['sub_category'];

			$new_array['video_url'] = check_slashes( $array['video_url'] );

			/*if( $array['video_type'] == 'youtube' ){
				$video = $this->get_youtube_video( $array['url'] );
				$new_array['provider_url'] = check_slashes( $video['provider'] );
				$new_array['author_name'] = $array['author_name'];
				$new_array['author_url'] = check_slashes( $array['author_url'] );
				$new_array['video_title'] = check_slashes($array['video_title']);
				$new_array['description'] = check_slashes($array['description']);
				$new_array['v_html'] = check_slashes($video['video']);
				$new_array['thumbnail_url'] = check_slashes($video['thumb']);
			}*/

			if( $array['video_type'] == 'dailymotion' ){
				$video = $this->get_dailymotion_video ( $array['video_url'] );
				$new_array['video_provider_url'] = check_slashes( $video['video_provider_url'] );
				$new_array['video_author_name'] = check_slashes( $video['video_author_name'] );
				$new_array['video_author_url'] = check_slashes( $video['video_author_url'] );
				$new_array['video_description'] = check_slashes ($array['video_description'] );
				$new_array['video_html'] = check_slashes( $video['video_html'] );
				$new_array['video_thumb_url'] = check_slashes( $video['video_thumb_url'] );
			}

			if($array['video_type'] == 'vimeo'){
				$video = $this->get_vimeo_video($array['video_url']);
				$new_array['video_provider_url'] = check_slashes($video['video_provider_url']);
				$new_array['video_author_name'] = check_slashes($video['video_author_name']);
				$new_array['video_author_url'] = check_slashes($video['video_author_url']);
				$new_array['video_html'] = check_slashes($video['video_html']);
				$new_array['video_thumb_url'] = check_slashes($video['video_thumb_url']);
				$new_array['video_description'] = check_slashes($video['video_description']);
			}
			$uniqe = "-" . $id;
			$new_array['video_title'] = check_slashes( $array['video_title'] );
			$new_array['video_url_str'] = $this->smart_url( trim( $new_array['video_title'] . $uniqe ) );
			$new_array['video_vd_url'] = $this->video_permalink( trim( $new_array['video_title'] . $uniqe ) );
			$new_array['video_custom_url'] = BASE_URL."video/".$id."/".$this->smart_url( $new_array['video_title'] ).".html";
			$new_array['video_tags'] = strtolower( str_replace(' ', ',', $array['video_tags'] ) );
			$new_array['video_type'] = $array['video_type'];
			$new_array['video_modified'] = date("Y-m-d H:i:s",time());
			$new_array['video_featured'] = $array['video_featured'];
			$new_array['video_status'] = $array['video_status'];

			$result = $this->db->update( $new_array, $id, $table );
			if($result){
				@header("location:videos.php?msg=".$this->message['update']."&type=success");
			}else{
				@header("location:videos.php?msg=".$this->message['error']."&type=error");
			}
			return $result;
		}

		function delete_video( $id ){
			$table = $this->table_prefix . $this->table_videos;
			$query = "UPDATE `$table` SET `video_status` = 'trash' WHERE `id` = '$id'";
			$result = $this->db->query($query);
			if($result){
				@header("location:videos.php?msg=".$this->message['delete']."&type=success");
			}else{
				@header("location:videos.php?msg=".$this->message['error']."&type=error");
			}
		}

		function delete_permanent_video( $id ){
			$table = $this->table_prefix . $this->table_videos;
			$query = "DELETE FROM `$table` WHERE `id` = '$id'";
			$result = $this->db->query($query);
			if($result){
				@header("location:videos.php?msg=".$this->message['delete']."&type=success");
			}else{
				@header("location:videos.php?msg=".$this->message['error']."&type=error");
			}
		}


		public function get_video_by_id( $id ){
			$table = $this->table_prefix . $this->table_videos;
			$query = "SELECT * FROM `$table` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function view_video_count($id, $ip){
			$table = $this->table_prefix . $this->table_videos;
			$v_table = $this->table_prefix . $this->table_video_viewer;
			$lastday = time()-(24*60*60);
			$get_query = "delete from `$v_table` where `is_time` < '$lastday'";
			$this->db->query($get_query);

			$new_array = array();
			$check_query = "select `ip` from `$v_table` where `ip` = '$ip' and `v_id` = '$id'";
			$check_count = $this->db->count_rows_by_query($check_query);

			if( $check_count == 0 ){
				$new_array['v_id'] = $id;
				$new_array['ip'] = $ip;
				$new_array['is_time'] = time();
				$this->db->insert( $new_array, $v_table );
				$query = "update `$table` set video_view = video_view + 1 where id = '$id'";
				$result = $this->db->query($query);
				return $result;
			}
		}


		/**/
		

		private function smart_url($str) {
		    $friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false); 
		    $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
		    $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8"); 
		    $friendlyURL = preg_replace('/[^a-z0-9-]+/i', '-', $friendlyURL);
		    $friendlyURL = preg_replace('/-+/', '-', $friendlyURL);
		    $friendlyURL = trim($friendlyURL, '-');
		    $friendlyURL = strtolower($friendlyURL);
		    return $friendlyURL;
		}		

		public function video_permalink( $title ){
			$title = $this->smart_url( $title );
			$url = BASE_URL."video/".$title;
			return $url;
		}

		public function get_video_by_name ( $name ) {
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$name = trim ( $this->smart_url( $name ) );
			$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category where `video_url_str` = '$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_view_video_by_id ( $id ) {
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category where `$v_table`.`id` = '$id'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_letest_video ( $limit = '5' ) {
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category WHERE `video_status` = 'publish' ORDER BY `video_date` DESC LIMIT 0 , $limit";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_top_view_video ( $limit = '5' ){
			$table = $this->table_prefix . $this->table_videos;
			$new_array = array();
			$query = "SELECT * FROM `$table` WHERE `video_status` = 'publish' ORDER BY `video_view` DESC LIMIT 0 , $limit";
			$result = $this->db->query($query);
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_featured_video ( $limit = '4' ){
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$query = "SELECT `$v_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$v_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$v_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$v_table`.sub_category WHERE `video_status` = 'publish' AND `video_featured` = 'yes' LIMIT 0 , $limit";
			$result = $this->db->query($query);
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function related ( $id, $title, $limit = "5" ){
			
			$table = $this->table_prefix . $this->table_videos;
			
			$new_array = array();
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $title);
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			$title = str_replace("-"," ",$clean);
			$title = explode( " ", $title );
			$total_word = count( $title );
			if( $total_word >= 0 ){
				for ( $i = 0; $i < $total_word; $i++ ){
					if($i==0){
						$like = "`video_title` like '%".$title[$i]."%'";
					}else{
						$like .= " OR `video_title` like '%".$title[$i]."%'";
					}
				}
			}
			$query = "SELECT * FROM `$table` WHERE ($like) AND `id` != '$id' AND `video_status` = 'publish' GROUP BY `video_title` LIMIT 0 , $limit";
			$result = $this->db->query($query);
			if( $this->db->num_rows( $result ) ){
				while( $row = $this->db->fetch_assoc( $result ) ){
					$new_array[] = $row;
				}
			}else{
				$query = "SELECT * FROM `$table` WHERE `id` != '$id' AND `video_status` = 'publish' LIMIT 0 , $limit";
				$result = $this->db->query($query);
				while($row = $this->db->fetch_assoc($result)){
					$new_array[] = $row;
				}
			}
	
			return $new_array;
	
		}
		
		function set_video_feed(){
			
			$table_video = $this->table_prefix . $this->table_videos;
			$table_feed = $this->table_prefix . $this->table_feed;

			$lastday = time()-(24*60*60);
			$lastday = date_formate( $lastday );
			$today = date_formate(time());

			$this->db->query("DELETE FROM `$table_feed` WHERE 1 AND `is_time` = '$lastday'");
			
			$get_query = "SELECT * FROM `$table_feed` WHERE 1 AND is_time = '$today'";
			$count = $this->db->count_rows_by_query( $get_query );
			
			if( $count < 1){
				$new_array = array();
				$select = "SELECT `id` FROM `$table_video` WHERE 1 AND `video_status` = 'publish' ORDER BY rand( ) LIMIT 0 , 2";
				$select_result = $this->db->query($select);
				while ( $select_row = $this->db->fetch_assoc($select_result) ){
					$new_array['video_id'] = $select_row['id'];
					$new_array['is_time'] = $today;
					$this->db->insert( $new_array, $table_feed );
				}				
			}
			
		}

	}
	$video = new Videos($db);
?>