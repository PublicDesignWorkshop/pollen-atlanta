$(document).ready(function() {

	//assign default slider active value (day 1)
	$(".day1").addClass("active");

	// logic that controls slider: all steps, and slide functions. This will be 
	// the place for eventual shifting between day-based twitter json sets. In
	// that case, the switch statements below will also add and remove datasets
	// from the map. This is why it's essential that this file loads after map.js

	$( "#slider" ).slider({
		min: 1,
		max: 12,
		slide: function( event, ui ) {
			console.log( ui.values );
			//uses the value of the slider to control the content of the tooltip.
			$(".count").hide().removeClass("active");
			switch(ui.value){
				case 1: //April 5 2012
					$(".day1").show().addClass("active")
					break;
				case 2: //April 6 2012
					$(".day2").show().addClass("active")
					break;
				case 3: //April 7 2012
					$(".day3").show().addClass("active")
					break;
				case 4: //April 8 2012
					$(".day4").show().addClass("active")
					break;
				case 5: //April 9 2012
					$(".day5").show().addClass("active")
					break;
				case 6: //April 10 2012
					$(".day6").show().addClass("active")
					break;
				case 7: //April 11 2012
					$(".day7").show().addClass("active")
					break;
				case 8: //April 12 2012
					$(".day8").show().addClass("active")
					break;
				case 9: //April 13 2012
					$(".day9").show().addClass("active")
					break;
				case 10: //April 14 2012
					$(".day10").show().addClass("active")
					break;
				case 11: //April 15 2012
					$(".day11").show().addClass("active")

					break;
				case 12: //April 16 2012
					$(".day12").show().addClass("active")
					break;
				default:
			}
		}
	});

	// Fade pollen count in and out in place of logo
	$("#pollen_navigation").hover(
		function () {
			$("#logo h1").hide();
			$(".count.active").fadeIn();
			map.removeLayer(flickrLayer);
		},
		function () {
			$(".count.active").hide();
			$("#logo h1").fadeIn();
			map.addLayer(flickrLayer);
		}
	);
 	
});