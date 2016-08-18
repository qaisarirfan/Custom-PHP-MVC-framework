<?php
	include("php/class.captcha.php");

	$configuration = array(
		'captcha_type' => 'custom', // random, custom, default
		'image_width' => '200',
		'image_height' => '100',
		'background' => array ( 'i8ReKS' => array ( 'background' => 'background/i8ReKS.png', 'color' => 'e0e0e0', 'opacity' => '0' ) ),
		'fonts' => array( 'Attic' => 'fonts/Attic.otf' ),
		'color' => 'ff0', // fff, f00, 00f, ff0

		'min_font_size' => '15',
		'max_font_size' => '30',

		'min_rotation' => '-13',
		'max_rotation' => '13',

		'word_lenght' => '3', // limit 2, 10
		'word_type' => 'alphabetic', // alphabetic, mixstring, number, math, dictionary

		'multiple_word' => true, // false, true
		'multiple_word_lenght' => '2', // 1, 2, 3, 4
		'random_word_lenght' => array ('3','5'), // array ('3','5','7','10')

		'math_first_range' => array (10,19),
		'math_second_range' => array (1,9),
		'math_operator' => '+', // +, -
	);

	$conf = array(
		'captcha_type' => 'default', // random, custom, default
		'image_width' => '200',
		'image_height' => '100',
		'background' => array ( 'i8ReKS' => array ( 'background' => 'background/i8ReKS.png', 'color' => 'e0e0e0', 'opacity' => '0' ) ),
		'fonts' => array( 'Attic' => 'fonts/Attic.otf' ),
		'color' => 'ff0', // fff, f00, 00f, ff0

		'min_font_size' => '18',
		'max_font_size' => '48',

		'min_rotation' => '-13',
		'max_rotation' => '13',

		'word_lenght' => '3', // limit 2, 10
		'word_type' => 'math', // alphabetic, mixstring, number, math, dictionary

		'multiple_word' => true, // false, true
		'multiple_word_lenght' => '2', // 1, 2, 3, 4
		'random_word_lenght' => array ('3','5'), // array ('3','5','7','10')

		'math_first_range' => array (10,19),
		'math_second_range' => array (1,9),
		'math_operator' => '+', // +, -
	);

	$captch = new Captcha( $conf );

	$captch->get_captcha();
?>