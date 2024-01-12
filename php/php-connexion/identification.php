<?php
session_start();
$errors = array();
$min_length = 8;
$max_length = 20;
$common_words = array('password', '123456', 'admin', 'user');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $mdp = $_POST['mdp'];
    include('../auth/connexionBd.php');
    $sql = "SELECT * FROM user where mail ='$id'";
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount() > 0) { //trouvé avec l'adresse mail
        $data = $result->fetchAll();
        $user_pseudo = $data[0]["pseudo"];

        if (password_verify($mdp, $data[0]["password"])) {
            $_SESSION['id'] = $user_pseudo;
            $_SESSION['mail'] = $id;
            header("Location:../pages/pageAppli.php");
        }
        else{
            $errorsConnexion = array();
            $errorsConnexion[] = "Nom d'utilisateur ou mot de passe incorrect.";
            include '../pages/pageConnexion.php';
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
                header("Location:../pages/pageAppli.php");
            }
            else{
                $errorsConnexion = array();
                $errorsConnexion[] = "Nom d'utilisateur ou mot de passe incorrect.";
            }
            include '../pages/pageConnexion.php';
        } else {
            $errorsConnexion = array();
            $errorsConnexion[] = "Nom d'utilisateur ou mot de passe incorrect.";
            include '../pages/pageConnexion.php';
        }
    }
} else if (isset($_POST['incription'])) {

    include('../auth/connexionBd.php');

    $mail = $_POST['mailInscr'];
    $pseudo = $_POST['pseudoInscr'];
    $pass = $_POST['mdpInscr'];


    if (empty($pseudo) || empty($mail)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    } else if (empty($pass)) {
        $errors[] = "Le mot de passe est requis.";
    } else if (strlen($pass) < $min_length || strlen($pass) > $max_length) { // Mot de passe invalide (longueur incorrecte)
        $errors[] = "La longueur du mot de passe est invalide.";
    } else if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $pass)) { // Mot de passe invalide (doit contenir des caractères spéciaux)
        $errors[] = "Le mot de passe est invalide, il doit contenir des caractères spéciaux.";
    } else if (!preg_match('/[0-9]/', $pass) || !preg_match('/[a-zA-Z]/', $pass)) { // Mot de passe invalide (doit contenir à la fois des chiffres et des lettres)
        $errors[] = "Le mot de passe est invalide, il doit contenir des chiffres et des lettres.";
    } else if (in_array(strtolower($pass), $common_words)) { // Mot de passe invalide (mot de passe trop commun)
        $errors[] = "Le mot de passe est trop commun, il doit contenir des chiffres et des lettres.";
    } else { //verificiation si l'adresse mail est déja prise
        $sql = "SELECT * FROM user where mail ='$mail'";
        $result = $db->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) { //qqn trouvé avec la mm adresse mail
            $errors[] = "Désolé... cette adresse mail est déjà utilisé.";
        } else {
            $sql = "SELECT * FROM user where pseudo ='$pseudo'";
            $result = $db->prepare($sql);
            $result->execute(); // verification avec le pseudo
            if ($result->rowCount() > 0) {
                $errors[] = "Désolé... ce pseudo est déjà utilisé.";
            } else { // Création du compte utilisateur
                $_SESSION['id'] = $pseudo;
                $_SESSION['mail'] = $mail;
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (mail,pseudo,password) VALUES ('$mail','$pseudo','$pass')";
                $req = $db->prepare($sql);
                $req->execute();
                header("Location:../pages/pageAppli.php");
            }
        }
    }
    include '../pages/pageConnexion.php';
}
