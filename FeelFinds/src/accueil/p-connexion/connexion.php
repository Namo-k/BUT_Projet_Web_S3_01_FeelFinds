<?php session_start()?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/icon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Se connecter - FeelFinds</title>
</head>
<body>

<?php 
if (isset($_SESSION['id'])){
    echo "Vous êtes bien connecté en tant que:" .$_SESSION['id'];
}
else{
?>

<div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Se connecter</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">S'inscrire</label>
            <div class="login-form">
                <div class="sign-in-htm">
                    <h1 class="sous-titre">Te revoilà, ça faisait longtemps !</h1>
                    <form method="POST" action="login.php">
                        <div class="group">
                            <label for="user" class="label">Nom d'utilisateur ou mail</label>
                            <input id="user"placeholder="Nom d'utilisateur ou mail" type="text" class="input" name="id">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Mot de passe</label>
                            <input id="pass" placeholder="Mot de passe" type="password" class="input" data-type="password" name="mdp">
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Se connecter" name="submit">
                        </div>

                </form>
                    <div class="hr"></div>
                    <!-- mdp oublié
                    <div class="foot-lnk">
                        <a href="#forgot">Forgot Password?</a>
                    </div>
                    -->
                </div>


                <div class="sign-up-htm">
                    <h1 class="sous-titre">T'es sûr qu'on ne se connaisse pas ? Dans ce cas, rejoins nous !</h1>
                    <form method="POST" action="login.php">
                    <div class="group">
                        <label for="user" class="label">Pseudo</label>
                        <input id="user" placeholder="Pseudonyme" type="text" class="input" name="pseudoInscr">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Adresse mail</label>
                        <input id="pass" placeholder="Adresse mail" type="text" class="input" name="mailInscr">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Mot de passe</label>
                        <input id="pass" placeholder="Mot de passe" type="password" class="input" data-type="password" name="mdpInscr">
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="S'inscrire">
                    </div>
                </form>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">On se connait déjà ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>
   
   </body>
</html>