<?php
	class MonthlyStats{

		private $db;
		public $session_table = STATS_SESSIONS;
		public $page_table = STATS_PAGEVIEWS;
		
		public function __construct($db){
			$this->db=$db;
		}

		public function total_visits($year){
			$new_array = array();
			for($i=1; $i<=12; $i++){
				$new_array['visits_'.sprintf('%02d',$i)] = 0;
			}
			$query = "SELECT from_unixtime( time, '%m' ) AS MONTH , count( * ) AS total FROM sessions WHERE browser <> 'Other' AND from_unixtime( time, '%Y' ) =$year GROUP BY MONTH";
			$result = $this->db->query($query);
			while ($row = $this->db->fetch_array($result)) {
				$month = $row['MONTH'];
				$new_array['total_visits'] += $row['total'];
				$new_array['visits_'.$month] = $row['total'];
			}
			return $new_array;
		}

		public function unique_visits($year){
			$new_array = array();
			for($i=1; $i<=12; $i++){
				$new_array['unique_'.sprintf('%02d',$i)] = 0;
			}
			$query = "SELECT from_unixtime( time, '%m' ) AS MONTH , count( DISTINCT ( ip ) ) AS total FROM `$this->session_table` WHERE from_unixtime( time, '%Y' ) =$year GROUP BY MONTH";
			$result = $this->db->query($query);
			while ($row = $this->db->fetch_array($result)) {
				$month = $row['MONTH'];
				$new_array['total_unique'] += $row['total'];
				$new_array['unique_'.$month] = $row['total'];
			}
			return $new_array;
		}

		public function direct_visits($year){
			$total_visits = $this->total_visits($year);
			$new_array = array();
			for($i=1; $i<=12; $i++){
				$new_array['direct_'.sprintf('%02d',$i)] = 0;
				$new_array['external_'.sprintf('%02d',$i)] = 0;
			}
			echo $query = "SELECT from_unixtime( time, '%m' ) AS MONTH , count( * ) AS total FROM sessions WHERE browser <> 'Other' AND from_unixtime( time, '%Y' ) =$year AND referer = '' GROUP BY MONTH";
			$result = $this->db->query($query);
			while ($row = $this->db->fetch_array($result)) {
				$month = $row['MONTH'];
				$new_array['total_direct'] += $row['total'];
				$new_array['direct_'.$month] = $row['total'];
				
				$new_array['external_'.$month] = $total_visits['visits_'.$month] - $row['total'];
				$new_array['total_external'] += $new_array['external_'.$month];
			}
			return $new_array;
		}

		public function page_visits($year){
			$new_array = array();
			for($i=0; $i<=11; $i++){
				$new_array['page_'.sprintf('%02d',$i)] = 0;
			}
			$query = "SELECT from_unixtime( time, '%m' ) AS MONTH , count( * ) AS total FROM pageviews WHERE from_unixtime( time, '%Y' ) =$year GROUP BY MONTH";
			$result = $this->db->query($query);
			while ($row = $this->db->fetch_array($result)) {
				$month = $row['MONTH'];
				$new_array['total_page'] += $row['total'];
				$new_array['page_'.$month] = $row['total'];
			}
			return $new_array;
		}


		function get_by_month( $column = "*", $year, $parma = '' ){
			$query = "SELECT FROM_UNIXTIME(`time`, '%m') AS `month`, `time`, count($column) AS `total`";
			$query .= " FROM `$this->session_table`";
			$query .= " WHERE";
			$query .= " FROM_UNIXTIME(`time`,'%Y') = '$year'";
			$query .= " AND `country` != ''";
			$query .= " AND `is_bot` != 'Robot'";
			$query .= " AND `is_bot` != 'unknown'";
			$query .= " " . $parma;
			$query .= " GROUP BY `month`";
			$query .= " ORDER BY `month` DESC";
			$result = $this->db->query( $query );
			$new_array = array();
			while( $row = $this->db->fetch_assoc( $result ) ){
				$new_array[] = $row;
			}
			return $new_array;
		}


		
	}$MS = new MonthlyStats($db);
?>