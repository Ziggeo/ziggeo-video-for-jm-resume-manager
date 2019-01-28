<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();


//WP Dashboad > Plugins (list)

//For a link to settings in plugins screen
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
	//$links[] = '<a href="' . esc_url( get_admin_url(null, 'options-general.php?page=ziggeojmrm') ) . '">' .
	//			_x('Settings', '"Settings" link on the Plugins page', 'ziggeojmrm') . '</a>';
	$links[] = '<a href="mailto:support@ziggeo.com">'.
				_x('Support', '"Support" link on the Plugins page', 'ziggeojmrm') . '</a>';
	return $links;
});

?>