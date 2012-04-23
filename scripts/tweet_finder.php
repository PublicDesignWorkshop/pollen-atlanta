<html>
	<head>
		
		<style>
		body {
			font:12px Verdana;
		}
		ul li {
			list-style-type:none;
		}	
		</style>

	</head>

	<body>


	<?php

		////THIS SCRIPT WORKS!!!!
		//SUBSTITUTE THE FOLLOWING LINE FOR YOUR OWN DATABASE VARIABLES ($hostname,$username, $password, $database)
		
		$lat = 33.787423;
		$lng = -84.372597;
		
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
		//if connection succeeds
	
		
		//----------
		
			/*Search API, serarch tweets including #pollenATL */
			$searchURL  = "http://search.twitter.com/search.json?q=%23pollenatl&include_entities=true&rpp=20&result_type=mixed"; 

			/*get page*/
			if ($_GET[page]!=null) { 
				$searchURL = $searchURL."&page=".($_GET[page]);
			}

			$rpp = $_GET[rpp];
			$json = file_get_contents($searchURL, 0, null, null);
			$json_output = json_decode($json);
		
			echo "Tweets containing #pollenatl<br/>";
			//pages, tweets/page=20 as decalred in the search API url rpp=20
			echo "<p>";
				$p=$json_output->page;
				if ($json_output->previous_page!=null) { 
					echo ("<a href='pollen_tweets.php?page=".($p-1)."'>previous page</a>&nbsp;&nbsp;"); 
				} 
				echo ("[[page ".$p."]]");
				if ($json_output->next_page!=null) { 
					echo ("&nbsp;&nbsp;<a href='pollen_tweets.php?page=".($p+1)."'>next page</a>"); 
				}
			echo "</p>\n\n";
			//end of "pages"
			
			
			//numbering
			echo "\n<ul>";
				$i=($p-1)*$rpp+1;
				foreach($json_output->results as $o){
				
					echo "\n\t<!--tweet info -->\n";
					
					echo "\t\t<li>".$i++.". "."<strong>". $o->text ."</strong> (ID:". $o->id_str.")\n";
						echo "\t\t\t<ul>\n";
							echo "\t\t\t\t<li><img src='". $o->profile_image_url_https ."'/></li>\n";
							echo "\t\t\t\t<li>User: @".$o->from_user."(User ID: ". $o->from_user_id_str .")"."</li>\n";
							echo "\t\t\t\t<li>Time: ". $o->created_at ."</li>\n";
							echo "\t\t\t\t<!--images, check the number of images first-->\n";
							echo "\t\t\t\t<li>Number of Images: ". count($o->entities->media) ."</li>\n";
								echo "\t\t\t\t<ul>\n";
									mysql_error();
									$j = -1; 
									//if there is one media at least, print it
									if(count($o->entities->media)>0){
										foreach ($o->entities->media as $media) {
											echo "\t\t\t\t\t<li>".$media->media_url.";</li>";
										}
									}
								echo "\t\t\t\t</ul>\n";
							echo "\t\t\t\t<!--lat & lon -->";
							echo "\t\t\t\t<li>Latitude: ". $o->geo->coordinates[0] ."</li>\n";
							echo "\t\t\t\t<li>Longitude: ". $o->geo->coordinates[1] ."</li>\n";
						echo "\t\t\t</ul>\n\n";
				
						//insert some of the values into static variables to avoid
						//submission conflict on the query
							//scape their special characters
							//and delete their empty spaces
						$user_id = mysql_real_escape_string(trim($o->from_user_id_str));
						$entry_content = mysql_real_escape_string(trim($o->text));
						$latitude = mysql_real_escape_string(trim($o->geo->coordinates[0]));
						$longitude = mysql_real_escape_string(trim($o->geo->coordinates[1]));
						$numMediaFiles = mysql_real_escape_string(trim(count($o->entities->media)));
						//only add paths if there are media files
						if($numMediaFiles>0){
							$mediaPaths = mysql_real_escape_string(trim($media->media_url).";");
						}
						//if there aren't media files, the path is empty
						else if($numMediaFiles==0){
							$mediaPaths = "";
						}
						
						
						
						
						
						
						
						$tweet_id = $o->id_str;
						//define existing results
						$same_id = "SELECT tweet_id FROM map1 WHERE tweet_id = $tweet_id";
						$rows;
						//loop existing results
						if($result = mysql_query($same_id)){
							//retrieve existing results
							while($r = mysql_fetch_assoc($result)){
								//store existing results
								$rows = $r;
							}
						}
						//if this record is not in the existing results
						if($rows['tweet_id']!=$tweet_id && !empty($latitude)){
							//success message
							echo "<strong>this is inserted because it wasn't on the db before</strong><br/>";
							
							//insert it with the query
							$query = "INSERT IGNORE INTO map1 (username, user_id, profile_pic, tweet_id, tweet_content, number_media_files, media_paths, time, lat, lng) VALUES('$o->from_user','$user_id','$o->profile_image_url_https','$o->id_str','$entry_content','$numMediaFiles','$mediaPaths',NOW(),'$latitude', '$longitude' )";
							//INSERT IGNORE
							//only insert entries with lat/long
							if(!empty($latitude)&&!empty($longitude)){
								//execute query -> insert comments into table!
								if(@mysql_query($query)){
									echo '<p>The row has been inserted.</p>';
								} else{
									echo '<p style="color:red;">Could not create the table because:<br/>'.mysql_error().'</p><p>The query being run was:'.$query.'</p>';
								}
							}
							
							
							
							
						}
						
						
				}//end of "foreach twitter API"
				echo "</ul>";
				//end of "numbering"
			
		//---------- end of twitter API script
			
			
			
			
			mysql_close(); //close connection
		
		
		
	?>


	</body>
</html>