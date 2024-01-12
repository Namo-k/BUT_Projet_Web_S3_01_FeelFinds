<?php

try {
    include('../../auth/connexionBd.php');
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

try {
    include('../../auth/connexionBd.php');
    getMessages($db);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

function getMessages($db) {

    $query = $db->query('SELECT * FROM tchat ORDER BY id ASC LIMIT 10');
    $messages = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($messages as $message) {
        echo '<p><strong style="color: black;">' . htmlspecialchars($message['user']) . ':</strong> ' . htmlspecialchars($message['content']) . '</p>';
    }
}
?>
