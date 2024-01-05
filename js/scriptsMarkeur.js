L.mapbox.accessToken = 'pk.eyJ1IjoibG91IiwiYSI6IkJDYlg3REEifQ.9BLp9eUdT11kUy1jgujSsQ'; var map = L.mapbox.map('map')
    .setView([48.8509588, 2.3084927], 13)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));


// var myIcon = L.icon({
//     iconUrl: 'images/in-love.png',
//     iconSize: [10, 10]
// });


// L.marker([48.8509588, 2.3084927], { icon: myIcon }).addTo(map);
// L.marker([48.8650569, 2.3018097]).addTo(map);


// map.on('click', function (e) {
//     console.log(e.latlng);
//     var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
// });

// map.on('dblclick', function (e) {
//     console.log(e.latlng);
//     L.marker([e.latlng.lat, e.latlng.lng]).remove();
// });



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
// var filteredData = [];

// $.ajax({
//     type: 'GET',
//     url: 'data/monumentsHistoriques.json',
//     dataType: 'json',
//     success: function (data) {
//         console.log(data);

//         var chunkSize = 100;
//         var currentPage = 0;

//         function loadMarkers() {
//             var start = currentPage * chunkSize;
//             var end = start + chunkSize;

//             data.slice(start, end).forEach(function (location) {
//                 if (
//                     location['geo_point_2d'] &&
//                     !location.immeuble.includes("Immeuble") &&
//                     !location.immeuble.includes("Eglise") &&
//                     !location.immeuble.includes("Église") &&
//                     !location.immeuble.includes("église") &&
//                     !location.immeuble.includes("École") &&
//                     !location.immeuble.includes("Ecole") &&
//                     !location.immeuble.includes("Lycée") &&
//                     !location.immeuble.includes("Atelier") &&
//                     !location.immeuble.includes("Collège") &&
//                     !location.immeuble.includes("Maison") &&
//                     !location.immeuble.includes("ferme") &&
//                     !location.immeuble.includes("Ferme") &&
//                     !location.immeuble.includes("sncf") &&
//                     !location.immeuble.includes("auberge") &&
//                     !location.immeuble.includes("Synagogue") &&
//                     !location.immeuble.includes("Métropolitain") &&
//                     !location.immeuble.includes("Hôpital") &&
//                     !location.immeuble.includes("Boulangerie") &&
//                     !location.immeuble.includes("Gare") &&
//                     !location.immeuble.includes("Boutique") &&
//                     !location.immeuble.includes("Usine") &&
//                     !location.immeuble.includes("Gymnase") &&
//                     !location.immeuble.includes("Groupe scolaire") &&
//                     !location.immeuble.includes("Allée") &&
//                     !location.immeuble.includes("Garde-meuble") &&
//                     !location.immeuble.includes("Borne") &&
//                     !location.immeuble.includes("Cimetière") &&
//                     !location.immeuble.includes("Laboratoire") &&
//                     !location.immeuble.includes("Hôtel")
//                 ) {
//                     var coordinates = [location.geo_point_2d.lat, location.geo_point_2d.lon];
//                     var marker = L.marker(coordinates);

//                     var popupContent = '<b>' + location.immeuble + '</b>';
//                     marker.bindPopup(popupContent);
//                     markers.addLayer(marker);

//                     filteredData.push(location);
//                 }
//             });

//             currentPage++;

//             if (currentPage * chunkSize < data.length) {
//                 setTimeout(loadMarkers, 0);
//             } else {
//                 map.addLayer(markers); // Add markers when all data is processed
                
//                 // Convert the filtered data array to JSON
//                 var jsonString = JSON.stringify(filteredData, null, 2);
//                 console.log(jsonString);

//                 // Create a Blob containing the JSON data
//                 var blob = new Blob([jsonString], { type: 'application/json' });

//                 // Create a download link
//                 var link = document.createElement('a');
//                 link.href = URL.createObjectURL(blob);
//                 link.download = 'filteredData.json';

//                 // Append the link to the body and programmatically click it to trigger the download
//                 document.body.appendChild(link);
//                 link.click();

//                 // Remove the link from the DOM
//                 document.body.removeChild(link);
//             }
//         }

//         loadMarkers();
//     },
//     error: function (error) {
//         console.error('Erreur lors du chargement du fichier JSON:', error);
//     }
// });



