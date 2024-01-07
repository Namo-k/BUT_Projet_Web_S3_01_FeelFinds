const fs = require('fs');

// Lisez le fichier JSON
fs.readFile('filteredData.json', 'utf8', (err, data) => {
  if (err) {
    console.error('Erreur de lecture du fichier JSON:', err);
    return;
  }

  // Parsez le contenu JSON
  const jsonData = JSON.parse(data);

  // Effectuez la conversion en GeoJSON
  const geoJsonData = {
    type: 'FeatureCollection',
    features: jsonData.map(item => {
      if(!item.immeuble.includes("Immeuble") &&
      !item.immeuble.includes("Eglise") &&
      !item.immeuble.includes("Église") &&
      !item.immeuble.includes("église") &&
      !item.immeuble.includes("École") &&
      !item.immeuble.includes("Ecole") &&
      !item.immeuble.includes("Lycée") &&
      !item.immeuble.includes("Atelier") &&
      !item.immeuble.includes("Collège") &&
      !item.immeuble.includes("Maison") &&
      !item.immeuble.includes("ferme") &&
      !item.immeuble.includes("Brasserie") &&
      !item.immeuble.includes("Auberge") &&
      !item.immeuble.includes("Ferme") &&
      !item.immeuble.includes("sncf") &&
      !item.immeuble.includes("auberge") &&
      !item.immeuble.includes("Synagogue") &&
      !item.immeuble.includes("Métropolitain") &&
      !item.immeuble.includes("Hôpital") &&
      !item.immeuble.includes("Boulangerie") &&
      !item.immeuble.includes("Restaurant") &&
      !item.immeuble.includes("Gare") &&
      !item.immeuble.includes("Boutique") &&
      !item.immeuble.includes("Usine") &&
      !item.immeuble.includes("usine") &&
      !item.immeuble.includes("gymnase") &&
      !item.immeuble.includes("Groupe scolaire") &&
      !item.immeuble.includes("Allée") &&
      !item.immeuble.includes("Garde-meuble") &&
      !item.immeuble.includes("Borne") &&
      !item.immeuble.includes("Cimetière") &&
      !item.immeuble.includes("Laboratoire") &&
      !item.immeuble.includes("Hôtel")){
      return {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [item.geo_point_2d.lon, item.geo_point_2d.lat]
            },
            properties: {
                name: item.immeuble,
            }
      };}
    })
  };

  // Écrivez le résultat dans un fichier GeoJSON
  const geoJsonString = JSON.stringify(geoJsonData, null, 2);
  fs.writeFile('data.geojson', geoJsonString, (err) => {
    if (err) {
      console.error('Erreur d\'écriture du fichier GeoJSON:', err);
      return;
    }
    console.log('Conversion réussie. Fichier GeoJSON créé.');
  });
});
