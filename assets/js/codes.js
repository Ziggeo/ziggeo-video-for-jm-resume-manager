//
// INDEX
//	1. Job Manager
//		1.1. jQuery on.ready
//		1.2. ziggeojobmanagerUIFormRecorder()

//	2. Extension: Resume Manager
//		3.1. jQuery on.ready
//		2.1. ziggeojobmanagerUIResumeFormInit()
//	3. Admin
//		3.1. jQuery on.ready
//		3.1. ziggeojobmanagerShowVideoPreviewInit()




/////////////////////////////////////////////////
// 1. JOB MANAGER
/////////////////////////////////////////////////

	jQuery(document).ready( function() {
		ziggeojobmanagerUIFormRecorder(
			document.querySelector('#submit-job-form #company_video'),
			'company_video',
			ZiggeoWP.jobmanager.show_recorder,
			ZiggeoWP.jobmanager.show_uploader,
			false
		);
	});

	function ziggeojobmanagerUIFormRecorder(video_field, field_id, show_recorder, show_uploader, hide_link_field) {

		if(video_field) {

			if(hide_link_field === true) {
				video_field.style.display = 'none';
			}

			if(show_recorder === true) {
				var recorder_button = document.createElement('span');
				recorder_button.id = 'ziggeojobmanager_recorder';

				//Setup the class
				recorder_button.className = 'ziggeojobmanager_button';

				if(show_uploader === false) {
					recorder_button.className += ' wide';
				}

				if(ZiggeoWP.jobmanager.design === 'icons') {
					recorder_button.className += ' icons';
				}
				else if(ZiggeoWP.jobmanager.design === 'buttons') {
					recorder_button.className += ' noicons';
				}

				video_field.parentElement.appendChild(recorder_button);

				var recorder = new ZiggeoApi.V2.Recorder({
					element: recorder_button,
					attrs: {
						responsive: true,
						allowupload: false,
						theme: "modern",
						themecolor: "red"
					}
				});

				recorder.on('verified', function() {
					document.getElementById(field_id).value = 'https://' + recorder.get('video_data.embed_video_url') + '.mp4';
				});

				recorder.activate();
			}

			if(show_uploader === true) {
				var upload_button = document.createElement('span');
				upload_button.id = 'zigggeojobmanager_uploader';

				//Setup classes
				upload_button.className = 'ziggeojobmanager_button';

				if(show_recorder === false) {
					upload_button.className += ' wide';
				}

				if(ZiggeoWP.jobmanager.design === 'icons') {
					upload_button.className += ' icons';
				}
				else if(ZiggeoWP.jobmanager.design === 'buttons') {
					upload_button.className += ' noicons';
				}

				video_field.parentElement.appendChild(upload_button);

				var uploader = new ZiggeoApi.V2.Recorder({
					element: upload_button,
					attrs: {
						responsive: true,
						allowrecord: false,
						theme: "modern",
						themecolor: "red"
					}
				});

				uploader.on('verified', function() {
					document.getElementById(field_id).value = 'https://' + uploader.get('video_data.embed_video_url') + '.mp4';
				});

				uploader.activate();
			}

			return true;
		}

		return false;
	}




/////////////////////////////////////////////////
// EXTENSION: RESUME MANAGER
/////////////////////////////////////////////////

	jQuery(document).ready( function() {
		ziggeojobmanagerUIResumeFormInit();
	});

	//Resume submission form
	function ziggeojobmanagerUIResumeFormInit(video_field) {

		var video_field = document.querySelector('#submit-resume-form #candidate_video');

		if(video_field) {

				return ziggeojobmanagerUIFormRecorder(video_field,
													'candidate_video',
													ZiggeoWP.jobmanager.addons.resume_manager.show_recorder,
													ZiggeoWP.jobmanager.addons.resume_manager.show_uploader,
													ZiggeoWP.jobmanager.addons.resume_manager.hide_link_field
				);
		}

		return false;
	}




/////////////////////////////////////////////////
// 3. ADMIN
/////////////////////////////////////////////////

	jQuery(document).ready( function() {
		ziggeojobmanagerShowVideoPreviewInit();
	});

	function ziggeojobmanagerShowVideoPreviewInit() {

		var video_field = document.querySelector('#resume_data.postbox #_candidate_video');

		if(video_field) {
			var _preview = document.createElement('div');
			_preview.id = 'ziggeojobmanager_preview';
			_preview.className = 'button';
			_preview.innerHTML = 'View';

			_preview.addEventListener('click', function() {
				//show a popup player
				ziggeoShowOverlayWithPlayer(null, document.getElementById('_candidate_video').value);
			});

			video_field.parentElement.appendChild(_preview);
		}
	}
