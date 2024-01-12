<?php
session_start();

$message = '';
$pseudo = $_SESSION['id'];

try {
    include('../auth/connexionBd.php');

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
        
        $sql = $db->prepare("SELECT * FROM user WHERE pseudo = ?");
        $sql->execute([$pseudo]);

        $data = $sql->fetchAll();
        $avatarResult = $data[0]["avatar"];

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
}finally {
    $db = null;
}
header('Location: ../pages/pageProfil.php');
?>
