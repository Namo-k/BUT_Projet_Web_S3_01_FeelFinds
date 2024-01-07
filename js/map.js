$(document).ready(function () {
    var afficherOngletAvis = localStorage.getItem('afficherOngletAvis');
    var afficherOngletFavori = localStorage.getItem('afficherOngletFavori');
    if (afficherOngletAvis === 'true') {
        ongletAvisChargement();
        localStorage.removeItem('afficherOngletAvis');
    }
    if (afficherOngletFavori === 'true') {
        ongletFavoriChargement();
        localStorage.removeItem('afficherOngletFavori');
    }

});

mapboxgl.accessToken = 'pk.eyJ1IjoiYWxleGFuZHJlLWNhcm91IiwiYSI6ImNscHRpdDFkcTBkaXkyaXJsYWd0b3BzcTYifQ.T0KEMuCacRyljE3bfI89yw';
const map = new mapboxgl.Map({
    container: 'map',
    // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
    style: 'mapbox://styles/mapbox/navigation-night-v1',
    center: [3.4999696897357, 48.6319425075],
    zoom: 10,
    pitch: 0,
    container: 'map',
    antialias: true
});


map.on('style.load', () => {
    // Insert the layer beneath any symbol layer.
    const layers = map.getStyle().layers;
    const labelLayerId = layers.find(
    (layer) => layer.type === 'symbol' && layer.layout['text-field']
    ).id;
     
    // The 'building' layer in the Mapbox Streets
    // vector tileset contains building height data
    // from OpenStreetMap.
    map.addLayer(
    {
    'id': 'add-3d-buildings',
    'source': 'composite',
    'source-layer': 'building',
    'filter': ['==', 'extrude', 'true'],
    'type': 'fill-extrusion',
    'minzoom': 15,
    'paint': {
    'fill-extrusion-color': '#aaa',
     
    // Use an 'interpolate' expression to
    // add a smooth transition effect to
    // the buildings as the user zooms in.
    'fill-extrusion-height': [
    'interpolate',
    ['linear'],
    ['zoom'],
    15,
    0,
    15.05,
    ['get', 'height']
    ],
    'fill-extrusion-base': [
    'interpolate',
    ['linear'],
    ['zoom'],
    15,
    0,
    15.05,
    ['get', 'min_height']
    ],
    'fill-extrusion-opacity': 0.6
    }
    },
    labelLayerId
    );
});


map.setLanguage('fr');

const directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
    unit: 'metric', // Choisissez l'unité souhaitée
    language: 'fr',
    //profile: 'mapbox/cycling', // Choisissez le profil souhaité
    controls: {
        inputs: true, // Désactivez les champs de saisie dans le panneau de recherche
        instructions: true // Activez les instructions dans le panneau
    },
    interactive: false,
    placeholderOrigin: 'Entrez votre lieu de départ', // Placeholder personnalisé pour l'origine
    placeholderDestination: 'Entrez votre lieu de destination',// Désactive la capture automatique des clics pour ce contrôle
    profile: 'mapbox/driving',
    geocoder: {
        bbox: [-5.0, 41.0, 9.5, 51.5],
        country: 'FR'
    }
});

document.getElementById('directions-container').appendChild(directions.onAdd(map));

