<?php

/*
Now part of MFO base plugin
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//from http://ideas.woothemes.com/forums/191508-sensei/suggestions/5350719-add-next-lesson-button-once-lesson-is-complete
/* works, but keeps the anchor tag on the redirect
function sensei_user_lesson_end_goto_next () {
	global $post;
	$nav_id_array = sensei_get_prev_next_lessons( $post->ID );
	$next_lesson_id = absint( $nav_id_array['next_lesson'] );
	wp_redirect( get_permalink( $next_lesson_id ) );
}

add_action( 'sensei_user_lesson_end', 'sensei_user_lesson_end_goto_next' );
*/

/* DUH, this is a setting. Keeping the code here for reference
function mfo_sensei_configure_emails( $obj ) {
	remove_action( 'sensei_user_course_start', array( $obj, 'teacher_started_course' ), 10, 2 );
}

add_action('sensei_emails', 'mfo_sensei_configure_emails');
*/

/*
function enroll_course_shortcode( $atts, $content = null ) {
	WooThemes_Sensei_Utils::user_start_course('2121', '3825');
}
add_shortcode( 'enrollcourse', 'enroll_course_shortcode' );
*/

//todo: remove hard coded course ids

function enroll_maker_courses_shortcode( $atts, $content = null ) {
	$curuser = wp_get_current_user();
	WooThemes_Sensei_Utils::user_start_course($curuser->ID, '3825'); //registering
	WooThemes_Sensei_Utils::user_start_course($curuser->ID, '3874'); //maker-manual
	//return $output;
	return;
}
add_shortcode( 'enroll-maker-courses', 'enroll_maker_courses_shortcode' );

function enroll_producer_courses_shortcode( $atts, $content = null ) {
	$curuser = wp_get_current_user();
	WooThemes_Sensei_Utils::user_start_course($curuser->ID, '4631'); //website features for producers
	WooThemes_Sensei_Utils::user_start_course($curuser->ID, '3874'); //maker-manual
	return $output;
}
add_shortcode( 'enroll-producer-courses', 'enroll_producer_courses_shortcode' );

//fix sensei sidebar issues
//as per http://docs.woothemes.com/document/sensei-and-theme-compatibility/
//needed to be called from function.php - calling from plugin was not working...
function mfo_sensei_compatibility() {
	global $woothemes_sensei;
	mfo_log(4, "mfo_sensei_compatibility", "fixing compat issues");
	remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
	remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

	add_action('sensei_before_main_content', 'mfo_theme_wrapper_start', 10);
	add_action('sensei_after_main_content', 'mfo_theme_wrapper_end', 10);
	}

function mfo_theme_wrapper_start() {
	mfo_log (4, "mfo_theme_wrapper_start", "adding content-container div");
  	echo '<div id="content-container"><div id="content" role="main">';
}

function mfo_theme_wrapper_end() {
	mfo_log (4, "mfo_theme_wrapper_end", "closing content and content-container div");
  	echo '</div><!-- #content -->
	<!---------------- WRAPPER END------------------------------->
       </div><!-- #content-container -->';
        get_sidebar();
}

//declare sensei support for theme to stop annoying messages
add_action( 'after_setup_theme', 'declare_sensei_support' );
function declare_sensei_support() {
    add_theme_support( 'sensei' );
}

/*
//Doesn't look like they really implemnted this - only changes in some places
add_filter( 'sensei_lessons_text', 'sensei_custom_lessons_text', 10 );

function sensei_custom_lessons_text () {
        $text = "Topics";
        return $text;
}
*/


?>
