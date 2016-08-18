<?php
	class Database{
		
		var $error_msg = "";
		var $db_user = USERNAME;
		var $db_password = PASSWORD;
		var $db_name = DBNAME;
		var $connection;

		function __construct(){
			$this->connection = mysql_connect("localhost",$this->db_user,$this->db_password);
			if(!$this->connection){
				die("Error in connection to the database server");
			}
			mysql_select_db($this->db_name) or die("Error opening database");			
		}

		function query($query){
			$result=mysql_query($query);
			if(!$result){
				$this->err_msg = '<div style="border:dashed 1px #ff0000; background:#ffffcc; padding:10px; margin:5px; color:#ff0000">'.mysql_error().'<br><br>'.$query.'</div>';
				$error = mysql_error()."\r\n-->\r\n".$query;
				$this->write($error);
				return false;
			}else{
				return $result;
			}
		}

		function check_field($table,$array){
			$result = $this->query("SHOW COLUMNS FROM `$table`");
			while ($row = mysql_fetch_assoc($result))
			{
			    $resultset[] = $row['Field'];
			}
			for ($i=0; $i<count($resultset); $i++){
				if($resultset[$i]==$array[$i]){
					echo $resultset[$i]."==".$array[$i];
				}
			}
		}

		function stripcslashe ( $str ){
			return stripcslashes( $str );
		}
		function fetch_array($result){
			return mysql_fetch_array($result);
		}

		function fetch_row($result){
			return mysql_fetch_row($result);
		}

		function fetch_assoc($result){
			return mysql_fetch_assoc($result);
		}


		function num_rows($result){
			return mysql_num_rows($result);
		}

		function count_rows($result){
			return mysql_num_rows($result);
		}

		function fetch_array_by_query($query){
			$result=$this->query($query);
			return mysql_fetch_array($result);
		}

		function fetch_assoc_by_query($query){
			$result=$this->query($query);
			return mysql_fetch_assoc($result);
		}

		function count_rows_by_query($query){
			$result=$this->query($query);
			return mysql_num_rows($result);
		}

		function get_insert_id(){
			return intval(mysql_insert_id());
		}

		function insert_id(){
			return intval(mysql_insert_id());
		}

		function insert( $arr, $table_name ){
			$cols = implode( "`, `", array_keys( $arr ) );
			$cols = "`" . $cols . "`";
			$values = implode( "', '", $arr );
			$values = "'" . $values . "'";
			$query = "INSERT INTO `$table_name` ( $cols ) VALUES ( $values )";
			$result = $this->query( $query );
			if( $result ){
				return $this->insert_id();
			}else{
				return false;
			}
		}

		function update( $arr, $id, $table_name ){
			$q = '';
			foreach( $arr as $key => $value ){
				if( $q == '' )
					$q .= "`$key` = '$value'";
				else
					$q .= ", `$key` = '$value'";
			}
			$query = "UPDATE `$table_name` SET $q WHERE `id` = '$id'";
			$result = $this->query( $query );
			return $result;
		}

		function update_custom_field ( $table_name, $field, $arr, $val ) {
			$q = '';
			foreach( $arr as $key => $value ){
				if( $q == '' )
					$q .= "`$key` = '$value'";
				else
					$q .= ", `$key` = '$value'";
			}
			$query = "UPDATE `$table_name` SET $q WHERE `$field` = '$val'";
			$result = $this->query( $query );
			return $result;
		}

		function delete ( $id, $table_name ){
			$query = "DELETE FROM `$table_name` WHERE `id` = '$id'";
			$result = $this->query( $query );
			return $result;
		}

		function get_row( $table_name, $field, $field_value ){
			$query = "SELECT * FROM `$table_name` WHERE $field = '$field_value'";
			$row = $this->query( $query );
			$result = $this->fetch_assoc( $row );
			return $result;
		}

		function fetch ( $start = 0, $total = 0, $table_name, $locked, $order = '' ){
			$query = "SELECT * FROM `$table_name`";
			if( $locked == 'no' ){
				$query .= " WHERE `locked` = 'no'";
			}else{
				$query .= " WHERE `locked` = 'yes'";
			}
			if( $order != '' ){
				$query .= " ORDER BY $order DESC";
			}
			if( !$total == 0 ){
				$query .= " LIMIT $start, $total";
			}
			$result = $this->query( $query );
			$data = array();
			while( $row = $this->fetch_assoc( $result) ){
				$data[] = $row;
			}
			return $data;
		}

		function real_escape_string( $string ){
			$string = mysql_real_escape_string( $string );
			return $string;
		}


		function get_error(){
			return $this->err_msg;
		}

		public function write($message) {
			$path = SITE_PATH.'/query-error-logs/';
			$date = new DateTime();
			$log = $path . $date->format('Y-m-d').".txt";
			$page=$_SERVER['SCRIPT_FILENAME'];
			$ip = $_SERVER['REMOTE_ADDR'];

			if(is_dir($path)) {
				if(!file_exists($log)) {
					$fh = fopen($log, 'a+') or die("Fatal Error !");
					$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n";
					$at = "at $page $ip\r\n\r\n";
					fwrite($fh, $logcontent);
					fwrite($fh, $at);
					fclose($fh);
				} else {
					$this->edit($log,$date, $message);
				}
			} else {
				  if(mkdir($path,0777) === true) 
				  {
					 $this->write($message);  
				  }	
			}
		 }

		private function edit($log,$date,$message) {
			$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n\r\n";
			$logcontent = $logcontent . file_get_contents($log);
			$at = "at $page $ip\r\n\r\n";
			$logcontent = $at . file_get_contents($log);
			file_put_contents($log, $logcontent);
		}

		function error_logs($error){
			$path=SITE_PATH.'/logs/error_log.txt';die();
			$time=date("g:i A, d-M-Y",time());
			$page=$_SERVER['SCRIPT_FILENAME'];
			$ip = $_SERVER['REMOTE_ADDR'];
			if($error!=''){
				$error_logs=fopen($path,'a+');
				if($error_logs){
					fputs($error_logs,"$time-->--at-->--$page-->--$ip\r\n\r\n");
					fputs($error_logs,$error."\r\n");
					fputs($error_logs,"\r\n========================================\r\n\r\n");
				}
			}
		}
		
		function __destruct() {
			mysql_close($this->connection);
		}
	}
	$db = new Database();
?>