map.on('load', () => {
    // Add a new source from our GeoJSON data and
    // set the 'cluster' option to true. GL-JS will
    // add the point_count property to your source data.
    map.addSource('earthquakes', {
        type: 'geojson',
        // Point to GeoJSON data. This example visualizes all M1.0+ earthquakes
        // from 12/22/15 to 1/21/16 as logged by USGS' Earthquake hazards program.
        data: 'data/data.geojson',
        cluster: true,
        clusterMaxZoom: 15, // Max zoom to cluster points on
        clusterRadius: 45 // Radius of each cluster when clustering points (defaults to 50)
    });




    map.addLayer({
        id: 'clusters',
        type: 'circle',
        source: 'earthquakes',
        filter: ['has', 'point_count'],
        paint: {
            // Use step expressions (https://docs.mapbox.com/style-spec/reference/expressions/#step)
            // with three steps to implement three types of circles:
            //   * Blue, 20px circles when point count is less than 100
            //   * Yellow, 30px circles when point count is between 100 and 750
            //   * Pink, 40px circles when point count is greater than or equal to 750
            'circle-color': [
                'step',
                ['get', 'point_count'],
                '#91D468',
                100,
                '#EECB3F',
                750,
                '#F4974E'
            ],
            'circle-radius': [
                'step',
                ['get', 'point_count'],
                17,
                83,
                17,
                710,
                23
            ],
            'circle-opacity': 0.7,
        }

    });

    map.addLayer({
        id: 'cluster-count',
        type: 'symbol',
        source: 'earthquakes',
        filter: ['has', 'point_count'],
        layout: {
            'text-field': ['get', 'point_count_abbreviated'],
            'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
            'text-size': 12
        }
    });

    map.loadImage('images/marker-icon.png', function (error, image) {
        if (error) throw error;

        map.addImage('custom-marker', image);

        map.addLayer({
            id: 'unclustered-point',
            type: 'symbol',
            source: 'earthquakes',
            filter: ['!', ['has', 'point_count']],
            layout: {
                'icon-image': 'custom-marker', // Utilisez le nom de l'image chargée
                'icon-size': 0.8 // Ajustez la taille de l'icône selon vos préférences
            },
            paint: {
                'icon-opacity': 1 // Ajustez l'opacité si nécessaire
            }
        });
    });


    // inspect a cluster on click
    map.on('click', 'clusters', (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ['clusters']
        });
        const clusterId = features[0].properties.cluster_id;
        map.getSource('earthquakes').getClusterExpansionZoom(
            clusterId,
            (err, zoom) => {
                if (err) return;

                map.easeTo({
                    center: features[0].geometry.coordinates,
                    zoom: zoom
                });
            }
        );
    });

    map.on('click', () => {
        $('#ongletAvis').hide();
        $('#ongletFavori').hide();
        erreurAjout(false);
    });

    // When a click event occurs on a feature in
    // the unclustered-point layer, open a popup at
    // the location of the feature, with
    // description HTML from its properties.
    map.on('click', 'unclustered-point', (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        console.log(coordinates);
        // Accédez aux propriétés de l'objet GeoJSON
        const properties = e.features[0].properties;
        console.log(properties);

        // Créez une chaîne HTML avec les propriétés que vous souhaitez afficher
        let htmlContent = '';
        for (const key in properties) {
            if (Object.hasOwnProperty.call(properties, key)) {
                htmlContent += `${properties[key]}<br>`;
            }
        }

        // Ensure that if the map is zoomed out such that
        // multiple copies of the feature are visible, the
        // popup appears over the copy being pointed to.
        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        }

        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(htmlContent)
            .addTo(map);

        $('#ongletAvis').show();

        $('.input_adresse').val(stripHtmlTags(properties.name));

        onMarkerClick(stripHtmlTags(properties.name));
        $('#ongletAvis').show();
    });

    function onMarkerClick(nom_) {
        // Utilisez AJAX pour obtenir les informations du marqueur depuis le fichier PHP

        console.log("test");

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

                $('.nomMarqueur').text(nomMarqueur);


                $('.avis').empty();
                $('.nbrAvis').empty();
                $('.nbrSentiment').empty();

                var counts = {
                    'epoustouflant': 0,
                    'triste': 0,
                    'amour': 0,
                    'joyeux': 0,
                    'emouvant': 0,
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


                    //Bouton supression et modification
                    if (avisItem.nomUser === data.sessionName) {
                        var deleteButton = $('<button class="supprimer-avis">Supprimer</button>');
                        deleteButton.data('idSentiment', avisItem.IdSentiment);
                        console.log(avisItem.IdSentiment)
                        avisBlock.append(deleteButton);


                        var modifyButton = $('<button class="modifier-avis">Modifier</button>');
                        modifyButton.data('idSentiment', avisItem.IdSentiment);
                        avisBlock.append(modifyButton);

                        erreurAjout(true);
                    }
                    else{
                        erreurAjout(false);
                    }

                    avisBlock.append('<div class="traitBlanc"></div>');

                    $('.avis').append(avisBlock);
                    console.log(avisBlock);
                });

                if(avis.length === 0){
                    erreurAjout(false);
                }


                for (var sentimentType in counts) {
                    if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                        $('.nbrSentiment').append('<p> ' + counts[sentimentType] + '</p>');
                        $('.nbrSentiment').append('<img src="images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis">');
                    }
                }

                $('.supprimer-avis').on('click', supprimerAvis);
                $('.modifier-avis').on('click', modifierAvis);
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);
            }
        });
    }



    map.on('mouseenter', 'clusters', () => {
        map.getCanvas().style.cursor = 'pointer';
    });
    map.on('mouseleave', 'clusters', () => {
        map.getCanvas().style.cursor = '';
    });

    loadMarkeur();

    $("#btnAnnulerFiltre").on("click", loadMarkeur);


    function loadMarkeur() {
        // Requête AJAX pour récupérer les marqueurs après l'id 1540
        $.ajax({
            type: 'GET',
            url: 'php/getMarqueursApresId.php',
            data: { id: 0 },
            dataType: 'json',
            success: function (data) {
                // Vérifie si la réponse contient des erreurs
                if (data.error) {
                    console.error('Erreur lors de la récupération des marqueurs:', data.error);
                    return;
                }
                console.log(data);
                console.log(map.getSource('earthquakes'));

                // Vérifie si la source de données existe
                // Vérifie si la source de données existe
                const earthquakesSource = map.getSource('earthquakes');

                if (earthquakesSource) {
                    // Obtenez les fonctionnalités existantes
                    // const existingFeatures = earthquakesSource._data.features || [];

                    // Ajoutez les nouveaux marqueurs à la source de données GeoJSON existante
                    const newFeatures = data.marqueurs.map(function (marqueur) {
                        return {
                            type: 'Feature',
                            geometry: {
                                type: 'Point',
                                coordinates: [marqueur.Longitude, marqueur.Latitude]
                            },
                            properties: {
                                name: marqueur.NomMarqueur
                                // Ajoutez d'autres propriétés si nécessaire
                            }
                        };
                    });

                    // Créez un tableau combinant les fonctionnalités existantes et les nouvelles fonctionnalités
                    // const updatedFeatures = existingFeatures.concat(newFeatures);

                    // Mettez à jour la source de données avec le nouveau GeoJSON complet
                    earthquakesSource.setData({
                        type: 'FeatureCollection',
                        features: newFeatures
                    });
                } else {
                    console.error('La source de données GeoJSON avec le nom "earthquakes" n\'existe pas.');
                }
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);
            }
        });

        $("#btnAnnulerFiltre").hide();
    }
    for (let i = 0; i < sentiments.length; i++) {
        const emojiId = "emoji_" + sentiments[i].nom.toLowerCase();
        $("#onglet_2 ." + emojiId).click(function () {
            console.log(sentiments[i].nom);

            $("#btnAnnulerFiltre").show();


            // Supposons que vous avez le nom du sentiment dans une variable nomSentiment
            var nomSentiment = sentiments[i].nom;

            $.ajax({
                type: 'GET',
                url: 'php/getMarqueurSentiment.php',
                data: { sentiment: nomSentiment },
                dataType: 'json',
                success: function (data) {
                    // markers.clearLayers();
                    // Traitez les données renvoyées, par exemple, affichez-les dans la console
                    console.log(data);

                    // // Ajouter les nouveaux marqueurs au cluster
                    // data.marqueurs.forEach(function (marqueur) {
                    //     var coordinates = [marqueur.latitude, marqueur.longitude];
                    //     var marker = L.marker(coordinates);

                    //     var popupContent = '<b>' + marqueur.nomMarqueur + '</b>';
                    //     marker.bindPopup(popupContent);
                    //     markers.addLayer(marker);
                    // });




                    const earthquakesSource = map.getSource('earthquakes');

                    if (earthquakesSource) {

                        // Ajoutez les nouveaux marqueurs à la source de données GeoJSON existante
                        const newFeatures = data.marqueurs.map(function (marqueur) {
                            return {
                                type: 'Feature',
                                geometry: {
                                    type: 'Point',
                                    coordinates: [marqueur.longitude, marqueur.latitude]
                                },
                                properties: {
                                    name: marqueur.nomMarqueur
                                    // Ajoutez d'autres propriétés si nécessaire
                                }
                            };
                        });


                        earthquakesSource.setData({
                            type: 'FeatureCollection',
                            features: newFeatures
                        });
                    } else {
                        console.error('La source de données GeoJSON avec le nom "earthquakes" n\'existe pas.');
                    }


                },
                error: function (error) {
                    console.error('Erreur lors de la requête AJAX:', error);
                }
            });

        });
    }

});



