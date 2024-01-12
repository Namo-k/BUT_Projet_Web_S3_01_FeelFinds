<?php

try {
    //NE PAS EXECUTER CE FICHIER SVP
    //CA VA RAJOUTER DES MARQUEURS DEJA EXISTANT
    include('connexionBd.php'); 

    $jsonData = file_get_contents('data/filteredData.json');
    $data = json_decode($jsonData);

    foreach ($data as $location) {

        if (isset($location->geo_point_2d)) {

            $latitude = $location->geo_point_2d->lat;
            $longitude = $location->geo_point_2d->lon;
            $nomMarqueur = $location->immeuble;

            $sql = "INSERT INTO marqueur (NomMarqueur, Latitude, Longitude) VALUES (:nomMarqueur, :latitude, :longitude)";

            $req = $db->prepare($sql);

            $req->bindParam(':nomMarqueur', $nomMarqueur);
            $req->bindParam(':latitude', $latitude);
            $req->bindParam(':longitude', $longitude);

            $req->execute();

            echo "Enregistrement créé avec succès. <br>";
        }else{
            echo "vide";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
} finally {
    $db = null;
}

?>
