//init map
var map = new L.Map('map');

//init tilesets for base maps: with and without roads, aerial.
var terrainUrl =  'http://{s}.acetate.geoiq.com/tiles/terrain/{z}/{x}/{y}.png';
var terrainAttrib = '2011 GeoIQ &#038; Stamen, Data from OSM and Natural Earth';
var terrainMap = new L.TileLayer(terrainUrl, {maxZoom: 18, attribution: terrainAttrib, subdomains: ['a1', 'a2', 'a3']});

var roadUrl =  'http://{s}.acetate.geoiq.com/tiles/acetate-hillshading/{z}/{x}/{y}.png';
var roadAttrib = '2011 GeoIQ &#038; Stamen, Data from OSM and Natural Earth';
var roadMap = new L.TileLayer(roadUrl, {maxZoom: 18, attribution: roadAttrib, subdomains: ['a1', 'a2', 'a3']});

// var aerialUrl = 'http://oatile{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png';
// var aerialAttrib = 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">';
// var aerialMap = new L.tileLayer(aerialUrl, {maxZoom: 18, attribution: aerialAttrib, subdomains: ['1','2','3','4']});

//establish base maps
var baseMaps = {
    // "Satellite Map" : aerialMap,
    "Terrain Map": terrainMap,
    "Road Map": roadMap,
};

//get a place going
var atlanta = new L.LatLng(33.773, -84.37); 

//get map together with place and tileset
map.setView(atlanta, 13).addLayer(terrainMap);

//custom red marker
var redIcon = L.Icon.extend({
    iconUrl: '/pollen/img/red_marker.png',
});
var redMarker = new redIcon();

//custom green marker
var greenIcon = L.Icon.extend({
    iconUrl: '/pollen/img/green_marker.png',
});
var greenMarker = new greenIcon();


//add geoJSON layers:

//park geoJSON
var parkLayer = new L.GeoJSON();

parkLayer.on("featureparse", function (e) {
    if (e.properties && e.properties.NAME){
        e.layer.bindPopup(e.properties.NAME);
    }
});

parkLayer.addGeoJSON(parkData);
parkLayer.setStyle({
    weight: 2,
    color: "#FFF36A",
    opacity: .6,
    fillColor: "#FFF78F",
    fillOpacity: 0.6
});

//flickr geoJSON
var flickrLayer = new L.GeoJSON();

flickrLayer.on("featureparse", function (e) {
    if (e.properties && e.properties.PIC){
        var flickrContent = "<a href=" + e.properties.LINK + "><img class=\"pic\" src=\""+e.properties.PIC+"\" alt=" + e.properties.TITLE + " /></a><br />"+ e.properties.TITLE;
        e.layer.bindPopup(flickrContent);
        e.layer.setIcon(greenMarker)
    }
});
flickrLayer.addGeoJSON(flickrData);

//twitter geoJSON
var twitterLayer = new L.GeoJSON();

twitterLayer.on("featureparse", function (e) {
    if (e.properties && e.properties.MEDIA){
        var twitterContent = "<img class=\"pic\" src=\"" + e.properties.MEDIA + "\" alt=\"" + e.properties.CONTENT + "\" /><p class=\"content\">" + e.properties.CONTENT + "</p><img class=\"profile\" src=\"" + e.properties.USERPIC + "\" alt=\"" + e.properties.NAME + "\" /><p class=\"name\">"+ e.properties.NAME + "</p><p class=\"time\">" + e.properties.TIME + "</p>";
        twitterPopups = e.layer.bindPopup(twitterContent);
    }
    else{
        var twitterContent = "<p class=\"content\">" + e.properties.CONTENT + "</p><img class=\"profile\" src=\"" + e.properties.USERPIC + "\" alt=\"" + e.properties.NAME + "\" /><p class=\"name\">"+ e.properties.NAME + "</p><p class=\"time\">" + e.properties.TIME + "</p>";
        e.layer.bindPopup(twitterContent);
    }
});
twitterLayer.addGeoJSON(twitterData);


//name the layers in the UI
var overlayMaps = {
    "Parks": parkLayer,  
    "Flickr": flickrLayer,
    "Twitter": twitterLayer,
};

//Add default layers to map
map.addLayer(parkLayer)
   .addLayer(flickrLayer)
   .addLayer(twitterLayer);

var layersControl = new L.Control.Layers(baseMaps, overlayMaps);

map.addControl(layersControl);
