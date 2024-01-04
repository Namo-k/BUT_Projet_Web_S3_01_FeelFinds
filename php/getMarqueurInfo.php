<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');


$nomMarqueur = $_GET['nom'];


$nomMarqueur = strip_tags($nomMarqueur);

// Requête SQL pour récupérer l'ID et le nom du marqueur en fonction des coordonnées
$sqlMarqueur = "SELECT idMarqueur, nomMarqueur FROM Marqueur WHERE nomMarqueur = :nomM";
$reqMarqueur = $db->prepare($sqlMarqueur);
$reqMarqueur->bindParam(':nomM', $nomMarqueur);
$reqMarqueur->execute();

// Récupérer l'ID et le nom du marqueur
$marqueurData = $reqMarqueur->fetch(PDO::FETCH_ASSOC);

// Vérifier si le marqueur a été trouvé
if ($marqueurData) {
    $markerId = $marqueurData['idMarqueur'];
    $nomMarqueur = $marqueurData['nomMarqueur'];

    // Requête SQL pour récupérer les avis en fonction de l'ID du marqueur
    $sqlAvis = "SELECT * FROM Sentitheque WHERE idMarqueur = :id";
    $reqAvis = $db->prepare($sqlAvis);
    $reqAvis->bindParam(':id', $markerId);
    $reqAvis->execute();

    // Récupérer les avis
    $avis = $reqAvis->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les données au format JSON
    header('Content-Type: application/json');
    echo json_encode([
        'nomMarqueur' => $nomMarqueur,
        'avis' => $avis,
        'sessionName' =>$_SESSION['id'],
    ]);

} else {
    // Si le marqueur n'est pas trouvé, renvoyer une réponse appropriée
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Marqueur non trouvé',
    ]);
}
?>