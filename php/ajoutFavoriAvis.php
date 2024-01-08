<?php
session_start();

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    // Connexion à la base de données (utilisez PDO pour la sécurité)
    include('connexionBd.php');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérez les données du formulaire
    $idSentiment = $_POST['idSentiment'];


    // Requête SQL pour mettre à jour l'avis
    $sql = "UPDATE sentitheque SET favori = TRUE WHERE IdSentiment = :idSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->execute();

    // Renvoyer une réponse JSON
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Sentiment ajouter en favori avec succès']);
    
} catch (PDOException $e) {
    // Gérer les erreurs PDO
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de l\'ajout en favori du sentiment']);
} finally {
    // Fermer la connexion à la base de données
    $db = null;
}

header("Location:../appli.php");
?>
