<?php session_start(); ?>
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
            <a href="/appli.php"><img src="../images/retourapp.png" width="60" height="30" /></a>
            <a href="/deconnexion.php"><img src="../images/se-deconnecter.png" width="60" height="30" /></a>
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
            <p> Tu es sûr de vouloir nous quitter ? </p></br>

            <button id="showConfirmation">Supprimer compte</button>

            <h2>Je souhaite me <span style="text-decoration: underline;">désinscrire</span> ! Comment je fais ?</h2>
            <p>lorem</p></br>
            <h2>Je souhaite me <span style="text-decoration: underline;">désinscrire</span> ! Comment je fais ?</h2>
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