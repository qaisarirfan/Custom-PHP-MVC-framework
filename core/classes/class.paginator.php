<?php
	class Paging{
		private $query;
		private $db;
		private $current_page;
		private $results_per_page;
		private $total_records;
		private $total_pages;
		public $query_string;
		
		function __construct( $total, $current_page = 1, $results_per_page = 10, $array = array() ){
			$this->query_string = $array['query_string'];
			$this->current_page = $current_page < 1 ? 1 : $current_page;
			$this->results_per_page = $results_per_page;
			$this->total_records = $total;
			$this->total_pages=ceil($this->total_records/$this->results_per_page);
		}

		function get_start(){
			$start = ( $this->current_page - 1 ) * $this->results_per_page;
			return $start;
		}

		function get_total_records(){
			return $this->total_records;
		}

		function get_total_pages(){
			return $this->total_pages;
		}

		function pages(){
			$total = $this->current_page. ' of '. $this->total_pages;
			return $total;
		}

		function get_current_page(){
			return $this->current_page;
		}

		function render_pages( ){
			$html = "";
			$grace = 3; // $grace pages on the left and $grace pages on the right of current page
			$range = $grace * 2;

			$start  = ($this->current_page - $grace) > 0 ? ($this->current_page - $grace) : 1;
			$end = $start + $range;

			if($end > $this->total_pages){ //make sure $end doesn't go beyond total pages

				$end = $this->total_pages;
				$start = ($end - $range) > 0 ? ($end - $range) : 1; //if there is a change in $end, adjust $start again

			}
			
			if( $this->query_string == '' ){
				$qstring = $_SERVER['QUERY_STRING'];
				$regex = '|&?page=\d+|';
				$qstring = preg_replace($regex,"",$qstring);
				$separator = $qstring == '' ? '?' : '?' . $qstring . '&amp;';
				$separator .= 'page=';
			}else{
				$qstring = $this->query_string;
				$separator = $qstring . '/page/';
			}

			$html .= '<div id="pagination">';
				$html .= '<div class="pages">';
					$html .= "<ul>";
						if( $start > 1 ){
							$html .= '<li><a href="'.$separator.'1"><span>First</span></a></li>';
							$html .= '<li class="extend"><span>...</span></li>';
						}
						for( $i = $start; $i <= $end; $i++ ){
							if( $i == $this->current_page ){
								$html .= '<li class="current"><span>'.$i.'</span></li>'; // Current page is not clickable and different from other pages
							} else {
								$html .= '<li><a href="'.$separator.$i.'"><span>'.$i.'</span></a></li>';
							}
						}
						if( $end < $this->total_pages ){
							$html .= '<li class="extend"><span>...</span></li>';
							$html .= '<li><a href="'.$separator.$this->total_pages.'">Last</a></li>'; // If $end is away from total pages, add a link of the last page
						}
					$html .= "</ul>";
				$html .= "</div>";
				$html .= '<div class="pagenavi">';
					$html .= '<table>';
						$html .= '<tr>';
							$html .= '<td>Record&nbsp;</td>';
							$html .= '<td><b>'.$this->get_total_records().'</b></td>';
							$html .= '<td>&nbsp;-&nbsp;</td>';
							$html .= '<td>Page</td>';
							$html .= '<td><b>'.$this->pages().'</b></td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</div>';
				$html .= '<div class="clear">&nbsp;</div>';
			$html .= "</div>";
			return $html;
		}
	}
?>