var markers = L.markerClusterGroup();
let nb = 0;

$.ajax({
    type: 'GET',
    url: 'data/filteredData.json',
    dataType: 'json',
    success: function (data) {
        console.log(data);
        var chunkSize = 100;
        var currentPage = 0;

        function loadMarkers() {
            var start = currentPage * chunkSize;
            var end = start + chunkSize;

            data.slice(start, end).forEach(function (location) {
                if (location['geo_point_2d'] &&
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
                    !location.immeuble.includes("Cimetière") &&
                    !location.immeuble.includes("Laboratoire") &&
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

console.log("testshgdcz")
markers.on('click', function (event) {
    var clickedMarker = event.layer;
    console.log(clickedMarker);
    
    var markerLatLng = clickedMarker.getLatLng();

    // Centrer la carte sur le marqueur
    // map.setView(markerLatLng, 13);

    console.log(markerLatLng.lat + ', ' + markerLatLng.lng);

    console.log((markerLatLng.lat-0.15) + ', ' + markerLatLng.lng);

    $('.input_adresse').val(stripHtmlTags(clickedMarker.getPopup()._content));

    console.log(clickedMarker.getPopup()._content);

    onMarkerClick(clickedMarker.getPopup()._content);

});



map.on('click', function (e) {
    console.log(e.latlng);
    // var marker = L.marker([e.latlng.lat, e.latlng.lng]);
    // markers.addLayer(marker);
    $('#ongletAvis').hide();
});

$('#ferme').on("click", ()=>{$('#ongletAvis').hide();})
$('.input_adresse').on("click", ()=>{$('#ongletAvis').hide();})

function onMarkerClick(nom_) {
    // Utilisez AJAX pour obtenir les informations du marqueur depuis le fichier PHP
    $('#ongletAvis').show();
    
    
    $.ajax({
        type: 'GET',
        url: 'php/getMarqueurInfo.php',
        data: { nom: nom_ },
        dataType: 'json',
        success: function (data) {
            
            console.log(data);
            if (data.error) {
                console.error('Erreur lors de la récupération des informations du marqueur:', data.error);
                return;
            }

            var nomMarqueur = data.nomMarqueur;
            var avis = data.avis;

            $('#nomMarqueur').text(nomMarqueur);


            $('#avis').empty();
            $('#nbrAvis').empty();
            $('#nbrSentiment').empty();
            
            var counts = {
                'époustouflant': 0,
                'triste': 0,
                'amour': 0,
                'joyeux': 0,
                'émouvant': 0,
                'festif': 0
            };

            avis.forEach(function (avisItem) {
    
                console.log("avisItem");
                console.log(avisItem);
                var avisBlock = $('<div>');
                // avisBlock.append('<p>Sentiment : ' + avisItem.Sentiment + '</p>');
                avisBlock.append('<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis">');
                avisBlock.append('<p>Avis : ' + avisItem.Avis + '</p>');
                avisBlock.append('<p>Auteur : ' + (avisItem.nomUser.trim() !== '' ? avisItem.nomUser : 'Anonyme') + '</p>');
                console.log(avisItem.Sentiment);

                counts[avisItem.Sentiment.toLowerCase()]++;
                

                //Bouton supression
                if (avisItem.nomUser === data.sessionName) {
                    var deleteButton = $('<button class="supprimer-avis">Supprimer</button>');
                    deleteButton.data('idSentiment', avisItem.IdSentiment);
                    console.log(avisItem.IdSentiment)
                    avisBlock.append(deleteButton);
                }

                avisBlock.append('<div class="traitBlanc"></div>');

                $('#avis').append(avisBlock);
                console.log(avisBlock);
            });


            for (var sentimentType in counts) {
                if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                    $('#nbrSentiment').append('<p> ' + counts[sentimentType] + '</p>');
                    $('#nbrSentiment').append('<img src="images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis">');
                }
            }

            $('.supprimer-avis').on('click', supprimerAvis);
        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX:', error);
        }
    });
}



function stripHtmlTags(htmlString) {
    // Remplace toutes les balises HTML par une chaîne vide
    return htmlString.replace(/<\/?[^>]+(>|$)/g, "");
}

$.ajax({
    type: 'GET',
    url: 'php/chargementMarqueurs.php', 
    dataType: 'json',
    success: function (data) {
        data.forEach(function (nomMarqueur) {
            $('.input_adresse').append('<option value="' + nomMarqueur + '">' + nomMarqueur + '</option>');
        });
    },
    error: function (error) {
        console.error('Erreur lors du chargement des noms de marqueurs:', error);
    }
});

function getImagePath(sentiment) {
    switch (sentiment.toLowerCase()) {
        case 'epoustouflant':
            return 'images/emoji_epoustouflant.png';
        case 'triste':
            return 'images/emoji_triste.png';
        case 'amour':
            return 'images/emoji_amour.png';
        case 'joyeux':
            return 'images/emoji_joyeux.png';
        case 'emouvant':
            return 'images/emoji_emouvant.png';
        case 'festif':
            return 'images/emoji_festif.png';
        default:
            return ''; 
    }
}


$('#btn_modifierSupprimer').on('click', function () {

    var nbrAvis = 0;

    $.ajax({
        type: 'GET',
        url: 'php/getAvisUtilisateur.php',
        dataType: 'json',
        success: function (data) {

            if (data.error) {
                console.error('Erreur lors de la récupération des avis de l\'utilisateur:', data.error);
                return;
            }
            console.log(data);

            $('#ongletAvis').show(); 

            var nomMarqueur = data.nomMarqueur;
            var avis = data.avis;

            $('#nomMarqueur').text(nomMarqueur);

            $('#nomMarqueur').text('Avis de ' + data.sessionName);
            
            $('#nbrSentiment').empty();
            $('#nbrAvis').empty();

            $('#avis').empty();

            avis.forEach(function (avisItem) {
                var avisBlock = $('<div>');
                avisBlock.append('<p>Lieu : ' + avisItem.nomMarqueur + '</p>');
                avisBlock.append('<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis">');
                avisBlock.append('<p>Avis : ' + avisItem.Avis + '</p>');
               
                var deleteButton = $('<button class="supprimer-avis">Supprimer</button>');
                deleteButton.data('idSentiment', avisItem.IdSentiment);
                console.log(avisItem.IdSentiment)
                avisBlock.append(deleteButton);
                
                avisBlock.append('<div class="traitBlanc"></div>');

                $('#avis').append(avisBlock);
                ++nbrAvis;
            });
            
            $('#nbrAvis').append('<p> Nombre Avis : ' + nbrAvis + '</p>');

            $('.supprimer-avis').on('click', supprimerAvis);
            
        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour récupérer les avis de l\'utilisateur:', error);
        }
    });
});


function supprimerAvis() {
    // Récupérer l'ID de l'avis à supprimer
    var idSentiment = $(this).data('idSentiment');

    // Demander une confirmation avant la suppression
    var confirmation = confirm('Voulez-vous vraiment supprimer cet avis?');

    if (confirmation) {
        // Si l'utilisateur clique sur "OK", effectuer la suppression
        $.ajax({
            type: 'POST',
            url: 'php/supprimerAvis.php',
            data: { idSentiment: idSentiment },
            success: function (response) {
                console.log('Avis supprimé avec succès');
                console.log(response);
                window.location.reload();
            },
            error: function (error) {
                console.error('Erreur lors de la suppression de l\'avis:', error);
            }
        });
    } else {
        // Si l'utilisateur clique sur "Annuler", ne rien faire
        console.log('Suppression annulée par l\'utilisateur');
    }
}



//Pour centrer la carte sur le marqueur avec le nom selectionné
$('.input_adresse').on('change', function () {
    var selectedMarqueur = $(this).val();

    if (selectedMarqueur !== '') {
        // Effectuez une requête AJAX pour obtenir les coordonnées du marqueur
        $.ajax({
            type: 'POST', // Utilisez POST ou GET selon vos besoins
            url: 'php/getMarqueurCoordinates.php', // Le fichier PHP pour traiter la requête
            data: { nomMarqueur: selectedMarqueur },
            dataType: 'json',
            success: function (data) {
                // Vérifiez si la réponse contient des erreurs
                if (data.error) {
                    console.error('Erreur lors de la récupération des coordonnées:', data.error);
                    return;
                }

                // Les coordonnées du marqueur
                var latitude = data.latitude;
                var longitude = data.longitude;

                // Utilisez Leaflet pour centrer la carte sur les coordonnées
                map.setView([latitude, longitude], 15); // 15 est le niveau de zoom, ajustez-le selon vos besoins
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);
            }
        });
    }
});
