<?php
session_start();
include('../../auth/connexionBd.php');

$pseudo = $_SESSION['id'];

$sql = $db->prepare("SELECT avatar, avatar_nom FROM user WHERE pseudo = ?");
$sql->execute([$pseudo]);
$data = $sql->fetch(PDO::FETCH_ASSOC);

header('Content-Type: image/jpeg');

echo $data['avatar'];
$avatarResult = $data['avatar'];

$sql->closeCursor();
?>