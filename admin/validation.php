<?php

//to be added

//Validate options
function ziggeojobmanager_validate($input) {

	$allowed_options = array(
		'submission_form_video_record'			=> true,
		'submission_form_video_uploader'		=> true,
		'design'								=> true,
		//the Resume Manager addon
		'submission_form_e_rm_video_record'		=> true,
		'submission_form_e_rm_video_uploader'	=> true
	);

	$options = get_option('ziggeojobmanager');

	foreach($allowed_options as $option => $value) {

		if(isset($input[$option])) {
			$options[$option] = $input[$option];
		}
		else {
			$options[$option] = '0';
		}
	}

	return $options;
}



?>