<?php
	class TodayWebStats{

		private $db;
		public $session_table = STATS_SESSIONS;
		public $page_table = STATS_PAGEVIEWS;
		public $todaydate = '';

		function __construct( $db ){
			$this->db = $db;
		}
		
		function today( $todate = '' ){
			if( $todate == '' ){
				$date = date('Y-m-d',time());
			}else{
				$date = $todate;
			}
			return $this->todaydate = $date;
		}

		function prepare_today_site_visitor( $start = '0', $limit = '0', $column = 'is_bot', $parma = '' ){

			$today = $this->todaydate;

			$query = "SELECT *, count( * ) AS `total`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			if( $column == 'os' ){
				$query .= " AND `$column` != 'Other'";
			}
			if( $column == 'browser' ){
				$query .= " AND `$column` != 'Other'";
			}
			$query .= " AND `$column` != ''";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$query .= " GROUP BY `$column`";
			$query .= " ORDER BY `total` DESC";
			if( $limit > '0' ){
				$query .= " LIMIT $start, $limit";
			}
			$result = $this->db->query( $query );
			return $result;
		}


		function get_today_site_visitor( $start = '0', $limit = '0', $column = 'is_bot', $parma = '' ){
			$today = $this->todaydate;
			$query = "SELECT *, count( * ) AS `total`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			$query .= " AND `$column` != ''";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$query .= " GROUP BY `$column`";
			$query .= " ORDER BY `total` DESC";
			if( $limit > '0' ){
				$query .= " LIMIT $start, $limit";
			}
			$result = $this->db->query( $query );
			$today_arr = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$today_arr[] = $row;
			}
			return $today_arr;
		}

		function get_today_unique_visitor(){
			$today = $this->todaydate;
			$query = "SELECT count( DISTINCT ( `ip` ) ) AS total";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$result = $this->db->query($query);
			$row = $this->db->fetch_assoc($result);
			return $row['total'];
		}

		function prepare_today_page_visit( $start = '0', $limit = '0', $parma = '' ){

			$today = $this->todaydate;

			$query = "SELECT `serial`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$result = $this->db->query($query);
			$array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$array[] = $row['serial'];
			}
			$ids = implode( ',', $array );
			
			$ids = $ids ? $ids : '0';
			
			$page_query = "SELECT `file_parameters`, count( * ) AS total";
			$page_query .= " FROM `$this->page_table`";
			$page_query .= " WHERE `session_id` in ($ids)";
			$page_query .= " ".$parma;
			$page_query .= " GROUP BY `file_parameters`";
			$page_query .= " ORDER BY total DESC";
			if($limit > '0'){
				$page_query .= " LIMIT $start , $limit";
			}

			return $this->db->query( $page_query );
		}


		function get_today_page_visit( $start = '0', $limit = '0', $parma = '' ){

			$today = $this->todaydate;

			$query = "SELECT `serial`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$result = $this->db->query($query);
			$array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$array[] = $row['serial'];
			}
			$ids = implode( ',', $array );
			
			$ids = $ids ? $ids : '0';
			
			$page_query = "SELECT `file_parameters`, count( * ) AS total";
			$page_query .= " FROM `$this->page_table`";
			$page_query .= " WHERE `session_id` in ($ids)";
			$page_query .= " ".$parma;
			$page_query .= " GROUP BY `file_parameters`";
			$page_query .= " ORDER BY total DESC";
			if($limit > '0'){
				$page_query .= " LIMIT $start , $limit";
			}

			$page_result = $this->db->query( $page_query );
			$today_arr = array();
			while( $page_row = $this->db->fetch_assoc( $page_result ) ){
				$today_arr[] = $page_row;
			}
			return $today_arr;
		}

		function get_today_page_of ( $page, $limit='25' ){
			$today = $this->todaydate;
			if($limit!=''){
				$isLimit="LIMIT 0 , $limit";
			}
			$query = "SELECT `filename`, `file_parameters`, count( * ) AS total FROM `$this->page_table` WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today' AND `filename` LIKE '%$page%' GROUP BY `file_parameters` ORDER BY total DESC $isLimit";
			$result = $this->db->query($query);
			$today_arr=array();
			while($row = $this->db->fetch_assoc($result)){
				$today_arr[] = $row;
			}
			return $today_arr;
		}
		
		function get_today_totalpage_visit(){
			$today = $this->todaydate;

			$query = "SELECT `serial`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today'";
			$query .= " AND `country` != ''";
			$query .= " AND ( `is_bot` LIKE '%Browser%' )";
			$result = $this->db->query($query);
			$array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$array[] = $row['serial'];
			}
			$ids = implode( ',', $array );
			$ids = $ids ? $ids : '0';
			$page_query = "SELECT count( * ) AS total";
			$page_query .= " FROM `$this->page_table`";
			$page_query .= " WHERE `session_id` in ($ids)";
			$page_query .= " AND `filename` NOT LIKE '%page_not_found%'";

			$page_result = $this->db->query( $page_query );
			$total = $this->db->fetch_assoc( $page_result );
			return $total['total'];
		}

		function get_columns(){
			$new_arr = array();
			$query = "SHOW COLUMNS FROM `stats_sessions`";
			$result = $this->db->query($query);
			while($total = $this->db->fetch_assoc($result)){
				$new_arr[] = $total['Field'];
			}
			return $new_arr;
		}

		function get_all_bots_visitor( ){ // use
			$today = $this->todaydate;
			$query = "SELECT `is_bot` , count( * ) AS `total` FROM `$this->session_table` WHERE FROM_UNIXTIME(`time`,'%Y-%m-%d') = '$today' AND `is_bot` != '' GROUP BY `is_bot` ORDER BY `total` DESC";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}
		
	} $wsToday=new TodayWebStats($db);
?>