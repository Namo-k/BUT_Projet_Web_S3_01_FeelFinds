<?php
session_start();

// Assurez-vous que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

// Assurez-vous que la variable 'idSentiment' est définie dans la requête
if (!isset($_GET['idSentiment'])) {
    echo json_encode(['error' => 'ID du sentiment non spécifié']);
    exit;
}

try {
    // Connexion à la base de données (utilisez PDO pour la sécurité)

    include('connexionBd.php');
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérez l'ID du sentiment à partir de la requête GET
    $idSentiment = $_GET['idSentiment'];

    // Requête SQL pour récupérer les détails du sentiment
    $sql = "SELECT m.nomMarqueur, m.latitude, m.longitude FROM sentitheque s
    INNER JOIN marqueur m ON s.idMarqueur = m.idMarqueur
    WHERE s.IdSentiment = :idSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->execute();

    // Récupérez les résultats
    $marqueur = $stmt->fetch(PDO::FETCH_ASSOC);

    // Renvoyer les détails au format JSON
    header('Content-Type: application/json');
    echo json_encode($marqueur);
} catch (PDOException $e) {
    // Gérer les erreurs PDO
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des détails du sentiment']);
} finally {
    // Fermer la connexion à la base de données
    $db = null;
}
?>
