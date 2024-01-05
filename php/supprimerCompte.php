<?php
session_start();

// Vérifier si l'utilisateur est dbecté
if (!isset($_SESSION['id'])) {
    // L'utilisateur n'est pas dbecté, peut-être rediriger ou prendre d'autres mesures
    exit("Utilisateur non connecté");
}

// Récupérer l'ID de l'utilisateur dbecté
$user = $_SESSION['id'];

try {
    // dbexion à la base de données avec PDO
    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
    // Configurer PDO pour rapporter toutes les erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour supprimer l'avis de l'utilisateur dbecté
    $sql = "DELETE FROM user WHERE pseudo = :user";
    $stmt = $db->prepare($sql);

    // Lier les paramètres et exécuter la requête
    $stmt->bindParam(':user', $user);
    $stmt->execute();

    // Répondre avec une réponse JSON indiquant le succès de la suppression
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Gérer les exceptions en cas d'erreur PDO
    die("Erreur lors de la connexion à la base de données : " . $e->getMessage());
} finally {
    // Fermer la dbexion à la base de données
    $db = null;
    // header('Location: ../appli.php');
}

?>