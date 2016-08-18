<?php
	class PhotoAlbum{
		
		private $db;
		private $msg;
		public $table_album = ALBUM;
		public $table_album_viewer = ALBUM_VIEWER;
		public $table_album_photo = ALBUM_PHOTOS;
		public $table_photo_viewer = PHOTO_VIEWER;
		public $table_categories = CATEGORIES;
		public $table_sub_categories = SUB_CATEGORIES;


		public $table_allbum_photo_viewer = "allbum_photo_viewer";
		
		private $messages = array(
			'album' => array(
				'success' => 'Yours album was created.&type=success',
				'fail' => 'Your album was not created please try again.&type=error',
				'exists' => 'Your album already exists.&type=information',
				'folder_exists' => 'yours album folder already exists.&type=information',
				'update' => 'Yours album is update.&type=success',
				'update_fail' => 'Yours album is update.&type=success',
				'empty' => 'Album is not empty.&type=information',
				'delete' => 'Album was delete.&type=success',
				'not_exist' => 'Album is not exist please go to edit and update your album.&type=information'
			),
			'photo' => array(
				'add' => 'Your photo was successfully added.&type=success',
				'add_fail' => 'Your photo was not add please try again.&type=information',
				'update' => 'Your photo was successfully updated.&type=success',
				'update_fail' => 'Your photo was not updated yet please try again.&type=information',
				'delete' => 'Your photo is deleted successfully.&type=success',
				'delete_fail' => 'Your photo was not deleted yet please try again.&type=information'
			)
		);
		
		public function __construct( $db ){

			$this->db = $db;

		}

		public function folder_path(){
			return SITE_PATH . PHOTOS;
		}

		public function get_msg(){
			return $this->msg;
		}

		function prepare_query( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			$query = "SELECT * FROM `$this->table_album`";
			if( $user_type == 'user' ){
				$query .= " WHERE `album_status` != 'trash' AND `album_status` != 'draft'";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `album_status` != 'trash'";
			}
			$query .= " ORDER BY `album_date`  DESC";
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_posts ( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			$query = "SELECT * FROM `$this->table_album`";
			if( $user_type == 'user' ){
				$query .= " WHERE `album_status` != 'trash' AND `album_status` != 'draft'";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `album_status` != 'trash'";
			}
			$query .= " ORDER BY `album_date`  DESC";
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

		private function is_exists_row( $table, $field, $field_value ){

			$query = "select * from $table where $field = '$field_value'";
			$result = $this->db->fetch_array_by_query( $query );
			if( $result['album_name'] == $field_value ){
				return $ok = 0;
			}else{
				return $ok = 1;
			}

		}

		public function add_album( $arr ){
			
			foreach( $arr as $key => $value ){
				if( is_string( $value) ){
					$arr[ $key ] = check_slashes( $value );
				}
			}
	
			$new_array = array();
			$new_array['category'] = $arr['category'];
			$new_array['sub_category'] = $arr['sub_category'];
			$new_array['album_name'] = $arr['album_name'];
			$new_array['album_old_name'] = $arr['album_name'];
			$new_array['album_description'] = $arr['album_description'];
			$new_array['album_keywords'] = $arr['album_keywords'];
			$new_array['album_tags'] = strtolower( str_replace(' ', '', $arr['album_tags'] ) );
			$new_array['album_detail'] = $arr['album_detail'];
			$uniqe = "-" . randCode('3');
			$new_array['album_url_str'] = $this->smart_url( trim( $arr['album_name'] ) . $uniqe );
			$new_array['album_url'] = $this->album_permalink( trim( $arr['album_name'] ) . $uniqe );
			$new_array['album_path'] = BASE_URL . PHOTOS . $this->smart_url( trim( $arr['album_name'] ) );
			$new_array['album_date'] = date("Y-m-d H:i:s",time());
			$new_array['album_status'] = 'draft';
	
			$is_exists = $this->is_exists_row( $this->table_album, 'album_name', $new_array['album_name'] );
			
			if( $is_exists ){
				$name = $this->smart_url( trim( $new_array['album_name'] ) );
				if( !file_exists( $this->folder_path().$name ) or !is_dir( $this->folder_path().$name ) ){
					if( mkdir( $this->folder_path().$name ) ){
						$this->db->insert( $new_array, $this->table_album );
						header( "location:album.php?msg=" . $this->messages['album']['success'] );
					}else{
						header( "location:album.php?msg=" . $this->messages['album']['fail'] );
					}
				}else{
					header( "location:album.php?msg=" . $this->messages['album']['folder_exists'] );
				}
			}else{
				if( !file_exists( $this->folder_path().$name ) or !is_dir( $this->folder_path().$name ) ){
					mkdir( $this->folder_path().$name );
				}
				header( "location:album.php?msg=" . $this->messages['album']['exists'] );
			}
			return $result;
		}

		public function get_allbum_by_id( $id ){

			$query = "SELECT * FROM `$this->table_album` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = array();
			$fetch = $this->db->fetch_assoc( $result );
			return $fetch;

		}

		public function get_allbum_by_url ( $url ){
			if( $parma !='' ){
				$parma = $parma;
			}

			$query = "SELECT";
			$query .= " `$this->table_album`.*,";
			$query .= " `$this->table_categories`.id as c_id, `$this->table_categories`.name as c_name, `$this->table_categories`.url as c_url,";
			$query .= " `$this->table_sub_categories`.id as sc_id, `$this->table_sub_categories`.categories_id as sc_parent, `$this->table_sub_categories`.name as sc_name, `$this->table_sub_categories`.url as sc_url";
			$query .= " FROM";
			$query .= " `$this->table_album`";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_categories` ON `$this->table_categories`.id = `$this->table_album`.category";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_sub_categories` ON `$this->table_sub_categories`.id = `$this->table_album`.sub_category";
			$query .= " WHERE";
			$query .= " `album_status` = 'publish' AND `album_total_file` > '0' AND `album_url_str` = '$url'";

			$result = $this->db->query( $query );
			$fetch = $this->db->fetch_assoc( $result );
			return $fetch;

		}

		public function update_allbum( $arr ){
			
			$id = intval( $arr['id'] );

			foreach( $arr as $key => $value ){
				if( is_string( $value) ){
					$arr[ $key ] = check_slashes( $value );
				}
			}

			$new_array = array();
			$new_array['category'] = $arr['category'];
			$new_array['sub_category'] = $arr['sub_category'];
			$new_array['album_name'] = $arr['album_name'];
			$new_array['album_old_name'] = $arr['album_name'];
			$new_array['album_description'] = $arr['album_description'];
			$new_array['album_keywords'] = $arr['album_keywords'];
			$new_array['album_tags'] = strtolower( str_replace(' ', '', $arr['album_tags'] ) );
			$new_array['album_detail'] = $arr['album_detail'];
			$uniqe = "-" . $id;
			$new_array['album_url_str'] = $this->smart_url( trim( $arr['album_name'] ) . $uniqe );
			$new_array['album_url'] = $this->album_permalink( trim( $arr['album_name'] ) . $uniqe );
			$new_array['album_path'] = BASE_URL . PHOTOS . $this->smart_url( trim( $arr['album_name'] ) );
			$new_array['album_status'] = $arr['album_status'];

			$old_name = $this->smart_url( $this->get_old_name( $id ) );
			$name = $this->smart_url( trim( $new_array['album_name'] ) );

			if( file_exists( $this->folder_path().$old_name ) or is_dir( $this->folder_path().$old_name ) ){

				if( @rename( $this->folder_path().$old_name, $this->folder_path().$name ) ){

					$result = $this->db->update( $new_array, $id, $this->table_album );
					$this->db->query( "UPDATE `" . $this->table_album . "` SET `album_old_name` = '". $new_array['album_name'] ."' WHERE `id` = '" . $id . "'" );
					@header( "location:album.php?msg=" . $this->messages['album']['update'] );

				}else{

					@header( "location:album.php?msg=" . $this->messages['album']['fail'] );

				}
			}else{

				@mkdir( $this->folder_path().$name );
				@header( "location:album.php?msg=" . $this->messages['album']['update'] );

			}

			return $result;

		}

		private function get_old_name( $id ){

			$query = "SELECT `album_old_name` FROM `$this->table_album` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return stripslashes( $row['album_old_name'] );

		}

		public function get_album_name( $id ){
			$query = "SELECT `album_name` FROM `$this->table_album` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return stripslashes( $row['album_name'] );
		}

		public function get_dir_path_with_name( $name ){
			$dirpath = SITE_PATH . PHOTOS . $name . '/';
			return $dirpath;
		}

		public function view_album_count( $id, $ip ){
			$lastday = time()-(24*60*60);
			$get_query = "delete from `$this->table_album_viewer` where `is_time` < '$lastday'";
			$this->db->query($get_query);

			$new_array = array();
			$check_query = "select * from `$this->table_album_viewer` where `ip` = '$ip' and `a_id` = '$id'";
			$check_count = $this->db->count_rows_by_query($check_query);

			if( $check_count == 0 ){
				$new_array['a_id'] = $id;
				$new_array['ip'] = $ip;
				$new_array['is_time'] = time();
				$this->db->insert( $new_array, $this->table_album_viewer );
				$query = "update $this->table_album set album_view = album_view + 1 where id = '$id'";
				$result = $this->db->query($query);
				return $result;
			}
		}

		function view_photo_count( $id, $ip ){
			$lastday = time()-(24*60*60);
			$get_query = "delete from $this->table_photo_viewer where `is_time` < '$lastday'";
			$this->db->query($get_query);

			$new_array = array();
			$check_query = "select * from `$this->table_photo_viewer` where `ip` = '$ip' and `ap_id` = '$id'";
			$check_count = $this->db->count_rows_by_query( $check_query );

			if( $check_count == 0 ){
				$new_array['ap_id'] = $id;
				$new_array['ip'] = $ip;
				$new_array['is_time'] = time();
				$this->db->insert( $new_array, $this->table_photo_viewer );
				$query = "update $this->table_album_photo set photo_view = photo_view + 1 where id = '$id'";
				$result = $this->db->query($query);
				return $result;
			}
		}

		public function set_total_file( $id ){
			$query = "select count(*) as total from `$this->table_album_photo` where `album_id` = '$id'";
			$result = $this->db->fetch_array_by_query( $query );
			return $this->db->query("UPDATE `$this->table_album` SET `album_total_file` = '$result[total]' WHERE id = '$id'");
		}

		function prepare_photo_query( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			if( $parma != '' ){
				$parma = 'AND ' . $parma;
			}
			$query = "SELECT * FROM `$this->table_album_photo`";
			if( $user_type == 'user' ){
				$query .= " WHERE `photo_status` != 'publish'";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `photo_status` != 'trash' $parma";
			}
			$query .= " ORDER BY `photo_date`  DESC";
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );
		}

		function fetch_photo_posts ( $start = '0', $limit = '0', $parma = '', $user_type = 'admin' ){
			if( $parma != '' ){
				$parma = 'AND ' . $parma;
			}
			$query = "SELECT * FROM `$this->table_album_photo`";
			if( $user_type == 'user' ){
				$query .= " WHERE `photo_status` != 'trash' AND `photo_status` != 'draft' $parma";
			}
			if( $user_type == 'admin' ){
				$query .= " WHERE `photo_status` != 'trash' $parma";
			}
			$query .= " ORDER BY `photo_date`  DESC";
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

		public function add_photo( $arr ){
			$uniqe = "-" . randCode('3');
			$data = array(
				"album_id" =>  intval( $arr['album_id'] ),
				"photo_title" => $arr['photo_title'],
				"photo_name" => $arr['photo_name'],
				"photo_reference" => $arr['photo_reference'],
				"photo_size" => $arr['photo_size'],
				"photo_resolution" => $arr['photo_resolution'],
				"photo_type" => $arr['photo_type'],
				"photo_description" => $arr['photo_description'],
				"photo_url_str" => $this->smart_url( trim ( $arr['photo_title'] ) . $uniqe ),
				"photo_url" => $this->photos_permalink( trim ( $arr['photo_title'] ) . $uniqe ),
				"photo_date" => date( "Y-m-d H:i:s", time() ),
				"photo_status" => 'draft'
			);

			$result = $this->db->insert( $data, $this->table_album_photo );

			if( $result ){
				header( 'location:album.php?command=open&id='.$arr['album_id'].'&msg=' . $this->messages['photo']['add'] );
			}else{
				header( 'location:album.php?command=open&id='.$arr['album_id'].'&msg=' . $this->messages['photo']['add_fail'] );
			}

		}

		public function get_photos_id( $id ){
			$query = "SELECT * FROM `$this->table_album_photo` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_photo_name( $id ){

			$query = "SELECT `photo_name` FROM `$this->table_album_photo` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return stripslashes( $row['photo_name'] );

		}

		public function get_photo_url( $url ){

			$query = "SELECT * FROM `$this->table_album_photo` WHERE `photo_url_str` = '$url'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;

		}

		public function get_album_path( $id ){
			$query = "SELECT `album_path` FROM `$this->table_album` WHERE `id` = '$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row['album_path'];

		}

		public function update_photo( $arr ){
			$data = array();
			$id = intval( $arr['id'] );
			$uniqe = "-" . $id;
			$data = array(
				"album_id" =>  intval( $arr['album_id'] ),
				"photo_title" => $arr['photo_title'],
				"photo_name" => $arr['photo_name'],
				"photo_reference" => $arr['photo_reference'],
				"photo_size" => $arr['photo_size'],
				"photo_resolution" => $arr['photo_resolution'],
				"photo_type" => $arr['photo_type'],
				"photo_description" => $arr['photo_description'],
				"photo_url_str" => $this->smart_url( trim ( $arr['photo_title'] ) . $uniqe ),
				"photo_url" => $this->photos_permalink( trim ( $arr['photo_title'] ) . $uniqe ),
				"photo_status" => $arr['photo_status']
			);

			$result = $this->db->update( $data, $id, $this->table_album_photo );

			if( $result ){
				header( 'location:album.php?command=open&id='.$arr['album_id'].'&msg=' . $this->messages['photo']['update'] );
			}else{
				header( 'location:album.php?command=open&id='.$arr['album_id'].'&msg=' . $this->messages['photo']['update_fail'] );
			}
		}

		function prepare_album_with_photos ( $start = '0', $limit = '0', $parma = '' ){
			$query = "SELECT";
			$query .= " `$this->table_album`.*,";
			$query .= " `$this->table_categories`.id as c_id, `$this->table_categories`.name as c_name, `$this->table_categories`.url as c_url,";
			$query .= " `$this->table_sub_categories`.id as sc_id, `$this->table_sub_categories`.categories_id as sc_parent, `$this->table_sub_categories`.name as sc_name, `$this->table_sub_categories`.url as sc_url";
			$query .= " FROM";
			$query .= " `$this->table_album`";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_categories` ON `$this->table_categories`.id = `$this->table_album`.category";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_sub_categories` ON `$this->table_sub_categories`.id = `$this->table_album`.sub_category";
			$query .= " WHERE";
			$query .= " `album_status` = 'publish' AND `album_total_file` > 0 $parma";
			$query .= " ORDER BY `album_date` DESC";
			if ($limit > 0){
				$query .= " LIMIT $start , $limit";
			}

			return $this->db->query( $query );

		}

		function fetch_album_with_photos ( $start = '0', $limit = '0', $parma = '' ){
			$query = "SELECT";
			$query .= " `$this->table_album`.*,";
			$query .= " `$this->table_categories`.id as c_id, `$this->table_categories`.name as c_name, `$this->table_categories`.url as c_url,";
			$query .= " `$this->table_sub_categories`.id as sc_id, `$this->table_sub_categories`.categories_id as sc_parent, `$this->table_sub_categories`.name as sc_name, `$this->table_sub_categories`.url as sc_url";
			$query .= " FROM";
			$query .= " `$this->table_album`";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_categories` ON `$this->table_categories`.id = `$this->table_album`.category";
			$query .= " LEFT JOIN";
			$query .= " `$this->table_sub_categories` ON `$this->table_sub_categories`.id = `$this->table_album`.sub_category";
			$query .= " WHERE";
			$query .= " `album_status` = 'publish' AND `album_total_file` > 0 $parma";
			$query .= " ORDER BY `album_date` DESC";
			if ($limit > 0){
				$query .= " LIMIT $start , $limit";
			}

			$new_array = array();
			$result = $this->db->query( $query );
			if( $this->db->count_rows( $result ) ){
				while( $rows = $this->db->fetch_assoc( $result ) ){
					$html .= '<div class="heading-section">';
						$html .= '<h3>'.$rows['album_name'].'</h3>';
						$html .= '<span class="link"><a href="'.$rows['album_url'].'">More Photos &rarr;</a></span>';
						$html .= '<div class="clear">&nbsp;</div>';
					$html .= '</div>';
					$html .= '<div class="entry-meta">';
						$html .= '<span class="meta-published">'.$rows['album_date'].'</span>';
						$html .= '<span class="meta-categories">';
							$html .= '<a href="'.BASE_URL.'photo/topics/'.$rows['c_url'].'">'.$rows['c_name'].'</a>';
							if( $rows['sc_name'] !='' ){
								$html .= ' / <a href="'.BASE_URL.'photo/topics/'.$rows['c_url'].'/categories/'.$rows['sc_url'].'">'. $rows['sc_name']."</a>";
							}
						$html .= '</span>';
						$html .= '<span class="meta-reader">'.$rows['album_view'].' People(s) View this</span>';
						$html .= '<div class="clear">&nbsp;</div>';
					$html .= '</div>';
					$photo_query ="SELECT * FROM `$this->table_album_photo` WHERE `album_id` = '$rows[id]' AND `photo_status` = 'publish' ORDER BY `photo_date` DESC LIMIT 0 , 10";
					$photo_result = $this->db->query( $photo_query );
					$box_height = '128';
					$allbum_count = 0;
					if( $this->db->count_rows($photo_result) ){
						while( $photo_rows = $this->db->fetch_assoc( $photo_result ) ){
							$allbum_count++;
							if( $allbum_count%6==0 ){
								$m = " margin-right";
							}else{
								$m = "";
							}
							$pic = $rows['album_path'] . '/thumb-' .$photo_rows['photo_name'];
							$size = getimagesize($pic);
							if( $size[1] == $box_height ){
								$padding = '';
							}else{
								$new_height = ($box_height - $size[1]) / 2;
								$padding = 'style="padding-top:'.$new_height.'px;"';
							}

							$html .= '<div class="allbum '.$m.'">';
								$html .= '<a href="'.$photo_rows['photo_url'].'" '.$padding .'>';
									$html .= '<img src="'.$pic.'" alt="'.$photo_rows['photo_name'].'">';
								$html .= '</a>';
								
							$html .= '</div>';
						}
						$html .= '<div class="clear">&nbsp;</div>';
						
						$tags = explode(',', $rows['album_tags']);
						$html .= '<ul class="simple">';
							$html .= '<li>Tags :</li>';
							for( $i = 0; $i < count( $tags ); $i++){
								$html .= '<li><a href="'.BASE_URL.'photo/tag/'.$tags[$i].'">'.$tags[$i].'</a></li>';
							}
						$html .= '</ul>';
						$html .= '<br />';
						$html .= '<div class="clear">&nbsp;</div>';
				
					}else{
						$html .= '<div class="no-found">No Record</div>';
					}
				}
			}else{
				$html .= '<div class="no-found">No Record</div>';
			}
			return $html;


		}

		public function prepare_photos_by_album_id ( $start = '0', $limit = '0', $parma = '' ){

			$query = "SELECT * FROM `$this->table_album_photo`";
			$query .= " WHERE `photo_status` = 'publish' $parma";
			$query .= " ORDER BY `photo_date` DESC";
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			return $this->db->query( $query );

		}
		
		public function fetch_photos_by_album_id( $start = '0', $limit = '0', $parma = '' ){
			$new_array = array();
			$query = "SELECT * FROM `$this->table_album_photo`";
			$query .= " WHERE `photo_status` = 'publish' $parma";
			$query .= " ORDER BY `photo_date` DESC";
			if ( $limit > '0' ){
				$query .= " LIMIT $start , $limit";
			}
			$result = $this->db->query( $query );
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		public function delete_album ( $id ){
			$query = "SELECT * FROM `$this->table_album_photo`";
			$query .= " WHERE `album_id` = '$id'";
			$count = $this->db->count_rows_by_query( $query );
			if( $count != '0' ){

				@header( "location:album.php?msg=" . $this->messages['album']['empty'] );

			}else{
				
				$query = "DELETE FROM `$this->table_album` WHERE `id` = '$id'";
				$name = $this->smart_url( $this->get_album_name( $id ) );
				if( file_exists( $this->folder_path().$name ) || is_dir( $this->folder_path().$name ) ){
					if( @rmdir( $this->folder_path().$name ) ){
						$this->db->query( $query );
						@header( "location:album.php?msg=" . $this->messages['album']['delete'] );
					}else{
						@header( "location:album.php?msg=" . $this->messages['album']['empty'] );
					}
				}else{
					@header( "location:album.php?msg=" . $this->messages['album']['not_exist'] );
				}
			}

		}

		public function delete_photo( $arr ){
			$photoid = intval( $arr['photo_id'] );
			$albums_id = intval( $arr['album_id'] );
			$pic_name = $arr['name'];
			$name = $this->smart_url( $this->get_album_name( $albums_id ) );

			$query = "DELETE FROM `$this->table_album_photo` WHERE `id` = '$photoid'";
			$result = $this->db->query( $query );
			if( file_exists( $this->folder_path() . $name . "/" . $pic_name ) ){
				@unlink( $this->folder_path() . $name . "/" . $pic_name );
			}
			if( file_exists( $this->folder_path() . $name . "/thumb-" . $pic_name ) ){
				@unlink( $this->folder_path() . $name . "/thumb-" . $pic_name );
			}
			if( $result ){
				@header( 'location:album.php?command=open&id='. $albums_id . '&msg=' . $this->messages['photo']['delete'] );
			}else{
				@header( 'location:album.php?command=open&id='. $albums_id . '&msg=' . $this->messages['photo']['delete_fail'] );
			}
		}









		/**/


		public function get_total_file($allbumid){
			$query="SELECT * FROM allbums WHERE id = '$allbumid'";
			$result=$this->db->fetch_array_by_query($query);
			return $result['total_file'];
		}

		/*=========================================
			allbums section
		=========================================*/

		public function get_allbum($id=''){
			if($id==''){
				$query="SELECT * FROM allbums ORDER BY `name` ASC";
				$result=$this->db->query($query);
			}else{
				$query="SELECT * FROM allbums WHERE id='$id'";
				$result=$this->db->query($query);
				while($row=$this->db->fetch_assoc($result)){
					$result=$row;
				}
			}
			return $result;
		}

		public function get_allbum_fetch_array_by_id( $allbumid ){
			$query = "SELECT * FROM `" . $this->table_allbum . "` WHERE `id` = '$allbumid'";
			$result = $this->db->fetch_array_by_query( $query );
			return $result;
		}

		

		private function get_dir_path(){
			return SITE_PATH . '/site-content/albums/';
		}

		public function facebook_data_photo( $id ){
			$query = "SELECT * FROM `" . $this->table_allbums_photos . "` WHERE `allbums_id` = '$id' ORDER BY `id` ASC LIMIT 0,1";
			$result = $this->db->query ( $query );
			$row = $this->db->fetch_assoc ( $result );
			return $row;
		}
		
		


		/*=========================================
			end allbums section
		=========================================*/


		/*=========================================
			photo section
		=========================================*/

		private function get_photos(){
			$query = 'SELECT * FROM `$this->table_allbums_photos`';
			$result = $this->db->query( $query );
			return $result;
		}


		
		public function add_multi_photo( $arr, $file ){
			for($i=1; $i<=$arr['qty']; $i++){
				$allbumid = intval( $arr['allbums_id'] );
				$image = $file['image_'.$i];
				$image_name = check_slashes( $arr['title_'.$i] ) . '-' . randCode();

				if( $image['name'] != '' ){
					$allbum_name = $this->get_allbum_name( $allbumid );
					$allbum_name = str_replace( ' ', '-' ,$allbum_name );
					$allbum_path = $this->get_dir_path_with_name( $allbumid );
					/**/
					$this->upload_image_with_auto_thumbnail( $image, $allbum_path, $image_name, '75', 'thumb' );
					$pic = $this->get_image_name();
					$size = $this->display_filesize();
					$resolution = $this->get_image_resolution();
					$type = $this->format;
				}
	
				$data = array(
					"m_id" => intval( $arr['m_id'] ),
					"allbums_id" =>  intval( $arr['allbums_id'] ),
					"title" => check_slashes($arr['title_'.$i]),
					"name" => $pic,
					"image_reference" => $arr['image_reference_'.$i],
					"size" => $size,
					"resolution" => $resolution,
					"type" => $type,
					"description" =>  check_slashes($arr['description_'.$i]),
					"upload_date" => time(),
					"featured" => $arr['featured_'.$i],
					"locked" => $arr['lock_'.$i],
					"url_str" => $this->smart_url( trim ($arr['title_'.$i] ) ),
					"url" => $this->photos_permalink( trim ($arr['title_'.$i] ) )

				);
				$result = $this->db->insert( $data, $this->table_allbums_photos );
			}
			if( $result ){
				@header( 'location:allbum-photos.php?id='.$arr['allbums_id'].'&msg=' . $this->messages['photo']['add'] );
			}else{
				@header( 'location:allbum-photos.php?id='.$arr['allbums_id'].'&msg=' . $this->messages['photo']['add_fail'] );
			}
			return $result;
		}


		public function get_rand_photo($id){
			$allbum_name=$this->get_allbum_name($id);
			$row=$this->db->fetch_array_by_query("SELECT * FROM allbums_photos WHERE allbums_id = '$id' LIMIT 0,1");
			$pic=VIEW_BASE_URL.allbums_path.$allbum_name.'/thumb-'.$allbum_name.'/thumb-'.$row['name'];
			return $pic;
		}

		public function is_live($id){
			$query="update allbums_photos set is_live='yes', locked='no' where id='$id'";
			$result=$this->db->query($query);
			return $result;
			
		}

		public function get_allbum_with_limit( $allbum_limit = '3' ){
			$new_array = array();
			$query_allbum = "SELECT * FROM `$this->table_allbum` WHERE `locked` = 'no' AND `total_file` > 0  ORDER BY `created_date` DESC LIMIT 0 , $allbum_limit";
			$result_allbum = $this->db->query( $query_allbum );
			while( $row_allbum = $this->db->fetch_assoc($result_allbum) ){
				$new_array[] = $row_allbum;
			}
			return $new_array;
		}

		public function get_allbum_photo_with_limit( $photo_limit = '7', $allbums_id ){
			$new_array = array();
			$query_photo = "SELECT * FROM `$this->table_allbums_photos` WHERE `locked` = 'no' AND `allbums_id` = '$allbums_id' ORDER BY `upload_date` DESC LIMIT 0 , $photo_limit";
			$result_photo = $this->db->query( $query_photo );
			while( $row_photo = $this->db->fetch_assoc( $result_photo ) ){
				$new_array[] = $row_photo;
			}
			return $new_array;
		}
		
		public function get_allbum_with_photo( $allbum_limit = '3', $photo_limit = '10' ){
			/*deprecated*/
			$box_height = 75;
			$html = "";
			$query_allbum = "SELECT * FROM `$this->table_allbum` WHERE `locked` = 'no' AND `total_file` > 0  ORDER BY `created_date` DESC LIMIT 0 , $allbum_limit";
			$result_allbum = $this->db->query($query_allbum);
			while( $row_allbum = $this->db->fetch_assoc($result_allbum) ){
				$html .= '<div class="album_box">';
					$html .= '<h2 class="page_title">';
						$html .= '<span class="heading">'.$row_allbum['name'].'</span>';
						$html .= '<span class="link"><a href="'.$row_allbum['url'].'">More Photos &rarr;</a></span>';
						$html .= '<span class="view">'.$row_allbum['view'].' People(s) View this</span>';
						$html .= '<div class="clear"></div>';
					$html .= '</h2>';
					$query_photo = "SELECT * FROM `$this->table_allbums_photos` WHERE `locked` = 'no' AND `allbums_id` = '$row_allbum[id]' ORDER BY `upload_date` DESC LIMIT 0 , $photo_limit";
					$result_photo = $this->db->query($query_photo);
					$margin = 0;
					while( $row_photo = $this->db->fetch_assoc($result_photo) ){
						$margin++;
						$allbum_name = $this->get_allbum_name($row_photo['allbums_id']);
						$allbum_name = str_replace(' ','-',$allbum_name);
						$pic = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$row_photo['name'];
						$size=getimagesize($pic);
						if($size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						if($margin%7==0){
							$m = ' style="margin-right:0"';
						}else{
							$m = '';
						}
						$html .= '<div class="allbum fl" '.$m.'>';
							$html .= '<div class="allbum-thumb" '.$padding.'>';
								$html .= '<a href="'.$row_photo['url'].'"><img src="'.$pic.'" alt="'.$row_photo['title'].'" title="'.$row_photo['title'].'" /></a>';
							$html .= '</div>';
						$html .= '</div>';
					}
					$html .= '<div class="clear"></div>';
				$html .= '</div>';
			}
			return $html;
		}

		public function get_prev_next_photo( $album, $id ){
			$html = '';
			$box_height = 75;
			$allbum_name = $this->get_allbum_name( $album );
			$allbum_name = str_replace( ' ', '-', $allbum_name );
			$previous_query = "SELECT * FROM `$this->table_allbums_photos` WHERE locked = 'no' AND `allbums_id` = '$album' AND `id` < '$id'  ORDER BY `id` DESC LIMIT 0 , 1";
			$previous_result = $this->db->query( $previous_query );
			$previous_row = $this->db->fetch_assoc( $previous_result );
			$html .= '<div class="prev_next">';
				if($previous_row){
					$html .= '<div class="fl">';
						$img = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$previous_row['name'];
						$size = getimagesize($img);
						if( $size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						$html .= '<div class="box">';
							$html .= '<div class="img fl" '.$padding.'><img src="'.$img.'"></div>';
							$html .= '<div class="link fr"><a href="'.$previous_row['url'].'"><span>previous</span></a></div>';
						$html .= '</div>';
					$html .= '</div>';
				}else{
					$previous_query = "SELECT * FROM `$this->table_allbums_photos` WHERE locked = 'no' AND `allbums_id` = '$album' ORDER BY `id` DESC LIMIT 0 , 1";
					$previous_result = $this->db->query( $previous_query );
					$previous_row = $this->db->fetch_assoc( $previous_result );
					$html .= '<div class="fl">';
						$img = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$previous_row['name'];
						$size = getimagesize($img);
						if( $size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						$html .= '<div class="box">';
							$html .= '<div class="img fl" '.$padding.'><img src="'.$img.'"></div>';
							$html .= '<div class="link fr"><a href="'.$previous_row['url'].'"><span>previous</span></a></div>';
						$html .= '</div>';
					$html .= '</div>';
				}
				$next_query = "SELECT * FROM `$this->table_allbums_photos` WHERE locked = 'no' AND `allbums_id` = '$album' AND `id` > '$id'   ORDER BY `id` ASC LIMIT 0 , 1";
				$next_result = $this->db->query( $next_query );
				$next_row = $this->db->fetch_assoc( $next_result );
				if($next_row){
					$html .= '<div class="fr">';
						$img = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$next_row['name'];
						$size = getimagesize($img);
						if( $size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						$html .= '<div class="box">';
							$html .= '<div class="img fr" '.$padding.'><img src="'.$img.'"></div>';
							$html .= '<div class="link fl"><a href="'.$next_row['url'].'"><span>next</span></a></div>';
						$html .= '</div>';
					$html .= '</div>';
				}else{
					$next_query = "SELECT * FROM `$this->table_allbums_photos` WHERE locked = 'no' AND `allbums_id` = '$album' ORDER BY `id` ASC LIMIT 0 , 1";
					$next_result = $this->db->query( $next_query );
					$next_row = $this->db->fetch_assoc( $next_result );
					$html .= '<div class="fr">';
						$img = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$next_row['name'];
						$size = getimagesize($img);
						if( $size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						$html .= '<div class="box">';
							$html .= '<div class="img fr" '.$padding.'><img src="'.$img.'"></div>';
							$html .= '<div class="link fl"><a href="'.$next_row['url'].'"><span>next</span></a></div>';
						$html .= '</div>';
					$html .= '</div>';

				}
				$html .= '<div class="clear">&nbsp;</div>';
			$html .= '</div>';
			return $html;
		}

		public function get_random_photo( $album, $id ){
			$box_height = 75;
			$allbum_name = $this->get_allbum_name( $album );
			$allbum_name = str_replace( ' ', '-', $allbum_name );
			$query = "SELECT * FROM `$this->table_allbums_photos` WHERE locked = 'no' AND `allbums_id` = '$album' AND `id` != '$id' ORDER BY RAND( ) LIMIT 0 , 16";
			$result = $this->db->query( $query );
			$html = '';
			$html = '<div id="my-carousel-2" class="carousel module">';
				$html .= '<ul>';
					while( $row = $this->db->fetch_assoc( $result ) ){ 
						$pic = VIEW_BASE_URL . ALLBUMS_PATH . $allbum_name.'/thumb-'.$row['name'];
						$size = getimagesize($pic);
						if( $size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						$html .= '<li><a '.$padding.' href="'.$row['url'].'"><img src="'.$pic.'" alt="'.$row['title'].'" title="'.$row['title'].'" /></a></li>';
					}
				$html .= '</ul>';
			$html .= '</div>';
			return $html;
		}

		function get_footer_allbum_link($limit = 5){
			$query = "SELECT * FROM `allbums` WHERE `locked` = 'No' AND `total_file` > 0 ORDER BY `view` DESC LIMIT 0,$limit";
			$result = $this->db->query($query);
			$new_array = array();
			while($row = $this->db->fetch_array($result)){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_allbum_list($limit = ''){
			$new_array = array();
			if( $limit != '' ){
				$limit = " LIMIT 0 , $limit";
			}
			$query = "SELECT * FROM `$this->table_allbum` WHERE `locked` = 'no' AND `total_file` > 0 ORDER BY `view` DESC $limit";
			$result = $this->db->query($query);
			while ( $row = $this->db->fetch_assoc($result) ){
				$new_array[] = $row;						
			}
			return $new_array;
		}

		public function get_featured_photo( $limit = '' ){
			$box_height = 75;
			$html = "";
			if( $limit != '' ){
				$limit = " LIMIT 0 , $limit";
			}
			$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `featured` = 'yes' AND `locked` = 'no' ORDER BY `view` DESC $limit";
			$result = $this->db->query($query);
			$html .= '<div class="box">';
				if( $this->db->count_rows_by_query( $query ) != 0 ){
					$html .= '<h3>Featured Images</h3>';
				}
				$html .= '<div class="album_box">';
					$margin = 0;
					while( $row = $this->db->fetch_assoc( $result ) ){
						$margin++;
						$allbum_name = $this->get_allbum_name($row['allbums_id']);
						$allbum_name = str_replace(' ','-',$allbum_name);
						$pic = VIEW_BASE_URL.ALLBUMS_PATH.$allbum_name.'/thumb-'.$row['name'];
						$size = getimagesize($pic);
						if($size[1] == $box_height ){
							$padding = '';
						}else{
							$new_height = ($box_height - $size[1]) / 2;
							$padding = 'style="padding-top:'.$new_height.'px"';
						}
						if($margin%3==0){
							$m = ' style="margin-right:0"';
						}else{
							$m = '';
						}
						$html .= '<div class="allbum fl" '.$m.'>';
							$html .= '<div class="allbum-thumb" '.$padding.'>';
							$html .= '<a href="'.$row['url'].'"><img src="'.$pic.'" alt="'.$row['title'].'" title="'.$row['title'].'" /></a>';
							$html .= '</div>';
						$html .= '</div>';
					}
					$html .= '<div class="clear"></div>';
				$html .= '</div>';
			$html .= '</div>';
			return $html;
		}

		public function get_top_view_photo( $limit = '', $featured='' ){
			$new_array = array();
			if( $featured == 'featured' ){
				$featured = "AND featured = 'yes'";
			}
			if( $limit != '' ){
				$limit = " LIMIT 0 , $limit";
			}
			$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `locked` = 'no' $featured ORDER BY VIEW DESC $limit";
			$result = $this->db->query($query);
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		public function get_next_previous( $cid = "", $id = "" ){
			$html = "<ul>";
			$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `id` < '$id' AND `allbums_id` = '$cid' ORDER BY `id` DESC";
			$result_previous = $this->db->query($query);
			$row_previous = $this->db->fetch_array($result_previous);
			if($row_previous){
				$html .= '<li><a href="'.$this->photos_permalink($row_previous).'">Previous</a></li>';
			}else{
				$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `allbums_id` = '$cid' ORDER BY `id` DESC LIMIT 0 , 1";
				$result_previous = $this->db->query($query);
				$row_previous = $this->db->fetch_array($result_previous);
				$html .= '<li><a href="'.$this->photos_permalink($row_previous).'">Previous</a></li>';
			}

			$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `id` > '$id' AND `allbums_id` = '$cid' ORDER BY `id` ASC";
			$result_next = $this->db->query($query);
			$row_next = $this->db->fetch_array($result_next);
			if($row_next){
				$html .= '<li><a href="'.$this->photos_permalink($row_next).'">Next</a></li>';
			}else{
				$query = "SELECT * FROM `$this->table_allbums_photos` WHERE `allbums_id` = '$cid' ORDER BY `id` ASC LIMIT 0 , 1";
				$result_next = $this->db->query($query);
				$row_next = $this->db->fetch_array($result_next);
				$html .= '<li><a href="'.$this->photos_permalink($row_next).'">Next</a></li>';
			}
			
			$html .= "</ul>";
			return $html;
		}

		function get_album_by_menu ( $menuid ){
			$html = '';
			$i=0;
			$query = "SELECT * FROM `$this->table_menu` WHERE `id` in ($menuid) AND `locked` = 'no' ORDER BY `name` ASC";
			$result = $this->db->query( $query );
			while( $rows = $this->db->fetch_array( $result ) ){
				$i++;
				if($i==1){ 
					$sep = ''; 
				}else { 
					$sep = ' / ';
				}
				$html.= $sep . '<a href="'.VIEW_BASE_URL.'/album/category/'.$rows['url'].'" title="'.stripcslashes($rows['name']).'">'.stripcslashes($rows['name']).'</a>';
			}
			return $html;
		}

		/* #Fetch Category Row By name */
		public function get_cat_by_name ( $name ) {
			$name = trim ( $this->smart_url( $name ) );
			$query="select * from `$this->table_menu` where `url`='$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		/* #Fetch Album Row By name */
		public function get_album_by_name ( $name ) {
			$name = trim ( $this->smart_url( $name ) );
			$query="select * from `$this->table_allbum` where `url_str`='$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_album_by_old_name ( $name ) {
			$name = trim ( $name );
			$query="select * from `$this->table_allbum` where `old_url`='$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		/* #Fetch Album Row By name */
		public function get_photo_by_name ( $name ) {
			$name = trim ( $this->smart_url( $name ) );
			$query="select * from `$this->table_allbums_photos` where `url_str`='$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_photo_by_old_name ( $name ) {
			$name = trim ( $name );
			$query="select * from `$this->table_allbums_photos` where `old_url` = '$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		function get_album_category ( $id ){
			$query = "SELECT `name` FROM `$this->table_menu` WHERE `id` = '$id' AND `locked` = 'no'";
			$result = $this->db->query( $query );
			$rows = $this->db->fetch_array( $result );
			return $rows['name'];
		}

		function get_personalities(){
			$array = array();
			$result = $this->db->query("SELECT `id`, `name` FROM `$this->table_personality` ORDER BY `name` ASC");
			while( $rows = $this->db->fetch_array( $result ) ){
				$array[] = $rows;
			}
			return $array;
		}

		function person_permalink ($id){
			$arr = $this->get_personality_name($id);
			$url = $arr['url'];
			return $url;
		}

		function get_personality_name($id){
			if($id!=0){
				$result = $this->db->query("SELECT `id`, `name`, `url` FROM `$this->table_personality` where `id` = '$id'");
				$row = $this->db->fetch_array( $result );
				return $row;
			}
		}

		function get_all_categories( $range ){
			$topics = array();
			$html = "";
			$menu_query = "select `menu_id` from `$this->table_allbum` group by `menu_id`";
			$menu_result = $this->db->query( $menu_query );
			if( $this->db->num_rows($menu_result) != 0){
				while( $menu_rows = $this->db->fetch_array( $menu_result ) ){
					$topics[] = $menu_rows['menu_id'];
				}
				$ids = implode( ',', $topics );
	
				foreach ( $range as $char){
					$query = "select * from `$this->table_menu` where `id` in ($ids) and `name` LIKE '$char%' ORDER BY `name` ASC";
					$result = $this->db->query( $query );
					if( $this->db->num_rows( $result ) < 1 ) continue;
					$html .= '<div class="categories-box">';
						$html .= '<h5>'.$char.'</h5>';
						$html .= '<ul>';
							while( $row = $this->db->fetch_assoc( $result ) ){
								$html.='<li>';
									$html.='<h6>';
										$html.='&rarr; <a href="'.VIEW_BASE_URL.'/album/category/'.$row['url'].'">'.stripcslashes($row['name']).'</a>';
									$html.='</h6>';
								$html.="</li>";
							}
						$html.="</ul>";
					$html.="</div>";
				}
			}
			return $html;
		}

		function get_albums_name ( $range ){
			$html = "";
			foreach ( $range as $char){
				$query = "select `name`, `url` from `$this->table_allbum` where `locked` = 'no' and total_file > 0 and `name` LIKE '$char%' ORDER BY `name` ASC";
				$result = $this->db->query( $query );
				if( $this->db->num_rows( $result ) < 1 ) continue;
				$html .= '<div class="categories-box">';
					$html .= '<h5>'.$char.'</h5>';
					$html .= '<ul>';
						while( $row = $this->db->fetch_assoc( $result ) ){
							$html.='<li>';
								$html.='<h6>';
									$html.='&rarr; <a href="'.$row['url'].'">'.stripcslashes($row['name']).'</a>';
								$html.='</h6>';
							$html.="</li>";
						}
					$html.="</ul>";
				$html.="</div>";
			}
			return $html;
		}

		function get_allbum_categories_list( $xml = false ){
			$topics = array();
			$html = "";
			$menu_query = "select `menu_id` from `$this->table_allbum` group by `menu_id`";
			$menu_result = $this->db->query( $menu_query );
			while( $menu_rows = $this->db->fetch_array( $menu_result ) ){
				$topics[] = $menu_rows['menu_id'];
			}
			$ids = implode( ',', $topics );
			if( $xml == true ){
				$query = "select * from `$this->table_menu` where `id` in ($ids) ORDER BY `name` ASC";
				$result = $this->db->query( $query );
				if( $this->db->num_rows( $result ) < 1 ) continue;
				while( $row = $this->db->fetch_assoc( $result ) ){
					$html .= "<url>";
						$html .= "<loc>".VIEW_BASE_URL.'/album/category/'.$row['url']."</loc>";
						$html .= "<priority>0.8</priority>";
					$html .= "</url>";
				}
			}else{
				foreach ( $range as $char){
					$query = "select * from `$this->table_menu` where `id` in ($ids) and `name` LIKE '$char%' ORDER BY `name` ASC";
					$result = $this->db->query( $query );
					if( $this->db->num_rows( $result ) < 1 ) continue;
					$html .= '<div class="categories-box">';
						$html .= '<h5>'.$char.'</h5>';
						$html .= '<ul>';
							while( $row = $this->db->fetch_assoc( $result ) ){
								$html.='<li>';
									$html.='<h6>';
										$html.='&rarr; <a href="'.VIEW_BASE_URL.'/album/category/'.$row['url'].'">'.stripcslashes($row['name']).'</a>';
									$html.='</h6>';
								$html.="</li>";
							}
						$html.="</ul>";
					$html.="</div>";
				}
			}
			return $html;
		}

		function get_allbum_categories ( ){
			$topics = array();
			$new_array = array();
			$menu_query = "select `menu_id` from `$this->table_allbum` where locked = 'no' group by `menu_id`";
			$menu_result = $this->db->query( $menu_query );
			while( $menu_rows = $this->db->fetch_array( $menu_result ) ){
				$topics[] = $menu_rows['menu_id'];
			}
			$ids = implode( ',', $topics );
			$query = "select * from `$this->table_menu` where `id` in ($ids) ORDER BY `name` ASC";
			$result = $this->db->query( $query );
			if( $this->db->num_rows( $result ) < 1 ) continue;
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		/*-------------Helper Function--------------------*/

		function smart_url($str) {
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			return $clean;
		}		

		private function photos_permalink( $name){
			$name = $this->smart_url( $name );
			$url = BASE_URL . "photo/" . $name;
			return $url;
		}

		private function album_permalink( $name ){
			$name = $this->smart_url( $name );
			$url = BASE_URL . "album/" . $name;
			return $url;
		}
	} $albuM = new PhotoAlbum( $db );
?>