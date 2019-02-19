<?php

//This file contains the functionality that extends the features to provide support for Resume Manger addon


//the above might no longer be needed...
add_filter('the_candidate_video', function($link) {
	//grab the default video player template that should be used
	$code = ziggeojobmanager_get_template('player', 'integrations');

	echo '<ziggeoplayer ' . $code . ' ziggeo-source="' . $link . '"></ziggeoplayer>';

	//Since we will show the link, it is not needed for us to return it. If we do, there will be two players
	//return $link;
});

?>