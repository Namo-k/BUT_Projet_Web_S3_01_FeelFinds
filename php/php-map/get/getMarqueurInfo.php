<?php
session_start();


if (!isset($_GET['nom'])) {
    echo json_encode(['error' => 'nom du marqueur non spécifié']);
    exit;
}

if (isset($_SESSION['id'])) { 
    $sessionName = $_SESSION['id'];
}else {
    $sessionName = " ";
} 


try {
    
    include('../../auth/connexionBd.php');

    $nomMarqueur = $_GET['nom'];

    $nomMarqueur = strip_tags($nomMarqueur);

    $sqlMarqueur = "SELECT idMarqueur, nomMarqueur FROM Marqueur WHERE nomMarqueur = :nomM";
    $reqMarqueur = $db->prepare($sqlMarqueur);
    $reqMarqueur->bindParam(':nomM', $nomMarqueur);
    $reqMarqueur->execute();

    $marqueurData = $reqMarqueur->fetch(PDO::FETCH_ASSOC);

    if ($marqueurData) {
        $markerId = $marqueurData['idMarqueur'];
        $nomMarqueur = $marqueurData['nomMarqueur'];

        $sqlAvis = "SELECT * FROM Sentitheque WHERE idMarqueur = :id";
        $reqAvis = $db->prepare($sqlAvis);
        $reqAvis->bindParam(':id', $markerId);
        $reqAvis->execute();

        $avis = $reqAvis->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            'nomMarqueur' => $nomMarqueur,
            'avis' => $avis,
            'sessionName' =>$sessionName,
        ]);

    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Marqueur non trouvé',
        ]);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération de l\'ID et nom du marqueur']);
} finally {
    $db = null;
}


?>