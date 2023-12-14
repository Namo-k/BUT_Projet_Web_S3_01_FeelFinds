L.mapbox.accessToken = 'pk.eyJ1IjoibG91IiwiYSI6IkJDYlg3REEifQ.9BLp9eUdT11kUy1jgujSsQ'; var map = L.mapbox.map('map')
.setView([48.8509588, 2.3084927], 13)
.addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));


var myIcon = L.icon({
	iconUrl: 'data/img/in-love.png',
	iconSize: [10, 10]
});


L.marker([48.8509588, 2.3084927], {icon: myIcon}).addTo(map);
L.marker([48.8650569, 2.3018097]).addTo(map);


// map.on('click', function (e) {
//     console.log(e.latlng);
//     var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
// });

map.on('dblclick', function (e) {
console.log(e.latlng);
L.marker([e.latlng.lat, e.latlng.lng]).remove();
});



$.ajax({
    type: 'GET',
    url: 'json/zones-touristiques-internationales.json',
    dataType: 'json',
    success: function (data) {
        data.forEach(function (location) {
            // console.log(location);
            if (location['geometry']) {
                var coordinates = location.geometry.coordinates.reverse();
                var marker = L.marker(coordinates).addTo(map);
    
                var popupContent = '<b>' + location.fields.name + '</b>';
                marker.bindPopup(popupContent);
            }
        });
    },
    error: function (error) {
        console.error('Erreur lors du chargement du fichier JSON:', error);
    }
    });

    var markers = L.markerClusterGroup();

    $.ajax({
    type: 'GET',
    url: 'json/baseCulturel.json',
    dataType: 'json',
    success: function (data) {
        var chunkSize = 100; // Définissez la taille de la page
        var currentPage = 0;
    
        function loadMarkers() {
            var start = currentPage * chunkSize;
            var end = start + chunkSize;
    
            data.slice(start, end).forEach(function (location) {
                if (location['geometry']) {
                    var coordinates = location.geometry.coordinates.reverse();
                    var marker = L.marker(coordinates);
                    var popupContent = '<b>' + location.fields.nom + '</b>';
                    marker.bindPopup(popupContent);
                    markers.addLayer(marker);
                }
            });
    
            currentPage++;
    
            if (currentPage * chunkSize < data.length) {
                setTimeout(loadMarkers, 0); // Chargez la prochaine page après un délai pour ne pas bloquer l'interface utilisateur
            }
    
            map.addLayer(markers);
        }
    
        loadMarkers();
    },
    error: function (error) {
        console.error('Erreur lors du chargement du fichier JSON:', error);
    }
    });
    
    
