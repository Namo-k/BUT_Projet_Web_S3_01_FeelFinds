<?php

session_start();
try {
    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'idMarqueur à partir du nom du marqueur
    $nomMarqueur = $_POST['nomMarqueur']; // Remplacez 'nomMarqueur' par le nom réel de votre champ

    $nomMarqueur = strip_tags($nomMarqueur);

    $sqlSelectIdMarqueur = "SELECT idMarqueur FROM Marqueur WHERE nomMarqueur = :nomMarqueur";
    $reqSelectIdMarqueur = $db->prepare($sqlSelectIdMarqueur);
    $reqSelectIdMarqueur->bindParam(':nomMarqueur', $nomMarqueur);
    $reqSelectIdMarqueur->execute();

    // Vérifier si l'idMarqueur a été trouvé
    if ($row = $reqSelectIdMarqueur->fetch(PDO::FETCH_ASSOC)) {
        $idMarqueur = $row['idMarqueur'];

        // Récupérer les valeurs du formulaire
        $sentiment = $_POST['sentiment']; // Remplacez 'sentiment' par le nom réel de votre champ
        $avis = $_POST['avis']; // Remplacez 'avis' par le nom réel de votre champ


        // Insérer les valeurs dans la table Sentiment
        $sqlInsertSentiment = "INSERT INTO Sentitheque (Sentiment, Avis,nomUser, idMarqueur) VALUES (:sentiment, :avis, :nom, :idMarqueur)";
        $reqInsertSentiment = $db->prepare($sqlInsertSentiment);
        $reqInsertSentiment->bindParam(':sentiment', $sentiment);
        $reqInsertSentiment->bindParam(':avis', $avis);
        $reqInsertSentiment->bindParam(':nom', $_SESSION['id']);
        $reqInsertSentiment->bindParam(':idMarqueur', $idMarqueur);
        $reqInsertSentiment->execute();

        // Renvoyer une réponse JSON
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Sentiment enregistré avec succès']);
    } else {
        // Renvoyer une réponse JSON indiquant que le nom du marqueur n'a pas été trouvé
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nom du marqueur non trouvé']);
    }
} catch (PDOException $e) {
    // Gérer les erreurs PDO
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de l\'enregistrement du sentiment']);
}

// Fermer la dbexion à la base de données
$db = null;
header('Location: ../appli.php');

?>
