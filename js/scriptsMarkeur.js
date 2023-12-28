L.mapbox.accessToken = 'pk.eyJ1IjoibG91IiwiYSI6IkJDYlg3REEifQ.9BLp9eUdT11kUy1jgujSsQ'; var map = L.mapbox.map('map')
.setView([48.8509588, 2.3084927], 13)
.addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));


var myIcon = L.icon({
	iconUrl: 'images/in-love.png',
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



// $.ajax({
//     type: 'GET',
//     url: 'data/zones-touristiques-internationales.json',
//     dataType: 'json',
//     success: function (data) {
//         data.forEach(function (location) {
//             // console.log(location);
//             if (location['geometry']) {
//                 var coordinates = location.geometry.coordinates.reverse();
//                 var marker = L.marker(coordinates).addTo(map);
    
//                 var popupContent = '<b>' + location.fields.name + '</b>';
//                 marker.bindPopup(popupContent);
//             }
//         });
//     },
//     error: function (error) {
//         console.error('Erreur lors du chargement du fichier JSON:', error);
//     }
//     });

    // var markers = L.markerClusterGroup();

    // $.ajax({
    // type: 'GET',
    // url: 'data/baseCulturel.json',
    // dataType: 'json',
    // success: function (data) {
    //     var chunkSize = 100; // Définissez la taille de la page
    //     var currentPage = 0;
    
    //     function loadMarkers() {
    //         var start = currentPage * chunkSize;
    //         var end = start + chunkSize;
    
    //         data.slice(start, end).forEach(function (location) {
    //             if (location['geometry']) {
    //                 var coordinates = location.geometry.coordinates.reverse();
    //                 var marker = L.marker(coordinates);
    //                 var popupContent = '<b>' + location.fields.nom + '</b>';
    //                 marker.bindPopup(popupContent);
    //                 markers.addLayer(marker);
    //             }
    //         });
    
    //         currentPage++;
    
    //         if (currentPage * chunkSize < data.length) {
    //             setTimeout(loadMarkers, 0); // Chargez la prochaine page après un délai pour ne pas bloquer l'interface utilisateur
    //         }
    
    //         map.addLayer(markers);
    //     }
    
    //     loadMarkers();
    // },
    // error: function (error) {
    //     console.error('Erreur lors du chargement du fichier JSON:', error);
    // }
    // });


   // Supprimer et ajouter au bon endrois le contrôle de zoom
    map.zoomControl.remove();
    var zoomControl = L.control.zoom({ position: 'bottomright' }).addTo(map);
    
    
// var markers = L.markerClusterGroup();
// let nb = 0;

$.ajax({
    type: 'GET',
    url: 'data/monumentsHistoriques.json',
    dataType: 'json',
    success: function (data) {
        console.log(data);
        var chunkSize = 100; // Définissez la taille de la page
        var currentPage = 0;

        function loadMarkers() {
            var start = currentPage * chunkSize;
            var end = start + chunkSize;

            data.slice(start, end).forEach(function (location) {
                if (location['geo_point_2d']&& 
                !location.immeuble.includes("Immeuble") &&
                 !location.immeuble.includes("Eglise") &&
                  !location.immeuble.includes("Église") && 
                  !location.immeuble.includes("église") && 
                  !location.immeuble.includes("École") && 
                  !location.immeuble.includes("Ecole") && 
                  !location.immeuble.includes("Lycée") && 
                  !location.immeuble.includes("Atelier") && 
                  !location.immeuble.includes("Collège") && 
                  !location.immeuble.includes("Maison") &&
                  !location.immeuble.includes("ferme") &&
                  !location.immeuble.includes("Ferme") &&
                  !location.immeuble.includes("sncf") &&
                  !location.immeuble.includes("auberge") &&
                  !location.immeuble.includes("Synagogue") &&
                  !location.immeuble.includes("Métropolitain") &&
                  !location.immeuble.includes("Hôpital") &&
                  !location.immeuble.includes("Boulangerie") &&
                  !location.immeuble.includes("Gare") &&
                  !location.immeuble.includes("Boutique") &&
                  !location.immeuble.includes("Usine") &&
                  !location.immeuble.includes("Gymnase") &&
                  !location.immeuble.includes("Groupe scolaire") &&
                  !location.immeuble.includes("Allée") &&
                  !location.immeuble.includes("Garde-meuble") &&
                  !location.immeuble.includes("Borne") &&
                  !location.immeuble.includes("Hôtel")) {
                    var coordinates = [location.geo_point_2d.lat, location.geo_point_2d.lon];
                    var marker = L.marker(coordinates);

                    var popupContent = '<b>' + location.immeuble + '</b>';
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