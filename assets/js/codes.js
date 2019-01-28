
//
// INDEX
//	1. Hooks
//		1.1. on.ready
//		1.1. embed_events.on.verified
//	2. Field on form
//		2.1. ziggeojmrmChangeVideoField()
//	3. On Resume
//		3.1. on.ready
//	4. Simplifiers
//		4.1. ziggeojmrmStoreToken()
//		4.2. ziggeojmrmGetStoredToken()
//		4.3. ziggeojmrmCreateButtons()




/////////////////////////////////////////////////
// 1. HOOKS
/////////////////////////////////////////////////

	ziggeo_app.on('ready', function() {
		ziggeojmrmChangeVideoField();
	});

	//make the submission of video save the token into the video filed..
	//we add "ziggeo-" before the token so that we check if the value contains "ziggeo" and if it does, we know
	// that token is what follows, making sure that if someone had submitted the URL before, we do not try to
	// see that as a video..
	ziggeo_app.embed_events.on('verified', function(embedding) {
		//@update - make this saved differently depending on the preferences
		//@update - make it possible to choose if you want /p/ or /v/ to be used for playback
		//document.getElementById("candidate_video").value = "ziggeo-" + data.video.token;
		//this does require however that iframe embed allows this domain for it to work.
		document.getElementById("candidate_video").value = "https://ziggeo.io/p/" + embedding.get('video');
		ziggeojmrmStoreToken(data.video.token);
	});




/////////////////////////////////////////////////
// 2. FIELD ON FORM
/////////////////////////////////////////////////

	function ziggeojmrmChangeVideoField() {
		var videoElement = document.getElementById("candidate_video");
		//we check if the element exists. If it does not, videoElement is null, so lets just break out..
		if(!videoElement) {
			//this got activated on the profile page
			var photos = document.getElementsByClassName("candidate_photo");
			if (photos.length > 0 ) {
				//we are on resume page, lets show video..
				//since the JobManager docs do not say how you can get the value, we can use local storage
				// for the preview..
				var token = ziggeojmrmGetStoredToken();
				var playerHolder = document.createElement("div");
				playerHolder.id = "candidate_video-emb";
				photos[0].parentElement.appendChild(playerHolder);
				if(token) {
					var embedding = new ZiggeoApi.V2.Recorder({
						element: document.getElementById("#candidate_video-emb"),
						attrs: {
							//@here - possibly change to actually pull in the rerecorder template
							width: photos[0].getBoundingClientRect().width,
							height: photos[0].getBoundingClientRect().height,
							video: token,
							theme: 'modern',
							themecolor: 'red'
						}
					});

					embedding.activate();
				}
				ziggeojmrmCreateButtons(playerHolder, photos[0]);
				return true;
			}
			else {
				return false;
			}
			return false;
		}

		var _token = null;

		if(videoElement) {
			//we hide the input field and will add token to it later on
			videoElement.style.display = "none";
			//We need to make sure that we show recorder if the input is empty (no video yet) and to actually
			// show it within the video rerecorder if the video token is present..
			if(videoElement.value !== "") {
				//we have some data here..
				if(videoElement.value.indexOf("ziggeo") > -1) {
					//Ziggeo video token is present
					var _token = videoElement.value.substr(videoElement.value.indexOf("/p/")+3);
					//Now we add it to local Storage for safe keeping
					ziggeojmrmStoreToken(_token);
				}
				else {
					//most likely some URL is shown..lets leave everything as is..
					return false;
				}
			}
		}

		var recHolder = document.createElement("div");
		recHolder.id = "candidate_video-emb";
		videoElement.parentNode.appendChild(recHolder);

		//we should show the rerecorder
		if(_token) {
			//we now attach embedding to this new element
			//For now we are showing rerecorder, however we must add some check to see if this is the same
			// person that had recorded the video. If they are not, we need to use player instead - we do
			// not want to allow rerecording to other people..
			var embedding = new ZiggeoApi.V2.Recorder({
				element: document.getElementById("#candidate_video-emb"),
				attrs: {
					//@here - possibly change to actually pull in the rerecorder template
					width: 640,
					height: 480,
					video: _token,
					theme: 'modern',
					themecolor: 'red'
				}
			});

			embedding.activate();
		}
		//we should show the recorder
		else {
			//we now attach embedding to this new element

			ziggeoAjax({
							'operation': 'ziggeojmrm-get-template',
							'template_type': 'recorder'
						}, function(response) {
							//var params_obj = JSON.parse(response);

							var embedding = new ZiggeoApi.V2.Recorder({
								element: document.getElementById("#candidate_video-emb"),
								attrs: JSON.parse(response)
							});

							embedding.activate();
						});
		}
	}




