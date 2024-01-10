<?php
session_start();
// Connexion à la base de données
$message = '';
$pseudo = $_SESSION['id'];

try {
    include('connexionBd.php');

    // Traitement du fichier uploadé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
        
        // Vérifier si l'image existe déjà dans la base de données
        $sql = $db->prepare("SELECT * FROM user WHERE pseudo = ?");
        $sql->execute([$pseudo]);

        $data = $sql->fetchAll();
        $avatarResult = $data[0]["avatar"];

            // Mettre à jour l'image existante
            $updateSql = "UPDATE user SET avatar = ?, avatar_nom = ? WHERE pseudo = ?";
            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute([$image_data, $image_name, $pseudo]);

            $message = "L'image a été mise à jour avec succès dans la base de données.";


        $sql->closeCursor();
        $updateStmt->closeCursor();
    } else {
        $message = "Une erreur est survenue lors du téléchargement de l'image.";
    }
} catch (PDOException $e) {
    $message = "La connexion à la base de données a échoué ici: " . $e->getMessage();
}
$db = null;
header('Location: profil.php');
?>
