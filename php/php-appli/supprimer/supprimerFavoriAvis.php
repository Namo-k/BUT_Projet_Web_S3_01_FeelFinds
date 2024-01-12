<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {

    include('../../auth/connexionBd.php');

    $idSentiment = $_POST['idSentiment'];


    $sql = "UPDATE sentitheque SET favori = FALSE WHERE IdSentiment = :idSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->execute();

    header('Content-Type: application/json');
    echo json_encode(['message' => 'Sentiment supprimer en favori avec succès']);
    
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la suppression en favori du sentiment']);
} finally {
    $db = null;
}

header("Location:../../pages/pageAppli.php");
?>
