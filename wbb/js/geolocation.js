function ermittlePosition() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			if (typeof position != 'undefined') {
				document.cookie = "gettank_latitude=" + position.coords.latitude;
				document.cookie = "gettank_longitude=" + position.coords.longitude;
				location.reload();
			} else alert('Ihr Browser unterstuetzt keine Geolocation.');
		});
	} else alert('Ihr Browser unterstuetzt keine Geolocation.');
}