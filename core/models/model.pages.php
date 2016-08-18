<?php
	class Pages{
		
		private $db;
		private $msg;
		public $table_pages = PAGES;
		public $table_page_viewer = PAGE_VIEWER;

		function __construct( $db ){
			$this->db = $db;
		}
		
		public function get_error_msg(){
			return $this->msg;
		}

		function prepare_query( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			$query = "SELECT * FROM `$this->table_pages`";
			if( $user_type == 'user' ){
				$query .= " WHERE `page_status` != 'publish'";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `page_status` != 'trash'";
			}
			$query .= " ORDER BY `page_date`  DESC";
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_posts ( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			$query = "SELECT * FROM `$this->table_pages`";
			if( $user_type == 'user' ){
				$query .= " WHERE `page_status` != 'publish'";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `page_status` != 'trash'";
			}
			$query .= " ORDER BY `page_date`  DESC";
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

		
		public function add_page( $arr ){
			$new_array = array();
			$new_array['page_name'] = check_slashes( $arr['page_name'] );
			$new_array['page_description'] = check_slashes( $arr['page_description'] );
			$new_array['page_keywords'] = check_slashes( $arr['page_keywords'] );
			$new_array['page_text'] = check_slashes( $arr['page_text'] );
			$new_array['page_section'] = $arr['page_section'];
			$new_array['page_date'] = date("Y-m-d H:i:s",time());
			$new_array['page_url_str'] = $this->smart_url( trim( $new_array['page_name'] ) );
			$new_array['page_url'] = $this->page_permalink( trim( $new_array['page_name'] ) );
			$new_array['page_status'] = $arr['page_status'];

			$result = $this->db->insert( $new_array, $this->table_pages );
			if( $result ){
				header('location:pages.php?msg=Page add successfully&type=success');
			}else{
				header('location:pages.php?msg=Error to add paage successfully&type=error');
			}
		}
		
		public function update_page( $arr ){
			$id = $arr['id'];
			$new_array = array();
			$new_array['page_name'] = check_slashes( $arr['page_name'] );
			$new_array['page_description'] = check_slashes( $arr['page_description'] );
			$new_array['page_keywords'] = check_slashes( $arr['page_keywords'] );
			$new_array['page_text'] = check_slashes( $arr['page_text'] );
			$new_array['page_section'] = $arr['page_section'];
			$new_array['page_url_str'] = $this->smart_url( trim( $new_array['page_name'] ) );
			$new_array['page_url'] = $this->page_permalink( trim( $new_array['page_name'] ) );
			$new_array['page_status'] = $arr['page_status'];

			$result = $this->db->update( $new_array, $id, $this->table_pages );
			if( $result ){
				header('location:pages.php?msg=Page update successfully&type=success');
			}else{
				header('location:pages.php?msg=Error to update paage successfully&type=error');
			}

		}

		function del_page($id){
			$query = "UPDATE `$this->table_pages` SET `page_status` = 'trash' WHERE `id` ='$id'";
			$result=$this->db->query($query);
			if($result){
				header('location:pages.php?msg=Page successfully delete&type=success');
			}else{
				header('location:pages.php?msg=Error to delete page successfully&type=error');
			}
		}

		public function get_footer_pages(){
			$query="SELECT * FROM `$this->table_pages` WHERE `page_status` = 'publish' AND (`page_section` = 'footer' OR `page_section` = 'both')";
			$result=$this->db->query($query);
			$arr=array();
			while($row=$this->db->fetch_array($result)){
				$arr[]=$row;
			}
			return $arr;
		}
		function get_header_pages(){
			$query="SELECT * FROM `$this->table_pages` WHERE `page_status` = 'publish' AND (`page_section` = 'header' OR `page_section` = 'both')";
			$result=$this->db->query($query);
			$arr=array();
			while($row=$this->db->fetch_array($result)){
				$arr[]=$row;
			}
			return $arr;
		}

		function get_row_by_id( $id ){
			$query = "SELECT * FROM `$this->table_pages` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		function get_row_by_url( $url ){
			$query = "SELECT * FROM `$this->table_pages` WHERE `page_url_str` = '$url'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		private function smart_url($str) {
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			return $clean;
		}		
		private function page_permalink( $name ){
			$name=$this->smart_url( $name );
			$url = BASE_URL . "page/" . $name;
			return $url;
		}

		function view_page_count($id, $ip){
			$lastday = time()-(24*60*60); 
			$get_query = "delete from $this->table_page_viewer where `is_time` < '$lastday'";
			$this->db->query($get_query);

			$new_array = array();
			$check_query = "select `ip` from `$this->table_page_viewer` where `ip` = '$ip' and `page_id` = '$id'";
			$check_count = $this->db->count_rows_by_query($check_query);

			if( $check_count == 0 ){
				$new_array['page_id'] = $id;
				$new_array['ip'] = $ip;
				$new_array['is_time'] = time();
				$this->db->insert( $new_array, $this->table_page_viewer );
				$query = "update $this->table_pages set page_view = page_view + 1 where id = '$id'";
				return $this->db->query($query);
			}

		}


	}
	$page = new Pages( $db );
?>