// Sélectionnez la div avec la classe "mapbox-directions-profile"
const profileDiv = document.querySelector('.mapbox-directions-profile');

// Vérifiez si la div existe avant de tenter de la supprimer
if (profileDiv) {
    // Supprimez la div du DOM
    profileDiv.parentNode.removeChild(profileDiv);
}

// Définissez les limites de la vue (bounds) pour la France et ses pays voisins
const allowedBounds = [
    [-10, 35], // Southwest coordinates (approximate)
    [20, 55]   // Northeast coordinates (approximate)
];

// Assurez-vous que la carte reste dans les limites autorisées
// map.setMaxBounds(allowedBounds);

// Limitez le zoom pour empêcher l'utilisateur de zoomer trop loin
// map.setMinZoom(5); // Niveau de zoom minimal
// map.setMaxZoom(25); // Niveau de zoom maximal

// Ajoutez un contrôle de zoom
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');


//CODE NAMO------------------------------------------------------------------------------------------------------
function stripHtmlTags(htmlString) {
    // Remplace toutes les balises HTML par une chaîne vide
    return htmlString.replace(/<\/?[^>]+(>|$)/g, "");
}

function erreurAjout(bool){
    if(bool == true){
        if ($('#ongletAjouter').is(':visible')) {
            $("#ongletAjouter #msgErreurAjoutSentiment").show();
            $("#ongletAjouter #msgErreurAjoutSentiment").text("Impossible d'ajouter un autre sentiment ici. Modifiez plutôt.")
            $('#ongletAjouter .btn').prop('disabled', true);

        } 
    }else{
        if ($('#ongletAjouter').is(':visible')) {
            $("#ongletAjouter #msgErreurAjoutSentiment").hide();
            $('#ongletAjouter .btn').prop('disabled', false);
        } 
    } 
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

function ongletAvisChargement(){

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

            var counts = {
                'epoustouflant': 0,
                'triste': 0,
                'amour': 0,
                'joyeux': 0,
                'emouvant': 0,
                'festif': 0
            };

            $('#ongletAvis').show();

            var nomMarqueur = data.nomMarqueur;
            var avis = data.avis;

            $('#ongletAvis .nomMarqueur').text(nomMarqueur);

            $('#ongletAvis .nomMarqueur').text('Avis de ' + data.sessionName);

            $('#ongletAvis .nbrSentiment').empty();
            $('#ongletAvis .nbrAvis').empty();

            $('#ongletAvis .avis').empty();

            avis.forEach(function (avisItem) {

                counts[avisItem.Sentiment.toLowerCase()]++;


                var avisBlock = $('<div>');
                avisBlock.append('<p>Lieu : ' + avisItem.nomMarqueur + '</p>');
                avisBlock.append('<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis">');
                avisBlock.append('<p>Avis : ' + avisItem.Avis + '</p>');

                var deleteButton = $('<button class="supprimer-avis">Supprimer</button>');
                deleteButton.data('idSentiment', avisItem.IdSentiment);
                console.log(avisItem.IdSentiment)
                avisBlock.append(deleteButton);

                var modifyButton = $('<button class="modifier-avis">Modifier</button>');
                modifyButton.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(modifyButton);

                var recentrerBtn = $('<button class="recentrer-avis">Recentrer</button>');
                recentrerBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(recentrerBtn);

                var favoriBtn = $('<button class="favori-avis">Favori</button>');
                favoriBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(favoriBtn);

                avisBlock.append('<div class="traitBlanc"></div>');

                $('#ongletAvis .avis').append(avisBlock);
                ++nbrAvis;
            });

            for (var sentimentType in counts) {
                if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                    $('#ongletAvis .nbrSentiment').append('<p> ' + counts[sentimentType] + '</p>');
                    $('#ongletAvis .nbrSentiment').append('<img src="images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis">');
                }
            }

            $('#ongletAvis .nbrAvis').append('<p> Nombre Avis : ' + nbrAvis + '</p>');

            $('.supprimer-avis').on('click', supprimerAvis);
            $('.modifier-avis').on('click', modifierAvis);
            $('.recentrer-avis').on('click', recentrerAvis);
            $('.favori-avis').on('click', favoriAvis);

            $('#ongletFavori').hide();

        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour récupérer les avis de l\'utilisateur:', error);
        }
    });
}

