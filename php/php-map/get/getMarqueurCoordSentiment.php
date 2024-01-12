<?php
//Script pour la fonctionnalité recentrer
session_start();

if (!isset($_GET['idSentiment'])) {
    echo json_encode(['error' => 'ID du sentiment non spécifié']);
    exit;
}

try {
    
    include('../../auth/connexionBd.php');
    
    $idSentiment = $_GET['idSentiment'];

    $sql = "SELECT m.nomMarqueur, m.latitude, m.longitude FROM sentitheque s
    INNER JOIN marqueur m ON s.idMarqueur = m.idMarqueur
    WHERE s.IdSentiment = :idSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->execute();

    $marqueur = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($marqueur);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des détails du sentiment']);
} finally {
    $db = null;
}
?>
