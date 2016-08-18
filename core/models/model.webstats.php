<?php
	class WebStats{
		private $db;
		public $session_table = STATS_SESSIONS;
		public $page_table = STATS_PAGEVIEWS;
		public $todaydate = '';

		function __construct( $db ){
			$this->db = $db;
		}

		function get_stats_year( $m = 'min' ){

			$query = "SELECT $m(`time`) AS `year` FROM `$this->session_table`";
			$result = $this->db->query( $query );
			$array = $this->db->fetch_assoc( $result );
			return $array['year'];
			
		}

		function get_page_visit( $query ){
			$new_arr=array();
			$result = $this->db->query($query);
			while($row = $this->db->fetch_assoc($result)){
				$new_arr[] = $row;
			}
			return $new_arr;
		}

		function get_country_name( $code ){
			$query = "SELECT `name` FROM `$this->stats_countries` WHERE `code` = '$code'";
			$result = $this->db->query($query);
			$array = $this->db->fetch_assoc($result);
			return $array['name'];
		}

		function get_unique( $column = "" ){
			$query = "SELECT count( DISTINCT ( `$column` ) ) AS total FROM `$this->session_table` WHERE `$column` <> ''";
			$result = $this->db->query($query);
			$array = $this->db->fetch_assoc($result);
			return $array['total'];
		}

		function get_country_list( $query = "", $column = "" ){
			$new_arr = array();
			$html = "";
			$result = $this->db->query($query);
			while($array = $this->db->fetch_assoc($result)){
				$new_arr[$array[$column]] = $array['total'];
			}
			$count = 0;
			foreach( $new_arr as $index => $row ){
				$count++;
				$query = "select count(p.serial) as total from `$this->page_table` p, `$this->session_table` s where s.$column = '$index' and p.session_id=s.serial";
				$page_result = $this->db->query($query);
				$page_array = $this->db->fetch_assoc($page_result);
				
				$query = "select `time` from $this->session_table where `$column` = '$index' order by `time` desc limit 0,1";
				$time_result = $this->db->query($query);
				$time_array = $this->db->fetch_assoc($time_result);
				$html .= "<tr>";
					$html .= '<td>'.$count.'</td>';
					if($column == 'ip'){
						$query = "SELECT `country_code` FROM `$this->session_table` WHERE `ip` = '$index'";
						$country_result = $this->db->query($query);
						$country_array = $this->db->fetch_assoc($country_result);
						$html .= '<td style="text-align:left"><div class="flag flag-'.strtolower($country_array['country_code']).'"></div></td>';
						$html .= '<td style="text-align:left;">'.$this->get_country_name( $country_array['country_code'] ).'</td>';
						$html .= '<td style="text-align:left;">'.$index.'</td>';
					}else{
						$html .= '<td style="text-align:left"><div class="flag flag-'.strtolower($index).'"></div></td>';
						$html .= '<td style="text-align:left;">('.$index.')&nbsp;'.$this->get_country_name( $index ).'</td>';
					}
					$html .= '<td>'.$row.'</td>';
					$html .= '<td>'.intval($page_array['total']).'</td>';
					$html .= '<td>'.date('d-M-Y h:i A',$time_array['time']).'</td>';
				$html .= "</tr>";
			}
			return $html;
		}

		function get_columns(){
			$new_arr = array();
			$query = "SHOW COLUMNS FROM `$this->session_table`";
			$result = $this->db->query($query);
			while($total = $this->db->fetch_assoc($result)){
				$new_arr[] = $total['Field'];
			}
			return $new_arr;
		}

		function search_group($like = "", $column = ""){
			$new_arr = array();
			$query = "SELECT count( * ) AS total, `$column` FROM `$this->session_table` WHERE `$column` LIKE '%$like%' GROUP BY `$column`";
			$result = $this->db->query($query);
			while($array = $this->db->fetch_assoc($result)){
				$new_arr[] = $array;
			}
			return $new_arr;
		}

		function search($like = "", $column = "", $query = "" ){
			$new_arr = array();
			$result = $this->db->query($query);
			while($array = $this->db->fetch_assoc($result)){
				$new_arr[] = $array;
			}
			return $new_arr;
		}
		function session( $serial = "" ){
			$new_arr = array();
			$query = "SELECT * FROM `$this->session_table` WHERE `serial` = '$serial'";
			$result = $this->db->query($query);
			while($array = $this->db->fetch_assoc($result)){
				$new_arr[] = $array;
			}
			return $new_arr;
		}

		function session_detail( $serial = "", $query = "" ){
			$new_arr = array();
			$result = $this->db->query($query);
			while($array = $this->db->fetch_assoc($result)){
				$new_arr[] = $array;
			}
			return $new_arr;
		}
		
		function next_and_previous( $table = "", $column = "", $search = "", $serial = "" ){
			if( $column == 'time'){
				$where = "FROM_UNIXTIME( `time` , '%d-%m-%Y' ) = '$_REQUEST[Search]'";
			}else{
				$where = "`$_REQUEST[columns]` LIKE '%$_REQUEST[Search]%'";
			}
			$html = "<ul>";
			$query = "SELECT `serial` FROM `$table` WHERE $where AND `serial` < '$serial' ORDER BY `serial` DESC";
			$result = $this->db->query($query);
			$array = $this->db->fetch_row($result);
			if($array){
				$html .= '<li><a href="session-detail.php?serial='.$array[0].'&amp;columns='.$column.'&amp;Search='.$search.'">Previous</a></li>';
			}else{
				$query = "SELECT `serial` FROM `$table` WHERE $where ORDER BY `serial` DESC LIMIT 0,1";
				$result = $this->db->query($query);
				$array = $this->db->fetch_row($result);
				$html .= '<li><a href="session-detail.php?serial='.$array[0].'&amp;columns='.$column.'&amp;Search='.$search.'">Previous</a></li>';
			}

			$query = "SELECT `serial` FROM `$table` WHERE $where AND `serial` > '$serial' ORDER BY `serial` ASC";
			$result = $this->db->query($query);
			$array = $this->db->fetch_row($result);
			if($array){
				$html .= '<li><a href="session-detail.php?serial='.$array[0].'&amp;columns='.$column.'&amp;Search='.$search.'">Next</a></li>';
			}else{
				$query = "SELECT `serial` FROM `$table` WHERE $where ORDER BY `serial` ASC LIMIT 0,1";
				$result = $this->db->query($query);
				$array = $this->db->fetch_row($result);
				$html .= '<li><a href="session-detail.php?serial='.$array[0].'&amp;columns='.$column.'&amp;Search='.$search.'">Next</a></li>';
			}
			$html .= "</ul>";
			return $html;
		}

		function count_country(){
			$query = "select * from `$this->session_table` where `country` = ''";
			return $this->db->count_rows_by_query($query);
		}

		function update_country(){
			$query = "select * from `$this->session_table` where `country_code` = ''";
			$count = $this->db->count_rows_by_query($query);
			if ($count!=0){
				$new_array = array();
				$result_empty_country = $this->db->query($query);
				while( $rows_empty_country = $this->db->fetch_assoc($result_empty_country)){
					$query = "SELECT * FROM `$this->ip_table` WHERE '".$rows_empty_country['ip']."' BETWEEN `ip_start` AND `ip_end` ORDER BY `country` DESC LIMIT 0 , 1";
					$result = $this->db->fetch_assoc_by_query( $query );
					$query_update = "update `$this->session_table` set `country_code` = '$result[country]' where `serial` = '" . $rows_empty_country['serial'] . "'";
					$this->db->query($query_update);
				}
			}
		}
		
		function get_country_count_empty( $date ){
			$date = date( 'Y-m-d', $date );
			$query = "SELECT `country` FROM `$this->session_table` WHERE `country` = '' AND FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$date'";
			$result = $this->db->query($query);
			$count = $this->db->count_rows($result);
			$today_arr=array();
			while($row = $this->db->fetch_assoc($result)){
				$today_arr[] = $row;
			}
			return $count;

			
		}

		function get_empty_column( $date ){
			$date = date( 'Y-m-d', $date );
			$query = "SELECT `serial`, `ip` FROM `$this->session_table` WHERE `country_code` = '' AND FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$date'";
			$result = $this->db->query($query);
			$new_array = array();
			while($row = $this->db->fetch_assoc($result)){
				$new_array[] = $row;
			}
			return $new_array;

		}

		function get_all_bots_visitor( ){
			$query = "SELECT `is_bot` , count( * ) AS `total` FROM `$this->session_table` WHERE `is_bot` != '' GROUP BY `is_bot` ORDER BY `total` DESC";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_all_bots_string( $mcolumn = '', $column = 'user_agent', $limit = '10' ){
			$query = "SELECT $mcolumn `$column` , count( * ) AS `total` FROM `$this->session_table` WHERE `is_bot` != '' AND `is_bot` = 'Robot' GROUP BY `$column` ORDER BY `total` DESC LIMIT 0 , $limit";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_by_month( $column = "*", $year, $parma = '' ){
			$query = "SELECT FROM_UNIXTIME(`time`, '%m') AS `month`, count($column) AS `total`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE";
			$query .= " FROM_UNIXTIME(`time`,'%Y') = '$year'";
			$query .= " AND `country_code` != ''";
			$query .= " AND `is_bot` != 'Robot'";
			$query .= " AND `is_bot` != 'unknown'";
			$query .= " " . $parma;
			$query .= " GROUP BY `month`";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}

		function get_page_by_month( $month, $year ){

			$pquery = "SELECT `serial`";
			$pquery .= " FROM `$this->session_table`";
			$pquery .= " WHERE FROM_UNIXTIME(`time`,'%Y') = '$year'";
			$pquery .= " AND `country_code` != ''";
			$pquery .= " AND `is_bot` != 'Robot'";
			$pquery .= " AND `is_bot` != 'unknown'";
			$presult = $this->db->query($pquery);
			$array = array();
			while( $prow = $this->db->fetch_assoc( $presult ) ){
				$array[] = $prow['serial'];
			}
			$ids = implode( ',', $array );

			$query = "SELECT FROM_UNIXTIME(`time`, '%m') AS `month`, count(*) AS `total`";
			$query .= " FROM `$this->page_table`";
			$query .= " WHERE";
			$query .= " `session_id` in ($ids)";
			$query .= " GROUP BY `month`";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}
		
	} $ws = new WebStats($db);
?>