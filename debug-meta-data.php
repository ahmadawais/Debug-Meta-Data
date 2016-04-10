<?php
/**
 * Plugin Name: Debug Meta Data
 * Description: Dumps all the meta data in a debug metabox for all the post types.
 * Plugin URI: http://ahmadawais.com
 * Author: mrahmadawais
 * Author URI: http://ahmadawais.com
 * Version: 1.0.3
 * License: GPL2
 * Text Domain: DMD
 *
 * @package DMD
 */

/*
    Copyright (C) Year  Ahmad Awais (http://ahmadawais.com/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add Meta box.
 *
 * @since 1.0.1
 */
function debug_meta_data_add_meta_box() {

	$post_types = get_post_types();
	foreach ( $post_types as $post_type ) {

		add_meta_box(
			'debug_meta_data-debug-meta-data',
			__( 'Debug Meta Data', 'debug_meta_data' ),
			'debug_meta_data_html',
			$post_type,
			'normal',
			'low'
		);

	}
}

/**
 * Meta box Output
 *
 * @since 1.0.1
 */
function debug_meta_data_html( $post ) {

	echo '<h3>All Meta Data</h3>';

	// Get all the data.
	$get_post_custom_val = get_post_custom( $post->ID );
	foreach ( $get_post_custom_val as $name => $value ) {

	    echo '<strong>' . $name . '</strong> =>  ';
	    foreach ( $value as $name_array => $value_array ) {
	            echo $name_array . '  =>  ' . $value_array;
	            echo var_dump( $value_array );
	    }
	    echo '<br />';

	}
}

// Let's finally add it.
add_action( 'add_meta_boxes', 'debug_meta_data_add_meta_box' );




/**
 * Dump User Meta Data.
 *
 * @since  1.0.1
 */
function dmd_dump_user_meta( $user ) {

	echo "<hr/><h2>User Meta Data</h2>";

	// Current User's meta data
	$dmd_user_meta = get_user_meta( get_current_user_id() );

	// Dump the data.
	foreach ( $dmd_user_meta as $name => $value ) {
	    echo "<strong>".$name."</strong>"."  =>  ";

	    foreach ( $value as $nameAr=>$valueAr ) {
	            echo $nameAr . "  =>  " . $valueAr;
	            echo var_dump( $valueAr );
	    }
	    echo "<br />";
	}
}

// Add it.
add_action( 'show_user_profile', 'dmd_dump_user_meta' );
add_action( 'edit_user_profile', 'dmd_dump_user_meta' );