$('#btn_modifierSupprimer').on('click', ongletAvisChargement);


function ongletFavoriChargement(){
    var nbrAvis = 0;
   

    $.ajax({
        type: 'GET',
        url: 'php/getAvisUtilisateurFavori.php',
        dataType: 'json',
        success: function (data) {

            if (data.error) {
                console.error('Erreur lors de la récupération des avis de l\'utilisateur:', data.error);
                return;
            }
            console.log(data);

            var counts = {
                'epoustouflant': 0,
                'triste': 0,
                'amour': 0,
                'joyeux': 0,
                'emouvant': 0,
                'festif': 0
            };

            $('#ongletFavori').show();

            var avis = data.avis;

            console.log(avis);


            $('#ongletFavori .nomPersonne').text('Avis de ' + data.sessionName);

            $('#ongletFavori .nbrSentiment').empty();
            $('#ongletFavori .nbrAvis').empty();

            $('#ongletFavori .avis').empty();

            avis.forEach(function (avisItem) {
            
                counts[avisItem.Sentiment.toLowerCase()]++;
  
                var avisBlock = $('<div>');
                avisBlock.append('<p>Lieu : ' + avisItem.nomMarqueur + '</p>');
                avisBlock.append('<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis">');
                avisBlock.append('<p>Avis : ' + avisItem.Avis + '</p>');

                
                var recentrerBtn = $('<button class="recentrer-avis">Recentrer</button>');
                recentrerBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(recentrerBtn);

                var deleteButton = $('<button class="supprimer-favori">Supprimer Favori</button>');
                deleteButton.data('idSentiment', avisItem.IdSentiment);
                console.log(avisItem.IdSentiment)
                avisBlock.append(deleteButton);

               
                avisBlock.append('<div class="traitBlanc"></div>');

                $('#ongletFavori .avis').append(avisBlock);
                ++nbrAvis;
            });

            for (var sentimentType in counts) {
                if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                    $('#ongletFavori .nbrSentiment').append('<p> ' + counts[sentimentType] + '</p>');
                    $('#ongletFavori .nbrSentiment').append('<img src="images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis">');
                }
            }

            $('#ongletFavori .nbrAvis').append('<p> Nombre de Favori : ' + nbrAvis + '</p>');


            $('.supprimer-favori').on('click', supprimerFavori);
            $('.recentrer-avis').on('click', recentrerAvis);

            
        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour récupérer les avis de l\'utilisateur:', error);
        }
    });
}


