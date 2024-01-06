<?php
session_start();

// Connexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

// Récupérer l'id à partir des données GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si l'id est valide
// if ($id <= 0) {
//     echo json_encode(['error' => 'ID invalide']);
//     exit;
// }

try {
    // Préparer la requête SQL
    $sql = "SELECT * FROM marqueur WHERE idMarqueur > :id";
    $req = $db->prepare($sql);
    $req->bindParam(':id', $id);
    $req->execute();

    // Récupérer les résultats
    $marqueurs = $req->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer une réponse JSON avec les marqueurs
    header('Content-Type: application/json');
    echo json_encode(['marqueurs' => $marqueurs]);

} catch (PDOException $e) {
    // Gérer les erreurs PDO
    echo json_encode(['error' => 'Erreur lors de la récupération des marqueurs']);
} finally {
    // Fermer la connexion à la base de données
    $db = null;
}
?>
