
<?php

//set display errors on and ask to be warned against any kind of bugs
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);

//arrays of data for each photo
$picsWithLink = array();
$pics = array();
$lats = array();
$longs = array();
$titles = array();		
$output = array();

//get Flickr photos with geo-tags, the text "pollen", within a 20mi radius of Atlanta
$search = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=f4b48d42735d6b7bf17e62dde7ae27c4&text=pollen&has_geo=&lat=33.747270&lon=-84.387113&radius=20&radius_units=mi&format=rest';
$rsp = simplexml_load_file($search);

foreach($rsp->photos->photo as $item) {
	$title 	= $item->attributes()->title;	
	$id 	= $item->attributes()->id;
	$farm	= $item->attributes()->farm;
	$server	= $item->attributes()->server;
	$secret	= $item->attributes()->secret;
	$owner	= $item->attributes()->owner;				

	//create "link" html	
	$link[]= "http://www.flickr.com/photos/".$owner."/".$id."/";
	//create pic link
	$pics[]="http://farm".$farm.".static.flickr.com/".$server."/".$id."_".$secret.".jpg";

	$titles[]=$title;

	//get lat and long
	$getLocSearch = "http://api.flickr.com/services/rest/?method=flickr.photos.geo.getLocation&api_key=f4b48d42735d6b7bf17e62dde7ae27c4&photo_id=".$id."&format=rest";
	$loc = simplexml_load_file($getLocSearch);		
	
	foreach($loc->photo->location as $entry){
		$lat 	 = $entry->attributes()->latitude;
		$long 	 = $entry->attributes()->longitude;
		$lats[]	 = $lat;
		$longs[] = $long;				
	} 
}

$file = fopen("../data/flickr.js","w") or die ("Unable to open flickr.js!");

fwrite($file, "var flickrData =");
fwrite($file, "{ \"type\": \"FeatureCollection\",\"features\": [");
for ($i=1; $i<49; $i++ ) {
    fwrite($file, "{ \"type\": \"Feature\",");
    fwrite($file, "\"geometry\": {\"type\": \"Point\", \"coordinates\": [".$longs[$i].",".$lats[$i]."]},");
    fwrite($file, "\"properties\": {");
    fwrite($file, "\"PIC\": \"".$pics[$i]."\",");
    fwrite($file, "\"LINK\": \"".$link[$i]."\",");
    fwrite($file, "\"TITLE\": \"".$titles[$i]."\"");
    fwrite($file, "}},");
}
fwrite($file, "]};");
fclose($file);

echo "Flickr data saved to json!";

?>