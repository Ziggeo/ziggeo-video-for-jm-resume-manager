<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We hook into the Ziggeo AJAX call
add_filter('ziggeo_ajax_call', function($result, $operation) {

	if($operation === 'ziggeojobmanager-get-template') {

		$type = ''; //If it is not a good call we just return empty string

		if(isset($_POST['template_type'])) {
			$type = $_POST['template_type'];
		}

		//return the template that is set to be used by plugins, or the one defined in the settings
		return ziggeojobmanager_get_template($type);
	}

	return '';
}, 10, 2);

add_filter('ziggeo_ajax_call_client', function($result, $operation) {

	$type = ''; //If it is not a good call we just return empty string

	if(isset($_POST['template_type'])) {
		$type = $_POST['template_type'];
	}


	if($operation === 'ziggeojobmanager-get-template') {
		//return the template that is set to be used by plugins, or the one defined in the settings
		return ziggeojobmanager_get_template($type);
	}

	return '';
}, 10, 2);

?>