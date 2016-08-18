<?php
	class Preferences{

		var $db;
		var $table_custom_backgrounds = CUSTOM_BACKGROUND;
		var $table_preferences = PREFERENCES;
		var $messages = array(
			'custom_backgrounds' => array(
				'add' => 'Your background is successfully saved.&type=success',
				'add_fail' => 'Your background is not saved please try again.&type=error',
				'active' => 'Your background is successfully set.&type=success',
				'active_fail' => 'Your background is not set please try again.&type=error'
			)
		);

		function __construct( $db ){
			$this->db = $db;
		}

		function get_value( $field ){
			$query = "select `value` from `$this->table_preferences` where `name` = '$field'";
			$result = $this->db->query( $query );
			$value = $this->db->fetch_assoc( $result );
			return $value['value'];
		}

		function get_same_value( $field ){
			$new_array = array();
			$query = "select * from `$this->table_preferences` where `name` LIKE '%$field%'";
			$result = $this->db->query( $query );
			while( $value = $this->db->fetch_assoc( $result )){
				$new_array[] = $value;
			}
			return $new_array;
		}

		function check_field_exists( $field ){
			$query="select count(*) as total from `$this->table_preferences` where `name` = '$field'";
			$result = $this->db->query( $query );
			$value = $this->db->fetch_assoc( $result );
			return $value['total'];
		}

		function set_value( $field, $value ){
			if( $this->check_field_exists( $field ) != 0 ){
				$query="UPDATE `$this->table_preferences` SET `value` = '$value' WHERE `name` = '$field'";
			}else{
				$query="INSERT INTO `$this->table_preferences` (name,value) VALUES ('$field','$value')";
			}
			$result = $this->db->query( $query );
			return $result;
		}

		public function add_background( $arr, $image_name ){

			$array = array();
			$position = $arr['position_x']. ' ' .$arr['position_y'];
			$array['backgrounds_color'] = '#'.$arr['backgrounds_color'];
			$array['backgrounds_image'] = $image_name;
			$array['background_position'] = $position;
			$array['background_repeat'] = $arr['background_repeat'];
			$array['background_attachment'] = $arr['background_attachment'];
			$array['backgrounds_date'] = date("Y-m-d H:i:s",time());
			$array['locked'] = $arr['locked'];
			
			$result = $this->db->insert ( $array, $this->table_custom_backgrounds );

			if( $result ){
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['add'] );
			}else{
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['add_fail'] );
			}

		}

		public function edit_background( $arr, $id, $image_name ){

			$array = array();
			$position = $arr['position_x']. ' ' .$arr['position_y'];
			$array['backgrounds_color'] = '#'.$arr['backgrounds_color'];
			if($image_name != ''){
				$array['backgrounds_image'] = $image_name;
			}
			$array['background_position'] = $position;
			$array['background_repeat'] = $arr['background_repeat'];
			$array['background_attachment'] = $arr['background_attachment'];
			$array['locked'] = $arr['locked'];
			$result = $this->db->update ( $array, $id, $this->table_custom_backgrounds );

			if( $result ){
				$this->background();
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['update'] );
			}else{
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['update_fail'] );
			}

		}
	
		public function background (){
			$background = $this->db->get_row ( $this->table_custom_backgrounds, 'active', 'yes' );
			$path = SITE_PATH.CUSTOM_BACKGROUND_DIR.'css/custom-css.css';
			if( file_exists( $path ) ){
				unlink($path);
			}
			$css = fopen($path,'a+');
			if($css){
				$write = "body { background:url('".BASE_URL."site-content/custom-background/".$background['backgrounds_image']."') ".$background['background_repeat']." ".$background['background_position']." ".$background['background_attachment']." ".$background['backgrounds_color']." } ";
				fputs($css,$write);
			}
			fclose($css);
		}

		public function get_background ( $start = 0, $total = 0, $locked, $order ){
			$return = $this->db->fetch ( $start, $total, $this->table_custom_backgrounds, $locked, $order );
			return $return;
		}
		
		public function get_active_background ( $id ){
			$active = $this->db->get_row ( $this->table_custom_backgrounds, 'active', 'yes' );
			$array = array();
			if($active){
				$array['active'] = 'no';
				$result = $this->db->update( $array, $active['id'], $this->table_custom_backgrounds  );
				if ( $result ){
					unset($array);
					$array['active'] = 'yes';
				}
			}else{
				unset($array);
				$array['active'] = 'yes';
			}

			$result = $this->db->update( $array, $id, $this->table_custom_backgrounds  );
			$this->background();
			if( $result ){
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['active'] );
			}else{
				@header( 'location:preferences.php?command=web-customize&msg=' . $this->messages['custom_backgrounds']['active_fail'] );
			}

		}

		function get_background_row ( $id ){
			return $this->db->get_row( $this->table_custom_backgrounds, 'id', $id );
		}

		function background_preferences( $field, $value ){
			if( $this->check_field_exists( $field ) !=0 ){
				$query = "UPDATE `$this->table_preferences` SET `value` = '$value' WHERE `name` = '$field'";
				$result = $this->db->query( $query );
			}else{
				$query = "INSERT INTO `$this->table_preferences` ( `name`, `value` ) VALUES ( '$field', '$value' )";
				$result = $this->db->query( $query );
			}

			if( $result ){
				@header( "location:preferences.php?command=web-customize&msg=Set your $value background preferences&type=success" );
			}else{
				@header( "location:preferences.php?command=web-customize&msg=Not Set your $value background preferences&type=error" );
			}

		}
		
		function delete_background( $id ){
			$query = "select * from $this->table_custom_backgrounds where id='$id'";
			$result = $this->db->query ( $query );
			$fetch = $this->db->fetch_assoc ( $result );
			$image_path = SITE_PATH.CUSTOM_BACKGROUND_DIR.$fetch['backgrounds_image'];
			if( $this->db->delete ( $id, $this->table_custom_backgrounds ) ){
				@unlink( $image_path );
			}
		}
	}
	$pref = new Preferences( $db );
?>