$('#btn_favori').on('click', ongletFavoriChargement);



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

function modifierAvis() {
    // Récupérer l'ID de l'avis à modifier
    var idSentiment = $(this).data('idSentiment');

    $('#ongletAjouter').hide();

    // Récupérer les détails de l'avis depuis le serveur
    $.ajax({
        type: 'GET',
        url: 'php/getSentimentDetails.php',
        data: { idSentiment: idSentiment },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('input[name="idSentiment"]').val(data.IdSentiment);
            $('input[name="nomMarqueur"]').val(data.nomMarqueur);
            $('input[name="sentiment"]').val(data.Sentiment);
            $('.nom_sentiment').text(data.Sentiment);
            $('.input_desc').val(data.Avis);

        },
        error: function (error) {
            console.error('Erreur lors de la récupération des détails du sentiment:', error);
        }
    });

    // Afficher le formulaire de modification
    $('#ongletContaint').hide();
    $('#ongletModifier').show();
}

function recentrerAvis() {
    // Récupérer l'ID de l'avis à supprimer
    var idSentiment = $(this).data('idSentiment');

    
    // Si l'utilisateur clique sur "OK", effectuer la suppression
    $.ajax({
        type: 'GET',
        url: 'php/getMarqueurCoordSentiment.php',
        dataType: 'json',
        data: { idSentiment: idSentiment },
        success: function (data) {
            
            console.log('Marqueur trouvé');
            console.log(data);
            console.log(idSentiment);
            map.flyTo({
                center: [data.longitude, data.latitude], // Utilisez le premier point du trajet
                zoom: 15, // Ajustez le niveau de zoom selon vos préférences
                essential: true // Empêche le mouvement brusque de la carte pendant l'animation
            });
        },
        error: function (error) {
            console.error('Erreur recentrer de l\'avis:', error);
        }
    });
}

