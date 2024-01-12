<?php
session_start();

$errors = array();
$success = array();
$min_length = 8;
$max_length = 20;
$common_words = array('password', '123456', 'admin', 'user');

if (isset($_POST['submit'])) {
    $anmdp = $_POST['anmdp'];
    $nvmdp = $_POST['nvmdp'];

    if (empty($nvmdp)||empty($anmdp)) {
        $errors[] = "Le nouveau mot de passe est requis.";
    } else if (strlen($nvmdp) < $min_length || strlen($nvmdp) > $max_length) { // Mot de passe invalide (longueur incorrecte)
        $errors[] = "La nouveau longueur du mot de passe est invalide.";
    } else if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $nvmdp)) { // Mot de passe invalide (doit contenir des caractères spéciaux)
        $errors[] = "Le nouveau mot de passe est invalide, il doit contenir des caractères spéciaux.";
    } else if (!preg_match('/[0-9]/', $nvmdp) || !preg_match('/[a-zA-Z]/', $nvmdp)) { // Mot de passe invalide (doit contenir à la fois des chiffres et des lettres)
        $errors[] = "Le nouveau mot de passe est invalide, il doit contenir des chiffres et des lettres.";
    } else if (in_array(strtolower($nvmdp), $common_words)) { // Mot de passe invalide (mot de passe trop commun)
        $errors[] = "Le nouveau mot de passe est trop commun, il doit contenir des chiffres et des lettres.";
    } else {
    $user = $_SESSION['id'];
    include('../../auth/connexionBd.php');
    $sql = "SELECT * FROM user where pseudo ='$user'";
    $result = $db->prepare($sql);
    $result->execute();
    $data = $result->fetchAll();
    if (password_verify($anmdp, $data[0]["password"])) { //bon mot de passe
        $nv = password_hash($nvmdp, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password ='$nv' where pseudo ='$user'";
        $result = $db->prepare($sql);
        $result->execute();
        header('Location: ../../pages/pageProfil.php');
        $success[]= "Le mot de passe a bien été modifiée.";

    }
    else{//mauvais mot de passe
        $errors[] = "L'ancien mot de passe est incorrect.";
    }

}
include '../../pages/pageProfil.php';
}

?>