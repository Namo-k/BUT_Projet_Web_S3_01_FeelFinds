<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="images/icon2.png" type="image/x-icon">
    <title> FeelFinds </title>
    <!--police-->
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Patua One' rel='stylesheet'>

    <!-- <script src="https://api.mapbox.com/search/searchbox/v1/suggest?q={search_text}"></script> -->

    <!--js-->
    <script src="js/appli.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <!--css-->
    <link rel="stylesheet" href="css/appli.css">
    <link rel="stylesheet" href="css/mapbox.css" type="text/css">

    
    <!--itinéraire -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js"></script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
                        <li><a href="php/profil.php">Profil</a></li>
                        <li><a href="php/deconnexion.php">Déconnexion</a></li>
                    </ul>
                </li>
            </nav>
        <?php } else { ?>
            <div id="photoAvatar"><img src="images/connexion.png" width="60px"></div>
        <?php } ?>

    </div>
    <!--onglet sur la gauche-->
    <div id="menuOnglet">
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
                    <div id="directions-container"></div>

                   
                </div>

                <div class="line"></div>

                <div id="onglet_2">
                    <div class="sous_onglet_titre">
                        <img src="images/logo_sentiment.png" class="icone">
                        <p class="icone_txt"> Filtrer par sentiment </p>
                    </div>
                    <p class="sous_onglet_info"> Ressentir un sentiment particulier ? </p>

                    <div class="emoji">
                        <div style="display:flex;">
                            <div class="rectangle">
                                <img src="images/emoji_epoustouflant.png" width="26px" class="emojis emoji_epoustouflant">
                                <img src="images/emoji_triste.png" width="26px" class="emojis emoji_triste">
                                <img src="images/emoji_amour.png" width="26px" class="emojis emoji_amour">
                                <img src="images/emoji_joyeux.png" width="26px" class="emojis emoji_joyeux">
                                <img src="images/emoji_emouvant.png" width="26px" class="emojis emoji_emouvant">
                                <img src="images/emoji_festif.png" width="26px" class="emojis emoji_festif">
                            </div>
                            <div id="btnAnnulerFiltre">X</div>
                        </div>

                        <p class="nom_sentiment"> Testez ! </p>
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
                            <p class="bouton" id="btn_ajouter"> Ajouter un sentiment</p>
                            <p class="bouton" id="btn_modifierSupprimer"> Modifier ou Supprimer </p>
                            <p class="bouton"> Consulter Favori </p>
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

                <form action="php/ajoutSentiment.php" method="post">

                    <div class="adresse">

                        <p class="txtInfo"> &nbsp • &nbsp Adresse du lieu : </p>
                        <div>
                            <select name="nomMarqueur" class="inputA input_adresse">
                                <option value="">Choisissez votre lieu...</option>
                            </select>
                        </div>
                        <p>Lieu introuvable ? <span id="btnAjouterLieu" style="cursor:pointer;">Ajouter un lieu</span></p>

                    </div>

                    <div class="sentiments">
                        <p class="txtInfo"> &nbsp • &nbsp Choix du sentiment : </p>
                    </div>
                    <div class="emoji">
                        <div class="rectangle">
                            <img src="images/emoji_epoustouflant.png" width="26px" class="emojis emoji_epoustouflant">
                            <img src="images/emoji_triste.png" width="26px" class="emojis emoji_triste">
                            <img src="images/emoji_amour.png" width="26px" class="emojis emoji_amour">
                            <img src="images/emoji_joyeux.png" width="26px" class="emojis emoji_joyeux">
                            <img src="images/emoji_emouvant.png" width="26px" class="emojis emoji_emouvant">
                            <img src="images/emoji_festif.png" width="26px" class="emojis emoji_festif">
                        </div>

                        <p class="nom_sentiment"> Nom du sentiment </p>
                    </div>

                    <div class="description">
                        <p class="txtInfo"> &nbsp • &nbsp Description du moment : </p>
                        <div><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="avis" rows="5" cols="33"> </textarea></div>
                    </div>

                    <button class="btn"> Enregistrer </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment"><br><br>

                </form>

            </div>


            <div id="ongletModifier">
                <div class="sous_onglet_titre">
                    <img src="images/logo_gerer.png" class="icone">
                    <p class="icone_txt"> Gérer un sentiment </p>
                </div>
                <p class="sous_onglet_info"> Envie de modifier votre sentithèque? </p>

                <form action="php/modifierSentiment.php" method="post">

                    <div class="adresse">

                        <p class="txtInfo"> &nbsp • &nbsp Adresse du lieu : </p>
                        <div>
                            <input readonly type="text" name="nomMarqueur" placeholder="  Choisissez votre lieu..." class="inputA input_adresse"><br><br>
                        </div>

                    </div>

                    <div class="sentiments">
                        <p class="txtInfo"> &nbsp • &nbsp Choix du sentiment : </p>
                    </div>
                    <div class="emoji">
                        <div class="rectangle">
                            <img src="images/emoji_epoustouflant.png" width="26px" class="emojis emoji_epoustouflant">
                            <img src="images/emoji_triste.png" width="26px" class="emojis emoji_triste">
                            <img src="images/emoji_amour.png" width="26px" class="emojis emoji_amour">
                            <img src="images/emoji_joyeux.png" width="26px" class="emojis emoji_joyeux">
                            <img src="images/emoji_emouvant.png" width="26px" class="emojis emoji_emouvant">
                            <img src="images/emoji_festif.png" width="26px" class="emojis emoji_festif">
                        </div>

                        <p class="nom_sentiment"> Nom du sentiment </p>
                    </div>

                    <div class="description">
                        <p class="txtInfo"> &nbsp • &nbsp Description du moment : </p>
                        <div><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="avis" rows="5" cols="33"> </textarea></div>
                    </div>

                    <button class="btn"> Modifier </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment"><br><br>
                    <input type="text" name="idSentiment" placeholder="id sentiment" class="inputA hidden inputIdSentiment"><br><br>

                </form>

            </div>


            <div id="ongletAjouterMarqueur">
                <div class="sous_onglet_titre">
                    <img src="images/logo_gerer.png" class="icone">
                    <p class="icone_txt"> Ajouter un Lieu </p>
                </div>
                <p class="sous_onglet_info"> Envie d'ajouter votre lieu ? </p>

                <form action="php/ajoutMarqueur.php" method="post">

                    <div class="adresseLieu">
                        <p class="txtInfo"> &nbsp • &nbsp Adresse du lieu : </p>

                        <!-- <label for="addLieu">Adresse : </label><input type="text" name="addLieu" placeholder="  Choisissez votre lieu..." class="inputA  inputAdresseLieu"><br><br> -->
                        <label for="nomLieu">Nom : </label><input type="text" name="nomLieu" placeholder="  Choisissez votre lieu..." class="inputA  inputNomLieu"><br><br>
                        <label for="addLieu">Adresse : </label><br><span><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="addLieu" rows="5" cols="33"> </textarea></span>


                        <!-- <div>
                            <select name="nomMarqueur" class="inputA input_adresse">
                                <option value="">Choisissez votre lieu...</option>
                            </select>
                        </div>                    -->
                    </div>

                    <div class="sentiments">
                        <p class="txtInfo"> &nbsp • &nbsp Choix du sentiment : </p>
                    </div>
                    <div class="emoji">
                        <div class="rectangle">
                            <img src="images/emoji_epoustouflant.png" width="26px" class="emojis emoji_epoustouflant">
                            <img src="images/emoji_triste.png" width="26px" class="emojis emoji_triste">
                            <img src="images/emoji_amour.png" width="26px" class="emojis emoji_amour">
                            <img src="images/emoji_joyeux.png" width="26px" class="emojis emoji_joyeux">
                            <img src="images/emoji_emouvant.png" width="26px" class="emojis emoji_emouvant">
                            <img src="images/emoji_festif.png" width="26px" class="emojis emoji_festif">
                        </div>

                        <p class="nom_sentiment"> Nom du sentiment </p>
                    </div>

                    <div class="description">
                        <p class="txtInfo"> &nbsp • &nbsp Description du moment : </p>
                        <div><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="avis" rows="5" cols="33"> </textarea></div>
                    </div>

                    <button class="btn"> Enregistrer </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment"><br><br>
                    <input type="text" name="latitude" placeholder="  Choisissez votre lieu..." class="inputA hidden inputLatitude"><br><br>
                    <input type="text" name="longitude" placeholder="  Choisissez votre lieu..." class="inputA  hidden inputLongitude"><br><br>

                </form>

            </div>

        </div>

        <div id="ongletAvis">
            <p id="ferme">
                < Retour</p>
                    <h3>Info marqueur </h3>
                    <p id="nomMarqueur">Nom marqueur</p>
                    <div id="nbrAvis"></div>
                    <div id="nbrSentiment"></div>

                    <div id="traitBlanc1"></div>
                    <div id="avis">
                        <p id="sentiment">Sentiment</p>
                        <p id="avis">Avis</p>
                        <p id="personne">Personne</p>
                    </div>
        </div>

    </div>



    <!--appli carte-->
    <div id='map'></div>


    <script src="js/map.js"></script>
</body>

</html>