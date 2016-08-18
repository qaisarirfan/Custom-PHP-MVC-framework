<?php
	class Category{
		private $db;
		public $msg;
		public $table_prefix = DB_PREFIX;
		public $table_posts = "posts";
		public $table_videos = "videos";
		public $table_categories = "categories";
		public $table_sub_categories ="sub_categories";
		
		function __construct( $db ){
			$this->db = $db;
		}


		function folder_path(){
			return SITE_PATH . POST_PIC;
		}

		
		function get_error_msg(){
			return $this->msg;
		}


		function categories ( $range, $edit ){
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$html = "";
			foreach ( $range as $char){
				$query = "SELECT * FROM `$c_table` WHERE `name` LIKE '$char%' ORDER BY `name` ASC";
				$result = $this->db->query( $query );
				if( $this->db->num_rows($result)<1) continue;
				$html .= '<div class="categories-box">';
					$html .= '<h5>'.$char.'</h5>';
					$html .= '<ul>';
						while( $row = $this->db->fetch_array( $result ) ){
							$html .= '<li>';
								if($edit == 'edit-link'){
									$html .= '<h6><a href="categories.php?name='.$row['name'].'">' . $this->db->stripcslashe ( $row['name'] ).'</a>';
								}elseif( $edit == 'only-link' ){
									$html .= '<h6><a href="'.VIEW_BASE_URL.'/blog?topics='.$row['id'].'">' . $this->db->stripcslashe ( $row['name'] ).'</a><h6>';
								}else{
									$html .= '<h6>' . $this->db->stripcslashe ( $row['name'] );
								}
	
									if( $edit == 'edit-yes' ){
										$html .= '<ol>';
											$html .= '<li><a href="categories.php?action=add-sub-cat&amp;pcid='.$row['id'].'">Add Subcategory</a></li>';
											$html .= '<li>|</li>';
											$html .= '<li><a href="categories.php?action=pc-edit&amp;pcid='.$row['id'].'">Edit</a></li>';
											$html .= '<li>|</li>';
											$html .= '<li><a href="javascript:void(0);" onclick="del_category(\''.$row['id'].'\',\''.$row['name'].'\');">Delete</a></li>';
										$html .= '</ol>';
									}
								$html .= '</h6>';
								$html .= '<div class="clear">&nbsp;</div>';
								$html .= '<ul>';
									$query = "SELECT * FROM `$sc_table` WHERE $adminid `categories_id` = '$row[id]' ORDER BY `name` ASC";
									$subresult = $this->db->query( $query );
									if( $this->db->num_rows($subresult)<1) continue;
									while( $subrow = $this->db->fetch_array( $subresult ) ){
										if($edit == 'edit-link'){
											$html .= '<li>&ndash;&nbsp;<a href="categories.php?name='.$row['name'].'&amp;sname='.$subrow['name'].'">' . $this->db->stripcslashe ( $subrow['name'] ).'</a>';
										}else{
											$html .= '<li>&ndash;&nbsp;' . $this->db->stripcslashe ( $subrow['name'] );
										}
											if( $edit == 'edit-yes' ){
												$html .= '<ol>';
													$html .= '<li><a href="categories.php?action=edit-sub-cat&amp;pcid='.$row['id'].'&amp;pscid='.$subrow['id'].'">Edit</a></li>';
													$html .= '<li>|</li>';
													$html .= '<li><a href="javascript:void(0);" onclick="del_sub_category(\''.$subrow['id'].'\',\''.$subrow['name'].'\');">Delete</a></li>';
												$html .= '</ol>';
											}
											$html .= '<div class="clear">&nbsp;</div>';
										$html .= '</li>';
									}
								$html .= '</ul>';
							$html .= '</li>';
						}
					$html .= '</ul>';
				$html .= '</div>';
			}
			return $html;
		}

		public function category_by_id( $id ){
			$table = $this->table_prefix . $this->table_categories;
			$query = "select * from `$table` where id='$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function sub_cat_by_id( $id ){
			$table = $this->table_prefix . $this->table_sub_categories;
			$query = "select * from `$table` where id='$id'";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_category(){
			$table = $this->table_prefix . $this->table_categories;
			$category = array();
			$query = "select * from `$table` order by `name`";
			$result = $this->db->query( $query );
			while( $rows = $this->db->fetch_assoc( $result ) ){
				$category[] = $rows;
			}
			return $category;
		}

		public function add_category( $name ){
			$table = $this->table_prefix . $this->table_categories;
			$new_array = array();
			$name = check_slashes( trim( $name ) );
			$url = $this->smart_url( $name );

			// check exists row.
			$count = $this->db->count_rows_by_query("SELECT * FROM $table WHERE name='$name'");
			if( $count ){
				return false;
			}else{
				$new_array['name'] = $name;
				$new_array['url'] = $url;

				$result = $this->db->insert( $new_array, $table );
				return true;
			}

		}

		public function update_category($name, $id){
			$table = $this->table_prefix . $this->table_categories;
			$new_array = array();
			$name = check_slashes( trim( $name ) );
			$url = $this->smart_url( $name );

			// check exists row.
			$count = $this->db->count_rows_by_query("SELECT * FROM $table WHERE name='$name'");
			if($count){
				return false;
			}else{
				$new_array['name'] = $name;
				$new_array['url'] = $url;

				$result = $this->db->update( $new_array, $id, $table ); 
				return true;
			}
		}

		function delete_category( $id ){
			$p_table = $this->table_prefix . $this->table_posts;
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;

			$p_query = "SELECT `category` FROM `$p_table` WHERE `category` = '$id' AND `post_status` = 'publish'";
			$postcount = $this->db->count_rows_by_query( $p_query );

			$v_query = "SELECT `category` FROM `$v_table` WHERE `category` = '$id' AND `video_status` = 'publish'";
			$videocount = $this->db->count_rows_by_query( $v_query );

			if ( ($postcount == 0) && ($videocount == 0) ){
				$query = "SELECT `categories_id` FROM `$sc_table` WHERE `categories_id` = '$id'";
				$count = $this->db->count_rows_by_query( $query );
				if( $count == 0 ){
					$query = "delete from `$c_table` where `id` = '$id'";
					$result = $this->db->query( $query );
					@header('location:categories.php?msg=Category delete successfully.&type=success');
				}else{
					@header('location:categories.php?msg=You subcategory delete first for delete category.&type=information');
				}
			}else{
				$use = ''	;
				if( $postcount != 0 ){
					$use .= "Post($postcount), ";
				}
				if( $videocount != 0 ){
					$use .= "Video($videocount)";
				}
				@header('location:categories.php?msg=In this category you have '.$use.' please check these post and try again.&type=error');
			}
		}

		public function add_sub_category( $arr ){
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$new_array = array();
			$parentid = intval( $arr['pcid'] );
			$name = check_slashes( trim( $arr['name'] ) );
			$url = $this->smart_url( $name );

			// check exists row.
			$count = $this->db->count_rows_by_query("SELECT * FROM $sc_table WHERE name='$name'");
			if( $count ){
				@header('location:categories.php?msg=Sub Category already exists.&type=attention');
			}else{
				$new_array['categories_id'] = $parentid;
				$new_array['name'] = $name;
				$new_array['url'] = $url;

				$result = $this->db->insert( $new_array, $sc_table );
				@header('location:categories.php?msg=Sub Category add successfuly.&type=success');
			}
		}

		public function update_sub_category( $arr ){
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$new_array = array();
			$parentid = intval( $arr['pcid'] );
			$id = intval( $arr['pscid'] );
			$name = check_slashes( trim( $arr['name'] ) );
			$url = $this->smart_url( $name );

			$count = $this->db->count_rows_by_query("SELECT * FROM `$sc_table` WHERE `name` = '$name'");
			if($count){
				@header('location:categories.php?msg=Category already exists.&type=attention');
			}else{
				$new_array['categories_id'] = $parentid;
				$new_array['name'] = $name;
				$new_array['url'] = $url;

				$result = $this->db->update( $new_array, $id, $sc_table ); 
				@header('location:categories.php?msg=Category update successfuly.&type=success');
			}
		}

		function delete_sub_category( $id ){
			$p_table = $this->table_prefix . $this->table_posts;
			$v_table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;

			$p_query = "SELECT `sub_category` FROM `$p_table` WHERE `sub_category` = '$id' AND `post_status` = 'publish'";
			$postcount = $this->db->count_rows_by_query( $p_query );

			$v_query = "SELECT `sub_category` FROM `$v_table` WHERE `sub_category` = '$id' AND `video_status` = 'publish'";
			$videocount = $this->db->count_rows_by_query( $v_query );

			if ( ($postcount == 0) && ($videocount == 0) ){
				$query = "delete from `$sc_table` where `id` = '$id'";
				$result = $this->db->query( $query );
				if( $result ){
					@header('location:categories.php?msg=Your subcategory was deleted successfully.&type=success');
				}else{
					@header('location:categories.php?msg=Your subcategory not deleted successfully please try again.&type=error');
				}
			}else{
				$use = ''	;
				if( $postcount != 0 ){
					$use .= "Post($postcount), ";
				}
				if( $videocount != 0 ){
					$use .= "Video($videocount)";
				}
				@header('location:categories.php?msg=In this subcategory you have '.$use.' post please check these post and try again.&type=error');
			}
		}

		public function get_sub_category( $parentid = "" ){
			$table = $this->table_prefix . $this->table_sub_categories;
			if( $parentid != '' )
				$where = "where categories_id='$parentid'";
			else
				$where="";
			$category = array();
			$query = "select * from `$table` $where order by `name`";
			$result=$this->db->query( $query );
			while( $rows = $this->db->fetch_assoc( $result ) ){
				$category[] = $rows;
			}
			return $category;
		}

		function get_category_list( $page, $type, $xml = false ){
			if( $type == 'post' ){
				$table = $this->table_prefix . $this->table_posts;
			}elseif( $type == 'video' ){
				$table = $this->table_prefix . $this->table_videos;
			}
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;
			$html = "";
			$p_array = array();
			$p_query = "select `category` from `$table` where `".$type."_status` = 'publish' group by `category`";
			$p_result = $this->db->query( $p_query );
			$this->db->num_rows($p_result);
			if( $this->db->num_rows($p_result) != 0){
				while( $p_row = $this->db->fetch_assoc( $p_result ) ){
					$p_array[] = $p_row['category'];
				}
				$p_cat = implode(',',$p_array);

				$ps_array = array();
				$ps_query = "select `sub_category` from `$table` where `".$type."_status` = 'publish' group by `sub_category`";
				$ps_result = $this->db->query( $ps_query );
				while( $ps_row = $this->db->fetch_assoc( $ps_result ) ){
					$ps_array[] = $ps_row['sub_category'];
				}
				$ps_cat = implode(',',$ps_array);
	
				$query = "select * from `$c_table` where `id` in ($p_cat) order by `name` asc";
				$p_result = $this->db->query($query);
					if( $xml == false ){
						$html .= '<ul>';
					}
					while( $row = $this->db->fetch_assoc( $p_result ) ){
						if( $xml == true ){
							$html.='<url>';
								$html.='<loc>'.BASE_URL.$page.'/topics/'.$row['url'].'</loc>';
							$html.='</url>';
						}else{
							$html.='<li><a href="'.BASE_URL.$page.'/topics/'.$row['url'].'">'.stripcslashes($row['name']).'</a>';
						}
						if ( $ps_cat ){
							$query="select * from `$sc_table` where `categories_id` = '$row[id]' and `id` in ($ps_cat) order by `name` asc";
							if($this->db->count_rows_by_query($query)){
								if( $xml == false ){
									$html .= '<ul>';
								}

								$sresult=$this->db->query($query);
								while($srow=$this->db->fetch_assoc($sresult)){
									if( $xml == true ){
										$html.='<url>';
											$html.='<loc>'.BASE_URL.$page.'/topics/'.$row['url'].'/categories/'.$srow['url'].'</loc>';
										$html.='</url>';
									}else{
										$html.='<li><a href="'.BASE_URL.$page.'/topics/'.$row['url'].'/categories/'.$srow['url'].'">'.stripcslashes($srow['name']).'</a></li>';
									}
								}
								if( $xml == false ){
									$html .= '/<ul>';
								}

							}
						}
						if( $xml == false ){
							$html .= '</li>';
						}

					}
				if( $xml == false ){
					$html .= '</ul>';
				}
			}
			return $html;
		}

		public function get_menu_category_list(){
			$table = $this->table_prefix . $this->table_videos;
			$c_table = $this->table_prefix . $this->table_categories;
			$sc_table = $this->table_prefix . $this->table_sub_categories;

			$html = "";
			$p_array = array();
			$p_query = "select `category` from `$table` where `video_status` = 'publish' group by `category`";
			$p_result = $this->db->query( $p_query );
			if( $this->db->num_rows($p_result) != 0){
				while( $p_row = $this->db->fetch_assoc( $p_result ) ){
					$p_array[] = $p_row['category'];
				}
				$p_cat = implode(',',$p_array);

				$ps_array = array();
				$ps_query = "select `sub_category` from `$table` where `video_status` = 'publish' group by `sub_category`";
				$ps_result = $this->db->query( $ps_query );
				while( $ps_row = $this->db->fetch_assoc( $ps_result ) ){
					$ps_array[] = $ps_row['sub_category'];
				}
				$ps_cat = implode(',',$ps_array);

				$query = "select * from `$c_table` where `id` in ($p_cat) order by `name` asc";
				$p_result = $this->db->query($query);
				while( $row = $this->db->fetch_assoc( $p_result ) ){
					$html.='<li><a href="'.BASE_URL.'videos/topics/'.$row['url'].'">'.stripcslashes($row['name']).'</a>';
					if ( $ps_cat ){
						$query="select * from `$sc_table` where `categories_id` = '$row[id]' and `id` in ($ps_cat) order by `name` asc";
						if($this->db->count_rows_by_query($query)){
							$html.="<ul>";
							$sresult=$this->db->query($query);
							while($srow=$this->db->fetch_assoc($sresult)){
								$html.='<li><a href="'.BASE_URL.'videos/topics/'.$row['url'].'/categories/'.$srow['url'].'">'.stripcslashes($srow['name']).'</a></li>';
							}
							$html.="</ul>";
						}
					}
					$html.="</li>";
				}
			}
			return $html;
		}

		public function get_cat_by_name ( $name ) {
			$table = $this->table_prefix . $this->table_categories;
			$name = $this->smart_url( trim ( $name ) );
			$query="select * from `$table` where `url`='$name'";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		public function get_sub_cat_by_name ( $topics, $categories ) {
			$table = $this->table_prefix . $this->table_sub_categories;
			$topics = $this->smart_url( trim( $topics ) );
			$categories = $this->smart_url( trim( $categories ) );
			$parentid = $this->get_cat_by_name( $topics );
			$query="select * from `$table` where `url`='$categories' and `categories_id` = '$parentid[id]' ";
			$result = $this->db->query( $query );
			$row = $this->db->fetch_assoc( $result );
			return $row;
		}

		private function smart_url($str) {
			$clean = preg_replace( "/[^a-zA-Z0-9\/_|+ -]/", '', $str );
			$clean = strtolower( trim( $clean, '-' ) );
			$clean = preg_replace( "/[\/_|+ -]+/", '-', $clean );
			return $clean;
		}		
	}

	$cate = new Category( $db );
?>