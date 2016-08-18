<?php
	class Blog{
		private $db;
		public $msg;
		public $table_prefix = DB_PREFIX;
		public $table_posts = "posts";
		public $table_categories = "categories";
		public $table_sub_categories ="sub_categories";
		public $table_post_viewer = 'post_viewer';
		
		function __construct($db){
			$this->db=$db;
		}

		/*------------------Post Categories------------------------*/

		function folder_path(){
			return SITE_PATH . POST_PIC;
		}

		
		function get_error_msg(){
			return $this->msg;
		}

		function get_post( ){
			$table = $this->table_prefix . $this->table_posts;
			$query = "select * from `$table`";
			$result = $this->db->query( $query );
			return $result;
		}
		
		function get_post_id( $id ){
			$table = $this->table_prefix . $this->table_posts;
			$query = "select * from `$table` where `id` = '$id'";
			$result = $this->db->fetch_assoc_by_query( $query );
			return $result;
		}
		
		function delete_post( $id ){
			$table = $this->table_prefix . $this->table_posts;
			$query = "delete from `$table` where id='$id'";
			$name = $this->get_post_id( $id );
			unlink( SITE_PATH.POST_PIC . $name['post_thumb'] );
			unlink( SITE_PATH.POST_PIC . "thumb-" . $name['post_thumb'] );
			unlink( SITE_PATH.POST_PIC . "small-" . $name['post_thumb'] );
			unlink( SITE_PATH.POST_PIC . "medium-" . $name['post_thumb'] );
			$result = $this->db->query($query);
			return $result;
		}
		
		function prepare_query( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			if( $user_type == 'user' ){
				$p_table = $this->table_prefix . $this->table_posts;
				$c_table = $this->table_prefix . $this->table_categories;
				$sc_table = $this->table_prefix . $this->table_sub_categories;
				$query = "SELECT `$p_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$p_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$p_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$p_table`.sub_category WHERE `post_status` = 'publish' $parma ORDER BY `post_date` DESC";
			}
			if( $user_type == 'admin' ){
				$table = $this->table_prefix . $this->table_posts;
				$query = "SELECT * FROM `$table` ORDER BY `post_date` DESC";
			}
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_posts ( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			if( $user_type == 'user' ){
				$p_table = $this->table_prefix . $this->table_posts;
				$c_table = $this->table_prefix . $this->table_categories;
				$sc_table = $this->table_prefix . $this->table_sub_categories;
				$query = "SELECT `$p_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$p_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$p_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$p_table`.sub_category WHERE `post_status` = 'publish' $parma ORDER BY `post_date` DESC";
			}
			if( $user_type == 'admin' ){
				$table = $this->table_prefix . $this->table_posts;
				$query = "SELECT * FROM `$table` ORDER BY `post_date` DESC";
			}
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			$result = $this->db->query( $query );
			$new_array = array();
			while( $rows = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $rows;
			}
			return $new_array;
		}

		function view_post_count($id, $ip){
			$p_table = $this->table_prefix . $this->table_posts;
			$v_table = $this->table_prefix . $this->table_post_viewer;
			$lastday = time() - ( 24 * 60 * 60 );
			$get_query = "delete from `$v_table` where `is_time` < '$lastday'";
			$this->db->query($get_query);

			$new_array = array();
			$check_query = "select `ip` from `$v_table` where `ip` = '$ip' and `post_id` = '$id'";
			$check_count = $this->db->count_rows_by_query( $check_query );

			if( $check_count == 0 ){
				$new_array['post_id'] = $id;
				$new_array['ip'] = $ip;
				$new_array['is_time'] = time();
				$this->db->insert( $new_array, $v_table );
				$query = "update `$p_table` set post_view = post_view + 1 where `id` = '$id'";
				return $this->db->query( $query );
			}
		}

		public function add_post( $arr, $thumb ){
			$table = $this->table_prefix . $this->table_posts;
			$new_array = array();
			$title = check_slashes( trim ( $arr['post_title'] ) );
			$new_array['category'] = intval( $arr['category'] );
			$new_array['sub_category'] = intval( $arr['sub_category'] );
			$new_array['post_thumb'] = $thumb;
			$new_array['post_content'] = check_slashes( $arr['post_content'] );
			$new_array['post_title'] = $title;
			$new_array['post_keywords'] = check_slashes ($arr['post_keywords'] );
			$new_array['post_description'] = check_slashes( $arr['post_description'] );
			$new_array['post_tags'] = check_slashes( strtolower( str_replace(' ', '', $arr['post_tags'] ) ) );
			$uniqe = "-" . randCode('3');
			$new_array['post_url_str'] = $this->smart_url( $title . $uniqe );
			$new_array['post_url'] = $this->post_permalink( $title . $uniqe );
			$new_array['post_date'] = date("Y-m-d H:i:s",time());
			$new_array['post_status'] = $arr['post_status'];
			$new_array['post_featured'] = $arr['post_featured'];
			$result = $this->db->insert( $new_array, $table );
			return $result;
		}
		
		public function update_post( $arr, $thumb ){
			$table = $this->table_prefix . $this->table_posts;
			$id = intval( $arr['postid'] );
			$new_array = array();
			$new_array['category'] = intval( $arr['category'] );
			$new_array['sub_category'] = intval( $arr['sub_category'] );
			$new_array['post_thumb'] = $thumb;
			$new_array['post_content'] = check_slashes( $arr['post_content'] );
			$new_array['post_title'] = check_slashes( trim ( $arr['post_title'] ) );
			$new_array['post_keywords'] = check_slashes ($arr['post_keywords'] );
			$new_array['post_description'] = check_slashes( $arr['post_description'] );
			$new_array['post_tags'] = check_slashes( strtolower( str_replace(' ', '', $arr['post_tags'] ) ) );
			$uniqe = "-" . randCode('3');
			$new_array['post_url_str'] = $this->smart_url( trim ( $arr['post_title'] . $uniqe ) );
			$new_array['post_url'] = $this->post_permalink( trim ( $arr['post_title'] . $uniqe ) );
			$new_array['post_date'] = date("Y-m-d H:i:s",time());
			$new_array['post_modified'] = date("Y-m-d H:i:s",time());
			$new_array['post_status'] = $arr['post_status'];
			$new_array['post_featured'] = $arr['post_featured'];
			$result = $this->db->update( $new_array, $id, $table );
			return $result;
		}

		public function get_post_by_id( $id ){
			$table = $this->table_prefix . $this->table_posts;
			$query = "select * from `$table` where `id` = '$id'";
			$result = $this->db->fetch_assoc_by_query( $query );
			return $result;
		}

		function get_letest_post ( $limit = '5' ){
			$p_table = $this->table_prefix . $this->table_posts;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$new_array = array();
			$query = "SELECT `$p_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$p_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$p_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$p_table`.sub_category WHERE `post_status` = 'publish' ORDER BY `post_date` DESC LIMIT 0 , $limit";
			$result = $this->db->query($query);
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_top_view_post ( $limit = '5' ){
			$table = $this->table_prefix . $this->table_posts;
			$new_array = array();
			$query = "SELECT * FROM `$table` ORDER BY `post_view` DESC LIMIT 0 , $limit";
			$result = $this->db->query($query);
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_tags_list (){
			$table = $this->table_prefix . $this->table_posts;
			$query = "select `id`, `post_tags` from `$table` where `post_status` = 'publish'";
			$result = $this->db->query( $query );
			$tag_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				if( $row['post_tags'] != '' && $row['post_tags'] != ' ' ){
					$tags = explode( ',', $row['post_tags'] );
					foreach($tags as $tag){
						$flag = 'false';
						foreach( $tag_array as $key => $val ){
							if( $tag == $key ){
								$flag = 'true';
							}
						}
						if( $flag == 'false' ){
							$query_count = "select count(*) as total from `$table` where instr(concat(',',post_tags,','),',$tag,')>0";
							$result_count = $this->db->query( $query_count );
							$row_count = $this->db->fetch_array( $result_count );
							if( in_array( $tag, $tag_array ) ){
								$tag_array[ $tag ] = $row_count['total'];
							}else{
								$tag_array[ $tag ] += $row_count['total'];
							}
						}
					}
				}
			}
			return $tag_array;
		}


		public function get_post_by_name ( $name ) {
			$name = $this->smart_url( trim ( $name ) );
			$p_table = $this->table_prefix . $this->table_posts;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$query = "SELECT `$p_table`.*, `$c_table`.id as c_id, `$c_table`.name as c_name, `$c_table`.url as c_url, `$sc_table`.id as sc_id, `$sc_table`.categories_id as sc_parent, `$sc_table`.name as sc_name, `$sc_table`.url as sc_url FROM `$p_table` LEFT JOIN `$c_table` ON `$c_table`.id = `$p_table`.category LEFT JOIN `$sc_table` ON `$sc_table`.id = `$p_table`.sub_category WHERE `post_url_str` = '$name'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		function related ( $id, $title, $limit = "5" ){
			
			$table = $this->table_prefix . $this->table_posts;
			
			$new_array = array();
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $title);
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			$title = str_replace("-"," ",$clean);
			$title = explode( " ", $title );
			$total_word = count( $title );
			if( $total_word >= 0 ){
				for ( $i = 0; $i < $total_word; $i++ ){
					if($i==0){
						$like = "`post_title` like '%".$title[$i]."%'";
					}else{
						$like .= " OR `post_title` like '%".$title[$i]."%'";
					}
				}
			}
			$query = "SELECT * FROM `$table` WHERE ($like) AND `id` != '$id' AND `post_status` = 'publish' GROUP BY `post_title` LIMIT 0 , $limit";
			$result = $this->db->query($query);
			if( $this->db->num_rows( $result ) ){
				while( $row = $this->db->fetch_assoc( $result ) ){
					$new_array[] = $row;
				}
			}else{
				$query = "SELECT * FROM `$table` WHERE `id` != '$id' AND `post_status` = 'publish' LIMIT 0 , $limit";
				$result = $this->db->query($query);
				while($row = $this->db->fetch_assoc($result)){
					$new_array[] = $row;
				}
			}
	
			return $new_array;
	
		}

		private function smart_url($str) {
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			return $clean;
		}		

		private function post_permalink( $title ){
			$title = $this->smart_url( $title );
			$url = BASE_URL . "blog/" . $title;
			return $url;
		}

	}
	$blog= new Blog($db);
?>