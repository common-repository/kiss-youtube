<?php
/*
	Plugin Name: KISS Youtube
	Plugin URI: http://grugl.me/2009/05/15/kiss-youtube-english/
	Description: Keep It Simple Stupid Youtube plugin helps to add YouTube videos into your posts with Valid XHTML. It can't be more easiest. Just place the code of Youtube video between [youtube][/youtube] or [youtubewd][/youtubewd] tags. Also check your admin HTML-Editor for a new button for quick addition.
	Version: 1.0
	Author: Dimitry German
	Author URI: http://grugl.me
	Copyright 2009, Dimitry German
*/

function kisstube($content){
	$width = 425; $height = 344;		// Standart Screen Size
	$widthwd = 560; $heightwd = 340;	// Widescreen Size
	$addvalue ='&fs=1&rel=0&hd=1&showinfo=0';		// Addition params for Youtube
	$array = preg_split( "/\[(?i)youtube(?-i)]/", $content );
	$output = $array[0];
	for ($i=1; $i < count ($array); $i++ ){
		$array_temp = preg_split( "/\[\/(?i)youtube(?-i)]/", $array[$i] );
		$getid = $array_temp[0];
		$output .= '<object type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" data="http://www.youtube.com/v/'.$getid.$addvalue.'"><param name="movie" value="http://www.youtube.com/v/'.$getid.$addvalue.'"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent" /></object>';
		$output .= $array_temp[1];
	}	
	
	$array = preg_split( "/\[(?i)youtubewd(?-i)]/", $output );
	$output = $array[0];
	for ($i=1; $i < count ($array); $i++ ){
		$array_temp = preg_split( "/\[\/(?i)youtubewd(?-i)]/", $array[$i] );
		$getid = $array_temp[0];
		$output .= '<object width="'.$widthwd.'" height="'.$height.'" allowfullscreen="true" type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$getid.$addvalue.'"><param name="movie" value="http://www.youtube.com/v/'.$getid.$addvalue.'" /></object>';
		$output .= $array_temp[1];
	}
	return $output;
}

function youtube_button(){
	if(preg_match('~post(-new)?.php~',$_SERVER['REQUEST_URI'])){
		wp_print_scripts( 'quicktags' );
		echo "<script type=\"text/javascript\">"."\n";
		echo "/* <![CDATA[ */"."\n";
		echo "edButtons[edButtons.length] = new edButton"."\n";
		echo "\t('ed_YTube',"."\n";
		echo "\t'YTube'"."\n";
		echo "\t,'[youtube]'"."\n";
		echo "\t,'[/youtube]'"."\n";
		echo "\t,'n'"."\n";
		echo "\t);"."\n";
		echo "/* ]]> */"."\n";
		echo "</script>"."\n";
	}
}

add_filter('the_content','kisstube');
add_action('admin_head','youtube_button');
?>