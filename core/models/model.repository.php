<?php
	class FileRepository{

		public $db;
		public $table_prefix = DB_PREFIX;
		public $allowed_extensions = array ('txt','jpg','png','jpeg','pdf');
		public $table_file_repository = 'file_repository';
		public $return_msg;
		public $messages = array(
			'file' => array(
				'ext' => 'Your file is not a valid.&type=error',
				'size' => 'Your file size it too big.&type=error',
				'error_upload' => 'Your file is not upload properly.&type=success',
				'active_fail' => 'Your background is not set please try again.&type=error',
				'del' => 'Your File Deleted.&type=success'
			),
			'save' => array(
				'add' => 'Your file is successfuly add.&type=success'
			)
			
		);

		function __construct($db){
			$this->db=$db;
		}
		function return_msg(){
			return $this->return_msg;
		}
		function folder_path(){
			return SITE_PATH.'/site-content/file-repository/';
		}

		function prepare_query( $start = 0, $limit = 0, $parma = '', $user_type = 'admin' ){
			$table = $this->table_prefix . $this->table_file_repository;
			$query = "SELECT * FROM `$table` ORDER BY `upload_date` DESC";
			if ($limit > 0){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_row ( $start = 0, $limit = 0, $parma = '', $user_type = 'admin' ){
			$table = $this->table_prefix . $this->table_file_repository;
			$query = "SELECT * FROM `$table` ORDER BY `upload_date` DESC";
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


		function add_file( $array, $file ){
			$table = $this->table_prefix . $this->table_file_repository;
			$type = false;
			$size = false;
			$arr = array();
			$file_name = $file['file_name'];
			if ( $this->check_file_type( $file_name ) ){
				$type = true;
			}else{
				$type = false;
				$this->return_msg = $this->messages['file']['ext'];
			}
			if( $this->check_file_size( $file_name ) ){
				$size = true;
			}else{
				$size = false;
				$this->return_msg = $this->messages['file']['size'];
			}

			$default_name = $file['name'];
			$nDn = pathinfo($default_name);
			$default_name = $this->smart_url($nDn['filename']).'.'.$nDn['extension'];

			if( $type == true and $size == true ){
				if ( move_uploaded_file( $file_name['tmp_name'], $this->folder_path() . $file_name['name'] ) ){

					$img_info = pathinfo( $this->folder_path() . $file_name['name'] );
					$name = $this->smart_url($array['file_title']).".".$img_info['extension'];
					rename( $this->folder_path() . $file_name['name'], $this->folder_path() . $name );

					$arr['file_name'] = $name;
					$arr['file_title'] = $array['file_title'];
					$arr['type'] = $array['file_type'];
					$arr['url'] = BASE_URL . FILE_REPOSITORY . $name;
					$arr['upload_date'] = time();
					$arr['is_show'] = $array['is_show'];

					if( $this->db->insert ( $arr, $table ) ){
						header("location:repository.php?msg=".$this->messages['save']['add']);
					}
				}
			}else{
				$this->return_msg = $this->messages['file']['error_upload'];
			}
		}

		function check_file_type( $file ){
			$name = pathinfo ( $file['name'] );
			$extension = strtolower($name['extension']);
			if( in_array( $extension, $this->allowed_extensions ) ){
				return true;
			}else{
				return false;
			}
		}

		function check_file_size( $file ){
			$size = round ($file ['size'] / 1024, 2);
			if( $size <= 3072 ){
				return true;
			}else{
				return false;
			}
		}

		function display_filesize( $filesize ){
			if(is_numeric($filesize)){
				$decr = 1024; 
				$step = 0;
				$prefix = array('Byte','KB','MB','GB','TB','PB');
				while(($filesize / $decr) > 0.9){
					$filesize = $filesize / $decr;
					$step++;
				}
				return round($filesize,2).' '.$prefix[$step];
			}else{
				return 'NaN';
			}
		}

		function delete_file( $arr ){
			$table = $this->table_prefix . $this->table_file_repository;
			$query = "delete from `$table` where id = '$arr[id]'";
			if ( unlink ( $this->folder_path() . $arr['file'] ) ){
				$this->db->query( $query );
				header("location:repository.php?msg=".$this->messages['file']['del']);
			}else{
				header("location:repository.php");
			}
		}


		private function smart_url($str) {
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			return $clean;
		}		

	}

	$FR = new FileRepository( $db );
?>