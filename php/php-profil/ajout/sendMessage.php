<?php
session_start();
// Connexion à la base de données (remplacez ces informations par vos propres paramètres)


try {
    include('../../auth/connexionBd.php');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérez le message envoyé par le client
$message = $_POST['message'];
$utilisateur = $_SESSION['id'];
if(!empty($message)){
// Ajoutez le message à la table des messages
$query = $db->prepare('INSERT INTO tchat (user, content) VALUES (?, ?)');
$query->execute([$utilisateur, $message]);
}

?>
