<?php

//
//	This file represents the integration module for Job Manager plugin addon called "Resume Manager" and Ziggeo
//

// Index
//	1. Hooks
//		1.1. ziggeo_list_integration
//		1.2. plugins_loaded
//	2. General functionality
//		2.1. ziggeojmrm_get_version()
//		2.1. ziggeojmrm_init()
//		2.1. ziggeojmrm_run()


//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


/////////////////////////////////////////////////
// 1. HOOKS
/////////////////////////////////////////////////

	//Show the entry in the integrations panel
	add_action('ziggeo_list_integration', function() {

		$data = array(
			//This section is related to the plugin that we are combining with the Ziggeo, not the plugin/module that does it
			'integration_title'		=> 'Job Manager\'s addon "Resume Manager"', //Name of the plugin
			'integration_origin'	=> 'https://wpjobmanager.com/add-ons/resume-manager/', //Where you can download it from

			//This section is related to the plugin or module that is making the connection between Ziggeo and the other plugin.
			'title'					=> 'Ziggeo Video for Job Manager\'s Resume Managger', //the name of the module
			'author'				=> 'Ziggeo', //the name of the author
			'author_url'			=> 'https://ziggeo.com/', //URL for author website
			'message'				=> 'Add videos to your Resume Manger plugin', //Any sort of message to show to customers
			'status'				=> true, //Is it turned on or off?
			'slug'					=> 'ziggeo-video-for-jm-resume-manager', //slug of the module
			//URL to image (not path). Can be of the original plugin, or the bridge
			'logo'					=> ZIGGEOJMRM_ROOT_URL . 'assets/images/logo.png',
		);

		//Check current Ziggeo version
		if(ziggeojmrm_run() === true) {
			$data['status'] = true;
		}
		else {
			$data['status'] = false;
		}

		echo zigeo_integration_present_me($data);
	});

	add_action('plugins_loaded', function() {
		ziggeojmrm_run();
	});

/////////////////////////////////////////////////
// 2. GENERAL FUNCTIONALITY
/////////////////////////////////////////////////

	//Checks if the Job Manager exists and returns the version of it
	function ziggeojmrm_get_version() {
		if(defined('JOB_MANAGER_VERSION')) {
			//Job Manager is enabled, we need Resume Manager as well
			if(defined('RESUME_MANAGER_VERSION')) {
				return RESUME_MANAGER_VERSION;
			}
		}

		return 0;
	}

	//Function that we use to run the module 
	function ziggeojmrm_run() {

		//Needed during activation of the plugin
		if(!function_exists('ziggeo_get_version')) {
			return false;
		}

		//Check current Ziggeo version
		if( version_compare(ziggeo_get_version(), '2.0') >= 0 &&
			//check the bbPress version
			version_compare(ziggeojmrm_get_version(), '1.15.2') >= 0) {

			if(ziggeo_integration_is_enabled('ziggeo-video-for-jm-resume-manager')) {
				ziggeojmrm_init();
				return true;
			}
		}

		return false;
	}

	//We add all of the hooks we need
	function ziggeojmrm_init() {

		$options = get_option('ziggeojmrm');

		//filter to change the fileds on the form
		add_filter('submit_resume_form_fields', 'ziggeojmrm_change_field');

		//used to allow us to grab the "ziggeo-{token}" if present in passed content and change it with out code..
		//add_filter( 'wp_video_shortcode_override', 'ziggeo_JobManagerResumeManager_filterVideos' );

		//the above might no longer be needed...
		add_filter('the_candidate_video', 'ziggeojmrm_play_on_resume');
	}

	function ziggeojmrm_change_field($fields) {
		//include_once /assets/js/codes.js
		//activate the first part of codes.js
		return $fields;
	}

	function ziggeojmrm_play_on_resume() {
		?>
		<script type="text/javascript">
			//activate the function we need
		</script>
		<?php
	}

?>