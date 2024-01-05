<?php

session_start();

// Assurez-vous que les données nécessaires sont présentes
if (isset($_POST['latitude'], $_POST['longitude'], $_POST['nomLieu'], $_POST['sentiment'], $_POST['avis'])) {
    // Récupérez les données du formulaire
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $nomLieu = $_POST['nomLieu'];
    $sentiment = $_POST['sentiment'];
    $avis = $_POST['avis'];

    // Utilisez PDO pour se connecter à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertion du marqueur dans la table marqueur
        $insertMarqueur = $db->prepare('INSERT INTO marqueur (nomMarqueur, latitude, longitude) VALUES (:nomLieu, :latitude, :longitude)');
        $insertMarqueur->bindParam(':nomLieu', $nomLieu);
        $insertMarqueur->bindParam(':latitude', $latitude);
        $insertMarqueur->bindParam(':longitude', $longitude);

        $insertMarqueur->execute();

        // Récupérez l'ID du dernier marqueur inséré
        $idMarqueur = $db->lastInsertId();

        // Insertion du sentiment dans la table sentitheque
        $insertSentiment = $db->prepare('INSERT INTO sentitheque (sentiment, avis, nomUser, idMarqueur) VALUES (:sentiment, :avis, :nomUser, :idMarqueur)');
        $insertSentiment->bindParam(':sentiment', $sentiment);
        $insertSentiment->bindParam(':avis', $avis);
        $insertSentiment->bindParam(':nomUser', $_SESSION['id']);
        $insertSentiment->bindParam(':idMarqueur', $idMarqueur);

        $insertSentiment->execute();

        // Fermez la connexion à la base de données
        $db = null;

        // Renvoyez une réponse JSON indiquant le succès
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Marqueur et sentiment ajoutés avec succès']);
    } catch (PDOException $e) {
        // Gérez les erreurs PDO
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Erreur lors de l\'ajout du marqueur et du sentiment']);
    }
} else {
    // Les données nécessaires ne sont pas présentes, renvoyez une réponse JSON d'erreur
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Données manquantes']);
}

header('Location: ../appli.php');
?>
