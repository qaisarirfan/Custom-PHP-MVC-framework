<?php
	class UploadImage{

		/*image*/
		var $image_width;
		var $image_height;
		var $image_size;
		var $image_name;
		var $image_full_path;
		var $type;
		var $attribute;
		var $mime_types;
		var $format;
		
		/*image limit*/
		var $restrict_image_size=false;
		var $restricted_width;
		var $restricted_height;
		var $restricted_size=3072.00; /* (1024*3) 3 Megabyte */
		
		/*file allow*/
		var $allowed_extension=array('jpg','jpeg','gif','png');
		
		/*thum setting*/
		var $thumb_width='100';
		var $thumb_height='100';
		var $fix_aspect='both';
		var $prefix='thumb';
		var $margin='100';
		
		/*message*/
		var $message;

		public function __construct( ){

		}

		
		/*get message*/
		function get_message(){
			return $this->message;
		}

		private function smartString($str) {
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
			return $clean;
		}		

		/*check image limit*/
		function restrict_image($width,$height,$size){
			$size=$size/1024;
			if($this->restricted_size > $size){
				$this->restrict_image_size=true;
				return true;
			}else{
				return false;
			}
		}

		function image_create_from ( $image ){
			$name = $this->name_explode($image);
			switch( $name['extension'] ){

				case "jpg":
				$imag = imagecreatefromjpeg( $image );
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

		private function image_save_from( $image, $new_image, $ext ){

			switch( $ext ){
				case "jpg":
				$imag = imagejpeg( $image, $new_image.'.'.$ext, 100 );
				break;
				
				case "jpeg":
				$imag = imagejpeg( $image, $new_image.'.'.$ext, 100 );
				break;
				
				case "x-jpg":
				$imag = imagejpeg( $image, $new_image.'.'.$ext, 100 );
				break;
				
				case "gif":
				$imag = imagegif( $image, $new_image.'.'.$ext );
				break;
				
				case "png":
				$imag = imagepng( $image, $new_image.'.'.$ext, 100 );
				break;
				
				case "x-png":
				$imag = imagepng( $image, $new_image.'.'.$ext, 100 );
				break;
		
				default:
				$imag = false;
				break;
			}
			return $imag;
		}

		private function name_explode( $name ){
			$fileparts = pathinfo($name);
			return $fileparts;
		}

		function thumbnail_maker ( $img_src, $img, $w, $h, $fix_aspect = "both", $prefix = "thumb", $destination ){
			$image = $img_src . $img;
			$imgs = $this->image_create_from( $image );
			$img_height = imagesy( $imgs );
			$img_width = imagesx( $imgs );
		
			if ( $fix_aspect == 'both' ){
				$thumb_width = $w;
				$thumb_height = $h;	
			} else if ( $fix_aspect == 'width' ){
				$thumb_width = $w;
				$thumb_height = floor( ($w / $img_width ) * $img_height );
			}
			else if ( $fix_aspect == 'height' ){
				$thumb_height = $h;
				$thumb_width = floor( ( $h / $img_height ) * $img_width );
			}
			$new_img = imagecreatetruecolor( $thumb_width, $thumb_height );
			imagecopyresampled( $new_img, $imgs, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_width, $img_height );
			$name = $this->name_explode( $image );
			$this->image_save_from( $new_img, $destination . $prefix .'-'. $name['filename'], $name['extension'] );
		}

		/*create thumb*/
		function create_thumbnail($source,$destination){

			$img_info=pathinfo($source);
			$ext=strtolower($img_info['extension']);
			
			if ($ext=='jpg'){
				$source_image=imagecreatefromjpeg($source);
			}else if($ext=='png'){
				$source_image=imagecreatefrompng($source);
			}else if($ext=='gif'){
				$source_image=imagecreatefromgif($source);
			}else if($ext=='bmp'){
				$source_image=imagecreatefromjpeg($source);
			}else{
				$this->message="Invalid File Format. Only jpg, png, gif images are allowed&type=attention";
				return false;
			}

			$src_width=imagesx($source_image);
			$src_height=imagesy($source_image);

			$virtual_image=imagecreatetruecolor($this->thumb_width,$this->thumb_height);
			imagecopyresampled($virtual_image,$source_image,0,0,0,0,$this->thumb_width,$this->thumb_height,$src_width,$src_height);

			$thumb_name=$this->prefix.'-'.$this->image_name;
			
			if($ext=='jpg'){
				imagejpeg($virtual_image,$destination.$thumb_name);
				return true;
			}else if($ext=='png'){
				imagepng($virtual_image,$destination.$thumb_name);
				return true;
			}else if($ext=='gif'){
				imagegif($virtual_image,$destination.$thumb_name);
				return true;
			}else if($ext=='bmp'){
				imagejpeg($virtual_image,$destination.$thumb_name);
				return true;
			}else{
				return false;
			}
		}

		function upload_image($source,$destination,$name){

			/*image default name*/
			$default_name=$source['name'];
			$nDn=pathinfo($default_name);
			$default_name=$this->smartString($nDn['filename']).'.'.$nDn['extension'];

			/*image source path*/
			$source_path=$source['tmp_name'];
			
			/*image size*/
			$this->image_size=$source["size"];
		
			/*image get information*/
			list($width,$height,$type,$attr)=getimagesize($source['tmp_name']);
			
			/*Check image size limit */
			$this->restrict_image($width,$height,$this->image_size);

			/*image name explode and get extension*/
			$info=pathinfo($default_name);
			$ext=strtolower($info['extension']);
			
			if ($this->restrict_image_size==true){
				$allowed=in_array($ext,$this->allowed_extension);
				if($allowed){
					/*upload image*/
					if(move_uploaded_file($source_path,$destination.$default_name)){
						/*give new name*/
						$img_info=pathinfo($destination.$default_name);
						if(!empty($name)){
							$name=$this->smartString($name).".".$img_info['extension'];
							rename($destination.$default_name,$destination.$name);
						}else{
							$name=$default_name;	
						}
						list($width,$height,$type,$attr)=getimagesize($destination.$name);
						$this->image_width=$width;
						$this->image_height=$height;
						$this->type=$type;
						$this->attribute=$attr;
						$this->image_full_path=$destination.$name;
						$this->image_name=$name;
						$this->format=$source['type'];
						return true;
					}else{
						$this->message="Image not found on given source '$source_path'&type=error";
						return false;
					}
				}else{
					$this->message="You Uploaded the file named <b>'$default_name'</b> Allowed extensions are jpg, png, gif&type=attention";
				}
			}else{
				$this->message="Image size across the limit&type=attention";
			}
		}

		/*upload image with fix size*/
		function upload_fixed_size_image($source,$destination,$name='',$width=100,$height=100,$fix_aspect="width",$prefix="thumb"){
			if ($this->upload_image_with_thumbnail($source,$destination,$name,$width,$height,$fix_aspect,$prefix="thumb")){
				unlink($this->image_full_path);
				rename($destination.$this->image_name,$destination.$prefix.$this->image_name);
				return true;
			}
			else{
				$this->message="Error Uploading Image&type=attention";
				return false;	
			}
		}
		
		/*upload image with fix thumb*/
		function upload_image_with_thumbnail($source,$destination,$name='',$width=100,$height=100,$fix_aspect="width",$prefix="thumb"){
			if($this->upload_image($source,$destination,$name)){
				$this->set_thumb_settings($width,$height,$fix_aspect,$prefix);
				if($this->create_thumbnail($this->image_full_path,$destination))
					return true;
				else{
					$this->message="Error Creating Thumb&type=attention";
					return false;
				}
			}
			else{
				$this->message="Error Uploading Image&type=error";
				return false;
			}
		}
		/*image fix thumb setting*/
		function set_thumb_settings($width=100,$height=100,$fix_aspect="both",$prefix="thumb"){
			if ($fix_aspect=='both'){
				$this->thumb_width=$width;
				$this->thumb_height=$height;	
			}
			else if ($fix_aspect=='width'){
				$this->thumb_width=$width;
				$this->thumb_height=floor(($width/$this->image_width)*$this->image_height);
			}
			else if ($fix_aspect=='height'){
				$this->thumb_height=$height;
				$this->thumb_width=floor(($height/$this->image_height)*$this->image_width);
			}
			$this->prefix=$prefix;
		}		

		/*upload image with auto thumb*/
		function upload_image_with_auto_thumbnail($source,$destination,$name,$margin,$prefix){
			if($this->upload_image($source,$destination,$name)){
				$this->set_auto_thumb_settings($margin);
				if($this->create_thumbnail($this->image_full_path,$destination))
					return true;
				else{
					$this->message="Error Creating Thumb&type=attention";
					return false;
				}
			}else{
				$this->message="Error Uploading Image&type=error";
				return false;
			}
		}
		/*image auto thumb setting*/
		function set_auto_thumb_settings($margin){
			if($this->image_width > $this->image_height){
				$percentage=($margin/$this->image_width);
			}else if($this->image_height > $this->image_width){
				$percentage=($margin/$this->image_height);
			}else{
				$percentage=($margin/$this->image_height);
			}
			
			$this->thumb_width=round($this->image_width*$percentage);
			$this->thumb_height=round($this->image_height*$percentage);
		}

		/*get image filesize*/
		function display_filesize(){
			$filesize=$this->image_size;
			if(is_numeric($filesize)){
				$decr = 1024; 
				$step = 0;
				$prefix = array('Byte','KB','MB','GB','TB','PB');
				while(($filesize / $decr) > 0.9){
					$filesize = $filesize / $decr;
					$step++;
				}
				return round($filesize,2).' '.$prefix[$step];
			}else{
				return 'NaN';
			}
		}

		/*get image resolution*/
		function get_image_resolution(){
			$width=$this->image_width;
			$height=$this->image_height;
			return $width.' x '.$height;
		}

		/*get image size limit*/
		function get_image_size_limit(){
			$result=($this->restricted_size/1024).' MB';
			return $result;
		}

		/*get image name*/
		function get_image_name(){
			return $this->image_name;	
		}

		/*get image full path*/
		function get_image_full_path(){
			return $this->image_full_path;	
		}
	}
	$upload_img=new UploadImage();
?>