jQuery(function($){
	$.supersized({
	
		//Functionality
		slideshow               :   1,		//Slideshow on/off
		autoplay				:	1,		//Slideshow starts playing automatically
		start_slide             :   0,		//Start slide (0 is random)
		random					: 	0,		//Randomize slide order (Ignores start slide)
		slide_interval          :   30000,	//Length between transitions
		transition              :   1, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed		:	2000,	//Speed of transition
		new_window				:	1,		//Image links open in new window/tab
		pause_hover             :   0,		//Pause slideshow on hover
		keyboard_nav            :   1,		//Keyboard navigation on/off
		performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
		image_protect			:	1,		//Disables image dragging and right click with Javascript
		// image_path				:	'./img/bg', //Default image path
		
		//Size & Position
		min_width		        :   0,		//Min width allowed (in pixels)
		min_height		        :   0,		//Min height allowed (in pixels)
		vertical_center         :   1,		//Vertically center background
		horizontal_center       :   1,		//Horizontally center background
		fit_portrait         	:   0,		//Portrait images will not exceed browser height
		fit_landscape			:   0,		//Landscape images will not exceed browser width  
		
		//Components
		navigation              :   0,		//Slideshow controls on/off
		thumbnail_navigation    :   0,		//Thumbnail navigation
		slide_counter           :   0,		//Display slide numbers
		slide_captions          :   0,		//Slide caption (Pull from "title" in slides array)
		
		//Flickr
		source					:	4,						//1-Set, 2-User, 3-Group, 4-Tags
		// set      	        :   '72157594346214896', 	//Flickr set ID (found in URL)
		// user					:	'######',				//Flickr user ID (http://idgettr.com/)
		// group				:	'######', 				//Flickr group ID (http://idgettr.com/)
		tags					: 	'pollen',    			//Comma separated tags
		total_slides			:	100,					//How many pictures to pull (Between 1-500)
		image_size              :   'z', 					//Flickr Image Size - t,s,m,z,b  (Details: http://www.flickr.com/services/api/misc.urls.html)
		sort_by					:    3,		//1-Date Posted, 2-Date Taken, 3-Interestingness
		sort_direction			:    0,		//0-descending, 1-ascending
		
		/**
		FLICKR API KEY
		NEED TO GET YOUR OWN -- http://www.flickr.com/services/apps/create/
		**/
		api_key					:	'f4b48d42735d6b7bf17e62dde7ae27c4'		//Flickr API Key
			
	}); 
});