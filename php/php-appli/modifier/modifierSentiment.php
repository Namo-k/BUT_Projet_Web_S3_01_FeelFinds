<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {

    include('../../auth/connexionBd.php');

    $idSentiment = $_POST['idSentiment'];
    $sentiment = $_POST['sentiment'];
    $avis = $_POST['avis'];

    $sql = "UPDATE sentitheque SET sentiment = :sentiment, avis = :avis WHERE IdSentiment = :idSentiment";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':sentiment', $sentiment);
    $stmt->bindParam(':avis', $avis);
    $stmt->bindParam(':idSentiment', $idSentiment);
    $stmt->execute();
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Sentiment modifié avec succès']);
    
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la modification du sentiment']);
} finally {
    $db = null;
}

header("Location:../../pages/pageAppli.php");
?>
