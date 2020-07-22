<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

function ziggeojobmanager_get_template($type = 'video-recorder') {
	$template_used = false;
	$code = '';

	if($type === 'video-recorder') {
		//These are only included if needed and for bellow we do need them
		//include_once(ZIGGEO_ROOT_PATH . '/templates/defaults_recorder.php');

		if($code = ziggeo_get_recorder_code('integrations')) {

			// if($template = ziggeo_p_template_params_as_object(null, $code)) {
			// 	$template_used = true;
			// }
		}
	}
	elseif($type === 'video-player') {
		//These are only included if needed and for bellow we do need them
		//include_once(ZIGGEO_ROOT_PATH . '/templates/defaults_player.php');

		if($code = ziggeo_get_player_code('integrations')) {

			// if($template = ziggeo_p_template_params_as_object(null, $code)) {
			// 	$template_used = true;
			// }
		}
	}

	//return $template;
	return $code;
}
?>