var filteredData = [];
$.ajax({
    type: 'GET',
    url: '../data/monumentsHistoriques.json',
    dataType: 'json',
    success: function (data) {
        data.forEach(function (location) {
            if (
                location['geo_point_2d'] &&
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
                !location.immeuble.includes("Hôtel")
            ) {
                filteredData.push(location);
            }
        });


        //filtered data en json
        var jsonString = JSON.stringify(filteredData, null, 2); 
        console.log(jsonString);

        //genre de conteneur où on met le truc dedans
        var blob = new Blob([jsonString], { type: 'application/json' }); 

        //Permet le telechargement du nouveau fichier json
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'filteredData.json';

        document.body.appendChild(link);
        link.click();

        document.body.removeChild(link);

    },
    error: function (error) {
        console.error('Erreur lors du chargement du fichier JSON:', error);
    }
});