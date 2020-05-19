<?php

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();

//We are hooking into the ZiggeoWP object and adding a property of our own within the same.
add_action('ziggeo_add_to_ziggeowp_object', function() {

	$options = get_option('ziggeojobmanager');

	?>
	jobmanager: {
		show_recorder: <?php echo ($options['submission_form_video_record'] != '0') ? 'true': 'false'; ?>,
		show_uploader: <?php echo ($options['submission_form_video_uploader'] != '0') ? 'true': 'false'; ?>,
		design: '<?php echo $options['design']; ?>',
		addons: {
			resume_manager: {
				show_recorder: <?php echo ($options['submission_form_e_rm_video_record'] != '0') ? 'true': 'false'; ?>,
				show_uploader: <?php echo ($options['submission_form_e_rm_video_uploader'] != '0') ? 'true': 'false'; ?>,
				hide_link_field: <?php echo ($options['submission_form_e_rm_video_link'] != '0') ? 'true': 'false'; ?>
			}
		}
	},
	<?php
});

?>