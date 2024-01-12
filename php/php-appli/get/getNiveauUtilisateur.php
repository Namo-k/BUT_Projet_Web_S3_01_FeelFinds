<?php
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$niveau = null;

try {
    include('../auth/connexionBd.php');

    $userNom = $_SESSION['id'];

    $sql = "SELECT niveau 
            FROM user
            WHERE pseudo = :userNom";
    
    $req = $db->prepare($sql);
    $req->bindParam(':userNom', $userNom);
    $req->execute();

    $data = $req->fetch(PDO::FETCH_ASSOC);

    $niveau = $data['niveau'];


} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de la récupération du niveau']);

} finally {
    $db = null;
}
?>