/////////////////////////////////////////////////
// 3. ON RESUME
/////////////////////////////////////////////////

	ziggeo_app.on('ready', function () {
		//if we have already created the video embedding holder exit
		if(document.getElementById("candidate_video-emb")) { return false; }

		var videoElement = document.getElementById("candidate-video");

		//oembed is used to show the videos, so this should hold and iframe if exists
		if(videoElement) {
			//we grab the link to the video through iframe URL
			var video_token = videoElement.getElementsByTagName("iframe")[0].src.replace("https://", "")
											.replace("http://", "").replace("ziggeo.io/p/", "");
			if(video_token) {
				//video should be in place of photo, so we use this for a reference
				var photos = document.getElementsByClassName("candidate_photo");
				if (photos.length > 0 ) {
					var playerHolder = document.createElement("div");
					playerHolder.id = "candidate_video-emb";
					photos[0].parentElement.appendChild(playerHolder);
					//@here
					var embedding = new ZiggeoApi.V2.Recorder({
						element: document.getElementById("#candidate_video-emb"),
						attrs: {
							//@here - possibly change to actually pull in the rerecorder template
							width:photos[0].getBoundingClientRect().width,
							height:photos[0].getBoundingClientRect().height,
							video:video_token,
							theme: 'modern',
							themecolor: 'red'
						}
					});

					embedding.activate();

					//lets create buttons for switching between photo and video..
					ziggeojmrmCreateButtons(playerHolder, photos[0]);
					return true;
				}
				else {
					//photo placeholder was not available
					return false;
				}
			}
		}
	});




/////////////////////////////////////////////////
// 4. SIMPLIFIERS
/////////////////////////////////////////////////

	//if local storage is not available we use cookies..
	function ziggeojmrmStoreToken(token) {
		try {
			sessionStorage.setItem("ziggeo-token", token);
			sessionStorage.getItem("ziggeo-token");
			//since we are still here, lets go on..
			return true;
		}
		catch(e) {
			//cookies
			return false;
		}
	}

	//returns the video token from storage or cookies
	function ziggeojmrmGetStoredToken() {
		try {
			return sessionStorage.getItem("ziggeo-token");
		}
		catch(e) {
			//cookies
			return false;
		}
	}

	//creates the buttons for switching between photo and video
	//it is used on the Resume (pre)view pages
	function ziggeojmrmCreateButtons(playerElem, photoElem) {
		var btnHolder = document.createElement("div");
		btnHolder.id = "ziggeo-buttons-holder-JMV";
		document.getElementById("candidate_video-emb").parentNode.appendChild(btnHolder);

		var btn1 = document.createElement("span");
		btn1.className = "ziggeo-button btn-left";
		btn1["data-for"] = "candidate_photo";
		btn1.innerHTML = "Photo";
		btnHolder.appendChild(btn1);

		var btn2 = document.createElement("span");
		btn2.className = "ziggeo-button btn-right";
		btn2["data-for"] = "candidata_video-emb";
		btn2.innerHTML = "Video";
		btnHolder.appendChild(btn2);
		
		playerElem.style.display = "block";
		photoElem.style.display="none";
		
		if(document.addEventListener) {
			btn1.addEventListener("click", function() {
				photoElem.style.display="block";
				playerElem.style.display = "none";
			}, false);
			btn2.addEventListener("click", function() {
				playerElem.style.display = "block";
				photoElem.style.display="none";
			}, false);
		}
		else {
			btn1.attachEvent("onclick", function() {
				photoElem.style.display="block";
				playerElem.style.display = "none";
			});
			btn2.attachEvent("onclick", function() {
				playerElem.style.display = "block";
				photoElem.style.display="none";
			});
		}
	}
