<?php session_start()?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Se connecter - FeelFinds</title>
    <link id="favicon" rel="icon" href="../img/icon2.png" type="image/png" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/config.js"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php 
if (isset($_SESSION['id'])){
    echo "Vous êtes bien connecté en tant que:" .$_SESSION['id'];
}
else{
?>

<div class="conteneur-login">
    <div class="login-wrap" style="background:white;border-radius: 20px 0px 0px 20px;">

        <img src="../img/logo.png" width="240" height="78" style="margin-left: 26%; position:absolute; z-index:2;margin-top:2%;margin-bottom:2%;"/>

        <div class="login-html" style="border-radius: 20px 0 0 20px;">
            <input id="tab-1" type="radio" name="tab" class="sign-in" onclick="changeTitle()" checked><label for="tab-1" class="tab" style="margin-top:2%;">Se connecter</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up" onclick="changeTitle2()"><label for="tab-2" class="tab" style="margin-top:2%;">S'inscrire</label>
            <!--connexion-->
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
                    <!--barre-->
                    <div class="hr"></div>
                    <!-- mdp oublié
                    <div class="foot-lnk">
                        <a href="#forgot">Forgot Password?</a>
                    </div>
                    -->
                    <div class="foot-lnk">
                        <label for="tab-2">On se connait pas ?</a>
                    </div>
                    <!-- stickers
                    <img src="" id ="stickers"width="80" height="80"/>-->
                </div>

                <!--inscription-->
                <div class="sign-up-htm">
                    <h1 class="sous-titre">On ne se connait pas ?<br>
                    Dans ce cas, rejoins-nous !</h1>
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

        <!--image sur le coté du login-->
    <div class="login-wrap" style="border-radius: 0 20px 20px 0px;"></div>
</div>

    <?php
}
?>
<script type="text/javascript">
    const fav = document.getElementById("favicon");
        function changeTitle() {
            newPageTitle = 'Se connecter - FeelFinds';
            document.title = newPageTitle;
            fav.setAttribute("href", "../img/icon2.png");  
        }
        function changeTitle2() {
            newPageTitle = 'S\'inscrire - FeelFinds';
            document.title = newPageTitle;
            fav.setAttribute("href", "../img/icon2.png");  
        }
    </script>
   </body>
</html>
