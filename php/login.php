<?php
session_start();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $mdp = $_POST['mdp'];

    // $db = new PDO('mysql:host=localhost;dbname=bd_feelfinds', 'root', '');

    include("connexionBd.php");
    
    $sql = "SELECT * FROM user where mail ='$id'";
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount() > 0) { //trouvé avec l'adresse mail
        $data = $result->fetchAll();
        $user_pseudo = $data[0]["pseudo"];

        if (password_verify($mdp, $data[0]["password"])) {
            $_SESSION['id'] = $user_pseudo;
            $_SESSION['mail'] = $id;
            header("Location:../appli.php");
        }
    } else { //non trouvé avec l'adresse mail, on test avec le pseudo
        $sql = "SELECT * FROM user where pseudo ='$id'";
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount() > 0) { //trouvé avec le pseudo
            $data = $result->fetchAll();
            if (password_verify($mdp, $data[0]["password"])) {
                $_SESSION['id'] = $id;
                $_SESSION['mail'] = $data[0]["mail"];
                header("Location:../appli.php");
            } 
        } 
    }
} else {

    include('connexionBd.php');
    $mail = $_POST['mailInscr'];
    $pseudo = $_POST['pseudoInscr'];
    $pass = $_POST['mdpInscr'];
    $_SESSION['id'] = $pseudo;
    $_SESSION['mail'] = $mail;
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (mail,pseudo,password) VALUES ('$mail','$pseudo','$pass')";
    $req = $db->prepare($sql);
    $req->execute();

    header("Location:../appli.php");
}
