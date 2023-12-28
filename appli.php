<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="images/icon2.png" type="image/x-icon">
    <title> FeelFinds </title>
    <link rel="stylesheet" href="css/appli.css">
    <script src="js/appli.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Patua One' rel='stylesheet'>
    <script src="https://api.mapbox.com/search/searchbox/v1/suggest?q={search_text}"></script>

    <!--js-->
    <script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
    <!--css-->
    <link rel="stylesheet" href="css/appli.css">
    <link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

</head>

<body>
    <div id="profil">
        <div id="pseudo">
            <div id="login">
                <?php if (isset($_SESSION['id'])) { ?>
                    <p id='nameSession'>@<?php echo $_SESSION['id']; ?></p>
                <?php } else { ?>
                    <p id='nameSession'><?php echo "Invité"; ?></p>
                <?php } ?>
            </div>

            <?php if (isset($_SESSION['id'])) { ?>
                <p id="niveau"> Niveau : Superstar </p>
            <?php } else { ?>
                <p id='nameSession' style="text-align:center;"> <a href="php/connexion.php" style="color: white; text-decoration: none;"> Connecte toi ! </p>
            <?php } ?>

        </div>
        <?php if (isset($_SESSION['id'])) { ?>
            <nav>
                <li> <a href="#">
                        <div id="photoAvatar"><img src="images/connexion.png" width="60px"></div>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="#">Profil</a></li>
                        <li><a href="php/deconnexion.php">Déconnexion</a></li>
                    </ul>
                </li>
            </nav>
        <?php } else { ?>
            <div id="photoAvatar"><img src="images/connexion.png" width="60px"></div>
        <?php } ?>

    </div>

    <!--onglet sur la gauche-->
    <div id="onglet">


        <div id="presentation">
            <div id="logo">
                <a href="index.html"><img src="images/logo.png" width="200px"></a>
            </div>
            <div id="slogan">
                <p id="typewriter"> P</p>
            </div>
            <div class="line"></div>
        </div>

        <div id="ongletContaint">
            <div id="onglet_1">
                <div class="sous_onglet_titre">
                    <img src="images/itineraire_logo.png" class="icone">
                    <p class="icone_txt"> Chercher mon itinéraire </p>
                </div>
                <p class="sous_onglet_info"> Aller à un endroit en particulier ? </p>

                <div class="sous_onglet">
                    <div id="depart">
                        <label> Départ : </label>
                        <div id="barre">
                            <input type="text" placeholder="  Choisissez un point de départ..." class="inputH" id="input_depart"> </br>
                            <img src="images/loupe.png" class="loupe">
                        </div>
                    </div>
                    <div id="arrivee">
                        <label for="arrive"> Arrivée : </label>
                        <div id="barre">
                            <input type="text" placeholder="  Choisissez une destination..." class="inputH" id="input_arrive">
                            <img src="images/loupe.png" class="loupe">
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div id="onglet_2">
                <div class="sous_onglet_titre">
                    <img src="images/logo_sentiment.png" class="icone">
                    <p class="icone_txt"> Filtrer par sentiment </p>
                </div>
                <p class="sous_onglet_info"> Ressentir un sentiment particulier ? </p>

                <div class="emoji">
                    <div id="rectangle">
                        <img src="images/emoji_epoustouflant.png" width="26px" class="emojis" id="emoji_epoustouflant">
                        <img src="images/emoji_triste.png" width="26px" class="emojis" id="emoji_triste">
                        <img src="images/emoji_amour.png" width="26px" class="emojis" id="emoji_amour">
                        <img src="images/emoji_joyeux.png" width="26px" class="emojis" id="emoji_joyeux">
                        <img src="images/emoji_emouvant.png" width="26px" class="emojis" id="emoji_emouvant">
                        <img src="images/emoji_festif.png" width="26px" class="emojis" id="emoji_festif">
                    </div>

                    <p id="nom_sentiment"> Testez ! </p>
                    <p id="description_sentiment"> Choisissez un sentiment </p>
                </div>
            </div>

            <div class="line"></div>

            <?php if (isset($_SESSION['id']) == 1) { ?>
                <div id="onglet_3">
                    <div class="sous_onglet_titre">
                        <img src="images/logo_gerer.png" class="icone">
                        <p class="icone_txt"> Gérer un sentiment </p>
                    </div>
                    <p class="sous_onglet_info"> Envie d'alimenter votre sentithèque? </p>
                    <div class="choix">
                        <p class="bouton" id="btn_ajouter"> Ajouter </p>
                        <p class="bouton"> Modifier </p>
                        <p class="bouton"> Supprimer </p>
                    </div>
                </div>

            <?php } else { ?>
            <?php } ?>
        </div>

        <div id="ongletAjouter">
            <div class="sous_onglet_titre">
                <img src="images/logo_gerer.png" class="icone">
                <p class="icone_txt"> Gérer un sentiment </p>
            </div>
            <p class="sous_onglet_info"> Envie d'alimenter votre sentithèque? </p>

            <div id="adresse">
                <p class="txtInfo"> &nbsp • &nbsp Adresse du lieu : </p>
                <div><input type="text" placeholder="  Choisissez votre lieu..." class="inputA" id="input_adresse"></div> </br>
            </div>

            <div id="sentiments">
                <p class="txtInfo"> &nbsp • &nbsp Choix du sentiment : </p>
            </div>
            <div class="emoji">
                <div id="rectangle">
                    <img src="images/emoji_epoustouflant.png" width="26px" class="emojis" id="emoji_2epoustouflant">
                    <img src="images/emoji_triste.png" width="26px" class="emojis" id="emoji_2triste">
                    <img src="images/emoji_amour.png" width="26px" class="emojis" id="emoji_2amour">
                    <img src="images/emoji_joyeux.png" width="26px" class="emojis" id="emoji_2joyeux">
                    <img src="images/emoji_emouvant.png" width="26px" class="emojis" id="emoji_2emouvant">
                    <img src="images/emoji_festif.png" width="26px" class="emojis" id="emoji_2festif">
                </div>

                <p id="nom_sentiment2"> Nom du sentiment </p>
            </div>

            <div id="description">
                <p class="txtInfo"> &nbsp • &nbsp Description du moment : </p>
                <!--<div><input type="text" placeholder="  Décrivez votre moment..." class="inputD" id="input_desc"></div> </br> -->

                <div><textarea id="input_desc" class="inputD" placeholder="Describe yourself here..." name="description" rows="5" cols="33"> </textarea></div>
            </div>

            <button class="btn"> Enregistrer </button>
            <img src="images/btn_retour.png" width="30px" id="btn_retour">
        </div>
    </div>

    <!--appli carte-->
    <div id='map'></div>
    <script src="js/scriptsMarkeur.js"></script>
</body>

</html>
