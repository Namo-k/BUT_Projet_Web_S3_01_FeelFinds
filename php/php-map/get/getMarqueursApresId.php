<?php
session_start();

try {
    include('../../auth/connexionBd.php');
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


try {

    $sql = "SELECT * FROM marqueur WHERE idMarqueur > :id";
    $req = $db->prepare($sql);
    $req->bindParam(':id', $id);
    $req->execute();

    $marqueurs = $req->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['marqueurs' => $marqueurs]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des marqueurs']);
} finally {
    $db = null;
}
?>
