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

// DEBUT CONFIG MAP ----------------------------------------------------------------------------------------------------------------------

mapboxgl.accessToken = 'pk.eyJ1IjoiYWxleGFuZHJlLWNhcm91IiwiYSI6ImNscHRpdDFkcTBkaXkyaXJsYWd0b3BzcTYifQ.T0KEMuCacRyljE3bfI89yw';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/navigation-night-v1',
    center: [1.526502, 47.239457],
    zoom: 5.5,
    pitch: 0,
    container: 'map',
    antialias: true
});


map.on('style.load', () => {
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

//ITINERAIRE -------------------------------------------------------------------------------------------

const directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
    unit: 'metric', 
    language: 'fr',
    controls: {
        inputs: true,
        instructions: true
    },
    interactive: false,
    placeholderOrigin: 'Entrez votre lieu de départ...',
    placeholderDestination: 'Entrez votre lieu de destination...',
    profile: 'mapbox/driving',
    geocoder: {
        bbox: [-5.0, 41.0, 9.5, 51.5],
        country: 'FR'
    }
});

document.getElementById('directions-container').appendChild(directions.onAdd(map));

// FIN ININERAIRE -------------------------------------------------------------------------------------------

map.on('load', () => {
    map.addSource('earthquakes', {
        type: 'geojson',
        data: '../../data/data.geojson', //on est actuellement dans le dossier php-pages
        cluster: true,
        clusterMaxZoom: 15,
        clusterRadius: 45
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

    map.loadImage('../../images/marker-icon.png', function (error, image) {
        if (error) throw error;

        map.addImage('custom-marker', image);

        map.addLayer({
            id: 'unclustered-point',
            type: 'symbol',
            source: 'earthquakes',
            filter: ['!', ['has', 'point_count']],
            layout: {
                'icon-image': 'custom-marker',
                'icon-size': 0.8
            },
            paint: {
                'icon-opacity': 1
            }
        });
    });

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
        $('#ongletInfoMarqueur').hide();
        erreurAjout(false);
    });

    map.on('click', 'unclustered-point', (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        console.log(coordinates);
       
        const properties = e.features[0].properties;
        console.log(properties);

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

        $('#ongletInfoMarqueur').show();

        $('.input_adresse').val(stripHtmlTags(properties.name));

        onMarkerClick(stripHtmlTags(properties.name));
        $('#ongletInfoMarqueur').show();
    });

    //Fonction au clic d'un marqueur -> Affiche l'onglet Informations du marqueur et charge les données
    function onMarkerClick(nom_) {

        $.ajax({
            type: 'GET',
            url: '../php-map/get/getMarqueurInfo.php',
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

                $('#ongletInfoMarqueur .nomMarqueur').text(nomMarqueur);


                $('#ongletInfoMarqueur .avis').empty();
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

                var nbrAvis = 0;

                avis.forEach(function (avisItem) {

                    console.log("avisItem");
                    console.log(avisItem);
                    var avisBlock = $('<div>');
                    avisBlock.append('<br> <img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis">');
                    avisBlock.append('<p> Avis : ' + avisItem.Avis + '</p>');
                    avisBlock.append('<p > Auteur : ' + (avisItem.nomUser.trim() !== '' ? avisItem.nomUser : 'Anonyme') + '</p>');
                    
        
                    
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

                    avisBlock.append('<div class="line2"></div>');

                    $('.avis').append(avisBlock);
                    console.log(avisBlock);
                    ++nbrAvis;
                });

                if(avis.length === 0){
                    erreurAjout(false);
                }

                $('#ongletInfoMarqueur .nbrAvis').append('<p id="nombreTotalAvis"> Nombre total avis : ' + nbrAvis + '</p>');

                for (var sentimentType in counts) {
                    if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                        $('.nbrSentiment').append('<p> ' + counts[sentimentType] + ' &nbsp </p>');
                        $('.nbrSentiment').append('<img src="../../images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis"> &nbsp &nbsp ');
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

    // FILTRER -----------------------------------------------------------------------------------------------

    $("#btnAnnulerFiltre").on("click", ()=>{
        $("#onglet_2 .nom_sentiment").html("Testez ! ");
        $("#onglet_2 #description_sentiment").html("Choisissez un sentiment");
        loadMarkeur();
    });


    function loadMarkeur() {
        $.ajax({
            type: 'GET',
            url: '../php-map/get/getMarqueursApresId.php',
            data: { id: 0 },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error('Erreur lors de la récupération des marqueurs:', data.error);
                    return;
                }
                console.log(data);
                console.log(map.getSource('earthquakes')); //earthquakes est le nom du cluster

                const earthquakesSource = map.getSource('earthquakes');

                if (earthquakesSource) {
                    
                    const newFeatures = data.marqueurs.map(function (marqueur) {
                        return {
                            type: 'Feature',
                            geometry: {
                                type: 'Point',
                                coordinates: [marqueur.Longitude, marqueur.Latitude]
                            },
                            properties: {
                                name: marqueur.NomMarqueur
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

        $("#btnAnnulerFiltre").hide();
    }
    for (let i = 0; i < sentiments.length; i++) {
        const emojiId = "emoji_" + sentiments[i].nom.toLowerCase();
        $("#onglet_2 ." + emojiId).click(function () {
            console.log(sentiments[i].nom);

            $("#btnAnnulerFiltre").show();

            var nomSentiment = sentiments[i].nom;

            $.ajax({
                type: 'GET',
                url: '../php-appli/get/getMarqueurSentiment.php',
                data: { sentiment: nomSentiment },
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    const earthquakesSource = map.getSource('earthquakes');

                    if (earthquakesSource) {

                        const newFeatures = data.marqueurs.map(function (marqueur) {
                            return {
                                type: 'Feature',
                                geometry: {
                                    type: 'Point',
                                    coordinates: [marqueur.longitude, marqueur.latitude]
                                },
                                properties: {
                                    name: marqueur.nomMarqueur
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

    // FIN FILTRER ---------------------------------------------------------------------------------------------------------------------

});


const profileDiv = document.querySelector('.mapbox-directions-profile');

if (profileDiv) {
    profileDiv.parentNode.removeChild(profileDiv);
}

// Les limites de la vue (bounds)
const allowedBounds = [
    [-10, 35], // Southwest coordinates (approximate)
    [20, 55]   // Northeast coordinates (approximate)
];

map.setMaxBounds(allowedBounds);

map.setMinZoom(5);
map.setMaxZoom(25);

map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');

// FIN CONFIG MAP ----------------------------------------------------------------------------------------------------------------------

//QUELQUE FONCTION -------------------------------------------------------------------------------------------------------------------


function stripHtmlTags(htmlString) {
    return htmlString.replace(/<\/?[^>]+(>|$)/g, ""); //code html en text
}


function getImagePath(sentiment) {
    switch (sentiment.toLowerCase()) {
        case 'epoustouflant':
            return '../../images/emoji_epoustouflant.png';
        case 'triste':
            return '../../images/emoji_triste.png';
        case 'amour':
            return '../../images/emoji_amour.png';
        case 'joyeux':
            return '../../images/emoji_joyeux.png';
        case 'emouvant':
            return '../../images/emoji_emouvant.png';
        case 'festif':
            return '../../images/emoji_festif.png';
        default:
            return '';
    }
}

// ------------------------------------------------------------------------------------------------------------------------------------

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


// BAR DE RECHERCHE DANS LE FORM AJOUTER SENTIMENT (input adresse) -----------------------------------------------------------------

loadNomMarqueurDansBarRecherche();

//Pour centrer la carte sur le marqueur avec le nom selectionné
$('.input_adresse').on('change', function () {
    var selectedMarqueur = $(this).val();

    if (selectedMarqueur !== '') {
        $.ajax({
            type: 'POST',
            url: '../php-map/get/getMarqueurCoordinates.php',
            data: { nomMarqueur: selectedMarqueur },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error('Erreur lors de la récupération des coordonnées:', data.error);
                    return;
                }
                var latitude = data.latitude;
                var longitude = data.longitude;
                console.log(latitude, longitude);

                map.flyTo({
                    center: [longitude, latitude],
                    zoom: 15, 
                    essential: true
                });
            },
            error: function (error) {
                console.error('Erreur lors de la requête AJAX:', error);
            }
        });
    }
});

function loadNomMarqueurDansBarRecherche(){
    //Requete AJAX servant a remplir la barre de recherche dans le form ajouterSentiment
    $.ajax({
        type: 'GET',
        url: '../php-map/get/getNomMarqueur.php',
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
}

// -----------------------------------------------------------------------------------------------------------------------------------------------

//ONGLET MA SENTITHEQUE --------------------------------------------------------------------------------------------------------------

function ongletAvisChargement(){

    var nbrAvis = 0;

    $.ajax({
        type: 'GET',
        url: '../php-appli/get/getAvisUtilisateur.php',
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

            $('#ongletAvis').slideToggle();

            var nomMarqueur = data.nomMarqueur;
            var avis = data.avis;

            $('#ongletAvis #titreAvis').html("Ma sentithèque");
            $('#ongletAvis .nomMarqueur').text(nomMarqueur);

            $('#ongletAvis .nomMarqueur').text('Propriétaire : ' + data.sessionName);

            $('#ongletAvis .nbrSentiment').empty();
            $('#ongletAvis .nbrAvis').empty();

            $('#ongletAvis .avis').empty();

            avis.forEach(function (avisItem) {

                counts[avisItem.Sentiment.toLowerCase()]++;


                var avisBlock = $('<div id="avis">');
                avisBlock.append('<p class ="avisTitre"> Lieu : </p>' + '<p id="nomLieu">' + avisItem.nomMarqueur + '</p>');
                avisBlock.append('<p id ="avisSentiment">  Sentiment : </p>' + '<div id="sentiment">'+ '<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis" id="avisEmoji">' + '</div>');
                avisBlock.append('<p class ="avisTitre"> Avis : </p>' + '<p id="avisTexte">' + '&nbsp' + '&nbsp' + avisItem.Avis + '</p>');

                avisBlock.append('<div class ="container-avis">');
                var modifyButton = $('<button class="modifier-avis">Modifier</button>');
                modifyButton.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(modifyButton);

                var recentrerBtn = $('<button class="recentrer-avis">Recentrer</button>');
                recentrerBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(recentrerBtn);

                var deleteButton = $('<button class="supprimer-avis">Supprimer</button>');
                deleteButton.data('idSentiment', avisItem.IdSentiment);
                console.log(avisItem.IdSentiment)
                avisBlock.append(deleteButton);

                var favoriBtn = $('<button class="favori-avis"> Favori </button>');
                favoriBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(favoriBtn);

                avisBlock.append('<div class="line2"></div>');

                avisBlock.append('</div>');
                $('#ongletAvis .avis').append(avisBlock);
                ++nbrAvis;

                avisBlock.append('</div>');
            });

            $('#ongletAvis .nbrSentiment').append('<p> &nbsp &nbsp <p>');
            for (var sentimentType in counts) {
                if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                    $('#ongletAvis .nbrSentiment').append('<p> ' + counts[sentimentType] + '&nbsp </p>');
                    $('#ongletAvis .nbrSentiment').append('<img src="../../images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis"> &nbsp &nbsp ');
                }
            }

            $('#ongletAvis .nbrAvis').append('<p id="nombreTotalAvis"> Nombre total avis : ' + nbrAvis + '</p>');

            $('.supprimer-avis').on('click', supprimerAvis);
            $('.modifier-avis').on('click', modifierAvis);
            $('.recentrer-avis').on('click', recentrerAvis);
            $('.favori-avis').on('click', favoriAvis);

            $('#ongletFavori').hide();
            $('#ongletInfoMarqueur').hide();

        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour récupérer les avis de l\'utilisateur:', error);
        }
    });
}

$('#btn_modifierSupprimer').on('click', ongletAvisChargement);

// FIN ONGLET MA SENTITHEQUE --------------------------------------------------------------------------------------------------------------------------

// DEBUT ONGLET FAVORI  --------------------------------------------------------------------------------------------------------------------------
function ongletFavoriChargement(){

    var nbrAvis = 0;
   
    $.ajax({
        type: 'GET',
        url: '../php-appli/get/getAvisUtilisateurFavori.php',
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

            $('#ongletInfoMarqueur').hide();
            $('#ongletFavori').slideToggle();

            var avis = data.avis;

            console.log(avis);


            $('#ongletFavori .nomPersonne').text('Propriétaire : ' + data.sessionName);

            $('#ongletFavori .nbrSentiment').empty();
            $('#ongletFavori .nbrAvis').empty();

            $('#ongletFavori .avis').empty();

            avis.forEach(function (avisItem) {
            
                counts[avisItem.Sentiment.toLowerCase()]++;
  
                var avisBlock = $('<div id="avis">');
                avisBlock.append('<p class ="avisTitre"> Lieu : </p>' + '<p id="nomLieu">' + avisItem.nomMarqueur + '</p>');
                avisBlock.append('<p id ="avisSentiment">  Sentiment : </p>' + '<div id="sentiment">'+ '<img src="' + getImagePath(avisItem.Sentiment) + '" width="26px" class="emojis" id="avisEmoji">' + '</div>');
                avisBlock.append('<p class ="avisTitre"> Avis : </p>' + '<p id="avisTexte">' + '&nbsp' + '&nbsp' + avisItem.Avis + '</p>');

                avisBlock.append('<div class ="container-avis-favori">');
                var recentrerBtn = $('<button class="recentrer-avis">Recentrer</button>');
                recentrerBtn.data('idSentiment', avisItem.IdSentiment);
                avisBlock.append(recentrerBtn);

                var deleteButton = $('<button class="supprimer-favori">Supprimer</button>');
                deleteButton.data('idSentiment', avisItem.IdSentiment);
                console.log(avisItem.IdSentiment)
                avisBlock.append(deleteButton);

                avisBlock.append('<div class="line2"></div>');
                avisBlock.append('</div>');

                $('#ongletFavori .avis').append(avisBlock);
                ++nbrAvis;
            });

            $('#ongletFavori .nbrSentiment').append('<p> &nbsp &nbsp <p>');
            for (var sentimentType in counts) {
                if (counts.hasOwnProperty(sentimentType) && counts[sentimentType] > 0) {
                    $('#ongletFavori .nbrSentiment').append('<p> ' + counts[sentimentType] + '&nbsp </p>');
                    $('#ongletFavori .nbrSentiment').append('<img src="../../images/emoji_' + sentimentType.toLowerCase() + '.png" width="26px" class="emojis"> &nbsp &nbsp');
                }
            }

            $('#ongletFavori .nbrAvis').append('<p> Nombre de favoris : ' + nbrAvis + '</p>');


            $('.supprimer-favori').on('click', supprimerFavori);
            $('.recentrer-avis').on('click', recentrerAvis);

            
        },
        error: function (error) {
            console.error('Erreur lors de la requête AJAX pour récupérer les avis de l\'utilisateur:', error);
        }
    });
}


$('#btn_favori').on('click', ongletFavoriChargement);


// FIN ONGLET FAVORI  --------------------------------------------------------------------------------------------------------------------------

// FONCTION SUPRIMER MODIFIER RECENTRER
function supprimerAvis() {
    
    var idSentiment = $(this).data('idSentiment');

    
    var confirmation = confirm('Voulez-vous vraiment supprimer cet avis?');

    if (confirmation) {
        
        $.ajax({
            type: 'POST',
            url: '../php-appli/supprimer/supprimerAvis.php',
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
       
        console.log('Suppression annulée par l\'utilisateur');
    }
}

function modifierAvis() {
    
    var idSentiment = $(this).data('idSentiment');

    $('#ongletAjouter').hide();

    $.ajax({
        type: 'GET',
        url: '../php-appli/get/getSentimentDetails.php',
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

    $('#ongletContaint').hide();
    $('#ongletModifier').show();
}

function recentrerAvis() {

    var idSentiment = $(this).data('idSentiment');


    $.ajax({
        type: 'GET',
        url: '../php-map/get/getMarqueurCoordSentiment.php',
        dataType: 'json',
        data: { idSentiment: idSentiment },
        success: function (data) {
            
            console.log('Marqueur trouvé');
            console.log(data);
            console.log(idSentiment);
            map.flyTo({
                center: [data.longitude, data.latitude],
                zoom: 15,
                essential: true
            });
        },
        error: function (error) {
            console.error('Erreur recentrer de l\'avis:', error);
        }
    });
}

function favoriAvis() {

    var idSentiment = $(this).data('idSentiment');

    var confirmation = confirm('Voulez-vous vraiment ajouter en favori cet avis?');

    if (confirmation) {

        $.ajax({
            type: 'POST',
            url: '../php-appli/ajout/ajoutFavoriAvis.php',
            data: { idSentiment: idSentiment },
            success: function (response) {
                console.log('Avis ajouté en favori avec succès');
                console.log(response);

                if ($('#ongletFavori').is(':visible')) {
                    localStorage.setItem('afficherOngletFavori', 'true');
                } 
                localStorage.setItem('afficherOngletAvis', 'true');
                window.location.reload()
            },
            error: function (error) {
                console.error('Erreur lors de l\'ajout en favori de l\'avis:', error);
            }
        });
    } else {
        console.log('Ajout favori annulée par l\'utilisateur');
    }
}

function supprimerFavori() {
    var idSentiment = $(this).data('idSentiment');
    var confirmation = confirm('Voulez-vous vraiment supprimer ce favori?');

    if (confirmation) {
        $.ajax({
            type: 'POST',
            url: '../php-appli/supprimer/supprimerFavoriAvis.php',
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
        console.log('Suppression annulée par l\'utilisateur');
    }
}

$('#fermeAvis').on("click", () => { $('#ongletAvis').hide();})
$('#fermeFavori').on("click", () => { $('#ongletFavori').hide(); })
$('#fermeInfoMarqueur').on("click", () => { $('#ongletInfoMarqueur').hide(); })
$('.input_adresse').on("click", () => { $('#ongletAvis').hide(); })


// AJOUTER UN LIEU -------------------------------------------------------------------------------------------------
var tempMarker; 
$('#btnAjouterLieu').on('click', function () {
    

    $('#ongletContaint').hide();
    $('#ongletAjouter').hide();
    $('#ongletAjouterMarqueur').show();

    map.on('click', (e) => {
        if ($('#ongletAjouterMarqueur').is(':visible')) {
            const coordinates = e.lngLat.toArray();
            console.log('Coordonnées:', coordinates);

            if (tempMarker) {
                tempMarker.remove();
            }

            tempMarker = new mapboxgl.Marker().setLngLat(coordinates).addTo(map);

            $('input[name="latitude"]').val(coordinates[1]);
            $('input[name="longitude"]').val(coordinates[0]);

            getAddressFromCoordinates(coordinates[1], coordinates[0]);
        } 

    });

});

function supprimerMarqueurTemporaire() {
    if (tempMarker) {
        tempMarker.remove();
        tempMarker = null;
    }
}


$('input[name="latitude"]').on('input', supprimerMarqueurTemporaire);
$('input[name="longitude"]').on('input', supprimerMarqueurTemporaire);

//Fonction Permettant de recup via les coordonnées -> L'adresse du point avec une requete à l'URL NOMINATIM
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

// FIN AJOUTER UN LIEU --------------------------------------------------------------------------------------------------------------------

// BTN RETOUR -----------------------------------------------
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

// --------------------------------------------------------

// TOGGLE THEME -----------------------------------------------------------------------------
//En cours de developpement (bug quand on change de styles nos marqueurs disparaissent)

var checkbox = document.getElementById('switch');

checkbox.addEventListener('change', function () {
  toggleMapStyle();
});

function toggleMapStyle() {
  if (checkbox.checked) {
    map.setStyle('mapbox://styles/mapbox/streets-v12');
  } else {
    map.setStyle('mapbox://styles/mapbox/navigation-night-v1');
  }
}

// --------------------------------------------------------------------------------------------