<?php

/**
 * Plugin Name: Embed Custom Field
 * Plugin URI: http://wordpress.org/plugins/embed-custom-field/
 * Description: Adds shortcode for including custom field data in posts/pages.
 * Version: 1.0.1
 * Author: Phil Hilton
 * Author URI: http://profiles.wordpress.org/philhilton/
 * License: GPLv2 or later.
 */
 
 /*  Copyright 2014  Phil Hilton  (email : philwordpress@umf.maine.edu)

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

defined('ABSPATH') or die("kthxbye!");

function shortcode_embed_custom_field ($atts) {
	if (! isset($atts[0]) ) return '';
	global $post;
	$theContent = get_post_meta($post->ID, esc_attr($atts[0]), true);
	return $theContent ? $theContent : '';
}
add_shortcode('embed_custom_field', 'shortcode_embed_custom_field');

?>