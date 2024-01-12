<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$userNom = $_SESSION['id'];

$sentimentId = $_POST['idSentiment'];

try {

    include('../../auth/connexionBd.php');

    $sql = "DELETE FROM sentitheque WHERE idSentiment = :sentimentId AND nomUser = :userNom";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':sentimentId', $sentimentId, PDO::PARAM_INT);
    $stmt->bindParam(':userNom', $userNom, PDO::PARAM_INT);
    $stmt->execute();

    mettreAJourNiveauUtilisateur($db);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la connexion à la base de données :' . $e->getMessage()]);
} finally {
    $db = null;
}



function mettreAJourNiveauUtilisateur($db) {
    $sql = "SELECT COUNT(*) AS nombreMarqueurs FROM Sentitheque WHERE nomUser = :nomUser";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nomUser', $_SESSION['id']);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreMarqueurs = $result['nombreMarqueurs'];
    

    include ("../../include/determinerNiveauUser.php");

    $sqlUpdateNiveau = "UPDATE user SET niveau = :niveau WHERE pseudo = :nomUser";
    $stmtUpdateNiveau = $db->prepare($sqlUpdateNiveau);
    $stmtUpdateNiveau->bindParam(':niveau', $niveauUtilisateur);
    $stmtUpdateNiveau->bindParam(':nomUser', $_SESSION['id']);
    $stmtUpdateNiveau->execute();
}


?>