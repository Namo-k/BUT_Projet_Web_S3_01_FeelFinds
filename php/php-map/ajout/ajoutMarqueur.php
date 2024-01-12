<?php

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

if (isset($_POST['latitude'], $_POST['longitude'], $_POST['nomLieu'], $_POST['sentiment'], $_POST['avis'])) {

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $nomLieu = $_POST['nomLieu'];
    $sentiment = $_POST['sentiment'];
    $avis = $_POST['avis'];

    try {
        include('../../auth/connexionBd.php');

        $insertMarqueur = $db->prepare('INSERT INTO marqueur (nomMarqueur, latitude, longitude) VALUES (:nomLieu, :latitude, :longitude)');
        $insertMarqueur->bindParam(':nomLieu', $nomLieu);
        $insertMarqueur->bindParam(':latitude', $latitude);
        $insertMarqueur->bindParam(':longitude', $longitude);

        $insertMarqueur->execute();

        $idMarqueur = $db->lastInsertId();

 
        $insertSentiment = $db->prepare('INSERT INTO sentitheque (sentiment, avis, nomUser, idMarqueur) VALUES (:sentiment, :avis, :nomUser, :idMarqueur)');
        $insertSentiment->bindParam(':sentiment', $sentiment);
        $insertSentiment->bindParam(':avis', $avis);
        $insertSentiment->bindParam(':nomUser', $_SESSION['id']);
        $insertSentiment->bindParam(':idMarqueur', $idMarqueur);

        $insertSentiment->execute();

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Marqueur et sentiment ajoutés avec succès']);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erreur lors de l\'ajout du marqueur et du sentiment']);
    }
    finally {
        $db = null;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Données manquantes']);
}

header('Location: ../../pages/pageAppli.php');
?>
