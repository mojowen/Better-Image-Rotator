<?php 
/*
Plugin Name: Better Image Rotator Widget
Plugin URI: https://github.com/mojowen/Better-Image-Rotator
Description: Better Image Rotator thing
Author: Scott Duncombe
Version: 0.5
Author URI: http://scottduncombe.com/
*/

// Setting a base path. Easy change if the code is going to be incorporated into a theme, use get_bloginfo('theme_directory') instead
$base = WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__), "" ,plugin_basename(__FILE__));
define('better_img_rotator_base', $base);

include_once('widget.php');
?>