<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    include('../../auth/connexionBd.php');

    $userNom = $_SESSION['id'];

    $sql = "SELECT s.*, marqueur.nomMarqueur 
            FROM sentitheque AS s
            JOIN marqueur ON s.idMarqueur = marqueur.idMarqueur
            WHERE s.nomUser = :userNom";
    
    $req = $db->prepare($sql);
    $req->bindParam(':userNom', $userNom);
    $req->execute();

    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['id'])) { 
        $sessionName = $_SESSION['id'];
    }else {
        $sessionName = " ";
    } 

    header('Content-Type: application/json');
    echo json_encode([
        'avis' => $resultats, 
        'sessionName' =>$sessionName, 
    ]);

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des avis']);

} finally {
    $db = null;
}
?>
