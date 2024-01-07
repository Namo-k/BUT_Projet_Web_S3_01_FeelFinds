<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="favicon" rel="icon" href="../images/icon2.png" type="image/png">
    <title>Profil - FeelFinds</title>
    <link rel="stylesheet" href="../css/profil.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/profil.js"></script>

</head>

<body>

    <header>
        <a href="../index.html"><img src="../images/icon2.png" width="80" height="40" id="logo" /></a>
        <h1 id="titre">Profil</h1>
        <div id="retour">
            <a href="../appli.php"><img src="../images/retourapp.png" width="60" height="30" /></a>
            <a href="deconnexion.php"><img src="../images/se-deconnecter.png" width="60" height="30" /></a>
        </div>
    </header>

    <div id="container">
        <section id="profil">
            <h1> Mon profil </h1>
            <img src="../images/photoprofil.jpeg" id="pprofil">
            <h2><?php echo $_SESSION['id']; ?></h2>
            <p>lorem lorem</p>

            <h2>Niveau</h2>
            <p>recup le niveau</p>

            <h2>Contact</h2>
            <ul>
                <li><?php echo $_SESSION['mail']; ?></li>
            </ul>
        </section>

        <section id="personnaliser">
            <h1> Paramètres </h1>
            <img src="../images/parametre.png" width="80" height="40">
            <h2>Je souhaite me <span style="text-decoration: underline;">désinscrire</span> ! Comment je fais ?</h2>
            <p> Tu es sûr de vouloir nous quitter ? </p>

            <button id="showConfirmation">Supprimer compte</button>
            
            <form method="POST" action="supprimerCompte.php" id="suppCompte">
                <div class="group">
                    <label for="pass" class="label">Entrez votre mot de passe : </label>
                    <input id="passCompte" placeholder="Mot de passe" type="password" data-type="password" class="input" name="anmdp" required>
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Supprimer le compte" name="confirmer">
                    <button id="annulerCompte">Annuler</button>
                </div>
            </form>
            <?php
                        // Affichage des msg s'il y en a
                        if (!empty($errorsSupp)) {
                            echo '<div class="error"><ul>';
                            foreach ($errorsSupp as $error) {
                                echo "<li>$error</li>";
                            }
                            echo '</ul></div>';
                        }?>

            <h2>Je souhaite <span style="text-decoration: underline;">modifier mon mot de passe</span> ! Comment je fais ?</h2>
            <p> Retiens bien ton nouveau mot de passe ! </p>
            <button id="modifierMDP"> Modifer mon mdp</button>

            <form method="POST" action="modifierMDP.php" id="mdpModif">
                <div class="group">
                    <label for="pass" class="label">Ancien mot de passe : </label>
                    <input id="passan" placeholder="Ancien mot de passe" type="password" data-type="password" class="input" name="anmdp" required>
                </div>
                <div class="group">
                    <label for="pass" class="label">Nouveau mot de passe : </label>
                    <input id="passnv" placeholder="Nouveau mot de passe" type="password" class="input" data-type="password" name="nvmdp" required>
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Enrengistrer la modification" name="submit">
                    <button id="annuler">Annuler</button>
                </div>
            </form>
            <?php
                        // Affichage des msg s'il y en a
                        if (!empty($errors)) {
                            echo '<div class="error"><ul>';
                            foreach ($errors as $error) {
                                echo "<li>$error</li>";
                            }
                            echo '</ul></div>';
                        }
                        else if (!empty($success)) {
                            echo '<div class="success"><ul>';
                            foreach ($success as $succes) {
                                echo "<li>$succes</li>";
                            }
                            echo '</ul></div>';
                        }
                        ?>

            <h2>Je souhaite modifier <span style="text-decoration: underline;">le style de la map</span> ! Comment je fais ?</h2>
            <ul>
                <li>lorem</li>
            </ul>
        </section>

    </div>
    <footer>
        <p>&copy; 2024 FeelFinds. Tous droits réservés.</p>
    </footer>
</body>

</html>