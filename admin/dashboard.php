<?php

//Mainly used for the purpose of selecting where Ziggeo would be used to show video or record it.

// Index
//	1. Hooks
//		1.1. admin_init
//		1.2. admin_menu
//	2. Fields and sections
//		2.1. ziggeojobmanager_show_form()
//		2.2. ziggeojobmanager_d_hooks()
//		2.3. ziggeojobmanager_o_submit_form_video_field()

//Checking if WP is running or if this is a direct call..
defined('ABSPATH') or die();



/////////////////////////////////////////////////
//	1. HOOKS
/////////////////////////////////////////////////

	//Add plugin options
	add_action('admin_init', function() {
		//Register settings
		register_setting('ziggeojobmanager', 'ziggeojobmanager', 'ziggeojobmanager_validate');

		//Active hooks
		add_settings_section('ziggeojobmanager_section_hooks', '', 'ziggeojobmanager_d_hooks', 'ziggeojobmanager');


			// Option to turn on or off the option in Job Manager for the videos recorder being part of
			// the submission form or just the standard input field
			add_settings_field('ziggeojobmanager_submit_form_video_field',
								__('Add Ziggeo recorder on submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_video_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_hooks');

	});

	add_action('admin_menu', function() {
		add_submenu_page(
			'ziggeo_video',						//parent slug
			'Ziggeo Video for Job Manager',		//page title
			'Ziggeo Video for Job Manager',		//menu title
			'manage_options',					//min capability to view
			'ziggeojobmanager',					//menu slug
			'ziggeojobmanager_show_form'		//function
		);
	});




/////////////////////////////////////////////////
//	2. FIELDS AND SECTIONS
/////////////////////////////////////////////////

	//Dashboard form
	function ziggeojobmanager_show_form() {
		?>
		<div>
			<h2>Ziggeo Video for Job Manager</h2>

			<form action="options.php" method="post">
				<?php
				wp_nonce_field('ziggeojobmanager_nonce_action', 'ziggeojobmanager_video_nonce');
				get_settings_errors();
				settings_fields('ziggeojobmanager');
				do_settings_sections('ziggeojobmanager');
				submit_button('Save Changes');
				?>
			</form>
		</div>
		<?php
	}

		function ziggeojobmanager_d_hooks() {
			?>
			<h3><?php _e('Job Manager settings', 'ziggeojobmanager'); ?></h3>
			<?php
			_e('Use the settings bellow to change the way Job Manager pages are handling videos', 'ziggeojobmanager');
		}

			function ziggeojobmanager_o_submit_form_video_field() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['submission_form_video']) ) {
					$options['submission_form_video'] = '1';
				}

				?>
				<input id="ziggeojobmanager_submission_form_video" name="ziggeojobmanager[submission_form_video]" size="50" type="checkbox" value="1"
					<?php echo checked( 1, $options['submission_form_video'], false ); ?> />
				<label for="ziggeojobmanager_submission_form_video"><?php _e('When checked your submission form will show record and upload option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}


?>