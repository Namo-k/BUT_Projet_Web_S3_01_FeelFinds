<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Se connecter - FeelFinds</title>
    <link id="favicon" rel="icon" href="../images/icon2.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/connexion.js"></script>
    <link rel="stylesheet" href="../css/connexion.css">
</head>

<body>

    <div class="conteneur-login">
        <div class="login-wrap" style="background:white;border-radius: 20px 0px 0px 20px;" >

            <a href="../index.html"><img src="../images/logo.png" width="240" height="78" style="margin-left: 26%; position:absolute; z-index:2;margin-top:2%;margin-bottom:4%;" /></a>

            <div class="login-html" style="border-radius: 20px 0 0 20px;">
                <input id="tab-1" type="radio" name="tab" class="sign-in" onclick="changeTitle()" checked><label for="tab-1" class="tab" style="margin-top:2%;">Se connecter</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up" onclick="changeTitle2()"><label for="tab-2" class="tab" style="margin-top:2%;">S'inscrire</label>
                <!--connexion-->
                <div class="login-form">
                    <div class="sign-in-htm">
                        <h1 class="sous-titre">Te revoilà, ça faisait longtemps !</h1>
                        <br>
                        <form method="POST" action="identification.php">
                            <div class="group">
                                <label for="user" class="label">Nom d'utilisateur ou mail</label>
                                <input id="user" placeholder="Nom d'utilisateur ou mail" type="text" class="input" name="id">
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Mot de passe</label>
                                <input id="pass" placeholder="Mot de passe" type="password" class="input" data-type="password" name="mdp">
                            </div>
                            <div class="group">
                                <input type="submit" class="button" value="Se connecter" name="submit">
                            </div>
                        </form>

                        <?php
                        // Affichage des erreurs s'il y en a
                        if (!empty($errorsConnexion)) {
                            echo '<div class="errorConnexion"><ul>';
                            foreach ($errorsConnexion as $error) {
                                echo "<li>$error</li>";
                            }
                            echo '</ul></div>';
                        }
                        ?>
                        <!--barre-->
                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <label for="tab-2">On se connait pas ?</a>
                        </div>
                    </div>

                    <!--inscription-->
                    <div class="sign-up-htm">
                        <h1 class="sous-titre">On ne se connait pas ?<br>
                            Dans ce cas, rejoins-nous !</h1>
                        <form method="POST" action="identification.php">
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
                                <input id="passInscr" placeholder="Mot de passe" type="password" class="input" data-type="password" name="mdpInscr">
                            </div>
                            <div id="passwordDiv"></div>
                            <div class="group">
                                <input type="submit" class="button" value="S'inscrire" name="incription">
                            </div>
                        </form>
                        <?php
                        // Affichage des erreurs s'il y en a
                        if (!empty($errors)) {
                            echo '<div class="error"><ul>';
                            foreach ($errors as $error) {
                                echo "<li>$error</li>";
                            }
                            echo '</ul></div>';
                        }
                        ?>
                        <div class="hr2"></div>
                        <div class="foot-lnk">
                            <label for="tab-1">On se connait déjà ?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--image sur le coté du login-->
        <div class="login-wrap" style="border-radius: 0 20px 20px 0px;	background: url('../images/tourcart.jpg') no-repeat center; 	background-size: 525px;"></div>
    </div>

    <?php
    // }
    ?>
    <script type="text/javascript">
        const fav = document.getElementById("favicon");

        function changeTitle() {
            newPageTitle = 'Se connecter - FeelFinds';
            document.title = newPageTitle;
            fav.setAttribute("href", "../images/icon2.png");
        }

        function changeTitle2() {
            newPageTitle = 'S\'inscrire - FeelFinds';
            document.title = newPageTitle;
            fav.setAttribute("href", "../images/icon2.png");
        }

        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('passInscr');
            var passwordConditions = document.createElement('div');
            var submitButton = document.querySelector('[name="incription"]');

            passwordConditions.className = 'password-conditions';
            passwordConditions.innerHTML = 'Conditions du mot de passe : ';

            passwordInput.parentNode.insertBefore(passwordConditions, passwordInput.nextSibling);

            function updatePasswordConditions() {
                var password = passwordInput.value;

                var lengthCondition = (password.length >= 8 && password.length <= 20);
                var specialCharCondition = /[!@#$%^&*(),.?":{}|<>]/.test(password);
                var digitCondition = /\d/.test(password);
                var letterCondition = /[a-zA-Z]/.test(password);

                passwordConditions.innerHTML = 'Conditions du mot de passe : ';

                if (lengthCondition) {
                    passwordConditions.innerHTML += '<span style="color: green;">Longueur valide</span>, ';
                } else {
                    passwordConditions.innerHTML += '<span style="color: red;">Longueur doit être entre 8 et 20 caractères</span>, ';
                }

                if (specialCharCondition) {
                    passwordConditions.innerHTML += '<span style="color: green;">Caractères spéciaux présents</span>, ';
                } else {
                    passwordConditions.innerHTML += '<span style="color: red;">Caractères spéciaux requis</span>, ';
                }

                if (digitCondition) {
                    passwordConditions.innerHTML += '<span style="color: green;">Chiffres présents</span>, ';
                } else {
                    passwordConditions.innerHTML += '<span style="color: red;">Chiffres requis</span>, ';
                }

                if (letterCondition) {
                    passwordConditions.innerHTML += '<span style="color: green;">Lettres présentes</span>';
                } else {
                    passwordConditions.innerHTML += '<span style="color: red;">Lettres requises</span>';
                }

                if (lengthCondition && specialCharCondition && digitCondition && letterCondition) {
                    submitButton.removeAttribute('disabled');
                    submitButton.classList.remove('disabled-button');
                } else {
                    submitButton.setAttribute('disabled', 'disabled');
                    submitButton.classList.add('disabled-button');
                }
            }

            passwordInput.addEventListener('input', updatePasswordConditions);
        });
    </script>

    <style>
        .disabled-button {
            background-color: #ddd;
            color: #888;
            cursor: not-allowed;
        }
    </style>

</body>

</html>