<?php
session_start();

$errors = array();
$success = array();

if (isset($_POST['submit'])) {
    $nvpseudo = $_POST['nvpseudo'];
    $mdp = $_POST['mdp'];

    if (empty($mdp)||empty($nvpseudo)) {
        $errors[] = "Un champ est vide.";
    }
    else {
    $user = $_SESSION['id'];

    include('connexionBd.php');
    $sql = "SELECT * FROM user where pseudo ='$user'";
    $result = $db->prepare($sql);
    $result->execute();
    $data = $result->fetchAll();
    if (password_verify($mdp, $data[0]["password"])) { //bon mot de passe

        $sql = "UPDATE user SET pseudo ='$nvpseudo' where pseudo ='$user'";
        $result = $db->prepare($sql);
        $result->execute();
        $success[]= "Le pseudo a bien été modifiée.";
    }
    else{//mauvais mot de passe
        $errors[] = "Le mot de passe est incorrect.";
    }

}
include 'profil.php';
}
else{
    header('Location: profil.php');
}
?>