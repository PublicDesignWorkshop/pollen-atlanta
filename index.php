<!DOCTYPE html>
<html>
	<head>
		<title>ATLANTA POLLEN</title>
		<link rel="icon" href="./img/favicon.ico" type="image/x-icon">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<?// bring in the style ?>	
		<link rel="stylesheet" href="http://code.leafletjs.com/leaflet-0.3.1/leaflet.css" />
		<!--[if lte IE 8]>
			<link rel="stylesheet" href="http://code.leafletjs.com/leaflet-0.3.1/leaflet.ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="./css/ui-lightness/jquery.ui.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="./css/supersized.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" media="screen" href="./css/screen.css">
	</head>

	<body>
		<div id="container">
			<div id="map_container">
				<? // div for leaflet map ?>
				<div id="map" height="600px"></div>
			</div>
			<div id="logo">
				<img src="./img/logo_icon.png" alt="POLLEN ATL" />
				<h1>POLLEN</h1>


				<?php

					//set up a database connection (not here, in database.php)
					include("./scripts/database.php");

					//cycle through all the rows
					$query = "SELECT * FROM Count ORDER BY  `count_id` ASC";

					$result = mysql_query($query);

					$num = mysql_num_rows($result);
					$counter = 1;
					if ($num > 0) {
						while ($row = mysql_fetch_assoc($result)) {
					        // You have $row['ID'], $row['count'], $row['date'], $row['type']
					        
							// this switch statement adds classes to the count for coloring
							switch (TRUE) {
	    						case($row['count'] < 15):
							        $scale = "low";
							        break;
								    case(($row['count'] < 92) && ($row['count'] >= 15)):
								        $scale = "medium";
								        break;
								    case(($row['count'] < 1500) && ($row['count'] >= 91)):
								        $scale = "high";
								        break;
								    case($row['count'] > 1500):
								    	$scale = "extreme";
								    	break;
							}

							echo "<p class=\"count day".$counter." ".$scale."\">";
							echo $row['date'];
							echo "<br />Pollen count: <strong>";
							echo $row['count'];
							echo "</strong></p>\n";
							$counter++;
					    }
					}
						
				?>

			</div>
			<div id="pollen_navigation"> 
				<? //jquery slider code found in slider.js ?>
				<div id="slider"></div>
			</div>
		</div>

		<?// let's get some JS in here! ?>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
		<script type="text/javascript" src="./js/jquery.ui.min.js"></script>
		<script type="text/javascript" src="./js/jquery.supersized.flickr.1.1.2.js"></script>

		<?// load map data, map ?>
		<script type="text/javascript" src="./data/parks.js"></script>
		<script type="text/javascript" src="./data/flickr.js"></script>
		<script type="text/javascript" src="./data/twitter.js"></script>
		<script type="text/javascript" src="http://code.leafletjs.com/leaflet-0.3.1/leaflet.js"></script>

		<?//controls page elements ?>
		<script type="text/javascript" src="./js/background.js"></script>	
		<script type="text/javascript" src="./js/map.js"></script>
		<script type="text/javascript" src="./js/slider.js"></script>		

	</body>

</html>