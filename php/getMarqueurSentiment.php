<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

if (!isset($_GET['sentiment'])) {
    echo json_encode(['error' => 'Le sentiment n\'a pas été spécifié']);
    exit;
}

try {
    $sentiment = $_GET['sentiment'];
    
    $sql = "SELECT DISTINCT m.nomMarqueur, m.latitude, m.longitude, s.Sentiment
    FROM marqueur as m JOIN sentitheque as s ON m.idMarqueur = s.idMarqueur 
    WHERE s.Sentiment = :nomSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nomSentiment', $sentiment);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les données au format JSON
    header('Content-Type: application/json');
    echo json_encode(['marqueurs' => $result]);

} catch (PDOException $e) {
    // Gérer les erreurs PDO
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des marqueurs']);
} finally {
    // Fermer la connexion à la base de données
    $db = null;
}
?>
