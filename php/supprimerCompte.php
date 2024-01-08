<?php
session_start();
$errorsSupp = array();

if (isset($_POST['confirmer'])) {

    $mdp = $_POST['anmdp'];
    $user = $_SESSION['id'];
    include('connexionBd.php');
        $sql = "SELECT * FROM user where pseudo ='$user'";
    $result = $db->prepare($sql);
    $result->execute();
    $data = $result->fetchAll();

    if (password_verify($mdp, $data[0]["password"])) { //bon mot de passe
        $nv = password_hash($nvmdp, PASSWORD_DEFAULT);
        $sql = "DELETE FROM user WHERE pseudo = :user";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        session_destroy();
        header("Location:../appli.php");    
    }
    else{//mauvais mot de passe
        $errorsSupp [] = "Le mot de passe est incorrecte.";
    }
    include 'profil.php';

}

?>