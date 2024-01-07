<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionnez tous les noms de marqueurs de la table 'Marqueur'
    $sql = "SELECT nomMarqueur FROM Marqueur ORDER BY nomMarqueur ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $marqueurs = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Renvoyer les noms de marqueurs au format JSON
    header('Content-Type: application/json');
    echo json_encode($marqueurs);
} catch (PDOException $e) {
    echo "La dbexion a échoué: " . $e->getMessage();
}

$db = null;
?>
