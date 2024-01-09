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

    <div class="switch">
        <input type="checkbox" class="switch__input" id="switch">
        <label class="switch__label" for="switch">
            <span class="switch__indicator"></span>
            <span class="switch__decoration"></span>
        </label>
    </div>

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
                <li> <a href="php/profil.php">
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
                                <img src="images/ecrire.png" id="ecrire">
                                <p class="bouton" id="btn_modifierSupprimer"> Modifier ou Supprimer </p>
                        </div>
                        <p class="bouton" id="btn_favori"> Consulter mes favoris <img src="images/etoile.png"> </p> 
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

                <div class="erreur">
                    <p id="msgErreurAjoutSentiment"></p>
                </div>

                <form action="php/ajoutSentiment.php" method="post">

                    
                    <div class="adresse">

                        <p class="txtInfo"> &nbsp • &nbsp Adresse du lieu : </p>
                        <div>
                            <select name="nomMarqueur" class="inputA input_adresse" required>
                                <option value="" id="inputALieu">&nbsp Choisissez votre lieu...</option>
                            </select>
                        </div>
                        <div id="ajouterLieu"> 
                            <p> Lieu introuvable ? <span id="btnAjouterLieu" style="">Ajouter un lieu</span></p>
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
                        <div><textarea class="input_desc inputD" placeholder=" Décrivez votre moment..." name="avis" rows="5" cols="33" required> </textarea></div>
                    </div>

                    <button class="btn" id="btnAjoutSentiment"> Enregistrer </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment" required><br><br>

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
                            <input readonly type="text" name="nomMarqueur" placeholder="  Choisissez votre lieu..." class="inputA input_adresse" required><br><br>
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
                        <div><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="avis" rows="5" cols="33" required> </textarea></div>
                    </div>

                    <button class="btn"> Modifier </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment" requierd><br><br>
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
                        <label for="nomLieu">Nom : </label><input type="text" name="nomLieu" placeholder="  Choisissez votre lieu..." class="inputA  inputNomLieu" required><br><br>
                        <label for="addLieu">Adresse : </label><br><span><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="addLieu" rows="5" cols="33" readonly> </textarea></span>

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
                        <div><textarea class="input_desc inputD" placeholder="Describe yourself here..." name="avis" rows="5" cols="33" required> </textarea></div>
                    </div>

                    <button class="btn"> Enregistrer </button>
                    <img src="images/btn_retour.png" width="30px" class="btn_retour">
                    <input type="text" name="sentiment" placeholder="  Choisissez votre lieu..." class="inputA hidden inputSentiment" required><br><br>
                    <input type="text" name="latitude" placeholder="  Choisissez votre lieu..." class="inputA hidden inputLatitude" readonly><br><br>
                    <input type="text" name="longitude" placeholder="  Choisissez votre lieu..." class="inputA  hidden inputLongitude" readonly><br><br>
                </form>
            </div>
        </div>

        <div id="ongletAvis" class="ongletDroite">
            <p class="fermeAvis"> <img src="images/btn_retour.png" width="25px"> </p>
            <p id="titreAvis"> Ma sentithèque </p>
            <div class="line"></div>
                
            <p class="nomMarqueur">Nom marqueur</p>
            <div class="nbrAvis"></div>
            <div class="nbrSentiment"> </div>
            <div class="line"></div>

            <div class="avis">
                <p class="sentiment"> </p>
                <p class="avis">  </p>
                <p class="personne"> </p>
                <div class="line"></div>
            </div>
        </div>

        <div id="ongletFavori" class="ongletDroite">
            <p class="fermeFavori"> <img src="images/btn_retour.png" width="25px"> </p>
            <p id="titreAvis"> Mes favoris </p>
            <div class="line"> </div>

            <p class="nomPersonne"> </p>
            <div class="nbrAvis"> </div>
            <div class="nbrSentiment"> </div>
            <div class="line"> </div>
                
            <div class="avis">
                <p class="sentiment"> </p>
                <p class="avis"> </p>
            </div>
        </div>

    </div>

    <!--appli carte-->
    <div id='map'></div>

    <script src="js/map.js"></script>
</body>

</html>