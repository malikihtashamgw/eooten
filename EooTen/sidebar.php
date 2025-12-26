<?php
/**
 * The template for displaying the sidebar.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
    wp_reset_postdata();

	if(is_page() || is_page_template('page-blog.php')){
		// Page Sidebar
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar(get_post_meta( get_the_ID(), 'eooten_sidebar', true )) );
	} elseif(is_search()){
		// Search Results Sidebar
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Search Results Widgets') );
	} else {
		// Blog Sidebar && Default Sidebar
		if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Widgets') );
	}
