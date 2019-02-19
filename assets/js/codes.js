//
// INDEX
//	1. Hooks
//		1.1. jQuery on.ready
//	2. Fields on form
//		2.1. ziggeojobmanagerUIFormRecorder()
//	




/////////////////////////////////////////////////
// 1. HOOKS
/////////////////////////////////////////////////

	jQuery(document).ready( function() {
		ziggeojobmanagerUIFormRecorder();
	});



function ziggeojobmanagerUIFormRecorder() {

	var video_field = document.querySelector('#submit-job-form #company_video');

	if(video_field) {
		var recorder_button = document.createElement('span');
		recorder_button.id = 'ziggeojobmanager_recorder';
		recorder_button.className = 'ziggeojobmanager_button';
		recorder_button.innerHTML = 'Record';
		video_field.parentElement.appendChild(recorder_button);

		var recorder = new ZiggeoApi.V2.Recorder({
			element: recorder_button,
			attrs: {
				responsive: true,
				allowupload: false,
				'input-bind': 'company_video',
				theme: "modern",
				themecolor: "red"
			}
		});

		recorder.on('verified', function() {
			document.getElementById('company_video').value = 'https://' + recorder.get('video_data.embed_video_url') + '.mp4';
			console.log('https://' + recorder.get('video_data.embed_video_url') + '.mp4');
		});

		recorder.activate();

		var upload_button = document.createElement('span');
		upload_button.id = 'zigggeojobmanager_uploader';
		upload_button.className = 'ziggeojobmanager_button';
		upload_button.innerHTML = 'Upload';
		video_field.parentElement.appendChild(upload_button);

		var uploader = new ZiggeoApi.V2.Recorder({
			element: upload_button,
			attrs: {
				responsive: true,
				allowrecord: false,
				'input-bind': 'company_video',
				theme: "modern",
				themecolor: "red"
			}
		});

		uploader.on('verified', function() {
			document.getElementById('company_video').value = 'https://' + uploader.get('video_data.embed_video_url') + '.mp4';
			console.log('https://' + uploader.get('video_data.embed_video_url') + '.mp4');
		});

		uploader.activate();
	}
}

