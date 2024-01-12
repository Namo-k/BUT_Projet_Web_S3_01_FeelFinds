<?php

try {
    
    include('../../auth/connexionBd.php');

    $nomMarqueur = $_POST['nomMarqueur'];

    $req = $db->prepare('SELECT latitude, longitude FROM Marqueur WHERE nomMarqueur = :nomMarqueur');
    $req->bindParam(':nomMarqueur', $nomMarqueur);
    $req->execute();


    if ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        header('Content-Type: application/json');
        echo json_encode(['latitude' => $row['latitude'], 'longitude' => $row['longitude']]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Marqueur non trouvé']);
    }
    
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération du coordonnées du marqueur par le nom']);
} finally {
    $db = null;
}
?>
