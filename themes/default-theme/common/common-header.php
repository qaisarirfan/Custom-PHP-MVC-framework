<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en-us" class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html lang="en-us" class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html lang="en-us" class="no-js ie8 oldie"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en-us" class="no-js">
<!--<![endif]-->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $page_name = basename( $_SERVER['SCRIPT_FILENAME'] ); ?>
<?php if( $page_name == 'index.php' && $this->preferences['seo_home_title'] == '' ){ ?>
<title><?php echo APP_TITLE; ?></title>
<?php }elseif( $page_name == 'index.php' && $this->preferences['seo_home_title'] != '' ){ ?>
<title><?php echo $this->preferences['seo_home_title']; ?></title>
<?php }else{ ?>
<title><?php echo $this->page_title . " | " . APP_TITLE; ?></title>
<?php } ?>
<link rel="shortcut icon" href="<?php echo $this->get_site_content_path(); ?>/logo/favicon.ico?v1" />

<link rel="stylesheet" href="<?php echo $this->get_theme_name_with_http(); ?>/css/style.css?v1" />
<link href="<?php echo $this->get_resources_path(); ?>/js-jquery/jquery-mega-drop-down-menu/css/dcmegamenu.css?v1" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->get_resources_path(); ?>/js-jquery/jquery-mega-drop-down-menu/css/skins/black.css?v1" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $this->get_resources_path(); ?>/js-jquery/jquery-1.7.min.js"></script>
<script type='text/javascript' src='<?php echo $this->get_resources_path(); ?>/js-jquery/jquery-mega-drop-down-menu/js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='<?php echo $this->get_resources_path(); ?>/js-jquery/jquery-mega-drop-down-menu/js/jquery.dcmegamenu.1.3.3.min.js'></script>
<script type="text/javascript" src="<?php echo $this->get_theme_name_with_http(); ?>/js/common-js.js"></script>
<script type="text/javascript">
$(document).ready(function($){
	$('#mega-menu').show();
	$('#mega-menu').dcMegaMenu({
		rowItems: '10',
		speed: 'fast',
		effect: 'fade'
	});
});
</script>
<?php if( $this->preferences['body_background'] == 'custom' ){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->get_site_content_path(); ?>/custom-background/css/custom-css.css" media="screen"/>
<?php } ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f38fa2e6466640a"></script>
<script type="text/javascript">
  addthis.layers({
    'theme' : 'dark',
    'share' : {
      'position' : 'left',
      'numPreferredServices' : 6
    }   
  });
</script>

