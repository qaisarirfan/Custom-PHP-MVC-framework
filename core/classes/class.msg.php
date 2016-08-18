<?php
	class Messages{
		
		private $msg;
		private $type='';
		
		public function __construct(){
			$this->type='type';
		}
		/**/
		private function set_msg_type(){
			if($this->type=='error'){ 
				return $this->type=$type;
			}
			if($this->type=='success'){
				return $this->type=$type;
			}
			if($this->type=='information'){
				return $this->type=$type;
			}
			if($this->type=='attention'){
				return $this->type=$type;
			}
		}
		/**/
		private function set_msg_class(){
			if($this->type=='error'){ 
				return 'n-error';
			}
			if($this->type=='success'){
				return 'n-success';
			}
			if($this->type=='information'){
				return 'n-information';
			}
			if($this->type=='attention'){
				return 'n-attention';
			}
		}
		/**/
		private function set_close_class(){
			return 'close_msg';
		}
		/**/
		public function get_msg_arrg($msg, $type){
			$this->msg = $msg;
			$this->type = $type;
			$html = "";
			$html .= '<div class="notification '.$this->set_msg_class().'">';
				$html .= '<div>'.$msg.'</div>';
			$html .= '</div>';
			return $html;
		}
	}
	$msg = new Messages();
?>