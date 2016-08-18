<?php
	class Members{
		var $table_prefix = DB_PREFIX;
		var $table_admin = "admin";
		private $session;
		private $db;
		private $msg;
	
		/*
**************************there is private set function to get data.*******************************
		*/
		public function __construct( $db ){
			$this->db = $db;
		}

		public function msg(){
			return $this->msg;
		}

		public function login($table, $username, $password){
			$query = "SELECT * FROM `$this->table_prefix$table` WHERE ( `username` = '$username' OR `email` = '$username' ) AND `PASSWORD` = '$password' AND `locked` = 'no'";
			$result = $this->db->query( $query );
			$count = $this->db->count_rows( $result );
			if( $count ){
				$row = $this->db->fetch_assoc( $result );
				return $row;
			}else{
				return false;
			}
		}

		/**/
		public function get_row($table, $id){
			$result=$this->db->query("select * from `$table` where `id` = '$id'");
			$member_row=$this->db->fetch_assoc($result);
			return $member_row;
		}
		/**/
		public function update_login( $table, $id, $islogin, $auto_logout ){
			$t = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			$result = $this->db->query( "UPDATE `$this->table_prefix$table` SET `total_login` = total_login+1, `last_login` = '$t', `ip` = '$ip', `auto_logout` = '$auto_logout' WHERE `id` = '$id'" );
		}
		/**/

		/*#########################
			General section     ->
		#########################*/

		public function get_rows($table){
			$rows=array();
			$query="SELECT * FROM $table";
			$result=$this->db->query($query);
			while($fetch=$this->db->fetch_array($result)){
				$rows[]=$fetch;
			}
			return $rows;
		}
		
		/**/

	
		
		/**/
		public function delete_rows_by_id($table, $field, $value){
			$query="DELETE FROM $table WHERE $field='$value'";
			if($result=$this->db->query($query)){
				@header("location:admin-members.php?msg=Profile is delete successful&type=success");
			}else{
				@header("location:admin-members.php?msg=Profile isn\'t delete&type=error");
			}
			return $result;
		}
		

		/*#########################
			admin member section     ->
		#########################*/

		public function add_admin_member($arr){
			$new_array = array();
			$new_array['username'] = $arr['username'];
			$new_array['email'] = $arr['email'];
			$new_array['password'] = $arr['password'];
			$new_array['firstname'] = $arr['firstname'];
			$new_array['lastname'] = $arr['lastname'];
			$new_array['m_type'] = $arr['m_type'];
			$new_array['date_created'] = time();
			$new_array['locked'] = 'no';

			if(!$count=$this->db->count_rows_by_query("SELECT * FROM admin WHERE username = '$username' OR email = '$email'")){
				$result = $this->db->insert( $new_array, $this->table_admin );
				if( $result ){
					@header("location:admin-members.php?msg=Profile is save successful&type=success");
				}else{
					@header("location:admin-members.php?msg=Profile isn\'t save&type=error");
				}
			}else{
				@header("location:add-admin-members.php?msg=Profile already exists&type=attention");
			}
		}
		
		public function update_admin_member($arr){
			$new_array = array();
			$id = intval( $arr['id'] );
			$new_array['username'] = $arr['username'];
			$new_array['email'] = $arr['email'];
			$new_array['password'] = $arr['password'];
			$new_array['firstname'] = $arr['firstname'];
			$new_array['lastname'] = $arr['lastname'];
			$new_array['m_type'] = $arr['m_type'];
			$new_array['locked'] = $arr['locked'];

			$result = $this->db->update( $new_array, $id, $this->table_admin );

			if( $result ){
				@header("location:admin-members.php?msg=Profile is update successful&type=success");
			}else{
				@header("location:admin-members.php?msg=Profile isn\'t update&type=error");				
			}

		}

		public function update_member_profile( $arr ){
			$new_array = array();

			$id = intval( $arr['m_id'] );
			$new_array['username'] = $arr['username'];
			$new_array['firstname'] = $arr['firstname'];
			$new_array['lastname'] = $arr['lastname'];
			$new_array['email'] = $arr['email'];
				
			$result = $this->db->update( $new_array, $id, $this->table_admin );

			if( $result ){
				@header("location:members.php?msg=Profile is update successful&type=success");
			}else{
				@header("location:members.php?msg=Profile isn\'t update&type=error");				
			}
		}

		public function delete_admin_member( $id ){
			$query = "DELETE FROM `$this->table_admin` WHERE `id` = '$id'";
			$ap_result = $this->db->query("DELETE FROM `$this->table_admin_permissions` WHERE `m_id` = '$id'");
			if( $ap_result ){
				$result = $this->db->query( $query );
				if( $result ){
					@header("location:admin-members.php?msg=Profile is delete successful&type=success");
				}else{
					@header("location:admin-members.php?msg=Profile isn\'t delete&type=error");
				}
			}
		}

		public function get_admin_rows_by_id( $id ){
			$query="SELECT * FROM $this->table_admin WHERE `id` = '$id'";
			$result=$this->db->query($query);
			$fetch=$this->db->fetch_assoc($result);
			return $fetch;
		}

		public function get_admin( ){
			$new_array = array();
			$query="select * from `$this->table_admin` ORDER BY `username` ASC";
			$result = $this->db->query($query);
			while ( $row = $this->db->fetch_assoc($result)){
				$new_array[] = $row;
			}
			return $new_array;
		}

		/**/
		public function get_admin_login($arr){
			$query="select * from admin where username='{$arr[username]}' and password='{$arr[password]}'";
			$result=$this->db->count_rows_by_query($query);
			if($result){
				$row=$this->db->fetch_array_by_query($query);
				$t=time();
				$id=intval($row['id']);
				$ip=$_SERVER['REMOTE_ADDR'];
				$type=intval($arr['utype']);
				$type=$type*10/3+7;
				if($type==7){
					$this->get_session($id, $_REQUEST['redirect_url']);
					$this->db->query("update admin set total_login=total_login+1, last_login='$t', ip='$ip' where id='$id'");
				}else{
					@header("location:login.php?utype=0&msg=Your username or password is Invalid!&type=error");
					exit();
				}
				if($_REQUEST['redirect_url']>0){
					header("location:".$_REQUEST['redirect_url']);
					exit();
				}else{
					@header("location:deshbroad.php");
					exit();
				}
			}else{
				@header("location:login.php?utype=0&msg=Your username or password is Invalid!&type=error");
				exit();
			}
		}
		
		/*#########################
			admin permission section   ->
		#########################*/

		public function get_permissions_rows_by_id( $id ){
			$query="SELECT * FROM $this->table_admin_permissions WHERE `m_id` = '$id'";
			$result=$this->db->query($query);
			$fetch=$this->db->fetch_assoc($result);
			return $fetch;
		}

		public function permission($arr){
			$query = "select * from admin_permissions where m_id='$arr[id]'";
			if($count = $this->db->count_rows_by_query($query)){
				return $this->update_permission($arr);
			}else{
				return $this->add_permission($arr);
			}
		}
		
		private function add_permission($arr){
			$permissions = array(
				"m_id" => intval($arr['id']),
				
				"allbum" => $arr['allbum'], 
				"allbum_add" => $arr['allbum_add'], 
				"allbum_edit" => $arr['allbum_edit'], 
				"allbum_del" => $arr['allbum_del'],
				
				"photo" => $arr['photo'], 
				"photo_add" => $arr['photo_add'], 
				"photo_edit" => $arr['photo_edit'], 
				"photo_del" => $arr['photo_del'],
				
				"page" => $arr['page'], 
				"page_add" => $arr['page_add'], 
				"page_edit" => $arr['page_edit'], 
				"page_del" => $arr['page_del'],
				
				"post" => $arr['post'], 
				"post_add" => $arr['post_add'], 
				"post_edit" => $arr['post_edit'], 
				"post_del" => $arr['post_del'],
				
				"admin" => $arr['admin'], 
				"admin_permission" => $arr['admin_permission'], 
				"admin_add" => $arr['admin_add'], 
				"admin_edit" => $arr['admin_edit'], 
				"admin_del" => $arr['admin_del'],
				
				"slider" => $arr['slider'], 
				"slider_add" => $arr['slider_add'], 
				"slider_edit" => $arr['slider_edit'],
				"slider_del" => $arr['slider_del'],
				
				"menu" => $arr['menu'], 
				"menu_add" => $arr['menu_add'], 
				"menu_edit" => $arr['menu_edit'], 
				"menu_del" => $arr['menu_del'],
				
				"preferences" => $arr['preferences'], 
				"stats" => $arr['stats'], 
				"profile" => $arr['profile'],
				
				"video" => $arr['video'], 
				"video_add" => $arr['video_add'], 
				"video_edit" => $arr['video_edit'], 
				"video_del" => $arr['video_del'],
				
				"web_customize" => $arr['web_customize'],
				
				"personality" => $arr['personality'], 
				"personality_add" => $arr['personality_add'], 
				"personality_edit" => $arr['personality_edit'], 
				"personality_del" => $arr['personality_del'],
				
				"movies" => $arr['movies'], 
				"movie_add" => $arr['movie_add'], 
				"movie_edit" => $arr['movie_edit'], 
				"movie_delete" => $arr['movie_delete']
			);
			
			$result = $this->db->insert( $permissions, $this->table_admin_permissions );
			
			if($result){
				@header("location:admin-permissions.php?id=$arr[id]&msg=Permission Set&type=success");
			}else{
				@header("location:admin-permissions.php?id=$arr[id]&msg=Permission Not Set&type=error");
			}
		}

		private function update_permission( $arr ){
			$m_id = intval($arr['id']);
			$permissions = array(

				"allbum" => $arr['allbum'], 
				"allbum_add" => $arr['allbum_add'], 
				"allbum_edit" => $arr['allbum_edit'], 
				"allbum_del" => $arr['allbum_del'],
				
				"photo" => $arr['photo'], 
				"photo_add" => $arr['photo_add'], 
				"photo_edit" => $arr['photo_edit'], 
				"photo_del" => $arr['photo_del'],
				
				"page" => $arr['page'], 
				"page_add" => $arr['page_add'], 
				"page_edit" => $arr['page_edit'], 
				"page_del" => $arr['page_del'],
				
				"post" => $arr['post'], 
				"post_add" => $arr['post_add'], 
				"post_edit" => $arr['post_edit'], 
				"post_del" => $arr['post_del'],
				
				"admin" => $arr['admin'], 
				"admin_permission" => $arr['admin_permission'], 
				"admin_add" => $arr['admin_add'], 
				"admin_edit" => $arr['admin_edit'], 
				"admin_del" => $arr['admin_del'],
				
				"slider" => $arr['slider'], 
				"slider_add" => $arr['slider_add'], 
				"slider_edit" => $arr['slider_edit'], 
				"slider_del" => $arr['slider_del'],
				
				"menu" => $arr['menu'], 
				"menu_add" => $arr['menu_add'], 
				"menu_edit" => $arr['menu_edit'], 
				"menu_del" => $arr['menu_del'],
				
				"preferences" => $arr['preferences'], 
				"stats" => $arr['stats'], 
				"profile" => $arr['profile'],
				
				"video" => $arr['video'], 
				"video_add" => $arr['video_add'], 
				"video_edit" => $arr['video_edit'], 
				"video_del" => $arr['video_del'],
				
				"web_customize" => $arr['web_customize'],
				
				"personality" => $arr['personality'], 
				"personality_add" => $arr['personality_add'], 
				"personality_edit" => $arr['personality_edit'], 
				"personality_del" => $arr['personality_del'],
				
				"movies" => $arr['movies'], 
				"movie_add" => $arr['movie_add'],
				"movie_edit" => $arr['movie_edit'], 
				"movie_delete" => $arr['movie_delete']
			);
			$result = $this->db->update_custom_field( $this->table_admin_permissions, 'm_id', $permissions, $m_id );
			
			if( $result ){
				@header("location:admin-permissions.php?id=$arr[id]&msg=Permission Set&type=success");
			}else{
				@header("location:admin-permissions.php?id=$arr[id]&msg=Permission Not Set&type=error");
			}
		}

		function get_permission_value( $id ){
			$query = "select * from `$this->table_admin_permissions` where `m_id` = '$id'";
			$result = $this->db->fetch_assoc_by_query( $query );
			return $result;
		}

		function check_permission( $type='', $adminid ){
			if($type=='supper_admin'){
				return $permission=$this->get_permission_value($adminid);
			}elseif($type=='content_writer'){
				return $permission=$this->get_permission_value($adminid);
			}elseif($type=='manager'){
				return $permission=$this->get_permission_value($adminid);
			}elseif($type=='editor'){
				return $permission=$this->get_permission_value($adminid);
			}
		}

		function check_super_user(){
			$count_admin = $this->db->count_rows_by_query("select * from `$this->table_admin` where `m_type` = 'supper_admin'");
			$new_array = array(
				"id" => "1",
				"username" => "admin",
				"email" => "qaisar.irfan.2888@gmail.com",
				"password" => "admin",
				"m_type" => "supper_admin",
				"login_status" => "false",
				"date_created" => time(),
				"locked" => "no"
			);
			if($count_admin == 0){
				$this->db->insert($new_array,'admin');
			}
			$count_admin_permissions = $this->db->count_rows_by_query("select * from admin_permissions where m_id='1'");
			if($count_admin_permissions == 0){
				$permissions = array();
				$permissions['m_id'] = '1';
				$permissions['allbum'] = 'yes';
				$permissions['allbum_add'] = 'yes';
				$permissions['allbum_edit'] = 'yes';
				$permissions['allbum_del'] = 'yes';
				$permissions['photo'] = 'yes';
				$permissions['photo_add'] = 'yes';
				$permissions['photo_edit'] = 'yes';
				$permissions['photo_del'] = 'yes';
				$permissions['page'] = 'yes';
				$permissions['page_add'] = 'yes';
				$permissions['page_edit'] = 'yes';
				$permissions['page_del'] = 'yes';
				$permissions['post'] = 'yes';
				$permissions['post_add'] = 'yes';
				$permissions['post_edit'] = 'yes';
				$permissions['post_del'] = 'yes';
				$permissions['admin'] = 'yes';
				$permissions['admin_permission'] = 'yes';
				$permissions['admin_add'] = 'yes';
				$permissions['admin_edit'] = 'yes';
				$permissions['admin_del'] = 'yes';
				$permissions['slider'] = 'yes';
				$permissions['slider_add'] = 'yes';
				$permissions['slider_edit'] = 'yes';
				$permissions['slider_del'] = 'yes';
				$permissions['menu'] = 'yes';
				$permissions['menu_add'] = 'yes';
				$permissions['menu_edit'] = 'yes';
				$permissions['menu_del'] = 'yes';
				$permissions['preferences'] = 'yes';
				$permissions['stats'] = 'yes';
				$permissions['profile'] = 'yes';
				$permissions['video'] = 'yes';
				$permissions['video_add'] = 'yes';
				$permissions['video_edit'] = 'yes';
				$permissions['video_del'] = 'yes';
				$permissions['web_customize'] = 'yes';
				$permissions['personality'] = 'yes';
				$permissions['personality_add'] = 'yes';
				$permissions['personality_edit'] = 'yes';
				$permissions['personality_del'] = 'yes';
				$permissions['movies'] = 'yes';
				$permissions['movie_add'] = 'yes';
				$permissions['movie_edit'] = 'yes';
				$permissions['movie_delete'] = 'yes';

				$this->db->insert($permissions,'admin_permissions');
			}
		}
		
		function add_newsletter( $arr ){
			$new_array = array();
			$new_array['name'] = $arr['name'];
			$new_array['email'] = $arr['email'];
			
			$query = "select `email` from `$this->table_newsletter` where `email`='$arr[email]'";
			if ( $this->db->count_rows_by_query ($query) == 0 ){
				$this->db->insert( $new_array, $this->table_newsletter );
				echo '<span class="success">Thank you! You are register for newsletter.</span>';
			}else{
				echo '<span class="fail">Your email already exists.</span>';
			}
		}

	}$member=new Members($db);

?>