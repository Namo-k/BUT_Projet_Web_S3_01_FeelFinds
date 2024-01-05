<?php

try {

    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds_test', 'root', '');
 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $jsonData = file_get_contents('data/filteredData.json');
    $data = json_decode($jsonData);

    foreach ($data as $location) {

        if (isset($location->geo_point_2d)) {

            $latitude = $location->geo_point_2d->lat;
            $longitude = $location->geo_point_2d->lon;
            $nomMarqueur = $location->immeuble;

            $sql = "INSERT INTO marqueur (NomMarqueur, Latitude, Longitude) VALUES (:nomMarqueur, :latitude, :longitude)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':nomMarqueur', $nomMarqueur);
            $stmt->bindParam(':latitude', $latitude);
            $stmt->bindParam(':longitude', $longitude);

            $stmt->execute();

            echo "Enregistrement créé avec succès. <br>";
        }else{
            echo "vide";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$db = null;
?>
