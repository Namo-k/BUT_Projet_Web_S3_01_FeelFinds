<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="images/icon2.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Accueil - FeelFinds</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Abril+Fatface" />
    <link href='https://fonts.googleapis.com/css?family=Patua One' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <link rel="stylesheet" href="css/index.css">
    <script src="lib/jquery-3.7.1.min.js"></script>

</head>

<body>
    <div id="navbar">
        <div id="logo">
            <img src="images/logo.png" width="200px" id="logo">
        </div>
        <ul>
            <li><a href="php/pages/pageAppli.php"> Découvrir l'app </a></li>
            <li><a href="php/pages/pageConnexion.php"> S'inscrire  </a></li>
            <li><a href="php/pages/pageConnexion.php"> Se connecter </a></li>
        </ul>
    </div>

    <div id ="container">
        <div id="titre"> 
            <p id="titre1" class="animate__animated animate__slideInDown"> Feel your Feelings </p>
        </div>

        <div id="slogan">
            <p> Explores des lieux culturels et partages tes sentiments ! </p>
        </div>

        <a href="php/pages/pageAppli.php"><button class="btn-2"> <div class="animate__animated animate__pulse"> Commencez l'aventure ! </div>
            <div id="marqueur">
                <img src="images/marqueur.png" width="25px"> 
            </div>
        </button></a>

        
    </div>

    <div id="presentation">
        <div class="bloc">
            <div class="logo_desc"><img src="images/echanger.png" width="52px"></div>
            <div class="titre_desc"> Echanger </div>
            <div class="desc"> Échangez avec vos amis à propos de ce que vous avez ressenti sur un endroit ! </div>
        </div>

        <div class="bloc">
            <div class="logo_desc"><img src="images/exprimer.png" width="52px"></div>
            <div class="titre_desc"> S'exprimer </div>
            <div class="desc"> Exprimez-vous et partagez votre ressenti et vos sentiments sur un lieu de la map ! </div>
        </div>
    </div>

    <div id="information">
        <img src="images/marqueur.png" width="27px">
        <p id="info_lieu"> Louvres, Paris </p>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> FeelFinds. Tous droits réservés.</p>
        <div class="social-buttons">
            <a href="https://www.facebook.com/" class="social-button" target="_blank">
                <img src="https://img.icons8.com/material-rounded/24/ffffff/facebook.png" alt="Facebook">
            </a>
    
            <a href="https://twitter.com/" class="social-button" target="_blank">
                <img src="https://img.icons8.com/material-sharp/24/ffffff/twitter.png" alt="Twitter">
            </a>
    
            <a href="https://www.instagram.com/" class="social-button" target="_blank">
                <img src="https://img.icons8.com/material-rounded/24/ffffff/instagram-new.png" alt="Instagram">
            </a>
    
            <a href="https://www.linkedin.com/" class="social-button" target="_blank">
                <img src="https://img.icons8.com/material-outlined/24/ffffff/linkedin.png" alt="LinkedIn">
            </a>
        </div>   
    </footer>
    
</body>


</html>