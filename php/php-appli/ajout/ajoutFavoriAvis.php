<?php
session_start();


if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    
    include('../../auth/connexionBd.php');

    $idSentiment = $_POST['idSentiment'];

    $sql = "UPDATE sentitheque SET favori = TRUE WHERE IdSentiment = :idSentiment";
    $reqAjoutFavori = $db->prepare($sql);
    $reqAjoutFavori->bindParam(':idSentiment', $idSentiment);
    $reqAjoutFavori->execute();

    
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Sentiment ajouter en favori avec succès']);
    
} catch (PDOException $e) {
    
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de l\'ajout en favori du sentiment']);
} finally {
    $db = null;
}

header("Location:../../pages/pageAppli.php");
?>
