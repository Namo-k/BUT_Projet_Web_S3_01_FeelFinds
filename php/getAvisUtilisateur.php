<?php
session_start();

try {
    // Établir une connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifiez si l'utilisateur est connecté (vous devrez peut-être adapter cela selon votre méthode d'authentification)
    if (!isset($_SESSION['id'])) {
        echo json_encode(['error' => 'Utilisateur non connecté']);
        exit;
    }

    // Récupérez l'ID de l'utilisateur connecté
    $userNom = $_SESSION['id'];

    // Écrivez votre requête SQL pour récupérer les avis de l'utilisateur depuis la table sentitheque
    $sql = "SELECT s.*, marqueur.nomMarqueur 
            FROM sentitheque AS s
            JOIN marqueur ON s.idMarqueur = marqueur.idMarqueur
            WHERE s.nomUser = :userNom";
    
    // Préparez et exécutez la requête
    $req = $db->prepare($sql);
    $req->bindParam(':userNom', $userNom);
    $req->execute();

    // Récupérez les résultats de la requête
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer une réponse JSON avec les résultats
    header('Content-Type: application/json');
    echo json_encode([
        'avis' => $resultats, 
        'sessionName' =>$_SESSION['id'], 
    ]);

} catch (PDOException $e) {
    // Gérer les erreurs PDO
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération des avis']);

} finally {
    // Fermer la connexion à la base de données
    $db = null;
}
?>
