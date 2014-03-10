var map;
var moletai = new google.maps.LatLng(55.312882, 25.958705);
var place = new google.maps.LatLng(55.312882, 25.558705);
function initialize() {
    var mapOptions = {
        zoom: 10,
        center: moletai,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var marker = new google.maps.Marker({
        map: map,
        position: place,
        title: 'labadiena',
        animation: google.maps.Animation.DROP
    });
    google.maps.event.addListener(marker, 'click', toggleBounce);

    function toggleBounce() {
        if (marker.getAnimation() != null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    var infowindow = new google.maps.InfoWindow({
        content: $('address').html(),
    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

// Monitor the window resize event and let the map know when it occurs
if (window.attachEvent) { 
    window.attachEvent("onresize", function() {this.map.onResize()} );          
} else { 
    window.addEventListener("resize", function() {this.map.onResize()} , false);
}