function favoriAvis() {
    // Récupérer l'ID de l'avis à supprimer
    var idSentiment = $(this).data('idSentiment');

    // Demander une confirmation avant la suppression
    var confirmation = confirm('Voulez-vous vraiment ajouter en favori cet avis?');

    if (confirmation) {
        // Si l'utilisateur clique sur "OK", effectuer la suppression
        $.ajax({
            type: 'POST',
            url: 'php/ajoutFavoriAvis.php',
            data: { idSentiment: idSentiment },
            success: function (response) {
                console.log('Avis ajouté en favori avec succès');
                console.log(response);

                if ($('#ongletFavori').is(':visible')) {
                    localStorage.setItem('afficherOngletFavori', 'true');
                } 
                localStorage.setItem('afficherOngletAvis', 'true');


                window.location.reload()
                // $('#ongletAvis').show();
                // if(a == 1){
                //     $('#ongletFavori').show();
                // }

            },
            error: function (error) {
                console.error('Erreur lors de l\'ajout en favori de l\'avis:', error);
            }
        });
    } else {
        // Si l'utilisateur clique sur "Annuler", ne rien faire
        console.log('Ajout favori annulée par l\'utilisateur');
    }
}

function supprimerFavori() {
    // Récupérer l'ID de l'avis à supprimer
    var idSentiment = $(this).data('idSentiment');

    // Demander une confirmation avant la suppression
    var confirmation = confirm('Voulez-vous vraiment supprimer ce favori?');

    if (confirmation) {
        // Si l'utilisateur clique sur "OK", effectuer la suppression
        $.ajax({
            type: 'POST',
            url: 'php/supprimerFavoriAvis.php',
            data: { idSentiment: idSentiment },
            success: function (response) {
                console.log('Favori supprimé avec succès');
                console.log(response);

                localStorage.setItem('afficherOngletFavori', 'true');
                if ($('#ongletAvis').is(':visible')) {
                    localStorage.setItem('afficherOngletAvis', 'true');
                } 
                
                window.location.reload();
            },
            error: function (error) {
                console.error('Erreur lors de la suppression du favori : ', error);
            }
        });
    } else {
        // Si l'utilisateur clique sur "Annuler", ne rien faire
        console.log('Suppression annulée par l\'utilisateur');
    }
}

