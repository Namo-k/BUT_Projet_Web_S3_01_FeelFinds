<?php
session_start();


if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    include('../../auth/connexionBd.php');

    $nomMarqueur = $_POST['nomMarqueur'];

    $nomMarqueur = strip_tags($nomMarqueur);

    $sqlSelectIdMarqueur = "SELECT idMarqueur FROM Marqueur WHERE nomMarqueur = :nomMarqueur";
    $reqSelectIdMarqueur = $db->prepare($sqlSelectIdMarqueur);
    $reqSelectIdMarqueur->bindParam(':nomMarqueur', $nomMarqueur);
    $reqSelectIdMarqueur->execute();

    if ($row = $reqSelectIdMarqueur->fetch(PDO::FETCH_ASSOC)) {
        $idMarqueur = $row['idMarqueur'];

        $sentiment = $_POST['sentiment'];
        $avis = $_POST['avis'];

        $sqlInsertSentiment = "INSERT INTO Sentitheque (Sentiment, Avis, nomUser, idMarqueur) VALUES (:sentiment, :avis, :nom, :idMarqueur)";
        $reqInsertSentiment = $db->prepare($sqlInsertSentiment);
        $reqInsertSentiment->bindParam(':sentiment', $sentiment);
        $reqInsertSentiment->bindParam(':avis', $avis);
        $reqInsertSentiment->bindParam(':nom', $_SESSION['id']);
        $reqInsertSentiment->bindParam(':idMarqueur', $idMarqueur);
        $reqInsertSentiment->execute();

        
        mettreAJourNiveauUtilisateur($db);

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Sentiment enregistré avec succès']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Nom du marqueur non trouvé']);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur lors de l\'enregistrement du sentiment']);
} finally {
    $db = null;
}

function mettreAJourNiveauUtilisateur($db) {
    $sql = "SELECT COUNT(*) AS nombreMarqueurs FROM Sentitheque WHERE nomUser = :nomUser";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nomUser', $_SESSION['id']);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreMarqueurs = $result['nombreMarqueurs'];
    

    include ("../../include/determinerNiveauUser.php");

    $sqlUpdateNiveau = "UPDATE user SET niveau = :niveau WHERE pseudo = :nomUser";
    $stmtUpdateNiveau = $db->prepare($sqlUpdateNiveau);
    $stmtUpdateNiveau->bindParam(':niveau', $niveauUtilisateur);
    $stmtUpdateNiveau->bindParam(':nomUser', $_SESSION['id']);
    $stmtUpdateNiveau->execute();
}

header("Location:../../pages/pageAppli.php");

?>
