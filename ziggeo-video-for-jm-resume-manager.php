<?php
/*
Plugin Name: Ziggeo Video for Job Manager Resume Manager plugin
Plugin URI: https://ziggeo.com
Description: Add the Powerful Ziggeo video service to your Resume Manager
Author: Ziggeo
Version: 1.0
Author URI: https://ziggeo.com
*/

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//rooth path
define('ZIGGEOJMRM_ROOT_PATH', plugin_dir_path(__FILE__) );

//Setting up the URL so that we can get/built on it later on from the plugin root
define('ZIGGEOJMRM_ROOT_URL', plugins_url() . '/ziggeo-video-for-jm-resume-manager/' );

//plugin version - this way other plugins can get it as well and we will be updating this file for each version change as is
define('ZIGGEOJMRM_VERSION', '1.0');

//Include files
include_once(ZIGGEOJMRM_ROOT_PATH . 'core/run.php');
include_once(ZIGGEOJMRM_ROOT_PATH . 'core/ajax.php');
include_once(ZIGGEOJMRM_ROOT_PATH . 'core/helpers.php');

//Add admin pages allowing us to select which hooks it would use (which segments would parse through Ziggeo)
//include_once(ZIGGEOJMRM_ROOT_PATH . 'admin/dashboard.php');
//include_once(ZIGGEOJMRM_ROOT_PATH . 'admin/validation.php');


?>