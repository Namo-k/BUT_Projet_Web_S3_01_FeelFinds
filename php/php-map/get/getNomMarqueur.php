<?php
try {
    include('../../auth/connexionBd.php');

    $sql = "SELECT nomMarqueur FROM Marqueur ORDER BY nomMarqueur ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $marqueurs = $stmt->fetchAll(PDO::FETCH_COLUMN);

    header('Content-Type: application/json');
    echo json_encode($marqueurs);
} catch (PDOException $e) {
    echo "La connexion a échoué: " . $e->getMessage();
}

$db = null;
?>
