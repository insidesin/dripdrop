/****************************************
	Author: 	Jackson Powell
	Unit:		The Web - INB271
 ****************************************/
 
function updateSearch(submit) {
	var geoLocate = document.forms["searchForm"]["current_location"].checked;
	
	//If geolocation box is checked
	if(geoLocate) {
		document.getElementById('distance').style.display = 'block';
		//Check if valid HTML5 validation use.
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(setPosition);
		} else {
			document.getElementById('search_alert').style.display = 'block';
			document.getElementById('search_alert').innerHTML = "HTML5 is required to use GeoLocation searches.";
		}
	}
 }
 
function setPosition(position) {
	document.getElementById('user_lat').value = position.coords.latitude;
	document.getElementById('user_long').value = position.coords.longitude;
}