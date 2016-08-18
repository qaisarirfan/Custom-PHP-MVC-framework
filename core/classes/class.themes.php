<?php
	class Themes{
		public $theme_name;
		public $theme_dir;
		public $theme_site_dir;
		
		public function __construct( $name ){
			$this->theme_name = $name;
		}
		
		public function render_file ( $name ){
			$path = SITE_PATH . $this->theme_dir . "/" . $this->theme_name . "/" . $this->theme_site_dir . "/" .$name;
			if( is_readable( $path ) ){
				require( $path );
			}else{
				die( $name .' &larr; is not accessible' );
			}
		}
		
		public function get_theme_path(){
			return SITE_PATH . $this->theme_dir . "/" . $this->theme_name;
		}
		
		public function get_theme_name(){
			return $this->theme_name;
		}
		
		public function get_theme_name_with_http(){
			return BASE_URL . $this->theme_dir . "/" . $this->theme_name;
		}

		public function get_site_content_path(){
			return BASE_URL . "site-content";
		}

		public function get_resources_path(){
			return BASE_URL . "resources";
		}

	}
?>