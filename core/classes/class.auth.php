<?php
	class Authenticate{

		public function __construct(){
			session_start();
			if( $_SESSION['login']['userid'] > 0 ){
				$uid = $_SESSION['login']['userid'];
			}
		}

		public function get_ip(){
			return $_SESSION['login']['ip'] = $_SERVER['REMOTE_ADDR'];
		}

		public function create_session( $userid ){
			$_SESSION['login']['user'] = $userid;
			$_SESSION['login']['start'] = time();
			$_SESSION['login']['expire'] = $_SESSION['login']['start'] + (30*60);
			$this->get_ip();
			return $_SESSION;
		}

		public function authenticate(){
			$userid = $_SESSION['login']['user'];
			$this->update_last_activity('admin',$userid);
			return $userid;
		}

		public function expire_session(){

			$t =	time();
			$time = $_SESSION['login']['expire'] - $_SESSION['login']['start'];
			return $time;

		}

		public function update_last_activity($table, $id){

			$t=time();
			mysql_query("UPDATE $table SET last_activity=$t WHERE id=$id");

		}

		public function get_userid(){
			
			return $_SESSION['login']['user'];

		}

		public function update_login(){

			$userid = $this->get_userid();
			mysql_query("UPDATE admin SET login_status='false' WHERE id='$userid'");

		}

		public function get_logout(){

			unset($_SESSION['login']['user']);

			$_SESSION['redirect']['redirect_url'] = $_SERVER['HTTP_REFERER'];

			@header("location:index.php");

		}

	}

	$auth = new Authenticate();
?>