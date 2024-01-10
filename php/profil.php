<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
    include('connexionBd.php');

    $pseudo = $_SESSION['id'];
    $avatarResult = null;

    try {
        // Récupérer l'image du pseudo spécifié
        $sql = $db->prepare("SELECT avatar, avatar_nom FROM user WHERE pseudo = ?");
        $sql->execute([$pseudo]);
        $data = $sql->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un avatar a été trouvé
        if ($data) {
            $avatarResult = $data['avatar'];
        }

        // Fermer le curseur
        $sql->closeCursor();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    $db = null;
} ?>
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
            <a href="../appli.php"><img src="../images/retourapp.png" width="60" height="30" style="margin-left: 40%;"/></a>
            <a href="deconnexion.php"><img src="../images/se-deconnecter.png" width="60" height="30" style="margin-left: 15%;"/></a>
        </div>
    </header>

    <div id="container">
        <section id="profil">
            <h1> Mon profil </h1>
            <div class="image-container" onclick="ouvrirFormulaire()">
                <?php
                // Afficher l'image si elle existe
                if ($avatarResult !== null) {
                    echo '<img src="afficherAvatar.php" alt="Avatar" class="hover-image">';
                } else {
                    echo '<img src="../images/photoprofil.jpeg" class="hover-image">';
                }
                ?>
                <div class="overlay">
                    <p style="color: white; margin-top:20%">Modifier votre avatar</p>
                </div>
            </div>
            <div id="formulaireContainer" class="formulaire-container">
                <form action="avatar.php" method="post" enctype="multipart/form-data">
                    <label for="image">Choisis ton avatar :</label>
                    <input type="file" name="image" id="image" required>
                    <br>
                    <input type="submit" value="Envoyer">
                    <button id="annulerAvatar">Annuler</button>
                </form>


            </div>
            <ul>
            <h2>Mon pseudo</h2>
            <li><?php echo $_SESSION['id']; ?></li>
            </ul>
            <p></p>



            <h2>Mon adresse mail de contact </h2>
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
            } ?>

            <h2>Je souhaite <span style="text-decoration: underline;">modifier mon mot de passe</span> ! Comment je fais ?</h2>
            <p> Retiens bien ton nouveau mot de passe ! </p>
            <button id="modifierMDP"> Modifier mon mdp</button>

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
            } else if (!empty($success)) {
                echo '<div class="success"><ul>';
                foreach ($success as $succes) {
                    echo "<li>$succes</li>";
                }
                echo '</ul></div>';
            }
            ?>

        <h2>Je souhaite <span style="text-decoration: underline;" >modifier mon pseudo</span> ! Comment je fais ? </h2>
                    <p> Tes amis te reconnaissent pas ou juste une envie ?  </p>
            <button id="modifierPseudo"> Modifer mon pseudo </button>

            <form method="POST" action="modifierPseudo.php" id="pseudoModif">
                <div class="group">
                    <label for="pass" class="label">Nouveau pseudo: </label>
                    <input id="passan" placeholder="Nouveau pseudonyme" type="text" class="input" name="nvpseudo">
                </div>
                <div class="group">
                    <label for="pass" class="label">Mot de passe : </label>
                    <input id="passnv" placeholder="Mot de passe" type="password" class="input" data-type="password" name="mdp">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Enrengistrer la modification" name="submit">
                    <button id="annulerPseudo">Annuler</button>
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
            } else if (!empty($success)) {
                echo '<div class="success"><ul>';
                foreach ($success as $succes) {
                    echo "<li>$succes</li>";
                }
                echo '</ul></div>';
            }
            ?>
        </section>

    </div>

    <div id="chat-container">
        <div id="messages"></div>
        <input type="text" id="message-input" placeholder="Entrez votre message">
        <button id="send-button" onclick="sendMessage()">Envoyer</button>
    </div>

    <script src="../js/chat.js"></script>

    <footer>
        <p>&copy; 2024 FeelFinds. Tous droits réservés.</p>
    </footer>
</body>

</html>