var map = L.map('map').setView([51.505, -0.09], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    maxZoom: 18,
}).addTo(map);

var marker = L.marker([51.505, -0.09], {
    draggable: true
}).addTo(map);

marker.on('dragend', function(event) {
    var marker = event.target;
    var position = marker.getLatLng();
    var lat = position.lat;
    var lng = position.lng;

    $('.map-coordinates').val(lat + ',' + lng);
});
