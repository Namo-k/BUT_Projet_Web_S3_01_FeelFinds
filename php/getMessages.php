<?php
// Connexion à la base de données (remplacez ces informations par vos propres paramètres)

try {
    include('connexionBd.php');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

try {
    include('connexionBd.php');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Appeler la fonction pour récupérer les messages après la connexion
    getMessages($db);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

function getMessages($db) {
    // Sélectionnez les 10 derniers messages de la table
    $query = $db->query('SELECT * FROM tchat ORDER BY id ASC LIMIT 10');
    $messages = $query->fetchAll(PDO::FETCH_ASSOC);

    // Affichez les messages dans un format HTML
    foreach ($messages as $message) {
        echo '<p><strong style="color: black;">' . htmlspecialchars($message['user']) . ':</strong> ' . htmlspecialchars($message['content']) . '</p>';
    }
}

// echo '<p><strong style"font-decoration:underline;">' . htmlspecialchars($message['user']) . ':</strong> ' . htmlspecialchars($message['content']) . '<span style="font-size:10px; margin-left:100px; position: absolute;" >heure : '. htmlspecialchars($message['heure']) .'</span></p>';

?>
