<?php
/*
Plugin Name: Ziggeo Video for Job Manager plugin
Plugin URI: https://ziggeo.com
Description: Add the Powerful Ziggeo video service to your Job Manager plugin. Included support for Resume Manager addon
Author: Ziggeo
Version: 1.0
Author URI: https://ziggeo.com
*/

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//rooth path
define('ZIGGEOJOBMANAGER_ROOT_PATH', plugin_dir_path(__FILE__) );

//Setting up the URL so that we can get/built on it later on from the plugin root
define('ZIGGEOJOBMANAGER_ROOT_URL', plugins_url() . '/ziggeo-video-for-job-manager/' );

//plugin version - this way other plugins can get it as well and we will be updating this file for each version change as is
define('ZIGGEOJOBMANAGER_VERSION', '1.0');

//Include files
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'core/run.php');
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'admin/dashboard.php');
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'admin/validation.php');
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'core/ajax.php');
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'core/helpers.php');
include_once(ZIGGEOJOBMANAGER_ROOT_PATH . 'core/header.php');

add_action('plugins_loaded', function() {
	include_once( ZIGGEOJOBMANAGER_ROOT_PATH . 'core/assets.php');
});


?>