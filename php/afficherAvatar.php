<?php
session_start();
include('connexionBd.php');

$pseudo = $_SESSION['id'];

// Récupérer l'image du pseudo spécifié
$sql = $db->prepare("SELECT avatar, avatar_nom FROM user WHERE pseudo = ?");
$sql->execute([$pseudo]);
$data = $sql->fetch(PDO::FETCH_ASSOC);

// Envoyer le type de contenu approprié
header('Content-Type: image/jpeg'); // Assurez-vous d'ajuster le type de contenu selon le type de votre image (jpeg, png, etc.)

// Afficher l'image
echo $data['avatar'];
$avatarResult = $data['avatar'];
// Fermer le curseur
$sql->closeCursor();
?>