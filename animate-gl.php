<?php

/*
Plugin Name: AnimateGL 
Plugin URI: http://codecanyon.net/user/creativeinteractivemedia
Description: Animate HTML elements with WebGL 
Version: 1.0
Author: creativeinteractivemedia
Author URI: http://codecanyon.net/user/creativeinteractivemedia
*/

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

define('ANIMATE_GL_VERSION', '1.0');
define('ANIMATE_GL_FILE', __FILE__);
    
include_once( plugin_dir_path( ANIMATE_GL_FILE ).'/includes/main.php' );

$animate_gl = AnimateGL::get_instance( );