$('.fermeAvis').on("click", () => { $('#ongletAvis').hide();})
$('.fermeFavori').on("click", () => { $('#ongletFavori').hide(); })
$('.input_adresse').on("click", () => { $('#ongletAvis').hide(); })


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
                console.log(latitude, longitude);
                // Utilisez Leaflet pour centrer la carte sur les coordonnées

                map.flyTo({
                    center: [longitude, latitude], // Utilisez le premier point du trajet
                    zoom: 15, // Ajustez le niveau de zoom selon vos préférences
                    essential: true // Empêche le mouvement brusque de la carte pendant l'animation
                });
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);
            }
        });
    }
});




var tempMarker; 
$('#btnAjouterLieu').on('click', function () {
    

    $('#ongletContaint').hide();
    $('#ongletAjouter').hide();
    $('#ongletAjouterMarqueur').show();

    map.on('click', (e) => {
        // Récupérer les coordonnées du clic
        const coordinates = e.lngLat.toArray(); // Utilise toArray() pour obtenir un tableau [longitude, latitude]
        console.log('Coordonnées:', coordinates);

        // Supprimer le marqueur temporaire s'il existe
        if (tempMarker) {
            tempMarker.remove();
        }

        // Ajouter un marqueur temporaire à l'emplacement du clic
        tempMarker = new mapboxgl.Marker().setLngLat(coordinates).addTo(map);

        // Mettre à jour les champs d'entrée avec les coordonnées
        $('input[name="latitude"]').val(coordinates[1]);
        $('input[name="longitude"]').val(coordinates[0]);

        // Obtenir l'adresse à partir des coordonnées
        getAddressFromCoordinates(coordinates[1], coordinates[0]);
    });

    // $('#btnAddLieu').on('click', function () {
    //     marker = L.marker([$('input[name="latitude"]').val(), $('input[name="longitude"]').val()]);
    //     markers.addLayer(marker);
    // });

});

function supprimerMarqueurTemporaire() {
    if (tempMarker) {
        tempMarker.remove();
        tempMarker = null;
    }
}


$('input[name="latitude"]').on('input', supprimerMarqueurTemporaire);
$('input[name="longitude"]').on('input', supprimerMarqueurTemporaire);
$('.btn_retour').on('click', ()=>{
    supprimerMarqueurTemporaire();
    var textVide="";
    $('select[name="nomMarqueur"]').val(textVide);
    $('input[name="nomMarqueur"]').val(textVide);
    $('textarea[name="avis"]').val(textVide);
    $('input[name="sentiment"]').val(textVide);
    $('input[name="idSentiment"]').val(textVide);
    $('input[name="nomLieu"]').val(textVide);
    $('input[name="latitude"]').val(textVide);
    $('input[name="longitude"]').val(textVide);
    $('textarea[name="addLieu"]').val(textVide);
    $(".nom_sentiment").html(textVide);
    erreurAjout(false);
});


function getAddressFromCoordinates(lat, lng) {

    var apiUrl = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng;

    $.ajax({
        url: apiUrl,
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            console.log(data);
            if (data && data.display_name) {
                $('textarea[name="addLieu"]').val(data.display_name);
            }
        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour obtenir l\'adresse:', error);
        }
    });
}

// Récupérer la référence de la checkbox
var checkbox = document.getElementById('switch');

// Ajouter un gestionnaire d'événements pour détecter le changement d'état
checkbox.addEventListener('change', function () {
  toggleMapStyle();
});

// Fonction pour basculer le style de la carte
function toggleMapStyle() {
  if (checkbox.checked) {
    // Changer le style de la carte à un autre style de votre choix
    map.setStyle('mapbox://styles/mapbox/streets-v12');
  } else {
    // Revenir au style par défaut
    map.setStyle('mapbox://styles/mapbox/navigation-night-v1');
  }
}