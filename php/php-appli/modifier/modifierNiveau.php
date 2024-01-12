<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {

    include('../../auth/connexionBd.php');

    $niveau = $_POST['niveau'];
    $pseudo = $_SESSION['id'];

    $sql = "UPDATE user SET niveau = :niveau WHERE pseudo = :pseudo";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':niveau', $niveau);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Niveau modifié avec succès']);
    
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la modification du niveau']);
} finally {
    $db = null;
}

header("Location:../../pages/pageAppli.php");
?>
