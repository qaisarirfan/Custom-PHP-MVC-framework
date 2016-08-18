<?php 
	class Slider{
		
		private $db;
		public $table_slider = SLIDER;

		function __construct( $db ){
			$this->db = $db;
		}

		function folder_path(){
			return SITE_PATH . SLIDER_PATH;
		}

		function get_slider_image( ){
			$new_array = array();
			$query = "SELECT * FROM `$this->table_slider` WHERE `slider_status` = 'publish'";
			$result = $this->db->query( $query );
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_slider_images( ){
			$new_array = array();
			$query = "SELECT * FROM `$this->table_slider` WHERE `slider_status` != 'trash'";
			$result = $this->db->query( $query );
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}
		
		function get_slide_by_id( $id ){
			$query = "SELECT * FROM `$this->table_slider` WHERE `id` = '$id'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}
		
		function add_slider_image ( $arr, $img ){
			$array = array();
			$array['slider_picture'] = $img;
			$array['slider_title'] = check_slashes( $arr['slider_title'] );
			$array['slider_url'] = check_slashes( $arr['slider_url'] );
			$array['slider_description'] = check_slashes( $arr['slider_description'] );
			$array['slider_date'] = date("Y-m-d H:i:s",time());
			$array['slider_status'] = $arr['slider_status'];

			$result = $this->db->insert( $array, $this->table_slider );
			return $result;
		}
		
		function update_slider_images( $arr ){
			$array = array();
			$id = intval( $arr['id'] );
			$array['slider_title'] = check_slashes( $arr['slider_title'] );
			$array['slider_url'] = check_slashes( $arr['slider_url'] );
			$array['slider_description'] = check_slashes( $arr['slider_description'] );
			$array['slider_status'] = $arr['slider_status'];

			$result = $this->db->update( $array, $id, $this->table_slider );
			return $result;
		}
		
		function update_slider_pic( $img, $id ){
			$query="update `$this->table_slider` set `slider_picture` = '$img' where `id` = '$id'";
			return $this->db->query($query);
		}
	
		public function delete_slide( $id ){
			$query = "UPDATE `$this->table_slider` SET `slider_status` = 'trash' WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			return $result;
		}

	}

	$slider=new Slider( $db );
?>