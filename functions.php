<?php
/*
** Copyright 2010-2014, Pye Brook Company, Inc.
**
** Licensed under the Pye Brook Company, Inc. License, Version 1.0 (the "License");
** you may not use this file except in compliance with the License.
** You may obtain a copy of the License at
**
**     http://www.pyebrook.com/
**
** This software is not free may not be distributed, and should not be shared.  It is governed by the
** license included in its original distribution (license.pdf and/or license.txt) and by the
** license found at www.pyebrook.com.
*
** This software is copyrighted and the property of Pye Brook Company, Inc.
**
** See the License for the specific language governing permissions and
** limitations under the License.
**
** Contact Pye Brook Company, Inc. at info@pyebrook.com for more information.
*/


add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	$timestamp = filemtime( get_stylesheet_directory()  . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style'), $timestamp  );
}


add_filter( 'wpsc_get_customer_meta', 'force_grid_view', 10, 3 );

function force_grid_view( $check_value, $key, $id ) {

	if ( 'display_type' == $key ) {
		$check_value = 'grid';
	}

	return $check_value;
}

add_filter( 'comment_form_defaults', 'comment_form_defaults_title' );

function comment_form_defaults_title( $defaults ) {
	$defaults['title_reply'] = 'Have a question or comment?';
	return $defaults;
}

