<?php

	session_start();

	class Captcha {
		protected $captcha_type = 'default'; // random, custom, default
		protected $default_font = array ( 'Attic' => 'fonts/default/Attic.otf', );
		protected $default_background = array ( 'binding-light' => array ( 'background' => 'background/default/binding-light.png', 'color' => '000', 'opacity' => '55' ) );

		protected $master_img;
		protected $blank_img = "img/blank-img.png";
		
		protected $min_font_size = 18;
		protected $max_font_size = 28;

		protected $min_rotation = '-13';
		protected $max_rotation = '13';
		
		protected $word_lenght = 4; // limit 2, 10
		protected $random_word_lenght = array('3','5','7');
		protected $word_type = "mixstring"; // alphabetic, mixstring , number, math, dictionary

		protected $math_first_range = array (10,19);
		protected $math_second_range = array (9,1);
		protected $math_operator = '+'; // +, -

		protected $image_width = 200;
		protected $image_height = 75;
		protected $background = array(
						'binding-dark' => array ( 'background' => 'background/binding-dark.png', 'color' => 'fff', 'opacity' => '50' ),
						'binding-light' => array ( 'background' => 'background/binding-light.png', 'color' => '000', 'opacity' => '40' ),
						'body-grey' => array ( 'background' => 'background/body-grey.gif', 'color' => 'fff', 'opacity' => '50' ),
						'cream-pixels' => array ( 'background' => 'background/cream-pixels.png', 'color' => '000', 'opacity' => '50' ),
						'knitted-netting' => array ( 'background' => 'background/knitted-netting.png', 'color' => '000', 'opacity' => '35' ),
						'tweed' => array ( 'background' => 'background/tweed.png', 'color' => 'fff', 'opacity' => '35' ),
						'witewall' => array ( 'background' => 'background/witewall.png', 'color' => '000', 'opacity' => '35' ),
						'fabric-patterns-04' => array ( 'background' => 'background/fabric-patterns-04.png', 'color' => '000', 'opacity' => '40' ),
						'fabric-patterns-05' => array ( 'background' => 'background/fabric-patterns-05.png', 'color' => '000', 'opacity' => '50' ),
						'i8ReKS' => array ( 'background' => 'background/i8ReKS.png', 'color' => 'fff', 'opacity' => '50' )
					);
		protected $color;
		protected $opacity;
		protected $fonts = array(
					'AGOldFace-Outline' => 'fonts/AGOldFace-Outline.otf',
					'AkiLines' => 'fonts/AkiLines.otf',
					'AmericanTypeOutline' => 'fonts/AmericanTypeOutline.otf',
					'AmericanUncialInitialsOpen' => 'fonts/AmericanUncialInitialsOpen.otf',
					'AmericanUncialOpen' => 'fonts/AmericanUncialOpen.otf',
					'AquariusOutline' => 'fonts/AquariusOutline.otf',
					'ArialRoundedMTStd-Light' => 'fonts/ArialRoundedMTStd-Light.otf',
					'ATHadrianoStd-Light' => 'fonts/ATHadrianoStd-Light.otf',
					'Attic' => 'fonts/Attic.otf',
					'BalladeSh' => 'fonts/BalladeSh.otf',
					'BauhausHeavyOutline' => 'fonts/BauhausHeavyOutline.otf',
					'Bermuda' => 'fonts/Bermuda.otf',
					'AntykwaBold' => 'fonts/AntykwaBold.ttf',
					'Antykwa' => 'fonts/AntykwaBold.ttf',
					'Candice' => 'fonts/Candice.ttf',
					'DingDong' => 'fonts/Ding-DongDaddyO.ttf',
					'Duality' => 'fonts/Duality.ttf',
					'Jura' => 'fonts/Jura.ttf',
					'StayPuft' => 'fonts/StayPuft.ttf',
					'Times' => 'fonts/TimesNewRomanBold.ttf',
					'VeraSans' => 'fonts/VeraSansBold.ttf'
				);

		protected $multiple_word = false;
		protected $multiple_word_lenght = '2';
		protected $text_rotation = array ('0','-5','5','-8','8','-10','10','-13','13');
		protected $dictionary_file_path = "words/";

		public function __construct( $config = array() ){

			if( $config['captcha_type'] != '' ){
				$this->captcha_type = $config['captcha_type'];
			}

			if( $this->captcha_type == 'custom' ){
				if( $config['fonts'] != '' ){
					$this->fonts = $config['fonts'];
				}
				if( $config['background'] != '' ){
					$this->background = $config['background'];
				}
			}

			if( $this->captcha_type == 'random' ){
				if( $config['fonts'] != '' ){
					$this->fonts = array_merge( $this->fonts, $config['fonts'] );
				}
				if( $config['background'] != '' ){
					$this->background = array_merge( $this->background, $config['background'] );
				}
			}

			if( $config['word_type'] != '' ){
				$this->word_type = $config['word_type'];
			}

			if( $config['math_first_range'] != '' and sizeof( $config['math_first_range'] ) == 2 ){
				$this->math_first_range = $config['math_first_range'];
			}

			if( $config['math_second_range'] != ''  and sizeof( $config['math_second_range'] ) == 2 ){
				$this->math_second_range = $config['math_second_range'];
			}

			if( $config['math_operator'] != '' ){
				$this->math_operator = $config['math_operator'];
			}

			if( $config['word_lenght'] != '' and $config['word_lenght'] <= 10  and $config['word_lenght'] >= 2 ){
				$this->word_lenght = $config['word_lenght'];
			}

			if( $config['random_word_lenght'] != '' ){
				$this->random_word_lenght = $config['random_word_lenght'];
			}

			if( $config['multiple_word'] != '' ){
				$this->multiple_word = $config['multiple_word'];
			}

			if( $config['multiple_word_lenght'] != '' ){
				$this->multiple_word_lenght = $config['multiple_word_lenght'];
			}
			
			if ( $this->captcha_type != 'default' ){
				if( $config['image_width'] != '' and $config['image_width'] >= '200' ){
					$this->image_width = $config['image_width'];
				}
				if( $config['image_height'] != '' and $config['image_height'] >= '70' ){
					$this->image_height = $config['image_height'];
				}
				if( $config['min_rotation'] != '' ){
					$this->min_rotation = $config['min_rotation'];
				}
				if( $config['max_rotation'] != '' ){
					$this->max_rotation = $config['max_rotation'];
				}
				if( $config['min_font_size'] != '' ){
					$this->min_font_size = $config['min_font_size'];
				}
				if( $config['max_font_size'] != '' ){
					$this->max_font_size = $config['max_font_size'];
				}
				if( $config['color'] != '' ){
					$this->color = $config['color'];
				}
			}
		}

		public function get_captcha(){

			$text = $this->get_word();

			$this->set_background_color();

			if ( $this->word_type == 'math' ) {
				$this->write_text( $text['question'] );
				$_SESSION['captcha'] = $text['answer'];
			}else{
				$this->write_text( $text );
				$_SESSION['captcha'] = $text;
			}
	         	imagefilter($this->master_img, IMG_FILTER_SMOOTH,0);
	         	imagefilter($this->master_img, IMG_FILTER_GAUSSIAN_BLUR);
			$this->write_image();
			$this->destroy();
		}

		protected function get_word ( ) {
			
			if ( $this->multiple_word == 'no' ){ 
				if ( $this->word_type == 'number' ){
					$text = $this->get_random_number();
				}elseif ( $this->word_type == 'alphabetic' ){
					$text = $this->get_random_alphabetic();
				}elseif( $this->word_type == 'mixstring' ){
					$text = $this->get_random_mixstring();
				}elseif( $this->word_type == 'math' ){
					$text = $this->get_mathematics_equation();
				}elseif( $this->word_type == 'dictionary' ){
					$text = $this->get_dictionary_word();
				}
			}else{
				if( $this->word_type != 'math' ){
					if ( $this->word_type == 'number' ){
						$text = $this->get_multiple_word();
					}elseif ( $this->word_type == 'alphabetic' ){
						$text = $this->get_multiple_word();
					}elseif( $this->word_type == 'mixstring' ){
						$text = $this->get_multiple_word();
					}elseif( $this->word_type == 'dictionary' ){
						$text = $this->get_multiple_word();
					}
				}else{
					$text = $this->get_mathematics_equation();
				}
			}

			return $text;
		}

		protected function get_random_number ( ) {
			if( $this->multiple_word == 'yes' ){
				$total = $this->random_word_lenght[array_rand( $this->random_word_lenght )];
			}else{
				$total = $this->word_lenght;
			}
			$number = array();
			$numbers = "0123456789";
			$lenght = strlen( $numbers );
			for ( $i = 0; $i < $total; $i++  ){
				$rand = mt_rand( 0, $lenght );
				$number[] = $numbers[$rand];
			}
			$count = 0;
			foreach ( $number as $index=>$value ){
				if( empty($value) ){
					$number[$index] = $count;
				}
				$count++;
			}
			return implode( $number );
		}

		protected function get_random_alphabetic ( ) {
			if( $this->multiple_word == 'yes' ){
				$total = $this->random_word_lenght[array_rand( $this->random_word_lenght )];
			}else{
				$total = $this->word_lenght;
			}
			$word = array();
			$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
			$lenght = strlen( $alphabet );
			for ( $i = 0; $i < $total; $i++ ){
				$rand = mt_rand( 0, $lenght );
				$word[] = $alphabet[$rand];
			}
			$range = range('a', 'z');
			$count = 0;
			foreach ( $word as $index=>$value ){
				if( empty($value) ){
					$word[$index] = $range[$count];
				}
				$count++;
			}
			return implode( $word );
		}

		protected function get_random_mixstring ( ) {
			if( $this->multiple_word == 'yes' ){
				$total = $this->random_word_lenght[array_rand( $this->random_word_lenght )];
			}else{
				$total = $this->word_lenght;
			}
			$word = array();
			$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ123456789";
			$lenght = strlen( $alphabet );
			for( $i = 0; $i < $total; $i++ ){
				$rand = rand( 0, $lenght );
				$word[] = $alphabet[$rand];
			}
			$count = 0;
			foreach ( $word as $index=>$value ){
				if( empty($value) || $value == '0' ){
					$word[$index] = $count;
				}
				$count++;
			}
			return implode( $word );
		}

		protected function get_mathematics_equation ( ) {
			$new_array = array();

			if ( !empty( $this->math_first_range ) and is_array( $this->math_first_range ) and sizeof( $this->math_first_range ) == 2 ){
				$first_value = mt_rand( $this->math_first_range[0], $this->math_first_range[1]);
			}
			if ( !empty( $this->math_second_range ) and is_array( $this->math_second_range ) and sizeof( $this->math_second_range ) == 2 ){
				$second_value = mt_rand( $this->math_second_range[0], $this->math_second_range[1]);
			}
			if ( $this->math_operator == '+' ){
				$total = $first_value + $second_value;
			}elseif ( $this->math_operator == '-' ){
				$total = $first_value - $second_value;				
			}
			$equation = $first_value ." $this->math_operator ". $second_value . ' = ?';
			$new_array['question'] = $equation;
			$new_array['answer'] = $total;

			return $new_array;
		}

		protected function get_multiple_word (){
			$words = "";

			for( $i = 0; $i < $this->multiple_word_lenght; $i++ ){
				if ( $this->word_type == 'number' ){
					$text = $this->get_random_number();
				}elseif ( $this->word_type == 'alphabetic' ){
					$text = $this->get_random_alphabetic();
				}elseif( $this->word_type == 'mixstring' ){
					$text = $this->get_random_mixstring();
				}elseif( $this->word_type == 'dictionary' ){
					$text = $this->get_dictionary_word();
				}

				if($i!=0){
					$words .= " ".$text;
				}else{
					$words .= $text;
				}
			}
			return $words;
		}

		protected function set_background_color(){
			if(!empty($this->master_img)){
				$this->destroy();
			}
			if ( $this->captcha_type == "default" ) {
				$background_array = $this->default_background['binding-light'];
			}

			if ( $this->captcha_type == "custom" ) {
				$background_array = $this->background[ array_rand( $this->background ) ];
			}

			if ( $this->captcha_type == "random" ) {
				$background_array = $this->background[ array_rand( $this->background ) ];
			}

			$img_path = $background_array['background'];
			
			if ( $this->color == '' ) {
				$this->color = $background_array['color'];
			}

			$this->opacity = $background_array['opacity'];

			$img_source = $this->image_create_from( $img_path );
			$src_width = imagesx($img_source);
			$src_height = imagesy($img_source);

			$this->master_img = imagecreatetruecolor( $this->image_width, $this->image_height );
			$dst_width = imagesx($this->master_img);
			$dst_height = imagesy($this->master_img);

			if ( $src_width < $dst_width or $src_height < $dst_height ){
				imagesettile( $this->master_img, $img_source );
				imagefilledrectangle( $this->master_img, 0, 0, $this->image_width, $this->image_height, IMG_COLOR_TILED );
			}else{
				imagecopymerge( $this->master_img, $img_source, 0, 0, 0, 0, $src_width, $src_height, 100 );
			}
		}
		
		protected function write_text( $text ){
			
			$colors = $this->hexTorgb( $this->color );
			$color = imagecolorallocatealpha( $this->master_img, $colors[0], $colors[1], $colors[2], 50 );
			$back_color = imagecolorallocatealpha( $this->master_img, $colors[0], $colors[1], $colors[2], $this->opacity );

			if ( $this->captcha_type == 'default' ) {
				$font_path = $this->default_font['Attic'];
			}

			if ( $this->captcha_type == 'custom' ) {
				$font_path = $this->fonts[ array_rand( $this->fonts ) ];
			}

			if ( $this->captcha_type == 'random' ) {
				$font_path = $this->fonts[ array_rand( $this->fonts ) ];
			}

			$font_size =  mt_rand( $this->min_font_size, $this->max_font_size );
			$angle = mt_rand( $this->min_rotation, $this->max_rotation );

			$bbox = imagettfbbox( $font_size, $angle, $font_path, $text );
			$x = $bbox[0] + ( $this->image_width ) - ( $bbox[4] );
			$y = $bbox[1] + ( $this->image_height ) - ( $bbox[5] );
			$x_ordinate = $x / 2;
			$y_ordinate = $y / 2;
			
			$img_source = $this->image_create_from( $this->blank_img );
			$src_width = imagesx( $img_source );
			$src_height = imagesy( $img_source );
			
			imagettftext( $img_source, 8, 45, 7, 34, $back_color, $font_path, $text );
			
			imagesettile( $this->master_img, $img_source );
			imagefilledrectangle( $this->master_img, 0, 0, $this->image_width, $this->image_height, IMG_COLOR_TILED );

			if( $this->word_type != 'math' ){
				imagettftext( $this->master_img, $font_size, $angle, $x_ordinate-4, $y_ordinate-4, $color, $font_path, $text );
				imagettftext( $this->master_img, $font_size, $angle, $x_ordinate-1, $y_ordinate-1, $color, $font_path, $text );
			}

			imagettftext( $this->master_img, $font_size, $angle, $x_ordinate, $y_ordinate, $color, $font_path, $text );
		
		}

		protected function get_dictionary_word( ) {
			$file = $this->dictionary_file_path.$this->word_lenght."-words.txt";
			if( !file_exists( $file ) && empty( $file ) ){
				return false;
			}
			$text_array = file( $file );
        		$line = mt_rand( 0, count( $text_array ) );
			$text = $text_array[$line];
			$replage = array ("\r\n"," ");
			$text = str_replace( $replage, "", $text);
			return $text;
		}

		protected function image_create_from($image){
			$name = $this->name_explode($image);
			switch( $name['extension'] ){
				case "jpg":
				$imag = imagecreatefromjpeg($image);
				break;
				
				case "jpeg":
				$imag = imagecreatefromjpeg($image);
				break;
				
				case "x-jpg":
				$imag = imagecreatefromjpeg($image);
				break;
				
				case "gif":
				$imag = imagecreatefromgif($image);
				break;
				
				case "png":
				$imag = imagecreatefrompng($image);
				break;
				
				case "x-png":
				$imag = imagecreatefrompng($image);
				break;

				default:
				$imag = false;
				break;
			}
			return $imag;
		}

		protected function name_explode( $name ){
			$fileparts = pathinfo($name);
			return $fileparts;
		}

		protected function hexTorgb($hex){

			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
			}
			$rgb = array($r, $g, $b);
			return $rgb;

		}

		protected function write_image() {
			header("Content-type: image/png");
			imagepng( $this->master_img );
			$this->destroy();
		}

		protected function destroy(){
			//imagedestroy( $this->master_img );
		}
	
	}

?>