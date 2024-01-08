<?php
// Connexion à la base de données (assurez-vous de la configurer correctement)
include('connexionBd.php');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérez le nom du marqueur depuis la requête AJAX
$nomMarqueur = $_POST['nomMarqueur'];

// Préparez la requête SQL pour récupérer les coordonnées du marqueur
$stmt = $db->prepare('SELECT latitude, longitude FROM Marqueur WHERE nomMarqueur = :nomMarqueur');
$stmt->bindParam(':nomMarqueur', $nomMarqueur);
$stmt->execute();

// Renvoyez les coordonnées au format JSON
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo json_encode(['latitude' => $row['latitude'], 'longitude' => $row['longitude']]);
} else {
    echo json_encode(['error' => 'Marqueur non trouvé']);
}
?>
