<?php
//Script pour le filtre
session_start();


if (!isset($_GET['sentiment'])) {
    echo json_encode(['error' => 'Le sentiment n\'a pas été spécifié']);
    exit;
}

try {
    include('../../auth/connexionBd.php');

    $sentiment = $_GET['sentiment'];
    
    $sql = "SELECT DISTINCT m.nomMarqueur, m.latitude, m.longitude, s.Sentiment
    FROM marqueur as m JOIN sentitheque as s ON m.idMarqueur = s.idMarqueur 
    WHERE s.Sentiment = :nomSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nomSentiment', $sentiment);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['marqueurs' => $result]);

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des marqueurs']);
} finally {
    $db = null;
}
?>
