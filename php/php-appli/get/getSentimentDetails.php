<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

if (!isset($_GET['idSentiment'])) {
    echo json_encode(['error' => 'ID du sentiment non spécifié']);
    exit;
}

try {
   
    include('../../auth/connexionBd.php');

    $userNom = $_SESSION['id'];

    $idSentiment = $_GET['idSentiment'];

    $sql = "SELECT s.*, m.nomMarqueur FROM sentitheque s
    INNER JOIN marqueur m ON s.idMarqueur = m.idMarqueur
    WHERE s.IdSentiment = :idSentiment AND s.nomUser = :userNom";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->bindParam(':userNom', $userNom);
    $stmt->execute();

    $sentimentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($sentimentDetails);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des détails du sentiment']);
} finally {
    $db = null;
}
?>
