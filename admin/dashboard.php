<?php

//Mainly used for the purpose of selecting where Ziggeo would be used to show video or record it.

// Index
//	1. Hooks
//		1.1. admin_init
//		1.2. admin_menu
//	2. Fields and sections
//		2.1. ziggeojobmanager_show_form()
//		2.2. ziggeojobmanager_d_core()
//		2.3. ziggeojobmanager_o_submit_form_videor_field()
//		2.4. ziggeojobmanager_o_submit_form_videou_field()
//		2.5. ziggeojobmanager_o_design()
//		2.6. ziggeojobmanager_d_e_resume()
//		2.7. ziggeojobmanager_o_submit_form_e_rm_videor_field()
//		2.8. ziggeojobmanager_o_submit_form_e_rm_videou_field()


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
		add_settings_section('ziggeojobmanager_section_core', '', 'ziggeojobmanager_d_core', 'ziggeojobmanager');
		add_settings_section('ziggeojobmanager_section_e_resumem', '', 'ziggeojobmanager_d_e_resume', 'ziggeojobmanager');


			// Option to turn on or off the option in Job Manager for the videos recorder being part of
			// the submission form or just the standard input field
			add_settings_field('ziggeojobmanager_submit_form_videor_field',
								__('Add Ziggeo recorder on submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_videor_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_core');

			add_settings_field('ziggeojobmanager_submit_form_videou_field',
								__('Add Ziggeo uploader on submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_videou_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_core');

			add_settings_field('ziggeojobmanager_design_buttons',
								__('The design of the recorder and uploader on submission forms', 'ziggeojobmanager'),
								'ziggeojobmanager_o_design',
								'ziggeojobmanager',
								'ziggeojobmanager_section_core');


			//Resume Manager
			add_settings_field('ziggeojobmanager_submit_form_e_rm_videor_field',
								__('Add Ziggeo recorder on Resume submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_e_rm_videor_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_e_resumem');

			add_settings_field('ziggeojobmanager_submit_form_e_rm_videou_field',
								__('Add Ziggeo uploader on Resume submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_e_rm_videou_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_e_resumem');

			add_settings_field('ziggeojobmanager_submit_form_e_rm_videou_field',
								__('Add Ziggeo uploader on Resume submission form', 'ziggeojobmanager'),
								'ziggeojobmanager_o_submit_form_e_rm_videou_field',
								'ziggeojobmanager',
								'ziggeojobmanager_section_e_resumem');
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

		function ziggeojobmanager_d_core() {
			?>
			<h3><?php _e('Job Manager settings', 'ziggeojobmanager'); ?></h3>
			<?php
			_e('Use the settings bellow to change the way Job Manager pages are handling videos', 'ziggeojobmanager');
		}

			function ziggeojobmanager_o_submit_form_videor_field() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['submission_form_video_record']) ) {
					$options['submission_form_video_record'] = '1';
				}

				?>
				<input id="ziggeojobmanager_submission_form_video_record" name="ziggeojobmanager[submission_form_video_record]" size="50" type="checkbox" value="1"
					<?php echo checked( 1, $options['submission_form_video_record'], false ); ?> />
				<label for="ziggeojobmanager_submission_form_video_record"><?php _e('When checked your submission form will show record option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}

			function ziggeojobmanager_o_submit_form_videou_field() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['submission_form_video_uploader']) ) {
					$options['submission_form_video_uploader'] = '1';
				}

				?>
				<input id="ziggeojobmanager_submission_form_video_uploader" name="ziggeojobmanager[submission_form_video_uploader]" size="50" type="checkbox" value="1"
					<?php echo checked( 1, $options['submission_form_video_uploader'], false ); ?> />
				<label for="ziggeojobmanager_submission_form_video_uploader"><?php _e('When checked your submission form will show upload option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}

			function ziggeojobmanager_o_design() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['design']) ) {
					$options['design'] = 'default';
				}

				?>
				<select id="ziggeojobmanager_design" name="ziggeojobmanager[design]">
					<option value="default" <?php echo ($options['design'] === 'default') ? 'selected="selected"' : '' ?> >Default (button and icon)</option>
					<option value="icons" <?php echo ($options['design'] === 'icons') ? 'selected="selected"' : '' ?> >Show Icons</option>
					<option value="buttons" <?php echo ($options['design'] === 'buttons') ? 'selected="selected"' : '' ?> >Show buttons</option>
				</select>
				<label for="ziggeojobmanager_design"><?php _e('When checked your submission form will show upload option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}

		//Resume manager
		function ziggeojobmanager_d_e_resume() {
			?>
			<h3><?php _e('Resume Manager settings', 'ziggeojobmanager'); ?></h3>
			<?php
			_e('Use the settings bellow to change the way Resume Manager pages are handling videos', 'ziggeojobmanager');
		}

			function ziggeojobmanager_o_submit_form_e_rm_videor_field() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['submission_form_e_rm_video_record']) ) {
					$options['submission_form_e_rm_video_record'] = '1';
				}

				?>
				<input id="ziggeojobmanager_submission_form_e_rm_video_record" name="ziggeojobmanager[submission_form_e_rm_video_record]" size="50" type="checkbox" value="1"
					<?php echo checked( 1, $options['submission_form_e_rm_video_record'], false ); ?> />
				<label for="ziggeojobmanager_submission_form_e_rm_video_record"><?php _e('When checked your Resume Manager submission form will show record option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}

			function ziggeojobmanager_o_submit_form_e_rm_videou_field() {
				$options = get_option('ziggeojobmanager');

				if(!isset($options['submission_form_e_rm_video_uploader']) ) {
					$options['submission_form_e_rm_video_uploader'] = '1';
				}

				?>
				<input id="ziggeojobmanager_submission_form_e_rm_video_uploader" name="ziggeojobmanager[submission_form_e_rm_video_uploader]" size="50" type="checkbox" value="1"
					<?php echo checked( 1, $options['submission_form_e_rm_video_uploader'], false ); ?> />
				<label for="ziggeojobmanager_submission_form_e_rm_video_uploader"><?php _e('When checked your Resume Manager submission form will show upload option in job submission form', 'ziggeojobmanager'); ?></label>
				<?php
			}

?>