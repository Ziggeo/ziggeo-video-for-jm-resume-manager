<?php


function ziggeojobmanager_get_template($type = 'recorder', $specific = 'integrations') {
	$template_used = false;

	if($type === 'recorder') {
		//These are only included if needed and for bellow we do need them
		include_once(ZIGGEO_ROOT_PATH . '/templates/defaults_recorder.php');

		if($code = ziggeo_get_recorder_code($specific)) {

			if($template = ziggeo_p_template_params_as_object(null, $code)) {
				$template_used = true;
			}
		}
	}
	elseif($type === 'player') {
		//These are only included if needed and for bellow we do need them
		include_once(ZIGGEO_ROOT_PATH . '/templates/defaults_player.php');

		if($code = ziggeo_get_player_code($specific)) {

			if($template = ziggeo_p_template_params_as_object(null, $code)) {
				$template_used = true;
			}
		}
	}

	return $template;
}
?>