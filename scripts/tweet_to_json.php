<?php

//set display errors on and ask to be warned against any kind of bugs
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);

//connect to PDW database (for some reason including database.php was giving a 403)
$address='localhost';
$user='publicdesign';
$password='F4epvo17';

$connect=mysql_connect($address, $user, $password);
if(!$connect){
	die('error: could not connect to sql server: '.mysql_error());
	
}

$db_select=mysql_select_db('pollensurveys',$connect);
if(!$db_select){
	die('error: could not get table: '.mysql_error());
}

//get me some variables for later please!
$tweets = array();

//define query
$query = 'SELECT * FROM map1 ORDER BY map_id ASC';

//run query
if($result = mysql_query($query)){
	
	//retrieve and print every record
	while($records = mysql_fetch_assoc($result)){
		//$rows[] = array('data' => $r);
		$tweets[] = $records;

		//like the flickr script, this code opens a file (or creates one) to pass to leaflet
		$file = fopen("../data/twitter.js","w") or die ("Unable to open twitter.js!");
		chmod("../data/twitter.js", 0777);

		fwrite($file, "var twitterData =");
		fwrite($file, "{ \"type\": \"FeatureCollection\",\"features\": [");

		foreach($tweets as $tweet){
			// takes every tweet row in the table and constructs geojson from the contents.
			// this will make it easier to attach the tweet data to the leaflet map.
			fwrite($file, "{ \"type\": \"Feature\",");
			fwrite($file, "\"geometry\": {\"type\": \"Point\", \"coordinates\": [".$tweet['lng'].",".$tweet['lat']."]},");
			fwrite($file, "\"properties\": {");
			fwrite($file, "\"NAME\": \"".$tweet['username']."\",");
			fwrite($file, "\"CONTENT\": \"".htmlentities($tweet['tweet_content'])."\",");
			fwrite($file, "\"USERPIC\": \"".$tweet['profile_pic']."\",");
			//converts the timestamp in the server to a more useful format like "April 9"
			fwrite($file, "\"TIME\": \"".strftime( "%B %e" , (strtotime($tweet['time'])))."\",");
			fwrite($file, "\"MEDIA\": \"".rtrim($tweet['media_paths'], ";")."\"");
			fwrite($file, "}},");
		}

		fwrite($file, "]};");
		fclose($file);
	}
	echo "Twitter data saved to json!";
}
else { // Query didn't run.
 echo '<p style="color: red;">
		Could not retrieve thedata because:<br />' 
		. mysql_error() . '.</p><p>The query being run was: ' . 
		$query . '</p>';
} // End of query IF.

mysql_close();
//echo "<p>Connection closed.</p>";
	
?>