<?php

//
//	This file represents the integration module for Job Manager plugin addon called "Resume Manager" and Ziggeo
//

// Index
//	1. Hooks
//		1.1. ziggeo_list_integration
//		1.2. plugins_loaded
//	2. General functionality
//		2.1. ziggeojobmanager_get_version()
//		2.1. ziggeojobmanager_init()
//		2.1. ziggeojobmanager_run()


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


/////////////////////////////////////////////////
// 1. HOOKS
/////////////////////////////////////////////////

	//Show the entry in the integrations panel
	add_action('ziggeo_list_integration', function() {

		$data = array(
			//This section is related to the plugin that we are combining with the Ziggeo, not the plugin/module that does it
			'integration_title'		=> 'Job Manager', //Name of the plugin
			'integration_origin'	=> 'https://wordpress.org/plugins/wp-job-manager/', //Where you can download it from

			//This section is related to the plugin or module that is making the connection between Ziggeo and the other plugin.
			'title'					=> 'Ziggeo Video for Job Manager plugin', //the name of the module
			'author'				=> 'Ziggeo', //the name of the author
			'author_url'			=> 'https://ziggeo.com/', //URL for author website
			'message'				=> 'Add videos to your Job Manager plugin and its addons', //Any sort of message to show to customers
			'status'				=> true, //Is it turned on or off?
			'slug'					=> 'ziggeo-video-for-job-manager', //slug of the module
			//URL to image (not path). Can be of the original plugin, or the bridge
			'logo'					=> ZIGGEOJOBMANAGER_ROOT_URL . 'assets/images/logo.png',
		);

		//Check current Ziggeo version
		if(ziggeojobmanager_run() === true) {
			$data['status'] = true;
		}
		else {
			$data['status'] = false;
		}

		echo zigeo_integration_present_me($data);
	});

	add_action('plugins_loaded', function() {
		ziggeojobmanager_run();
	});




/////////////////////////////////////////////////
// 2. GENERAL FUNCTIONALITY
/////////////////////////////////////////////////

	//Checks if the Job Manager exists and returns the version of it
	function ziggeojobmanager_get_version($core = true) {
		if(defined('JOB_MANAGER_VERSION')) {

			if($core === true) {
				return JOB_MANAGER_VERSION;
			}
			elseif($core === 'resume-manager') {
				//Job Manager is enabled, we need Resume Manager as well
				if(defined('RESUME_MANAGER_VERSION')) {
					return RESUME_MANAGER_VERSION;
				}
			}
		}

		return 0;
	}

	//Function that we use to run the module 
	function ziggeojobmanager_run() {

		//Needed during activation of the plugin
		if(!function_exists('ziggeo_get_version')) {
			return false;
		}

		//Check current Ziggeo version
		if( version_compare(ziggeo_get_version(), '2.0') >= 0 &&
			//check the job manager version
			version_compare(ziggeojobmanager_get_version(), '1.15.2') >= 0) {

			if(ziggeo_integration_is_enabled('ziggeo-video-for-job-manager')) {
				ziggeojobmanager_init();
				return true;
			}
		}

		return false;
	}

	//We add all of the hooks we need
	function ziggeojobmanager_init() {

		$options = get_option('ziggeojobmanager');

		//The hook for showing of the video on the front end under jobs listing
		add_filter('the_company_video_embed', function($video_embed, $post) {

			//In case it is "outside" video
			if(stripos($video_embed, '<video')) {
				//There is a video within it..

				//prefered
				if($pos = stripos($video_embed, '<source type="video/mp4" src="')) {

					$link = substr($video_embed, $pos + 30);

					$link = substr($link, 0, strpos($link, ' ') - 1);
				}
				else {
					$pos = stripos($video_embed, 'src="');

					$link = substr($video_embed, $pos + 5);

					$link = substr($link, 0, strpos($link, ' ') - 1);
				}

				//grab the default video player template that should be used
				include_once(ZIGGEO_ROOT_PATH . '/templates/defaults_player.php');
				$code = ziggeo_get_player_code('integrations');

				$video_embed = '<ziggeoplayer ' . $code . ' ziggeo-source="' . $link . '"></ziggeoplayer>';
				//anything else
			}

			return $video_embed;
		}, 10, 2);

		//the above might no longer be needed...
		add_filter('the_candidate_video', 'ziggeojobmanager_play_on_resume');
	}

?>